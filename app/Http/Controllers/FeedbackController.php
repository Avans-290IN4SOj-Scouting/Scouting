<?php

namespace App\Http\Controllers;

use App\Models\FeedbackForm;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(){
        return view('feedback.feedback');
    }

    public function store(Request $request){
        //validate the form data

        $validatedData = $request->validate([
            __('feedback/feedback.name') => 'required|string|max:255',
            __('feedback/feedback.email') => 'required|email|max:255',
        ]);

        $feedback = new FeedbackForm();

    }
}
