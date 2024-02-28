<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark navbar-keyshare bg-dark fixed-top">
            <a class="navbar-brand mr-auto" href="{{ route('index') }}">{{ config('app.name', 'Laravel') }}</a>
            @guest
            @else
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            @endif
            @guest
            @elseif ( Auth::User()->approved == 0)
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="./viewuser.php?id=" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ Auth::user()->image }}" height="25px" width="25px"> {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            @else
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('games.index') }}">{{ __('games.games') }}</a>
                        </li>


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="{{ route('games.index') }}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ __('games.platforms') }}
                            </a>


                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @foreach ($platforms as $platform)
                                    <a class="dropdown-item" href="{{ route('platforms.show', $platform->id) }}">{{ $platform->name }}</a>
                                @endforeach

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('keys.create') }}">{{ __('nav.addkey') }}</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ml-auto">
                        <form class="form-inline" method="get" action="{{ route('search.index') }}">
                            <auto-complete url='api/search/games/' placeholder="{{ __('nav.search') }}..." name="search" id="search" type="search" classes="form-control navbar-search"></auto-complete>
                        </form>


                        @can('admin',Auth::user())
                            <li class="nav-item dropdown">
                                <a href="{{ route('filament.admin.pages.dashboard') }}" class="nav-link" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('admin.admin') }}
                                </a>
                            </li>
                        @endcan


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="./viewuser.php?id=" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ Auth::user()->image }}" height="25px" width="25px"> {{ Auth::user()->name }}

                                <span class="badge badge-pill {{ Auth::user()->karma_colour }}"> {{ Auth::user()->karma }} </span>

                            </a>


                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/users/{{auth()->id()}}">{{ __('nav.viewprofile') }}</a>
                                <a class="dropdown-item" href="{{ route('users.edit', auth()->user()->id) }}">{{ __('nav.updateprofile') }}</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('keys.claimed.index') }}">{{ __('nav.claimedkeys') }}</a>
                                <a class="dropdown-item" href="{{ route('keys.shared.index') }}">{{ __('nav.sharedkeys') }}</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('password.reset.request') }}">{{ __('nav.changepassword') }}</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>

                    </ul>
                </div>
            @endif
        </nav>

        <div class="jumbotron">
            @if (file_exists(public_path('images/logo_override.png')))
                <img src="{{ asset('images/logo_override.png')}}" width="137" height="110">
            @else
                <img src="{{ asset('images/logo_default.png')}}" width="137" height="110">
            @endif
        </div>



        <title-header title="@yield('header')"></title-header>

        @if(session()->has('message'))
            <div class="container">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session()->get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif

        @yield('content')
</body>
</html>
