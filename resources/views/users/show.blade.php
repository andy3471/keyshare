@extends('layouts.app')

@section('header')
    {{ $user->name }}
@endsection

@section('content')
    <div class="container">

        <div class="media">
            <img src="{{ $user->image }}" class="img-fluid mr-3" width="150px" height="150px">
            <div class="media-body">
                <h5 class="mt-0"> {{ $user->name }}
                    <span class="badge badge-pill {{ $user->karma_colour }}"> {{ $user->karma }} </span>
                </h5>
                <p>
                    {{ $user->bio }}

                    @if(( $user->id == auth()->id() ))
                        <br>
                        <a href="{{ route('users.edit', $user->id) }}">{{ __('nav.updateprofile') }}</a>
                    @endif

                </p>
            </div>
        </div>
    </div>
@endsection
