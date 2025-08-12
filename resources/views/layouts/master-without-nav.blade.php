<!doctype html>
<html lang="ar"dir="rtl">

    <head>
        <meta charset="utf-8" />
        <title> @yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico')}}">
        @include('layouts.head-css-login')
  </head>

    @yield('body')
    
    
    @yield('content')


    @include('layouts.vendor-scripts-login')
    </body>
</html>
