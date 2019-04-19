@extends('layouts.app')

@section('content')

<div class="container">
    <div class="title">
        <h2> {{$key->platform}} - {{$key->game}} </h2>
    </div>

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

    <br><p> {{ __('keys.sharedby') }}: </p>
    <div class="media">
        <a href="\user\{{$key->created_user_id}}">
            <img class="mr-3" src="{{asset('/images/defaultpic.jpg')}}" width="150px" height="150px" alt="Generic placeholder image">
        </a>
        <div class="media-body">
            <h5 class="mt-0"><a href="\user\{{$key->created_user_id}}">{{$key->created_user_name}}</a></h5>
            <p> Bio Here </p>
            <a href=https://steamcommunity.com/profiles/test> View Steam Profile </a>
        </div>
</div>
@endsection
