<?php

namespace App\Http\Controllers;

use App\Enum\DeliveryStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderLine;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Services\GmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderDetailsController extends Controller
{
    public function __construct(
        protected GmailService $gmailService
    )
    {
    }

    public function orderDetails($orderId)
    {
        $order = Order::findOrFail($orderId);

        $redirect = $this->checkIfOrderBelongsToUser($order);
        if ($redirect) {
            return $redirect;
        }

        $ableToCancelStatus = [DeliveryStatus::AwaitingPayment->value, DeliveryStatus::Processing->value];
        $isCancellable = in_array($order->status, $ableToCancelStatus);

        $order->order_date = new \DateTime($order->order_date);
        $order->status = DeliveryStatus::localisedValue($order->status);

        $orderLines = OrderLine::with('product')->where('order_id', $orderId)->get();
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

    public function cancelOrder(Request $request)
    {
        try {
            $orderId = $request->input('orderId');

            $order = Order::where('id', $orderId)->first();

            $redirect = $this->checkIfOrderBelongsToUser($order);
            if ($redirect) {
                return $redirect;
            }

            if (!$order) {
                return redirect()->back()->with([
                    'toast-type' => 'error',
                    'toast-message' => __('toast/messages.error-order-not-found')
                ]);
            }

            $ableToCancelStatus = ['awaiting_payment', 'processing'];

            if (in_array($order->status, $ableToCancelStatus)) {
                $email = Auth::user()->getEmail();

                $message = $this->gmailService->sendMail($email, 'Order is cancelled', 'Order is cancelled');

                $order->status = 'cancelled';
                $order->save();
            } else {
                return redirect()->back()->with([
                    'toast-type' => 'error',
                    'toast-message' => __('toast/messages.error-order-not-cancelled'),
                ]);
            }

            return redirect()->back()->with([
                'toast-type' => 'success',
                'toast-message' => __('toast/messages.success-order-cancelled')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'toast-type' => 'error',
                'toast-message' => __('toast/messages.error-general')
            ]);
        }
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
