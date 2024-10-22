<!doctype html>
<html lang="en">

<head>
    @include('layouts.main.head')
    {{-- <script src="https://www.google.com/recaptcha/enterprise.js?render={{ env('SITE_KEY') }}" async defer></script> --}}

    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        function onSubmit(token) {
            document.getElementById("form").submit();
        }
    </script>

</head>

<body class="auth" @if (request()->is('signup'))
    style="background-image:unset !important;"
@endif>
    @include('sweetalert::alert')
    @yield('container')
    @include('layouts.main.script')
</body>

</html>
