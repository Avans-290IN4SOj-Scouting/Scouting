<?php

namespace App\Http\Controllers;

use App\Services\GmailService;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function __construct(
        protected GmailService $gmailService
    ) { }

    // GET
    public function index()
    {
        return view('test.index');
    }

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

    // POST
    public function test_send_test_mail(Request $request)
    {
        $email = $request->input('email');
        $message = $this->gmailService->sendMail($email, 'Test Subject', 'Test Email Content');
        if ($message !== null)
        {
            dd($message);
        }

        return redirect()->route('test.index')->with([
            'success', 'Mail sent sucessfully!',
            'toast-type' => 'success',
            'toast-message' => 'Mail sent sucessfully!',
        ]);
    }
}
