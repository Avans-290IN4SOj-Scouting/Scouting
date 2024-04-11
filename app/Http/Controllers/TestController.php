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

    public function gmailAuthCallback()
    {
        $authResult = $this->gmailService->authenticate();
        return redirect()->away($authResult);
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
