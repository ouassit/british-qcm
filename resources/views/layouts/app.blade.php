<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{asset('js/jquery-3.6.0.min.js')}}?v={{ time() }}" crossorigin="anonymous"></script>
    <script src="{{asset('js/jquery-ui.min.js')}}?v={{ time() }}" crossorigin="anonymous"></script>
    <script src="{{asset('js/popper.min.js')}}?v={{ time() }}" crossorigin="anonymous"></script>
    <script src="{{asset('js/bootstrap.min.js')}}?v={{ time() }}" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}?v={{ time() }}" defer></script>
    <script src="{{ asset('js/solid.min.js') }}?v={{ time() }}" defer></script>
    <script src="{{ asset('js/fontawesome.min.js') }}?v={{ time() }}" defer></script>
    <!--<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>-->
    <script src="{{ asset('js/common.js') }}?v={{ time() }}" defer></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}?v={{ time() }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}?v={{ time() }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}?v={{ time() }}">

</head>
<body class="app-body">
    <div id="app" class="app-shell">
        <nav class="navbar navbar-expand-md app-navbar">
            <div class="container-fluid app-container">
                <a class="navbar-brand app-brand" href="/dashboard">
                    <span class="app-brand-mark">PT</span>
                    <span>{{ config('app.name', 'Laravel') }}</span>
                </a>
                <button class="navbar-toggler app-navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @guest
                    @else
                        <ul class="navbar-nav me-auto app-nav">
                            @if(Auth::user()->super_admin)
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                        {{ __('Admin Dashboard') }}
                                    </a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                                        {{ __('Categories') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('quizs.*') ? 'active' : '' }}" href="{{ route('quizs.index') }}">
                                        {{ __('Tests') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('questions.*') ? 'active' : '' }}" href="{{ route('questions.index') }}">
                                        {{ __('Questions') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('students_tests.*') ? 'active' : '' }}" href="{{ route('students_tests.index') }}">
                                        {{ __('Students Tests') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" href="{{ route('settings.index') }}">
                                        {{ __('Settings') }}
                                    </a>
                                </li>
                            @endif
                        </ul>
                    @endif

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto app-account">
                        <!-- Authentication Links -->
                        @guest
                        @else
                            
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle app-user-link" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <span class="app-user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/logout"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <a class="dropdown-item" href="/change-password">
                                        {{ __('Change Password') }}
                                    </a>

                                    <form id="logout-form" action="/logout" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="app-main">
            <div class="app-content">
                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')

</body>
</html>
