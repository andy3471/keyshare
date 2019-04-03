@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Change Password</h2>
    <form method="POST" action="{{ route('postpassword') }}">
        @csrf
        <label for="password">Current Password</label>
        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

        <label for="password">New Password</label>
        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

        <label for="password">Confirm Password</label>
        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

        <br>
        <a class="btn btn-primary" type="submit">Change Password</a>
        </div>
    </div>
    </form>
</div>
@endsection
