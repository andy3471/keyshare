@extends('layouts.app')

@section('header')
    {{ $user->name }}
@endsection

@section('content')
    <div class="container">
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif

        <form method="POST" action="/admin/user/update" enctype="multipart/form-data">
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div> <br>
            @endforeach

            @csrf
            <input type="hidden" name="id" value="{{ $user->id }}">
            <img src="{{ $user->image }}" class="img-responsive mx-auto d-block rounded" width="200" height="200px">
            <label for="image"> {{ __('users.image') }}: ({{ __('users.imagereqs') }})</label>
            <br>
            <input name="image" type="file">
            <br>

            <label for="name"> {{ __('users.name') }}: </label>
            <input name="name" class="form-control" type="text" value="{{ $user->name }}" required>

            <label for="email"> {{ __('users.email') }}: </label>
            <input name="email" class="form-control" type="text" value="{{ $user->email }}">

            <label for="bio"> {{ __('users.bio') }}: </label>
            <textarea name="bio" class="form-control">{{ $user->bio }}</textarea>

            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="approved"
                    @if( $user->approved )
                        checked
                    @endif
                >
                <label class="form-check-label" for="exampleCheck1">{{ __('admin.approved') }}</label>
            </div>
            <br>
            <input type="submit" class="btn btn-keyshare" value="{{ __('nav.save') }}">
        </form>

    </div>
@endsection
