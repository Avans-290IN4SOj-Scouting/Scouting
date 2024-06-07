<?php

namespace App\Http\Controllers;

use App\Enum\DeliveryStatus;
use App\Models\Order;
use App\Models\OrderLine;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Services\GmailService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class OrderDetailsController extends Controller
{
    protected array $ableToCancelStatus;

    public function __construct(
        protected GmailService $gmailService
    )
    {
        $this->ableToCancelStatus = [
            DeliveryStatus::AwaitingPayment->value
        ];
    }

    public function orderDetails($id)
    {
        $order = Order::findOrFail($id);

        $redirect = $this->checkIfOrderBelongsToUser($order);
        if ($redirect) {
            return $redirect;
        }

        $isCancellable = in_array($order->status, $this->ableToCancelStatus);

        $order->order_date = new \DateTime($order->order_date);
        $order->status = DeliveryStatus::localisedValue($order->status);

        $orderLines = OrderLine::with('product')->where('order_id', $id)->get();
        $productIds = $orderLines->pluck('product_id')->toArray();
        $productsWithGroups = Product::with('groups')->whereIn('id', $productIds)->get();

        $totalPrice = 0;

        foreach ($orderLines as $orderLine) {
            $totalPrice += $orderLine->product_price * $orderLine->amount;

            $product = $productsWithGroups->where('id', $orderLine->product_id)->first();

            $orderLine->product->group_name = $product->groups->pluck('name')->first();
        }

        return view('orders.orderdetails', ['order' => $order, 'orderLines' => $orderLines, 'totalPrice' => $totalPrice, 'isCancellable' => $isCancellable]);
    }

    public function cancelOrder(string $id)
    {
        $order = Order::where('id', $id)->first();

        if (!$order) {
            return redirect()->back()->with([
                'toast-type' => 'error',
                'toast-message' => __('toast/messages.error-order-not-found')
            ]);
        }

        $redirect = $this->checkIfOrderBelongsToUser($order);

        if ($redirect) {
            return $redirect;
        }

        if (in_array($order->status, $this->ableToCancelStatus)) {
            $email = Auth::user()->getEmail();

            $logoPath = public_path('images/scouting/AZG_Scouting_logo_slogan_compact_RGB.png');
            $emailContent = View::make('orders.emails.order_cancelled', ['order' => $order])->render();
            $this->gmailService->sendMail($email, __('email.order-cancelled.subject'), $emailContent, $logoPath);

            $order->status = 'cancelled';
            $order->save();
        }

        return redirect()->back()->with([
            'toast-type' => 'success',
            'toast-message' => __('toast/messages.success-order-cancelled')
        ]);
    }

    private function checkIfOrderBelongsToUser($order)
    {
        if ($order->user_id != Auth::user()->id) {
            return redirect()->route('home')->with([
                'toast-type' => 'error',
                'toast-message' => __('toast/messages.error-nonauthorized-order')
            ]);
        }

        return null;
    }
}
