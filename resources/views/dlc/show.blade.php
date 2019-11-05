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
                    <a href="/keys/{{$key->id}}">{{$key->platform}}</a>
                </td>
                    <td>
                        <a href="/users/{{$key->created_user_id}}">
                            {{$key->created_user_name}}
                        </a>
                        @php( $k = Auth::user()->getKarma($key->created_user_id) )
                        <span class="badge badge-pill {{ $k->color }}"> {{$k->score}} </span>
                    </td>
                <tr>
            @endforeach
        @else
            <p> {{ __('games.nokeys') }} <p>
        @endif
    </table>

</div>
@endsection
