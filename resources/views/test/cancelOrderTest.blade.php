@extends('layouts.base')

@php
    $title = 'Testing View';
@endphp

@section('content')

<form action="{{ route('test.cancel-order') }}" method="post">
    @csrf
    <button type="submit" class="bg-blue-500 p-4 rounded text-white">Annuleer bestelling</button>
</form>

@endsection
