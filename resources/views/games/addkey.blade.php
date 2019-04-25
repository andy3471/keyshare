@extends('layouts.app')

@section('header')
    {{ __('keys.addkey') }}
@endsection

@section('content')
    <div class="container">

        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{ $error }}</div> <br>
        @endforeach

        <form method="POST" action="/addkey/store">
            @csrf
            <label for="gamename">{{ __('keys.game') }}: </label>
            <game-autocomplete placeholder="" id="gamename" name="gamename" classes="form-control"></game-autocomplete>

            <label for="platform"> {{ __('keys.platform') }}: </label>
            <select class='form-control' name='platform_id'>
                @foreach($platforms as $platform)
                    <option value="{{$platform->id}}">{{$platform->name}}</option>
                @endforeach
            </select>


            <label for="key"> {{ __('keys.key') }}: </label>
            <input name="key" class="form-control" type="text" required>
            <label for="message"> {{ __('keys.message') }}: </label>
            <textarea name="message" class="form-control" type="text"></textarea>
            <br>
            <input type="submit" class="btn btn-keyshare" value="{{ __('keys.add') }}">
        </form>
    </div>
@endsection
