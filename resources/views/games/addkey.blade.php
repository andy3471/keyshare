@extends('layouts.app')

@section('content')
<div class="container">
    <div class="title">
        <h2> {{ __('games.addkey') }} </h2>
    </div>

    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif

    <form method="POST" action="/addkey/store">
        @csrf
        <label for="gamename">{{ __('games.game') }}: </label>
        <game-autocomplete placeholder="" id="gamename" name="gamename" classes="form-control"></game-autocomplete>

        <label for="platform"> {{ __('games.platform') }}: </label>
        <select class='form-control' name='platform_id'>
            @foreach($platforms as $platform)
                <option value="{{$platform->id}}">{{$platform->name}}</option>
            @endforeach
        </select>


        <label for="key"> {{ __('games.key') }}: </label>
        <input name="key" class="form-control" type="text" required>
        <br>
        <input type="submit" class="btn btn-keyshare" value="Submit">
    </form>
</div>
@endsection
