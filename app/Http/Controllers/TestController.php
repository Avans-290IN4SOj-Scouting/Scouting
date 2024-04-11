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
            // return redirect()->route('test.index')->with([
            //     'error', 'gmail auth error',
            //     'toast-type' => 'error',
            //     'toast-message' => 'Gmail API auth error: ' . $request->input('error_description'),
            // ]);
            dd($request->input('error_description'));
        }

        if ($this->gmailService->authenticate_callback($request) === null)
        {
            return redirect()->route('test.index')->with([
                'success', 'gmail auth success',
                'toast-type' => 'success',
                'toast-message' => 'Successfully authenticated with Gmail API',
            ]);
        }
        else
        {
            return redirect()->route('test.index')->with([
                'error', 'gmail auth error',
                'toast-type' => 'error',
                'toast-message' => 'Failed to authenticate with Gmail API',
            ]);
        }
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
