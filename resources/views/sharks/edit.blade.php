@extends('sharks.layouts.app')

@section('content')
    <h1>Edit the shark</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{ route('sharks.store') }}">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input id="name" type="text" name="name" value="{{ $shark->name }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="text" name="email" value="{{ $shark->email }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="shark_level">Shark level</label>
            <select id="shark_level" name="shark_level" id="shark_level">
                @foreach($levels as $level)
                    <option @selected($loop->index === $shark->shark_level) value="{{ $loop->index }}">{{ $level }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Edit the shark!</button>
    </form>
@endsection
