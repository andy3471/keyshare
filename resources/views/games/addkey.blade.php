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
            <add-key></add-key>
        </form>

    </div>
@endsection
