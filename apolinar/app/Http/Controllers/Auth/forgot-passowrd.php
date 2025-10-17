@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Forgot Password</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <label>Email Address:</label>
        <input type="email" name="email" required>
        <button type="submit">Send Reset Link</button>
    </form>
</div>
@endsection
