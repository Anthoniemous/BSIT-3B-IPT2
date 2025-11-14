@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('assets/images/default-avatar.png') }}"
                 class="rounded-circle mb-3" style="width:120px; height:120px; object-fit:cover;">
            <h2 class="text-3xl font-bold text-gray-800">{{ $user->name }}</h2>
            <p class="text-gray-600">Update your profile info below.</p>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="bg-white p-5 rounded shadow-lg">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="form-group mb-3">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                               class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                               class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Password (leave blank to keep current)</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label>Avatar</label>
                        <input type="file" name="avatar" class="form-control" accept="image/*">
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
