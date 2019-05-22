@extends('layouts.app')

@section('header')
    {{ __('auth.notapproved') }}
@endsection

@section('content')
    <div class="container">
        <p> {{ __('auth.notapporvedlong') }} </p>


        <button class="btn btn-keyshare" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
@endsection
