<?php

namespace App\Http\Controllers;

use App\Services\GmailService;
use Illuminate\Http\Request;

class GmailController extends Controller
{
    public function __construct(
        protected GmailService $gmailService
    ) { }

    // Gmail Authentication
    public function authenticate()
    {
        $authResult = $this->gmailService->authenticate();
        return redirect()->away($authResult);
    }

    // Gmail Auth Callback
    public function gmailAuthCallback(Request $request)
    {
        if ($request->filled('error')) {
            return redirect()->route('test.index')->with([
                'toast-type' => 'error',
                'toast-message' => __('gmail.general-auth-error'),
            ]);
        }

        $callbackResult = $this->gmailService->authenticate_callback($request);
        return redirect()->route('test.index')->with([
            'toast-type' => $callbackResult['type'],
            'toast-message' => $callbackResult['message'],
        ]);
    }
}
