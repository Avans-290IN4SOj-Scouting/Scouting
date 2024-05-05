<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;
use App\Services\GmailService;
use Illuminate\Http\Request;

use Exception;
use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;
use Google_Client;
use Illuminate\Support\Facades\Storage;

// TODO: this class should be removed before the PR is accepted
// However without this class, the PR can't be tested
// So when tested, please request changes with a message its approved, ty :)
class TestController extends Controller
{
    // public function __construct(
    //     protected GmailService $gmailService
    // )
    // { }

    // GET
    public function index()
    {
        try
        {
            $client = new Client();
            dd(12);
        }
        catch (Exception $e)
        {
            dd(10);
        }

        return view('test.index');
    }

    // POST
    public function test_send_test_mail(Request $request)
    {
        // $email = $request->input('email');
        // $message = $this->gmailService->sendMail($email, 'Test Subject', 'Test Email Content');
        // if ($message !== null) {
        //     dd($message);
        // }

        // return redirect()->route('test.index')->with([
        //     'success', 'Mail sent sucessfully!',
        //     'toast-type' => 'success',
        //     'toast-message' => 'Mail sent sucessfully!',
        // ]);
    }
}
