<!DOCTYPE html>
<html>
<head>
    <title>@yield('title','')</title>
    <meta name="robots" content="noimageindex, nofollow, noindex">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
   {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">--}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,600;1,300;1,600&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-color-1: #fdbb2d;
            --brand-color-1-accent: #ffd94f;
            --brand-color-2: #12284c;
            --brand-color-2-light: #d9e6fa;
            --school-banner-img: url({{asset('image/skyhawksbanner.png')}});
        }
    </style>
    <link rel="stylesheet" type="text/css" href=" {{asset('css/bundle.css')}}">
    @yield('css')
</head>
<body>
@php($org_url = \App\Helpers\Common::getOrganizationUrl())
<header>
    <div class="header__navbar">
        <a class="header__navbar__logo" href="#">
            <img src="{{asset('image/flc-skyhawk-logo-sqaure.png')}}">
        </a>
        <ul>
            <li><a href="#">Tickets</a></li>
            <li><a href="{{ route('cart',$org_url) }}">Cart</a></li>
            @if(auth('web')->user())
                <li><a href="{{route('myaccount',$org_url)}}">Account</a></li>
                <li><a href="{{route('myaccount',$org_url)}}">Logout</a></li>
            @else
                <li><a  href="{{route('login',$org_url)}}">Login</a></li>
                <li><a  href="{{route('login',$org_url)}}">Register</a></li>

            @endif
        </ul>
    </div>
    <div class="header__banner">
        <img src="{{asset('image/skyhawksbanner.png')}}">
    </div>
    <div class="header__searchbar">
        <span>Search bar here</span>
    </div>
</header>
<div class="site-container">
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
<footer>
    <div class="footer__sponsors">
        <h5>Thank you to our sponsors:</h5>
        <div class="footer__sponsors__grid">
            <div class="footer__sponsors__grid__single"><!-- img --><span>Logo</span></div>
            <div class="footer__sponsors__grid__single"><!-- img --><span>Logo</span></div>
            <div class="footer__sponsors__grid__single"><!-- img --><span>Logo</span></div>
            <div class="footer__sponsors__grid__single"><!-- img --><span>Logo</span></div>
            <div class="footer__sponsors__grid__single"><!-- img --><span>Logo</span></div>
        </div>
    </div>
    <div class="footer__main">
        <span>Footer main</span>
    </div>
</footer>




</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('js/front//app.js')}}"></script>
<!-- Core theme JS-->
@yield('scripts')
</html>
