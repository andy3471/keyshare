@extends('layouts.app')

@section('header')
    {{ __('user.changepassword') }}
@endsection

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('postpassword') }}">
            @csrf
            <label for="password">{{ __('user.currentpassword') }}</label>
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="currentpassword" required>

            <label for="password">{{ __('user.newpassword') }}</label>
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="newpassword" required>

            <label for="password">{{ __('user.confirmpassword') }}</label>
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="comfirmpassword" required>

            <br>
            <a class="btn btn-keyshare" type="submit">{{ __('nav.save') }}</a>
            </div>
        </div>
        </form>
    </div>
@endsection
