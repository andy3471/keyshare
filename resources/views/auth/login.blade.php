@extends('layouts.app')

@section('header')
    {{ __('Login') }}
@endsection

@section('content')
    <div class="container">
        @if (config('app.demo_mode') == true)
            {{ __('auth.demomodelogin') }}
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label for="email">{{ __('E-Mail Address') }}</label>
            <input id="email" 
                type="email" 
                class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" 
                name="email"
                @if (config('app.demo_mode') == true)
                    value="admin@admin.com"
                @else
                    value="{{ old('email') }}"
                @endif required autofocus>

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif

            <label for="password">{{ __('Password') }}</label>
            <input id="password" 
                type="password"
                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                name="password"
                @if (config('app.demo_mode') == true)
                    value="password" 
                @endif required>

            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>

            @if ( config('keyshare.steamlogin'))
                <a href="{{ route('steamlogin') }}"><img  src="{{ asset('/images/steamlogin.png') }}" /></a>
            @endif
            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-keyshare">
                        {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif

                    <a class="btn btn-link" href="{{ route('register') }}">Register</a>
                </div>
            </div>
            <br>
        </form>
    </div>
@endsection
