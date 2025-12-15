@extends('layouts.customer')

@section('title', 'My Profile')
@section('page_heading', 'My Profile')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
    <li class="breadcrumb-item text-dark" aria-current="page">Profile</li>
@endsection

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4 text-primary">My Profile</h2>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-7 col-xl-6">

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5 text-center">

                                @php
                                    // DB stores: uploads/profile_images/... :contentReference[oaicite:2]{index=2}
                                    $profileSrc = (!empty($navCustomer?->profile_image))
                                        ? asset('storage/' . $navCustomer->profile_image)
                                        : asset('img/default-profile.png');
                                @endphp

                                <img src="{{ $profileSrc }}"
                                    alt="Profile"
                                    class="rounded-circle border"
                                    style="width: 100px; height: 100px; object-fit: cover;">

                    {{-- ✅ Upload New Image --}}
                    <form action="{{ route('profile.updateImage') }}" method="POST" enctype="multipart/form-data" class="mb-4 text-start">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small text-muted">Change Profile Image</label>
                            <input type="file" name="profile_image" class="form-control" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill w-100">
                            Upload New Image
                        </button>
                    </form>

                    <hr class="my-4">

                    {{-- ✅ Update Email --}}
                    <form action="{{ route('profile.updateEmail') }}" method="POST" class="mb-4 text-start">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small text-muted">Email Address</label>
                            <input type="email" name="email" value="{{ $customer->email }}" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-warning rounded-pill w-100">
                            Update Email
                        </button>
                    </form>

                    <hr class="my-4">

                    {{-- ✅ Change Password --}}
                    <form action="{{ route('profile.updatePassword') }}" method="POST" class="text-start">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label small text-muted">Current Password</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted">New Password</label>
                            <input type="password" name="new_password" class="form-control" required minlength="8">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control" required minlength="8">
                        </div>

                        <button type="submit" class="btn btn-success rounded-pill w-100">
                            Change Password
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
