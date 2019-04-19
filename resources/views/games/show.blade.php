@extends('layouts.app')

@section('header')
    {{ $game->name }}
@endsection

@section('content')

<div class="container">
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif

    <img src="{{ asset($game->image) }}" class="img-responsive mx-auto d-block rounded" width="460" height="215px">
    <br>
    <a href="{{ route('editgame', ['id' => $game->id]) }}">{{ __('games.editgame') }}</a><br>
    <br>
    <p> {{$game->description}} </p>

    <table class="table">

        @if(count($keys) > 0)
            <tr>
                <th>{{ __('games.platform') }}</th>
                <th>{{ __('games.addedby') }}</th>
            </tr>
            @foreach($keys as $key)
                <tr>
                <td>
                    <a href="/keys/{{$key->id}}">{{$key->platform}}</a>
                </td>
                    <td><a href="/users/{{$key->created_user_id}}">{{$key->created_user_name}}</a></td>
                <tr>
            @endforeach
        @else
            <p> {{ __('games.nokeys') }} <p>
        @endif

</div>
@endsection
