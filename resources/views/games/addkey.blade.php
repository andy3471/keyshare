@extends('layouts.app')

@section('content')
<div class="container">
    <h2> Add Key </h2>
    
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif

    <form method="POST" action="/addkey/store">
        @csrf
        <label for="gamename">Game: </label>
        <input id="gamename" name="gamename" class="form-control" required>
        
        <label for="platform"> Platform: </label>      
        <select class='form-control' name='platform_id'>
            @foreach($platforms as $platform)
                <option value="{{$platform->id}}">{{$platform->name}}</option>
            @endforeach
        </select>
    
    
        <label for="key"> Key: </label>
        <input name="key" class="form-control" type="text" required>
        <br>
        <input type="submit" class="btn btn-default" value="Submit">
    </form>
</div>
@endsection
