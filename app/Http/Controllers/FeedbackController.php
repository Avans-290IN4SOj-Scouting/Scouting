<?php

namespace App\Http\Controllers;

use App\Enum\FeedbackType;
use App\Models\FeedbackForm;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        return view('feedback.feedback', ['feedbacktypes' => FeedbackType::cases()]);
    }

    public function store(Request $request)
    {  
        $token = $request->input('h-captcha-response');
        $secretKey = 'ES_18327d0ec5554c5584eacbc15dcb12a0';
        $client = new Client();
    
        $response = $client->post('https://hcaptcha.com/siteverify', [
            'form_params' => [
                'secret' => $secretKey,
                'response' => $token
            ]
        ]);
    
        $body = json_decode($response->getBody());
        
        if ($body->success) {
            $validatedData = request()->validate([
                'email' => 'required|email|max:255',
                'type' => 'required',
                'message' => 'required',
    
            ]);
    
            $feedback = new FeedbackForm();
            $feedback->email = $validatedData['email'];
            $feedback->type = $validatedData['type'];
            $feedback->message = $validatedData['message'];
            $feedback->save();
    
            return redirect()->back()->with([
                'toast-type' => 'success',
                'toast-message' => __('feedback/feedback.succes_message')
            ]);
        } else {
            // hCaptcha validation failed
            return redirect()->back()->with('error', 'hCaptcha validation failed.');
        }

       
    }

    public function feedback_overview(){
        $feebackForms = FeedbackForm::all();

        return view ('feedback.overview', ['feedbackForms' => $feebackForms]);
    }
}
