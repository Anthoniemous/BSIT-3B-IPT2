<x-app-layout>
    <div class="container py-5">
        <h2 class="text-center mb-4">My Profile</h2>

        {{-- Success message --}}
        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        <div class="card mx-auto shadow-lg" style="max-width: 600px;">
            <div class="card-body text-center">

                {{-- ✅ Profile Image --}}
            @if($customer->profile_image)
            <img src="{{ asset($customer->profile_image) }}" 
                    class="rounded-circle mb-3 border border-3 border-primary" 
                    width="120" height="120" 
                    alt="Profile Image">
            @else
                <img src="{{ asset('img/default-profile.png') }}" 
                    class="rounded-circle mb-3 border border-3 border-secondary" 
                    width="120" height="120" 
                    alt="Default Profile">
            @endif

                {{-- ✅ Upload New Image --}}
                <form action="{{ route('profile.updateImage') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                    @csrf
                    <div class="mb-3 text-start">
                        <label class="form-label">Change Profile Image</label>
                        <input type="file" name="profile_image" class="form-control" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary rounded-pill w-100">Upload New Image</button>
                </form>

                <hr class="my-4">

                {{-- ✅ Update Email --}}
                <form action="{{ route('profile.updateEmail') }}" method="POST" class="mb-4 text-start">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" value="{{ $customer->email }}" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-warning rounded-pill w-100">Update Email</button>
                </form>

                <hr class="my-4">

                {{-- ✅ Change Password --}}
                <form action="{{ route('profile.updatePassword') }}" method="POST" class="text-start">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="new_password" class="form-control" required minlength="8">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required minlength="8">
                    </div>

                    <button type="submit" class="btn btn-success rounded-pill w-100">Change Password</button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
