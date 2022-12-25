<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/styleHeader.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="icon/logoBigger.ico">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <title>@yield('title')</title>

    <!-- Fonts -->

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @vite(['resources/js/app.js'])
</head>



<body>

    @if (Auth::check() &&
        !(Route::currentRouteName() == 'about you') &&
        !(Route::currentRouteName() == 'edit profile'))
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/home') }}">
                        PictureClear
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- 
                        Searches for the courses and returns a page with many courses that look alike the one being search
                        or returns a page of the only course found
                    -->

                    <div class="container">
                        <form method="GET" action="{{ url('/checkCourse') }}">
                            <div class="col-md-8">
                                <div class="search">
                                    <i class="fa fa-search"></i>
                                    <input min="1" step="any" placeholder="Procurar curso"
                                        class="form-control @error('findCourse') is-invalid @enderror" type="search"
                                        name="findCourse" value="{{ old('findCourse') }}" required
                                        autocomplete="findCourse" autofocus aria-label="Search"
                                        aria-describedby="search-addon">
                                    <button class="btn btn-outline-primary" type="submit">
                                        Procurar
                                    </button>
                                    @error('findCourse')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                    </div>
                    </form>
                </div>



                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                    </ul>
                    <ul class="navbar-nav ms-auto">

                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/course') }}">{{ __('Criar Curso') }}</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}
                                    <img id="profilepicture"  style="border-radius: 50% !important; height: 25px !important"
                                        src="{{ Auth::user()->picture != null ? 'storage/images/' . Auth::user()->picture .'' : 'images/default-profilepicture.png' }}"
                                        alt="{{ Auth::user()->picture != null ? Auth::user()->picture : 'default-profilepicture.png' }}">
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url("/profile/?username=" . Auth::user()->username) }}">
                                    {{ __('Meu perfil') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('edit profile') }}">
                                    {{ __('Editar perfil') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
        </div>
        </nav>
    @endif

    <main class="py-4">
        @yield('content')
    </main>
    </div>
</body>

</html>
