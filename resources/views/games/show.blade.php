@extends('layouts.app')

@section('header')
    {{ $game->name }}
@endsection

@section('content')

<div class="container">
    <img src="{{ asset($game->image) }}" class="img-fluid mx-auto d-block rounded">
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
                    <a href="/keys/{{$key->id}}">{{$key->platform->name}}</a>
                </td>
                    <td>
                        <a href="/users/{{$key->createduser->id}}">
                            {{$key->createduser->name}}
                        </a>
                    <span class="badge badge-pill {{ $key->createduser->karma_color }}"> {{ $key->createduser->karma }} </span>
                    </td>
                <tr>
            @endforeach
        @else
            <p> {{ __('games.nokeys') }} <p>
        @endif
    </table>

    @if ($dlcCount > 0)
        <div class="page">
            <title-header title="DLC"></title-header>
            <Game-List url="{{ $dlcurl }}"></Game-List>
        </div>
    @endif

</div>
@endsection
