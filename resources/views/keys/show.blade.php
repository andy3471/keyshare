@extends('layouts.app')

@section('header')
    {{$key->platform->name}} - {{$key->name}}
@endsection

@section('content')
    <div class="container">

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
                @if($key->platform->name == 'Steam')
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
            <a href="\users\{{$key->createduser->id}}">
                <img class="mr-3" src="{{ $key->createduser->image }}" width="150px" height="150px" alt="Generic placeholder image">
            </a>
            <div class="media-body">
                <h5 class="mt-0">
                    <a href="\users\{{ $key->createduser->id }}">{{$key->createduser->name}}</a>
                    <span class="badge badge-pill {{ $key->createduser->karma_colour }}"> {{ $key->createduser->karma }} </span>
                </h5>
                <p> {{ $key->createduser->bio }} </p>
            </div>

    </div>
@endsection
