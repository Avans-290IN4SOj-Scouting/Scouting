<?php

namespace App\Http\Controllers;

use App\Enum\FeedbackType;
use App\Models\FeedbackForm;

class FeedbackController extends Controller
{
    public function index()
    {
        return view('feedback.feedback', ['feedbacktypes' => FeedbackType::cases()]);
    }

    public function store()
    {  
        $validatedData = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required',
            'message' => 'required',

        ]);

        $feedback = new FeedbackForm();
        $feedback->name = $validatedData['name'];
        $feedback->email = $validatedData['email'];
        $feedback->subject = $validatedData['subject'];
        $feedback->message = $validatedData['message'];
        $feedback->save();

        return redirect()->back()->with([
            'toast-type' => 'success',
            'toast-message' => __('feedback/feedback.succes_message')
        ]);
    }
}
