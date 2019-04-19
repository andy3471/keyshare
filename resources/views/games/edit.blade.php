@extends('layouts.app')

@section('header')
    {{ __('games.edit') }}: {{ $game->name }}
@endsection

@section('content')
    <div class="container">
        <form method="POST" action="/games/update" enctype="multipart/form-data">
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div> <br>
            @endforeach

            @csrf
            <input type="hidden" name="gameid" value="{{ $game->id }}">
            <img src="{{ asset($game->image) }}" class="img-responsive mx-auto d-block rounded" width="460" height="215px">
            <label for="image"> {{ __('games.image') }}: ({{ __('games.imagereqs') }})</label>
            <br>
            <input name="image" type="file">
            <br>

            <label for="name"> {{ __('games.name') }}: </label>
            <input name="name" class="form-control" type="text" value="{{ $game->name }}" required>

            <label for="description"> {{ __('games.description') }}: </label>
            <input name="description" class="form-control" type="text" value="{{ $game->description }}">
            <br>
            <input type="submit" class="btn btn-keyshare" value="{{ __('nav.save') }}">
        </form>

    </div>
@endsection
