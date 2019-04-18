@extends('layouts.app')

@section('content')

<div class="page">
    <h2> {{$title}} </h1>

    @if(count($games) > 0)
        <div class="gamegrid">
            @foreach($games as $game)
                <div class="gamecard">
                    @if($title == 'Claimed Keys' or $title == 'Shared Keys')
                        <a href="/keys\{{$game->key_id}}">
                    @else
                        <a href="/games\{{$game->id}}">
                    @endif
                    <img src="{{asset('/images/gamedefault.png')}}" alt="Card image cap" class="image">
                    <div class="overlay">
                            {{$game->name}}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p> {{ __('games.notfound') }} </p>
    @endif

    <br>

        {!! $games->links(); !!}
</div>

@endsection
