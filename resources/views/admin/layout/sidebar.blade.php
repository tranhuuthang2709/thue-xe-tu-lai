<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('home') }}" class="logo">
                <p class="logo-edit">Thuê xe tự lái</p>
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Danh sách</h4>
                </li>
                <li class="nav-item active">
                    <a href="{{ route('admin.home') }}" class="collapsed">
                        <i class="fas fa-home"></i>
                        <p>Trang chủ</p>
                    </a>
                </li>
                @can('admin')
                    <li class="nav-item">
                        <a href="{{ route('category.index') }}">
                            <i class="fas fa-layer-group"></i>
                            <p>Danh mục</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('brand.index') }}">
                            <i class="fas fa-building"></i>
                            <p>Thương hiệu</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}">
                            <i class="fas fa-user"></i>
                            <p>Người dùng</p>
                        </a>
                    </li>
                @endcan
                @can('admin-lessor')
                    <li class="nav-item">
                        <a href="{{ route('car.index') }}">
                            <i class="fas fa-th-list"></i>
                            <p>Danh sách xe</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('booking.rentedCars') }}">
                            <i class="fa fa-cart-arrow-down"></i>
                            <p>Xe đang được thuê</p>
                        </a>
                    </li>
                @endcan
                @can('admin-employee')
                    <li class="nav-item">
                        <a href="{{ route('booking.index') }}">
                            <i class="fas fa-pen-square"></i>
                            <p>Đơn thuê</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('booking.listRefund') }}">
                            <i class="fa fa-ban"></i>
                            <p>Đơn hủy</p>
                        </a>
                    </li>
                @endcan
                <li class="nav-item">
                    <a href="{{ route('booking.listReturnCar') }}">
                        <i class="fa fa-undo"></i>
                        <p>Trả xe</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('listReport') }}">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>Danh sách xe hư hỏng</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
