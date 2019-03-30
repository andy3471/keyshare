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
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name', 'Laravel') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                  @guest
                  @else
                      <a class="nav-link dropdown-toggle" href="./viewuser.php?id=" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                      </a>
                      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/users/{{auth()->id()}}">View Profile</a>
                        <a class="dropdown-item" href="./updateuser.php">Update Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('claimedkeys') }}">Claimed Keys</a>
                        <a class="dropdown-item" href="{{ route('sharedkeys') }}">Shared Keys</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                          onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                          {{ __('Logout') }}
                        </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                      </div>
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('games') }}">Games</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('addkey') }}">Add Key</a>
                    </li>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('users') }}">Top Users</a>
                    </li>


                  </ul>
                  <form class="form-inline my-2 my-lg-0" method="get" action="{{ route('search') }}">
                    <game-autocomplete placeholder="Search..." name="search" id="search" type="search" classes="form-control mr-sm-2"></game-autocomplete>
                    <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
                  </form>
                </div>
              @endif
          </nav>

            -->


                  <div class="jumbotron">
                      <img src="{{ asset('images/LogoWeb.png') }}" alt="360NoHope" width="137" height="110">
                  </div>

            <div class="Container">

            @yield('content')
    </div>
</body>
</html>
