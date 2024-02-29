@extends('layouts.app')

@section('header')
    {{ __('auth.demomode') }}
@endsection

@section('content')
    <div class="container">
        <p> {{ __('auth.demomodelong') }} </p>
    </div>
@endsection
