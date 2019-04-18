@extends('layouts.app')

@section('content')

<div class="page">
    <div class="title">
        <h2> {{$title}}</h1>
    </div>

<Game-List url="{{ $url }}"></Game-List>
</div>

@endsection
