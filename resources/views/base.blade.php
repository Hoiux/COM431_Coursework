<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Comment Bank</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" />
</head>

<body>
    @yield('main')

    <!-- end bootstrap model -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
