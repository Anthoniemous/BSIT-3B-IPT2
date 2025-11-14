@extends('layouts.app') {{-- Main homepage layout --}}

@section('content')
<div class="container mt-5 text-center">
    <h2 class="text-3xl font-bold mb-3">Hello, {{ $user->name }}!</h2>
    <p class="mb-5 text-gray-600">Manage your profile and logout here.</p>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit"
            class="px-6 py-3 bg-red-500 text-white font-semibold rounded hover:bg-red-600">
            Logout
        </button>
    </form>
</div>
@endsection
