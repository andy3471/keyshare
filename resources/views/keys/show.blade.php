@extends('layouts.app')

@section('header')
    {{$key->platform}} - {{$key->game}}
@endsection

@section('content')
    <div class="container">
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif

        @if(session()->has('error'))
            <div class="alert alert-error">
                {{ session()->get('error') }}
            </div>
        @endif

        <form action="{{ route('claimkey') }}" method="post">
        @csrf

            @if( $key->owned_user_id == null)
                <input name="key" class="form-control" type="text" value ="*****-*****-*****-*****" disabled>
                <input type="hidden" name="id" value="{{$key->id}}" /> <br>
                <input type="submit" class="btn btn-keyshare" value="Claim Key">
                <br> {{ __('keys.claim') }}

            @elseif( $key->owned_user_id == auth()->id())
                <input name="key" class="form-control" type="text" value ="{{$key->keycode}}" disabled>
                @if($key->platform == 'Steam')
                    <br><a href="https://store.steampowered.com/account/registerkey?key={{$key->keycode}}"> Redeem on Steam</a>
                @endif

            @else
                <input name="key" class="form-control" type="text" value ="*****-*****-*****-*****" disabled>
                <input type="submit" class="btn btn-keyshare" value="Claim Key" disabled>
                <br> {{ __('keys.alreadyclaimed') }}
            @endif
        </form>

        @if ($key->message)
            {{ __('keys.leftMessage') }}: <br>
             {{$key->message}}
        @endif

        <br><p> {{ __('keys.sharedby') }}: </p>
        <div class="media">
            <a href="\user\{{$key->created_user_id}}">
                <img class="mr-3" src="{{ $key->created_user_image }}" width="150px" height="150px" alt="Generic placeholder image">
            </a>
            <div class="media-body">
                <h5 class="mt-0">
                    <a href="\users\{{$key->created_user_id}}">{{$key->created_user_name}}</a>
                    @php( $k = Auth::user()->getKarma($key->created_user_id) )
                    <span class="badge badge-pill {{ $k->color }}"> {{$k->score}} </span>
                </h5>
                <p> {{ $key->created_user_bio }} </p>
                <a href=https://steamcommunity.com/profiles/test> View Steam Profile </a>
            </div>

    </div>
@endsection
