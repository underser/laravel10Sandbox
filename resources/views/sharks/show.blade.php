@extends('sharks.layouts.app')
@section('content')
    <h1>Showing {{ $shark->name }}</h1>

    <div class="jumbotron text-center">
        <h2>{{ $shark->name }}</h2>
        <p>
            <strong>Email:</strong> {{ $shark->email }}<br>
            <strong>Level:</strong> {{ $shark->shark_level }}
        </p>
    </div>
@endsection
