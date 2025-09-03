@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Verify Your Email Address</h4>
                </div>

                <div class="card-body">
                    <p>
                        Before proceeding, please check your email for a verification link.
                        If you did not receive the email, you can request another one below.
                    </p>

                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            Resend Verification Email
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
