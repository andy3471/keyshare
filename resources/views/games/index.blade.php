@extends('layouts.app')

@section('content')

<div class="container">
    <h2> {{$title}} </h1>

    @if(count($games) > 0)
        @php ($i = 1)
        <div class="card-deck">
        @foreach($games as $game)
            <div class="card" style="width: 18rem;">
                @if($title == 'Claimed Keys' or $title == 'Shared Keys')
                    <a href="/keys\{{$game->key_id}}">
                @else
                    <a href="/games\{{$game->id}}">
                @endif
                    <img src="{{asset('/images/gamedefault.png')}}" alt="Card image cap" class="card-img-top">

                        <div class="card-body">
                            <p class="card-text">
                                {{$game->name}}
                            </p>
                            </a>
                        </div>
            </div>

                @if(!($i % 4))
                    </div><br><div class="card-deck">
                @endif
                @php ($i++)

        @endforeach
        </div>
    @else
        <p> No Games Found </p>
    @endif

    <br>

        {!! $games->links(); !!}

</div>
@endsection
