<?php

namespace App\Http\Controllers;

use App\Enum\DeliveryStatus;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(): View
    {
        $orders = Order::where('user_id', auth()->user()->id)
            ->orderBy('order_date', 'desc')
            ->take(3)
            ->get()
            ->each(function ($order) {
                $order->load(['orderLines' => function ($query) {
                    $query->orderByDesc('product_price');
                }]);
                $order->order_date = new \DateTime($order->order_date);
                $order->status = DeliveryStatus::localisedValue($order->status);
            });

        return view('profile.edit', [
            'user' => auth()->user(),
            'orders' => $orders,
        ]);
    }

    /**
     * Update the user's password.
     */
    public function update(ProfileUpdateRequest $request)
    {
        $validated = $request->validated();

        if (!Auth::attempt(['email' => Auth::user()->email, 'password' => $validated['old-password']])) {
            return Redirect::back()->withErrors(['old-password' => __('auth/profile.incorrect_password')]);
        }

        Auth::user()->update([
            'password' => bcrypt($validated['new-password']),
        ]);

        return Redirect::back()->with([
            'toast-type' => 'success',
            'toast-message' => __('auth/profile.password_updated'),
        ]);
    }
}
