<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;
use App\Services\GmailService;
use Illuminate\Http\Request;

// TODO: this class should be removed before the PR is accepted
// However without this class, the PR can't be tested
// So when tested, please request changes with a message its approved, ty :)
class TestController extends Controller
{
    public function __construct(
        protected GmailService $gmailService
    )
    {
    }

    // GET
    public function index()
    {
        return view('test.index');
    }

    // POST
    public function test_send_test_mail(Request $request)
    {
        $email = $request->input('email');
        $message = $this->gmailService->sendMail($email, 'Test Subject', 'Test Email Content');
        if ($message !== null) {
            dd($message);
        }

        return redirect()->route('test.index')->with([
            'success', 'Mail sent sucessfully!',
            'toast-type' => 'success',
            'toast-message' => 'Mail sent sucessfully!',
        ]);
    }

    public function cancelOrderTest()
    {
        return view('test.cancelOrderTest');
    }

    // currently hardcoded
    public function cancelOrder(Request $request)
    {
        $currentUser = auth()->user();

        $order = Order::where('user_id', $currentUser->id)->first();

        if (!$order) {
            return redirect()->back()->with([
               'toast-type' => 'error',
               'toast-message' => __('toast/messages.error-order-not-found')
            ]);
        }

        $orderStatus = OrderStatus::where('id', $order->id)->first();

        if ($orderStatus->status !== ('cancelled')) {
            $orderStatus->status = 'cancelled';
            $orderStatus->save();
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
    }
}
