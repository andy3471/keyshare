@extends('layouts.app')

@section('header')
    {{ $title }}
@endsection

@section('content')
    <div class="page">
        <Game-List url="{{ $url }}"></Game-List>
    </div>
@endsection
