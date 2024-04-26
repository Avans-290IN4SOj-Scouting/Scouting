<?php

namespace App\Http\Controllers;

use App\Models\FeedbackForm;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        return view('feedback.feedback');
    }

    public function store(Request $request)
    {
        if(!empty($request)){
            return $request;
        }
       

       
        //validate the form data

        $validatedData = $request->validate([
            __('feedback/feedback.name') => 'required|string|max:255',
            __('feedback/feedback.email') => 'required|email|max:255',
            __('feedback/feedback.category') => 'required',
            __('feedback/feedback.message') => 'required',

        ]);

        $feedback = new FeedbackForm();
        $feedback->name = $validatedData[__('feedback/feedback.name')];
        $feedback->email = $validatedData[__('feedback/feedback.email')];
        $feedback->category = $validatedData[__('feedback/feedback.category')];
        $feedback->message = $validatedData[__('feedback/feedback.message')];
        $feedback->save();

        return redirect()->back()->with([
            'toast-type' => 'success',
            'toast-message' => __('feedback/feedback.succes_message')
        ]);
    }
}
