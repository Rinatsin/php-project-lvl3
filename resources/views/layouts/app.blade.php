<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Page Analizer</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="csrf-param" content="_token" />
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .nav-item {
                font-size: 22px;
            }

            .text-uppercase {
                text-transform: uppercase;
            }

            .navbar-nav {
                display: flex;
                flex-direction: column;
                padding-left: 0;
                margin-bottom: 0;
                list-style: none;
            }

            .form-control {
                display: block;
                width: 100%;
                height: calc(1.6em + .75rem + 2px);
                padding: .375rem .75rem;
                font-size: .9rem;
                font-weight: 400;
                line-height: 1.6;
                color: #636b6f;
                background-color: #fff;
                background-clip: padding-box;
                border: 1px solid #ced4da;
                border-radius: .25rem;
                transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            }

            .form-control-lg {
                height: calc(1.5em + 1rem + 2px);
                padding: .5rem 1rem;
                font-size: 2.125rem;
                line-height: 1.5;
                border-radius: .3rem;
            }

            .text-uppercase {
                text-transform: uppercase!important;
            }

            .pl-5, .px-5 {
                padding-left: 3rem!important;
            }

            .pr-5, .px-5 {
                padding-right: 3rem!important;
            }

            .ml-3, .mx-3 {
                margin-left: 1rem!important;
            }

            .btn-group-lg>.btn, .btn-lg {
                padding: .5rem 1rem;
                font-size: 2.125rem;
                line-height: 2.5;
                border-radius: .3rem;
            }

            .btn-primary {
                color: #fff;
                background-color: #3490dc;
                border-color: #3490dc;
            }

            .btn {
                display: inline-block;
                font-weight: 400;
                color: #212529;
                text-align: center;
                vertical-align: middle;
                cursor: pointer;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                background-color: transparent;
                border: 1px solid transparent;
                padding: .375rem .75rem;
                font-size: .9rem;
                line-height: 1.6;
                border-radius: .25rem;
                transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            }

            .btn-lg {
                color: #fff;
                background-color: #3490dc;
                border-color: #3490dc;
                padding: .5rem 1rem;
                font-size: 1.125rem;
                line-height: 1.5;
                border-radius: .3rem;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 70px;
            }

            .links {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 20px;
            }
        </style>
    </head>
    <body>
        <div>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="{{  url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('domains.index') }}">Domains</a>
                </li>
            </ul>
        </div>
        @include('flash::message')
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
            <div>
            @yield('content');
            </div>

        </div>
    </body>
</html>
