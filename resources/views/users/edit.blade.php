@extends('layouts.app')

@section('header')
    {{ Auth::user()->name }}
@endsection

@section('content')
    <div class="container">
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif

        <form method="POST" action="/user/update" enctype="multipart/form-data">
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div> <br>
            @endforeach

            @csrf
            <input type="hidden" name="gameid" value="">
            <img src="{{ Auth::user()->image }}" class="img-responsive mx-auto d-block rounded" width="200" height="200px">
            <label for="image"> {{ __('users.image') }}: ({{ __('users.imagereqs') }})</label>
            <br>
            <input name="image" type="file">
            <br>

            <label for="name"> {{ __('users.name') }}: </label>
            <input name="name" class="form-control" type="text" value="{{ Auth::user()->name }}" required>

            <label for="email"> {{ __('users.email') }}: </label>
            @if ( (strpos(Auth::user()->email, '@' )) !== false)
                @php ($email = Auth::user()->email)
            @else
                @php ($email = null)
            @endif
            <input name="email" class="form-control" type="text" value="{{ $email }}">

            <label for="bio"> {{ __('users.bio') }}: </label>
            <textarea name="bio" class="form-control">{{ Auth::user()->bio }}</textarea>
            <br>
            <input type="submit" class="btn btn-keyshare" value="{{ __('nav.save') }}">
        </form>

    </div>
@endsection
