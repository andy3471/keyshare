@extends('layouts.app')

@section('header')
    {{ __('Reset Password') }}
@endsection

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <label for="email">{{ __('E-Mail Address') }}</label>
            <input
                id="email"
                type="email"
                class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                name="email"
                value="{{ old('email') }}"
                required
            />

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif

            <br />

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-keyshare">
                        {{ __('Send Password Reset Link') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('register') }}">
                            {{ __('Register') }}
                        </a>
                    @endif

                    <a class="btn btn-link" href="{{ route('login') }}">
                        Login
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
