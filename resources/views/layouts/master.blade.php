<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="SFVN" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    {{--CSRF Token--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', '@Master Layout'))</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/icons.min.css">
    <link rel="stylesheet" href="/assets/css/app.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    @yield('styles')
</head>
<body>
    <div id="wrapper">
        @include('components.topbar')
        @include('components.left-sidebar')
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            @include('components.footer')
        </div>
    </div>

    <script src="/assets/js/vendor.min.js"></script>
    <script src="/assets/js/app.min.js"></script>
    <script src="/assets/js/tool.js"></script>
    @yield('scripts')
</body>
</html>
