@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>

    <div class="bg-white shadow rounded-lg p-6">
        <p class="text-gray-700 mb-4">
            Welcome to the Admin Dashboard! Use the link below to manage your products.
        </p>

        <a href="{{ route('products.index') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Manage Products
        </a>
    </div>
</div>
@endsection
