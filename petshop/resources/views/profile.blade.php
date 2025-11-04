@extends('layouts.app')

@section('title', 'My Profile - Paw Paradise')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">My Profile</h1>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Profile Information</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="firstname" class="form-label">First Name</label>
                                <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" 
                                       name="firstname" value="{{ old('firstname', auth()->user()->firstname) }}" required>
                                @error('firstname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="middlename" class="form-label">Middle Name</label>
                                <input id="middlename" type="text" class="form-control" 
                                       name="middlename" value="{{ old('middlename', auth()->user()->middlename) }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="lastname" class="form-label">Last Name</label>
                                <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" 
                                       name="lastname" value="{{ old('lastname', auth()->user()->lastname) }}" required>
                                @error('lastname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email', auth()->user()->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="contact" class="form-label">Contact Number</label>
                            <input id="contact" type="text" class="form-control" 
                                   name="contact" value="{{ old('contact', auth()->user()->contact) }}">
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea id="address" class="form-control" name="address" rows="3">{{ old('address', auth()->user()->address) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary px-5">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Account Details</h5>
                </div>
                <div class="card-body">
                    <p><strong>Member Since:</strong><br>{{ auth()->user()->created_at->format('M d, Y') }}</p>
                    <p><strong>Account Type:</strong><br>{{ ucfirst(auth()->user()->role) }}</p>
                    <p><strong>Total Orders:</strong><br>{{ auth()->user()->sales()->count() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
