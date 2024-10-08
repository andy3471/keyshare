@extends('layouts.app')

@section('header')
    {{ __('nav.changepassword') }}
@endsection

@section('content')
    <div class="container">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.reset.save') }}">
            @csrf
            <label for="password">{{ __('users.currentpassword') }}</label>
            <input
                id="password"
                type="password"
                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                name="currentpassword"
                required
            />

            <label for="password">{{ __('users.newpassword') }}</label>
            <input
                id="password"
                type="password"
                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                name="newpassword"
                required
            />

            <label for="password">{{ __('users.confirmpassword') }}</label>
            <input
                id="password"
                type="password"
                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                name="newpassword_confirmation"
                required
            />

            <br />
            <input
                type="submit"
                class="btn btn-keyshare"
                value="{{ __('nav.save') }}"
            />
        </form>
    </div>
@endsection
