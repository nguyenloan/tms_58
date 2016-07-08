<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <title>{{ $title or trans('general/label.e_learning') }}</title>
    @include('layout.styles')
</head>
<body>
    @include('layout.header')
    <div>
        @include('layout.left-sidebar')
        <div class="col-sm-8">
            <section>
                @include('layout.result')
                @yield('content')
            </section>
        </div>
    </div>
    @include('layout.scripts')
    @yield('script')
</body>
</html>
