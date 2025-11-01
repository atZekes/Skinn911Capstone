@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Reset Your Password</h3>
    <form method="POST" action="{{ route('staff.password.reset.submit') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">
        <div class="mb-3">
            <label>New Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button class="btn btn-primary">Set Password</button>
    </form>
</div>
@endsection
