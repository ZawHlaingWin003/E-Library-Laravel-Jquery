<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard | @yield('title')</title>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    @yield('custom_style')
</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5">
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin6">

                    <a class="navbar-brand" href="index.html">
                        <span class="logo-text text-dark">
                            E-Library
                        </span>
                    </a>
                    <a
                    class="
                        nav-toggler
                        waves-effect waves-light
                        text-dark
                        d-block d-md-none
                    "
                    href="javascript:void(0)"
                    >
                        <i class="ti-menu ti-close"></i
                    ></a>
                </div>
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <ul class="navbar-nav ms-auto d-flex align-items-center">
                        <li class="in">
                            <form role="search" class="app-search d-none d-md-block me-3">
                                <input
                                    type="text"
                                    placeholder="Search..."
                                    class="form-control mt-0"
                                />
                                <a href="" class="active">
                                    <i class="fa fa-search"></i>
                                </a>
                            </form>
                        </li>
                        <li>
                            <a class="profile-pic p-0" href="#">
                                <img
                                    src="https://ui-avatars.com/api/?name={{ auth()->guard('admin_user')->user()->name }}"
                                    alt="user-img"
                                    width="36"
                                    class="img-circle"
                                />
                                <span class="text-white font-medium">
                                    @if (Auth::guard('admin_user')->check())
                                        <a class="d-inline-block nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                            {{ Auth::guard('admin_user')->user()->name }}
                                            <i class="fa fa-arrow-down"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                            onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    @endif
                                </span>
                            </a>
                        </li>

                    </ul>
                </div>
            </nav>
        </header>

        <aside class="left-sidebar" data-sidebarbg="skin6">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="sidebar-item pt-2">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('admin') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="fa fa-globe"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('admin/admin_users') || request()->is('admin/admin_users/upload') ? 'active' : '' }}" href="{{ route('admin_users.index') }}">
                                <i class="fa fa-user-tie"></i>
                                <span class="hide-menu">Admin Users</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('admin/users') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                <i class="fa fa-user"></i>
                                <span class="hide-menu">Users</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('admin/book_list') || request()->is('admin/books/create') || request()->is('admin/books/*/edit') ||  request()->is('admin/books/upload') ? 'active' : '' }}" href="{{ route('books.list') }}">
                                <i class="fa fa-book"></i>
                                <span class="hide-menu">Books</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('admin/author_list') || request()->is('admin/authors/create') || request()->is('admin/authors/*/edit') ? 'active' : '' }}" href="{{ route('authors.list') }}">
                                <i class="fa fa-users"></i>
                                <span class="hide-menu">Authors</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('admin/genre_list') || request()->is('admin/genres/create') || request()->is('admin/genres/*/edit') ? 'active' : '' }}" href="{{ route('genres.list') }}">
                                <i class="fa fa-list"></i>
                                <span class="hide-menu">Genres</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('admin/subscribed_list') ? 'active' : '' }}" href="{{ route('subscribed_list') }}">
                                <i class="fa fa-envelope"></i>
                                <span class="hide-menu">Subscribed Email List</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="page-wrapper">
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">@yield('title')</h4>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                @yield('content')
            </div>

            <footer class="footer text-center">
            {{ date('Y') }} © David Zaw. You can download admin dashboard at
            <a href="https://www.wrappixel.com/">wrappixel.com</a>
            </footer>
        </div>

    </div>

    <script src="{{ asset('dashboard/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/echart.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="{{ asset('dashboard/js/custom.js') }}"></script>
    @yield('custom_script')
</body>
</html>
