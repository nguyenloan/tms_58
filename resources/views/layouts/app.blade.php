<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ trans('settings.title') }}</title>
    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="/bower/bootstrap/dist/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="/bower/font-awesome/css/font-awesome.css"/>
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" type="text/css" href="/bower/font-awesome/css/landing_page.css"/>
    @yield('css')
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">{{ trans('settings.toggle') }}</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ trans('settings.company') }}
                </a>
            </div>
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">{{ trans('settings.home') }}</a></li>
                    @if (Auth::check())
                        <li><a href="{{ url('/course') }}">{{ trans('settings.course') }}</li>
                    @endif
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li>
                            <a href="#" data-toggle="modal" data-target="#login">{{ trans('settings.login') }}</a>
                        </li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#register">{{ trans('settings.register') }}</a>
                        </li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('users.show', ['id' => Auth::user()->id ]) }}">
                                        <i class="fa fa-btn fa-user"></i>{{ trans('settings.profile') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>{{ trans('settings.logout') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    @include('auth.login')
    @include('auth.register')
    @yield('content')
    <!-- JavaScripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>
</html>
