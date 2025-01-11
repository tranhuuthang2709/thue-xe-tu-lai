<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layout.head')
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        @include('admin.layout.sidebar')
        <!-- End Sidebar -->

        <div class="main-panel">
            @include('admin.layout.main_header')

            <div class="container">
                @yield('content')
            </div>
        </div>
    </div>
    @include('admin.layout.js')
</body>

</html>
