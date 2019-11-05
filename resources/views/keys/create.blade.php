@extends('layouts.app')

@section('header')
    {{ __('keys.addkey') }}
@endsection

@section('content')
    <div class="container">

        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{ $error }}</div> <br>
        @endforeach

        <add-key csrf="{{csrf_token()}}"></add-key>

    </div>
@endsection
