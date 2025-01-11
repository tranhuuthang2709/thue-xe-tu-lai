<!DOCTYPE html>
<html lang="en">

<head>
    @include('user.layout.head')
</head>

<body>
    <div class="main-wrapper">

        <header class="header">
            @include('user.layout.header')
        </header>

        {{-- home --}}
        @yield('content')


        <footer class="footer">
            @include('user.layout.footer')
        </footer>


    </div>

    @include('user.layout.js')
</body>

</html>
