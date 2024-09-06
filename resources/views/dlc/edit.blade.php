@extends('layouts.app')

@section('header')
        {{ __('dlc.edit') }}: {{ $dlc->name }}
@endsection

@section('content')
    <div class="container">
        <form
            method="POST"
            action="/games/dlc/update"
            enctype="multipart/form-data"
        >
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
                <br />
            @endforeach

            @csrf
            <input type="hidden" name="dlcid" value="{{ $dlc->id }}" />
            <img
                src="{{ asset($dlc->image) }}"
                class="img-fluid mx-auto d-block rounded"
            />
            <label for="image">
                {{ __('dlc.image') }}: ({{ __('dlc.imagereqs') }})
            </label>
            <br />
            <input name="image" type="file" />
            <br />

            <label for="name">{{ __('dlc.name') }}:</label>
            <input
                name="name"
                class="form-control"
                type="text"
                value="{{ $dlc->name }}"
                required
            />

            <label for="Game">{{ __('dlc.gamename') }}:</label>
            <auto-complete
                placeholder="{{ $dlc->game->name }}"
                id="gamename"
                name="gamename"
                classes="form-control"
                required="false"
            ></auto-complete>

            <label for="description">{{ __('dlc.description') }}:</label>
            <input
                name="description"
                class="form-control"
                type="text"
                value="{{ $dlc->description }}"
            />
            <br />
            <input
                type="submit"
                class="btn btn-keyshare"
                value="{{ __('nav.save') }}"
            />
        </form>
    </div>
@endsection
