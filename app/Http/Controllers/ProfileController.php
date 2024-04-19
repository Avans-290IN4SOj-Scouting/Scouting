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
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.index')->with('status', 'profile-updated');
    }
}
