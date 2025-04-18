@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh; padding-top: 50px;">
    <div class="row justify-content-center w-100">
        <div class="col-md-8 col-lg-6 col-xl-4">
            <div class="card border-0 rounded-lg shadow-lg">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4 fw-bold text-dark">Reset Password</h3>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

                        <div class="mb-3">
                            <label for="password" class="form-label fw-medium text-dark">New Password</label>
                            <input type="password" class="form-control form-control-lg" id="password" name="password" required>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-medium text-dark">Confirm Password</label>
                            <input type="password" class="form-control form-control-lg" id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <div class="d-flex justify-content-center mb-4">
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
