<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $url = $request->session()->pull('url.intended', route('home'));
        $request->session()->forget('url.intended');

        try {
            $request->authorize();
        } catch (AuthenticationException $e) {
            return redirect()->back()->withErrors(
                ['email' => __('auth/auth.email')],
                ['password' => __('auth/auth.password')],
            );
        }

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->to($url)
            ->with([
                'toast-type' => 'success',
                'toast-message' => __('auth/auth.register-success')
            ]);
    }
}
