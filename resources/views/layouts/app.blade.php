<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark navbar-keyshare bg-dark fixed-top">
            <a class="navbar-brand mr-auto" href="{{ route('home') }}">{{ config('app.name', 'Laravel') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            @guest
            @elseif ( Auth::User()->approved == 0)
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="./viewuser.php?id=" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ Auth::user()->image }}" height="25px" width="25px"> {{ Auth::user()->name }}

                                @php( $k = Auth::user()->getKarma() )
                                <span class="badge badge-pill {{ $k->color }}"> {{$k->score}} </span>

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
                            <a class="nav-link" href="{{ route('games') }}">{{ __('games.games') }}</a>
                        </li>


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="{{ route('games') }}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ __('games.platforms') }}
                            </a>


                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @foreach ($platforms as $platform)
                                    <a class="dropdown-item" href="/platform/{{ $platform->id }}">{{ $platform->name }}</a>
                                @endforeach

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('addkey') }}">{{ __('nav.addkey') }}</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ml-auto">
                        <form class="form-inline" method="get" action="{{ route('search') }}">
                            <autocomplete placeholder="{{ __('nav.search') }}..." name="search" id="search" type="search" classes="form-control navbar-search"></autocomplete>
                        </form>


                        @can('admin',Auth::user())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="./viewuser.php?id=" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('admin.admin') }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('adminshowusers') }}">{{ __('admin.users') }}</a>
                                </div>
                            </li>
                        @endcan


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="./viewuser.php?id=" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ Auth::user()->image }}" height="25px" width="25px"> {{ Auth::user()->name }}

                                <span class="badge badge-pill {{ Auth::user()->karma_color }}"> {{ Auth::user()->karma }} </span>

                            </a>


                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/users/{{auth()->id()}}">{{ __('nav.viewprofile') }}</a>
                                <a class="dropdown-item" href="{{ route('edituser') }}">{{ __('nav.updateprofile') }}</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('claimedkeys') }}">{{ __('nav.claimedkeys') }}</a>
                                <a class="dropdown-item" href="{{ route('sharedkeys') }}">{{ __('nav.sharedkeys') }}</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('changepassword') }}">{{ __('nav.changepassword') }}</a>
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
            <img src="{{ asset('images/LogoWeb.png') }}" alt="360NoHope" width="137" height="110">
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
