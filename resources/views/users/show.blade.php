@extends('layouts.app')

@section('header')
    {{ $user->name }}
@endsection

@section('content')
    <div class="container">
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif

        <div class="media">
            <img src="{{ $user->image }}" class="mr-3" width="250px" height="250px">
            <div class="media-body">
                <h5 class="mt-0"> {{ $user->name }}
                    @php( $k = Auth::user()->getKarma($user->id) )
                    <span class="badge badge-pill {{ $k->color }}"> {{$k->score}} </span>
                </h5>
                <p>
                    {{ $user->bio }}

                    @if(( $user->id == auth()->id() ))
                        <br>
                        <a href="{{ route('edituser') }}">{{ __('nav.updateprofile') }}</a>
                    @endif

                </p>
            </div>
        </div>
    </div>
@endsection
