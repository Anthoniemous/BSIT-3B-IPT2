<x-app-layout>
    <div class="container py-5">
        <h2 class="text-center mb-4">My Profile</h2>

        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        <div class="card mx-auto" style="max-width: 500px;">
            <div class="card-body text-center">
                @if($customer->profile_image)
                    <img src="{{ asset($customer->profile_image) }}" class="rounded-circle mb-3" width="120" height="120" alt="Profile Image">
                @else
                    <img src="{{ asset('img/default-profile.png') }}" class="rounded-circle mb-3" width="120" height="120" alt="Default Profile">
                @endif

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Change Profile Image</label>
                        <input type="file" name="profile_image" class="form-control" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary rounded-pill">Upload</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
