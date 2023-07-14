<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Crescent | Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="#">
    <link rel="shortcut icon" href="{{ asset('/images/favicon.png') }}">
    <link href="{{ mix('/css/backend.css') }}" rel="stylesheet" type="text/css">

    @yield('backend-style')

</head>

<body class="hold-transition skin-blue sidebar-mini">

    <div class="wrapper">

        @include('backend.partials.navbar')

        @include('backend.partials.sidebar')

        <div class="content-wrapper">

            @include('backend.partials.page-header')
            
            <section class="content">
                
                @include('flash::message')

                @yield('content')

            </section>
        </div>

        <footer class="main-footer">
            <strong>Copyright &copy; {{ date('Y') }} <a href="https://crescent.com">Crescent Education Connsultancy</a>.</strong> All rights reserved.
        </footer>

    </div>

    <script src="{{ mix('/js/backend.js') }}"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
    @yield('backend-script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.custom-textarea').ckeditor({
                    extraPlugins : 'justify',
            });
        });
    </script>
</body>
</html>
