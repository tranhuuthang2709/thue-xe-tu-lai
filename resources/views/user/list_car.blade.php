@extends('user.index')
@section('content')
    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row align-items-center text-center">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title">Danh sách xe cho thuê</h2>
                </div>
            </div>
        </div>
    </div>
    <section class="section car-listing">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-sm-12 col-12 theiaStickySidebar">
                    <a href="{{ route('list_car') }}">Quay lại</a>
                    <!-- Form tìm kiếm sử dụng phương thức GET -->
                    <form action="{{ route('search') }}" method="GET" autocomplete="off" class="sidebar-form">
                        <div class="sidebar-heading">
                            <h3>Nhập tên xe bạn muốn tìm kiếm</h3>
                        </div>
                        <div class="product-search">
                            <div class="form-custom">
                                <input type="text" class="form-control" id="member_search1" name="search"
                                    placeholder="Tìm kiếm xe...">
                                <span><img src="{{ asset('user') }}/assets/img/icons/search.svg" alt="img"></span>
                            </div>
                        </div>

                        <!-- Thương hiệu -->
                        <div class="accordion" id="accordionMain1">
                            <div class="card-header-new" id="headingOne">
                                <h6 class="filter-title">
                                    <a href="javascript:void(0);" class="w-100" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Thương hiệu
                                        <span class="float-end"><i class="fa-solid fa-chevron-down"></i></span>
                                    </a>
                                </h6>
                            </div>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample1">
                                <div class="card-body-chat">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="checkBoxes1">
                                                <div class="selectBox-cont">
                                                    @foreach ($brands as $brand)
                                                        <label class="custom_check w-100">
                                                            <input type="checkbox" name="brand[]"
                                                                value="{{ $brand->id }}">
                                                            <span class="checkmark"></span> {{ $brand->name }}
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Loại xe -->
                        <div class="accordion" id="accordionMain2">
                            <div class="card-header-new" id="headingTwo">
                                <h6 class="filter-title">
                                    <a href="javascript:void(0);" class="w-100 collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                        Loại xe
                                        <span class="float-end"><i class="fa-solid fa-chevron-down"></i></span>
                                    </a>
                                </h6>
                            </div>
                            <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample2">
                                <div class="card-body-chat">
                                    <div id="checkBoxes2">
                                        <div class="selectBox-cont">
                                            @foreach ($categories as $cate)
                                                <label class="custom_check w-100">
                                                    <input type="checkbox" name="category[]" value="{{ $cate->id }}">
                                                    <span class="checkmark"></span> {{ $cate->name }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Giá -->
                        <div class="accordion" id="accordionMain4">
                            <div class="card-header-new" id="headingFour">
                                <h6 class="filter-title">
                                    <a href="javascript:void(0);" class="w-100 collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                        Giá
                                        <span class="float-end"><i class="fa-solid fa-chevron-down"></i></span>
                                    </a>
                                </h6>
                            </div>
                            <div id="collapseFour" class="collapse show" aria-labelledby="headingFour"
                                data-bs-parent="#accordionMain4">
                                <div class="card-body-chat">
                                    <div class="filter-range">
                                        <!-- Min Price Range -->
                                        <input type="range" class="input-range" id="minPriceRange" name="min_price"
                                            min="0" max="5000000" step="100" value="0"
                                            oninput="updatePriceRange()">
                                        <!-- Max Price Range -->
                                        <input type="range" class="input-range" id="maxPriceRange" name="max_price"
                                            min="0" max="5000000" step="100" value=""
                                            oninput="updatePriceRange()">
                                        <div class="d-flex justify-content-between">
                                            <span id="minPrice">Từ 0</span>
                                            <span id="maxPrice"> đến 10,000,000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit"
                            class="d-inline-flex align-items-center justify-content-center btn w-100 btn-primary filter-btn">
                            <span><i class="feather-filter me-2"></i></span>Tìm kiếm
                        </button>
                    </form>
                </div>
                <div class="col-xl-9 col-lg-8 col-sm-12 col-12">
                    <div class="row">
                        @if ($cars->isEmpty())
                            <div class="text-center">
                                <h3>Không tìm thấy xe mong muốn!</h3>
                                <a href="{{ route('list_car') }} ">Quay lại danh sách xe</a>
                            </div>
                        @endif
                        @foreach ($cars as $car)
                            <div class="listview-car">
                                <div class="card">
                                    <div class="blog-widget d-flex">
                                        <div class="blog-img position-relative">
                                            <a href="{{ route('detail', $car->id) }}">
                                                <img src="{{ asset('storage/img_car/' . $car->main_image) }}"
                                                    width="350px" class="img-fluid" alt="blog-img">
                                            </a>
                                            <div class="fav-item1 position-absolute top-0 start-0">
                                                <span>{{ $car->brand->name }}</span>
                                            </div>
                                        </div>
                                        <div class="bloglist-content w-100">
                                            <div class="card-body">
                                                <div class="blog-list-head d-flex">
                                                    <div class="blog-list-title">
                                                        <h3><a
                                                                href="{{ route('detail', $car->id) }}">{{ $car->name }}</a>
                                                        </h3>
                                                        <h6>Danh mục : <span>{{ $car->category->name }}</span></h6>
                                                    </div>
                                                    <div class="blog-list-rate d-flex align-items-center">
                                                        @if ($car->discounted_price > 0)
                                                            <p class="mb-0 me-3">
                                                                <span class="old-price">{{ number_format($car->price) }}
                                                                    VND</span>
                                                            </p>
                                                            <p class="discount-price me-3">
                                                                {{ number_format($car->discounted_price) }} VND
                                                            </p>
                                                            <span>/ Ngày</span>
                                                        @else
                                                            <p class="discount-price me-3">
                                                                {{ number_format($car->price) }}
                                                                VND</p>
                                                            <span>/ Ngày</span>
                                                            </p>
                                                        @endif
                                                    </div>

                                                </div>
                                                <div class="listing-details-group">
                                                    <ul>
                                                        <li>
                                                            <span><img
                                                                    src="{{ asset('user') }}/assets/img/icons/car-parts-01.svg"></span>
                                                            <p>
                                                                {{ $car->transmission }}
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <span><img
                                                                    src="{{ asset('user') }}/assets/img/icons/car-parts-02.svg"></span>
                                                            <p>Màu {{ $car->color }}</p>
                                                        </li>
                                                        <li>
                                                            <span><img
                                                                    src="{{ asset('user') }}/assets/img/icons/car-parts-03.svg"></span>
                                                            <p>{{ $car->fuel_type }}</p>

                                                        </li>
                                                        <li>
                                                            <span><img
                                                                    src="{{ asset('user') }}/assets/img/icons/car-parts-04.svg"></span>
                                                            <p>{{ $car->license_plate }}</p>
                                                        </li>
                                                        <li>
                                                            <span><img
                                                                    src="{{ asset('user') }}/assets/img/icons/car-parts-05.svg"></span>
                                                            <p>{{ $car->manufacture_year }}</p>
                                                        </li>
                                                        <li>
                                                            <span><img
                                                                    src="{{ asset('user') }}/assets/img/icons/car-parts-06.svg"></span>
                                                            <p>{{ $car->seat }}</p>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="blog-list-head list-head-bottom d-flex">
                                                    <div class="blog-list-title">
                                                        <div class="title-bottom">
                                                            <div class="address-info">
                                                                <h6><i
                                                                        class="feather-map-pin me-2"></i>{{ $car->address->province }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="listing-button">
                                                        <a href="{{ route('detail', $car->id) }}"
                                                            class="btn btn-order"><span><i
                                                                    class="feather-calendar me-2"></i></span>Xem xe
                                                            ngay</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div>

                    <div class="blog-pagination">
                        <nav>
                            <ul class="pagination page-item justify-content-center">
                                <li class="previtem">
                                    <a class="page-link" href="{{ $cars->previousPageUrl() }}">
                                        <i class="fas fa-regular fa-arrow-left me-2"></i> Trước
                                    </a>
                                </li>
                                @php
                                    $currentPage = $cars->currentPage();
                                    $lastPage = $cars->lastPage();
                                    $pageRange = 5;
                                    $startPage = max(1, $currentPage - floor($pageRange / 2));
                                    $endPage = min($lastPage, $currentPage + floor($pageRange / 2));
                                @endphp
                                <li class="justify-content-center pagination-center">
                                    <div class="page-group">
                                        <ul>
                                            @foreach ($cars->getUrlRange(1, $cars->lastPage()) as $page => $url)
                                                <li class="page-item">
                                                    <a class="page-link {{ $cars->currentPage() == $page ? 'active' : '' }}"
                                                        href="{{ $url }}">{{ $page }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>

                                <!-- Liên kết "Sau" -->
                                <li class="nextlink">
                                    <a class="page-link" href="{{ $cars->nextPageUrl() }}">
                                        Sau <i class="fas fa-regular fa-arrow-right ms-2"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        function updatePriceRange() {
            var minPriceRange = document.getElementById("minPriceRange");
            var maxPriceRange = document.getElementById("maxPriceRange");
            var minPrice = document.getElementById("minPrice");
            var maxPrice = document.getElementById("maxPrice");
            var minPriceValue = minPriceRange.value;
            var maxPriceValue = maxPriceRange.value;
            if (parseInt(minPriceValue) > parseInt(maxPriceValue)) {
                minPriceRange.value = maxPriceValue;
                minPriceValue = maxPriceValue;
            }
            minPrice.textContent = 'Từ ' +
                parseInt(minPriceValue).toLocaleString() + 'VND';
            maxPrice.textContent = 'đến ' +
                parseInt(maxPriceValue).toLocaleString() + ' VND';
        }
        updatePriceRange();
    </script>

    <style>
        .input-range {
            width: 100%;
        }

        .filter-range {
            margin-top: 10px;
        }

        .d-flex {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
    </style>
@endsection
