@extends('layouts.app')

@section('header')
    {{ $game->name }}
@endsection

@section('content')

<div class="container">
    <img src="{{ asset($game->image) }}" class="img-fluid mx-auto d-block rounded">
    <br>
    @can('admin',Auth::user())
        <a href="{{ route('editgame', ['id' => $game->id]) }}">{{ __('games.editgame') }}</a><br>
    @endcan
    <br>
    <p> {{$game->description}} </p>
    @foreach($genres as $genre)
        <span class="badge bg-secondary">{{$genre->name}}</span>
    @endforeach
    <br>
    @if($igdb && $igdb->aggregated_rating)
       Rated an average of {{ $igdb->aggregated_rating }}  by {{ $igdb->aggregated_rating_count }} reviewers
    @endif


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


    @if($screenshots) 
        <div class="row">
        @foreach($screenshots as $screenshot)
            <div class="col-md-4" style="padding-bottom: 15px;">
                <img src="https://images.igdb.com/igdb/image/upload/t_screenshot_big/{{$screenshot->image_id}}.jpg"  class="img-thumbnail img-fluid">
            </div>
        @endforeach
        </div>
    @endif
</div>
@endsection
