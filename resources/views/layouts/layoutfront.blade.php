<!DOCTYPE html>
<html>
<head>
    <title>@yield('title','ISP')</title>
    <meta name="robots" content="noimageindex, nofollow, noindex">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
     @yield('css')
</head>
<body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="background-color: #000 !important;">
            <div class="container">
                <a class="navbar-brand" href="{{ route('front') }}" style="flex: 10"><img src="{{ asset('image/logo.png') }}" width="40%" ></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{ route('front') }}">Home</a></li>
                        @if(auth('web')->user())
                        <li class="nav-item"><a class="nav-link" href="{{route('logout')}}">Logout</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('myaccount')}}">Account# {{auth('web')->user()->sonarId}}</a></li>
                        @else
                        <li class="nav-item"><a class="nav-link" href="{{route('login')}}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('login')}}">Register</a></li>
                        @endif 
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart') }}">Cart ({{ count((array) session('cart')) }})</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page content-->
        <div class="container">

            @if(session('success'))
            <div class="alert alert-success mt-5">
                {{ session('success') }}
            </div> 
            @endif
            @if(session('error'))
            <div class="alert alert-danger mt-5">
                {{ session('error') }}
            </div> 
            @endif
            @yield('content')
        </div>
        @yield('scripts')
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
</body>
</html>