@extends('layouts.app')

@section('title', 'Register - Paw Paradise')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Create Account</h2>
                    
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="firstname" class="form-label">First Name</label>
                                <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" 
                                       name="firstname" value="{{ old('firstname') }}" required>
                                @error('firstname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="middlename" class="form-label">Middle Name (Optional)</label>
                                <input id="middlename" type="text" class="form-control" name="middlename" value="{{ old('middlename') }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="lastname" class="form-label">Last Name</label>
                                <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" 
                                       name="lastname" value="{{ old('lastname') }}" required>
                                @error('lastname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                       name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input id="password_confirmation" type="password" class="form-control" 
                                       name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="contact" class="form-label">Contact Number (Optional)</label>
                            <input id="contact" type="text" class="form-control" name="contact" value="{{ old('contact') }}">
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address (Optional)</label>
                            <textarea id="address" class="form-control" name="address" rows="2">{{ old('address') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-lg">Register</button>
                    </form>

                    <div class="text-center mt-4">
                        <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection