<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>E-Library | @yield('title')</title>


    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    @yield('custom_style')
</head>
<body>
    <!-- Loader  -->
    <div class="loader-container">
        <img src="{{ asset('frontend/assets/images/loader-img.gif') }}" alt="Loader GIF">
    </div>


    <!-- Navbar -->
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#"><i class="fas fa-book"></i> E-Library</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false">
                        <i class="fas fa-align-right text-primary"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <div class="me-auto"></div>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" aria-current="page" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('books') || request()->is('books/*') ? 'active' : '' }}" href="{{ route('books.index') }}">Library</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('authors') || request()->is('authors/*') ? 'active' : '' }}" href="{{ route('authors.index') }}">Authors</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('genres') || request()->is('genres/*') ? 'active' : '' }}" href="{{ route('genres.index') }}">Genres</a>
                            </li>
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->is('login') ? 'active' : '' }}" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->is('register') ? 'active' : '' }}" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                                @else
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            {{ Auth::user()->name }}
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
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
        </div>
    </header>

    @yield('content')

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-12 footer-col">
                    <p class="title mb-5">company</p>
                    <ul>
                        <li><a href="#">about us</a></li>
                        <li><a href="#">our services</a></li>
                        <li><a href="#">privacy policy</a></li>
                        <li><a href="#">event program</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-sm-12 footer-col">
                    <p class="title mb-5">get help</p>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">shipping</a></li>
                        <li><a href="#">returns</a></li>
                        <li><a href="#">order status</a></li>
                        <li><a href="#">payment options</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-sm-12 footer-col">
                    <p class="title mb-5">books shop</p>
                    <ul>
                        <li><a href="#">english</a></li>
                        <li><a href="#">myanmar</a></li>
                        <li><a href="#">japan</a></li>
                        <li><a href="#">korea</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-sm-12 footer-col">
                    <p class="title mb-5">follow us</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('frontend/js/script.js') }}"></script>
    @yield('custom_script')
</body>
</html>
