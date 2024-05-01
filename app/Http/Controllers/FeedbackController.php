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
            'email' => 'required|email|max:255',
            'subject' => 'required',
            'message' => 'required',

        ]);

        $feedback = new FeedbackForm();
        $feedback->email = $validatedData['email'];
        $feedback->subject = $validatedData['subject'];
        $feedback->message = $validatedData['message'];
        $feedback->save();

        return redirect()->back()->with([
            'toast-type' => 'success',
            'toast-message' => __('feedback/feedback.succes_message')
        ]);
    }

    public function feedback_overview(){
        $feebackForms = FeedbackForm::all();

        return view ('feedback.overview', ['feedbackForms' => $feebackForms]);
    }
}
