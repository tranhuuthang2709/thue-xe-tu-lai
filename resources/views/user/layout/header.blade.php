<div class="container-fluid">
    <nav class="navbar navbar-expand-lg header-nav">
        <div class="navbar-header">
            <a href="{{ route('home') }}" class="navbar-brand logo">
                <img src="{{ asset('user') }}/assets/img/logo.png" class="img-fluid" alt="Logo">
            </a>
        </div>
        <div class="main-menu-wrapper">
            <ul class="main-nav">
                <li class="active"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="has-submenu">
                    <a href="{{ route('list_car') }}">Danh sách xe </a>
                    {{-- <i class="fas fa-chevron-down"></i>
                    <ul class="submenu">
                        <li><a href="listing-grid.html">Xe 4 chỗ</a></li>
                        <li><a href="listing-list.html">xe 5 chỗ</a></li>
                        <li><a href="listing-details.html">Xe 7 chỗ</a></li>
                    </ul> --}}
                </li>
                <li class="has-submenu">
                    <a href="#">Giới thiệu </a>
                </li>
                <li><a href="">Liên hệ</a></li>
            </ul>
        </div>

        @if (Auth::check())
            <div class="dropdown">
                <a style="background-color:#ffa633;color:white;" class=" btn dropdown-toggle" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Xin chào {{ Auth::user()->last_name }}
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('profile') }}" class="dropdown-item">Thông tin cá nhân</a></li>
                    @if (Auth::user()->role !== 'customer')
                        <li><a href="{{ route('admin.home') }}" class="dropdown-item">Trang quản lý </a></li>
                    @endif
                    <li><a href="{{ route('user.bookings') }}" class="dropdown-item">Đơn thuê của bạn</a></li>
                    <li><a href="{{ route('favorite_cars') }}" class="dropdown-item">Yêu thích</a></li>
                    <li><a href="{{ route('cart.index') }}" class="dropdown-item">Giỏ hàng của bạn</a></li>
                    <li><a href="{{ route('change_password') }}" class="dropdown-item">Đổi mật khẩu</a></li>
                    @if (Auth::user()->role === 'customer')
                        <li><a href="{{ route('lessor.register') }}" class="dropdown-item">Đăng kí cho thuê xe
                            </a></li>
                    @endif
                    <li><a href="{{ route('logout') }}" class="dropdown-item">Đăng xuất</a></li>
                </ul>
            </div>
        @else
            <ul class="nav header-navbar-rht">
                <li class="nav-item">
                    <a class="nav-link header-login" href="{{ route('login') }}"><span><i
                                class="fa-regular fa-user"></i></span>Đăng
                        nhập</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link header-reg" href="{{ route('register') }}"><span><i
                                class="fa-solid fa-lock"></i></span>Đăng
                        ký</a>
                </li>
            </ul>
        @endif

    </nav>
</div>
