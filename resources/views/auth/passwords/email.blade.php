@extends('layouts.app')

@section('content')
<div class="container">
    <div class="title">
        <h2>{{ __('Reset Password') }}</h2>
    </div>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <label for="email">{{ __('E-Mail Address') }}</label>
        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

        @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
        <br>
        <button type="submit" class="btn btn-keyshare">
            {{ __('Send Password Reset Link') }}
        </button>

    </form>
</div>
@endsection
