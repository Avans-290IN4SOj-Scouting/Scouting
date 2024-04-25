<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(){
        return view('feedback.feedback');
    }

    public function store(Request $request){
        ddd($request->all());
        return redirect('home');
    }
}
