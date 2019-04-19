@extends('layouts.app')

@section('header')
    {{ __('Register') }}
@endsection

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <label for="name">{{ __('Name') }}</label>
            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif

            <label for="email">{{ __('E-Mail Address') }}</label>
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif

            <label for="password">{{ __('Password') }}</label>
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif

            <label for="password-confirm">{{ __('Confirm Password') }}</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

            <br>
            <button type="submit" class="btn btn-keyshare">
                {{ __('Register') }}
            </button>
        </form>
    </div>
@endsection
