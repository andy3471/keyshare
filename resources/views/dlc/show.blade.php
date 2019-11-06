@extends('layouts.app')

@section('header')
    {{ $dlc->game->name }}- {{ $dlc->name }}
@endsection

@section('content')

<div class="container">
    <img src="{{ asset($dlc->image) }}" class="img-fluid mx-auto d-block rounded">
    <br>
    <a href="{{ route('editdlc', $dlc) }}">{{ __('dlc.editdlc') }}</a><br>
    <br>
    <p> {{$dlc->description}} </p>

    <table class="table">

        @if(count($keys) > 0)
            <tr>
                <th>{{ __('dlc.platform') }}</th>
                <th>{{ __('dlc.addedby') }}</th>
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

</div>
@endsection
