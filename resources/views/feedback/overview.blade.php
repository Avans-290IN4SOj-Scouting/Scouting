<!-- feedbacks.blade.php -->

@extends('layouts.base')

@props(['feedbackForms'])

@section('content')
    <div class="container">
        <h1>Feedback Forms</h1>
        @if(count($feedbackForms) > 0)
            <ul class="list-group">
                @foreach($feedbackForms as $form)
                    <li class="list-group-item">
                        <h3>{{ $form->id }}</h3>
                        <p>{{ $form->description }}</p>
                        {{-- <a href="{{ route('feedbacks.show', $form->id) }}" class="btn btn-primary">View Feedback</a> --}}
                    </li>
                @endforeach
            </ul>
        @else
            <p>No feedback forms available.</p>
        @endif
    </div>
@endsection
