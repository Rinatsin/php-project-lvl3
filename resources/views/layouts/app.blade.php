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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 300;
                line-height: 3.6;
                margin: 0;
            }
            table {
                font-size: 14px;
                border-collapse: collapse;
                text-align: center;
            }
            th, td:first-child {
                background: #AFCDE7;
                color: white;
                padding: 10px 20px;
            }
            th, td {
                border-style: solid;
                border-width: 0 1px 1px 0;
                border-color: white;
                padding: 10px 10px !important;
            }
            td {
                background: #D8E6F3;
            }
            th:first-child, td:first-child {
                text-align: left;
            }
            .jumbotron {
                background-color: darkolivegreen;
                color: #ffffff;
            }

            .navbar {
                margin-bottom: 0;
                background-color: darkolivegreen;
                z-index: 9999;
                border: 0;
                font-size: 16px !important;
                line-height: 1.42857143 !important;
                letter-spacing: 2px;
                border-radius: 0;
            }
            .navbar li a, .navbar .navbar-brand {
                color: #fff !important;
            }

            footer .glyphicon {
                font-size: 20px;
                margin-bottom: 20px;
                color: #f4511e;
            }
        </style>
    </head>
    <body>
        <header>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{  url('/') }}">Page Analyzer</a>
                </div>
                <div>
                    <ul class="nav navbar-nav">
                        <li><a href="{{  url('/') }}">Home</a></li>
                        <li><a href="{{ route('domains.index') }}">Domains</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        </header>
        @include('flash::message')
        <div>
            @yield('content');
        </div>
        <footer class="border-top py-3 mt-5">
           <div class="container-lg">
               <div class="text-center">
                    <p>Site Made By <a href="https://boiling-crag-79525.herokuapp.com/" title="Rinat Salimyanov">Rinat Salimyanov</a></p>
               </div>
           </div>
        </footer>
    </body>
</html>
