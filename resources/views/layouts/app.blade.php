<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'AmbulAnapp') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            max-width: 100%;
            overflow-x: hidden;
        }
        .navbar {
            padding: 10px 0;
        }
        .navbar-brand {
            font-size: 1.4rem;
            font-weight: bold;
        }
        .nav-link {
            font-size: 1rem;
            padding: 0.5rem 1rem;
        }
        .container {
            padding-left: 15px;
            padding-right: 15px;
        }
        footer {
            font-size: 0.8rem;
        }
        @media (min-width: 768px) {
            .container {
                max-width: 720px;
                margin: 0 auto;
            }
            body {
                background-color: #f8f9fa;
            }
            .content-wrapper {
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
                margin-top: 20px;
                padding: 20px;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="content-wrapper">
        <header class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" width="30" height="30" class="d-inline-block align-top">
                    {{ config('app.name', 'AmbulAnapp') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        @auth
                        @endauth
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @if(Auth::check())
                                        @if(Auth::user()->avatar && file_exists(public_path(Auth::user()->avatar)))
                                            <img src="{{ asset(Auth::user()->avatar) }}" alt="Avatar" class="rounded-circle" width="30" height="30">
                                        @else
                                            <span class="rounded-circle bg-primary text-white d-inline-flex justify-content-center align-items-center" style="width: 30px; height: 30px;">
                                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                            </span>
                                        @endif
                                        {{ Auth::user()->name }}
                                    @endif
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @if(Auth::user()->role === 'admin')
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-tachometer-alt"></i> Dashboard
                                        </a>
                                    @endif
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-user"></i> Profil
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-cog"></i> Pengaturan
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
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
        </header>
        <div style="padding-top: 70px;">
            <!-- Konten utama akan dimulai di sini -->
        </div>

        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>

        <footer class="bg-light text-center text-lg-start mt-4">
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
                © 2024 AmbulAnapp
            </div>
        </footer>
    </div>

    @yield('scripts')
</body>
</html>
