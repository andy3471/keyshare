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
            <img src="{{ asset($game->image) }}" class="img-fluid mx-auto d-block rounded">
            <label for="image"> {{ __('games.image') }}: ({{ __('games.imagereqs') }})</label>
            <br>
            <input name="image" type="file">
            <br>

            <label for="name"> {{ __('games.name') }}: </label>
            <input name="name" class="form-control" type="text" value="{{ $game->name }}" required>

            <label for="description"> {{ __('games.description') }}: </label>
            <input name="description" class="form-control" type="text" value="{{ $game->description }}">
            <br>

            @if(config('igdb.enabled'))
                <label for="IGDB Linked Game"> {{ __('games.igdb_linked') }}: </label>
                <autocomplete 
                    placeholder
                    @if( $igdb )
                        value="{{$igdb->name}}"
                    @endif
                    url="/autocomplete/games/" 
                    id="igdbname"
                    name="igdbname" 
                    classes="form-control"
                ></autocomplete>
                <br>
            @endif
            
            <input type="submit" class="btn btn-keyshare" value="{{ __('nav.save') }}">
        </form>

    </div>
@endsection
