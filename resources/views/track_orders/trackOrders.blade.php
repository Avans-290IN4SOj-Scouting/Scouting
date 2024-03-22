@extends('layouts.base')

@php
    $title = "test";
@endphp

@section('content')
    <main class="max-w-6xl mx-auto mt-6 lg:mt-20 space-y-6">
        @if ($orders->count() > 0)
            <x-posts-grid :posts="$posts" />
            {{ $posts->links() }}
        @endif
    </main>
@endsection
