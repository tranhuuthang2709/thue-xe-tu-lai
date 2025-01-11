@extends('user.index')
@section('content')
    <div>
        <section class="banner-section banner-slider">
            <div class="container">
                <div class="home-banner">
                    <div class="row align-items-center">
                        <div class="col-lg-6" data-aos="fade-down">
                            <h1>Cho thuê xe tự lái</h1>
                            <p style="color: black; ">Với dịch vụ cho thuê xe tự lái chất lượng, đảm bảo an toàn và tiện
                                nghi,
                                chúng tôi mang đến cho bạn những trải nghiệm di chuyển tuyệt vời.</p>
                            <div class="view-all">
                                <a href="{{ route('list_car') }}" class="btn btn-view d-inline-flex align-items-center">Xem
                                    chi tiết <span><i class="feather-arrow-right ms-2"></i></span></a>
                            </div>
                        </div>
                        <div class="col-lg-6" data-aos="fade-down">
                            <div class="banner-imgs">
                                <img src="{{ asset('user') }}/assets/img/car-right.png" class="img-fluid aos"
                                    alt="bannerimage">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- tìm kiếm --}}
        </section>
        <div class="section-search">
            <div class="container">
                <div class="search-box-banner">
                    <form action="{{ route('search') }}" method="GET">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <div class="input-block">
                                    <label for="location">Chọn tỉnh/thành phố</label>
                                    <div class="group-img">
                                        <select class="form-control" id="province1" name="province1">
                                            <option value="">Chọn Tỉnh/Thành phố</option>
                                        </select>
                                        <input type="hidden" name="province1_value" id="province1_value">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-block">
                                    <label for="brand">Hãng xe</label>
                                    <div class="group-img">
                                        <select id="brand" name="brand[]" class="form-control">
                                            <option value="">Chọn hãng xe</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="input-block">
                                    <label for="seats">Số chỗ ngồi</label>
                                    <div class="group-img ">
                                        <select id="seats" name="seat" class="form-control">
                                            <option value="">Chọn số chỗ ngồi</option>
                                            <option value="4">4 chỗ</option>
                                            <option value="5">5 chỗ</option>
                                            <option value="7">7 chỗ</option>
                                        </select>
                                        <!-- <span ><i class="feather-users"></i></span> -->
                                    </div>
                                </div>
                            </div>



                            <!-- Nút tìm kiếm -->
                            <div class="col-md-2">
                                <div class="input-block">
                                    <div class="search-btn mt-4">
                                        <button class="btn search-button" type="submit">
                                            <i class="fa fa-search" aria-hidden="true"></i> Tìm kiếm
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <section class="section services">
            <div class="service-right">
                <img src="{{ asset('user') }}/assets/img/bg/service-right.svg" class="img-fluid" alt="services right">
            </div>
            <div class="container">

                <div class="section-heading" data-aos="fade-down">
                    <h2>Hướng dẫn thuê xe</h2>
                    <p>Chỉ với 3 bước đơn giản để trải nghiệm thuê xe cung chúng tôi một cách nhanh chóng</p>
                </div>

                <div class="services-work">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-12" data-aos="fade-down">
                            <div class="services-group">
                                <div class="services-icon border-secondary">
                                    <img class="icon-img bg-secondary"
                                        src="{{ asset('user') }}/assets/img/icons/services-icon-01.svg"
                                        alt="Choose Locations">
                                </div>
                                <div class="services-content">
                                    <h3>1. Chọn xe cần thuê</h3>
                                    <p>Dễ dàng tìm kiếm và lựa chọn chiếc xe phù hợp với nhu cầu của bạn từ đa dạng mẫu mã
                                        và thương hiệu.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-12" data-aos="fade-down">
                            <div class="services-group">
                                <div class="services-icon border-warning">
                                    <img class="icon-img bg-warning"
                                        src="{{ asset('user') }}/assets/img/icons/services-icon-02.svg"
                                        alt="Choose Locations">
                                </div>
                                <div class="services-content">
                                    <h3>2. Địa điểm nhận xe</h3>
                                    <p>Chọn địa điểm thuận tiện nhất để nhận xe, từ các điểm giao nhận chính thức đến các
                                        địa điểm được chỉ định.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-12" data-aos="fade-down">
                            <div class="services-group">
                                <div class="services-icon border-dark">
                                    <img class="icon-img bg-dark"
                                        src="{{ asset('user') }}/assets/img/icons/services-icon-03.svg"
                                        alt="Choose Locations">
                                </div>
                                <div class="services-content">
                                    <h3>3. Đặt xe</h3>
                                    <p>Chỉ cần vài thao tác đơn giản, bạn có thể đặt xe nhanh chóng và dễ dàng.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section popular-services popular-explore">
            <div class="container">
                <div class="tab-content">
                    <div class="section-heading" data-aos="fade-down">
                        <h2>Những xe phổ bến nhất</h2>
                        <p>Khám phá những mẫu xe được kết hợp giữa hiệu suất mạnh mẽ và thiết kế ấn tượng.</p>
                    </div>
                    <div class="tab-pane active" id="Carmazda">
                        <div class="row">
                            @foreach ($cars as $car)
                                <div class="col-lg-4 col-md-6 col-12" data-aos="fade-down">
                                    <div class="listing-item">
                                        <div class="listing-img">
                                            <a href="{{ route('detail', $car->id) }}">
                                                <img src="{{ asset('storage/img_car/' . $car->main_image) }}"
                                                    class="img-fluid" alt="{{ $car->name }}">

                                            </a>
                                            <div class="fav-item">
                                                <a href="#" class=" featured-text ">{{ $car->brand->name }}</a>
                                                <a href="#" class="fav-icon">
                                                    <i class="feather-heart"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="listing-content">
                                            <div class="listing-features">
                                                <h3 class="listing-title">
                                                    <a href="listing-details.html">{{ $car->name }}</a>
                                                </h3>
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
                                                </ul>
                                                <ul>
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
                                            <div class="listing-location-details">
                                                <div class="listing-price" style="font-size: 12px">
                                                    <span><i class="feather-map-pin"></i></span>
                                                    {{ $car->address->province }}
                                                </div>
                                                <div class="listing-price">
                                                    @if ($car->discounted_price > 0)
                                                        <p>
                                                            <span
                                                                class="old-price">{{ number_format($car->price) }}</span>
                                                            <span
                                                                class="discount-price">{{ number_format($car->discounted_price) }}</span>VND
                                                            <span>/ Ngày</span>
                                                        </p>
                                                    @else
                                                        <p>
                                                            <span
                                                                class="discount-price">{{ number_format($car->price) }}</span>
                                                            <span>/ Ngày</span>
                                                        </p>
                                                    @endif

                                                </div>

                                            </div>
                                            <div class="listing-button">
                                                <a href="{{ route('detail', $car->id) }}" class="btn btn-order"><span><i
                                                            class="feather-calendar me-2"></i></span>Xem ngay</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="section-heading mt-5" data-aos="fade-down">
                    <h2>Khám phá các hãng xe được yêu thích</h2>
                    <p>Chúng tôi cung cấp xe từ các thương hiệu nổi tiếng,
                        đảm bảo chất lượng và sự thoải mái.</p>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-12" data-aos="fade-down">
                        <div class="listing-tabs-group">
                            <ul class="nav listing-buttons gap-3" data-bs-tabs="tabs">
                                @foreach ($brands as $brand)
                                    <li>
                                        <a class="" href="{{ route('search', ['brand' => [$brand->id]]) }}">
                                            <span>
                                                <img width="30px"
                                                    src="{{ asset('storage/img_brand/' . $brand->image) }}">
                                            </span>
                                            {{ $brand->name }}
                                        </a>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        </section>
        <section class="section popular-services">
            <div class="container">
                <div class="section-heading" data-aos="fade-down">
                    <h2>Xếp hạng những xe được đặt nhiều nhất</h2>
                    <p>Khám phá những chiếc xe được nhiều người đặt nhất</p>
                </div>
                <div class="row">
                    <div class="popular-slider-group">
                        <div class="owl-carousel rental-deal-slider owl-theme owl-loaded owl-drag">
                            <div class="owl-stage-outer">
                                <div class="owl-stage"
                                    style="transform: translate3d(-1685px, 0px, 0px); transition: 2s; width: 3034px;">
                                    @foreach ($topcars as $topcar)
                                        <div class="owl-item" style="width: 313.067px; margin-right: 24px;">
                                            <div class="rental-car-item">
                                                <div class="listing-item mb-0">
                                                    <div class="listing-img">
                                                        <a href="{{ route('detail', $topcar->id) }}">
                                                            <img src="{{ asset('storage/img_car/' . $topcar->main_image) }}"
                                                                class="img-fluid" alt="{{ $topcar->name }}">

                                                        </a>
                                                        <div class="fav-item">
                                                            <a href="#"
                                                                class=" featured-text ">{{ $topcar->brand->name }}</a>
                                                            <a href="#" class="fav-icon">
                                                                <i class="feather-heart"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="listing-content">
                                                        <div class="listing-features">
                                                            <h3 class="listing-title">
                                                                <a href="listing-details.html">{{ $topcar->name }}</a>
                                                            </h3>
                                                        </div>
                                                        <div class="listing-details-group">
                                                            <ul>
                                                                <li>
                                                                    <span><img
                                                                            src="{{ asset('user') }}/assets/img/icons/car-parts-01.svg"></span>
                                                                    <p>
                                                                        {{ $topcar->transmission }}
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <span><img
                                                                            src="{{ asset('user') }}/assets/img/icons/car-parts-02.svg"></span>
                                                                    <p>Màu {{ $topcar->color }}</p>
                                                                </li>
                                                                <li>
                                                                    <span><img
                                                                            src="{{ asset('user') }}/assets/img/icons/car-parts-03.svg"></span>
                                                                    <p>{{ $topcar->fuel_type }}</p>

                                                                </li>
                                                            </ul>
                                                            <ul>
                                                                <li>
                                                                    <span><img
                                                                            src="{{ asset('user') }}/assets/img/icons/car-parts-04.svg"></span>
                                                                    <p>{{ $topcar->license_plate }}</p>
                                                                </li>
                                                                <li>
                                                                    <span><img
                                                                            src="{{ asset('user') }}/assets/img/icons/car-parts-05.svg"></span>
                                                                    <p>{{ $topcar->manufacture_year }}</p>
                                                                </li>
                                                                <li>
                                                                    <span><img
                                                                            src="{{ asset('user') }}/assets/img/icons/car-parts-06.svg"></span>
                                                                    <p>{{ $topcar->seat }}</p>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="listing-location-details">
                                                            <div class="listing-price" style="font-size: 12px">
                                                                <span><i
                                                                        class="feather-map-pin"></i></span>{{ $topcar->address->province }}
                                                            </div>
                                                            <div class="listing-price">
                                                                @if ($topcar->discounted_price > 0)
                                                                    <p>
                                                                        <span
                                                                            class="old-price">{{ number_format($topcar->price) }}</span>
                                                                        <span
                                                                            class="discount-price">{{ number_format($topcar->discounted_price) }}</span>VND
                                                                        <span>/ Ngày</span>
                                                                    </p>
                                                                @else
                                                                    <p>
                                                                        <span
                                                                            class="price">{{ number_format($topcar->price) }}</span>
                                                                        <span>/ Ngày</span>
                                                                    </p>
                                                                @endif

                                                            </div>

                                                        </div>
                                                        <div class="listing-button">
                                                            <a href="{{ route('detail', $topcar->id) }}"
                                                                class="btn btn-order"><span><i
                                                                        class="feather-calendar me-2"></i></span>Xem
                                                                ngay</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                            <div class="owl-nav disabled"><button type="button" role="presentation" class="owl-prev"><i
                                        class="fa-solid fa-arrow-left"></i></button><button type="button"
                                    role="presentation" class="owl-next"><i class="fa-solid fa-arrow-right"></i></button>
                            </div>
                            <div class="owl-dots disabled"></div>
                        </div>
                    </div>
                </div>
                <div class="view-all text-center" data-aos="fade-down">
                    <a href="{{ route('list_car') }}" class="btn btn-view d-inline-flex align-items-center">Xem tất cả xe
                        <span><i class="feather-arrow-right ms-2"></i></span></a>
                </div>

            </div>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.owl-carousel').owlCarousel({
                loop: true, // Bật vòng lặp
                margin: 24, // Khoảng cách giữa các mục
                nav: true, // Bật nút điều hướng
                dots: true, // Hiển thị các nút chấm
                autoplay: true, // Bật tự động chạy
                autoplayTimeout: 3000, // Thời gian chuyển đổi
                autoplayHoverPause: true, // Dừng khi hover
                responsive: {
                    0: {
                        items: 1
                    }, // Hiển thị 1 sản phẩm trên màn hình nhỏ
                    600: {
                        items: 2
                    }, // Hiển thị 2 sản phẩm trên màn hình vừa
                    1000: {
                        items: 3
                    } // Hiển thị 3 sản phẩm trên màn hình lớn
                }
            });
        });
        const host = "https://provinces.open-api.vn/api/";

        // Hàm gọi API để lấy dữ liệu
        var callAPI = (api, selectId) => {
            return axios.get(api)
                .then((response) => {
                    renderData(response.data, selectId);
                })
                .catch((error) => {
                    console.error("Error fetching data from API: ", error);
                });
        }

        // Gọi API để lấy danh sách tỉnh
        callAPI('https://provinces.open-api.vn/api/?depth=1', 'province1');

        // Hàm render dữ liệu vào dropdown
        var renderData = (array, selectId) => {
            let options = '<option value="">Chọn</option>';
            array.forEach(element => {
                options +=
                    `<option value="${element.code}" data-name="${element.name}">${element.name}</option>`;
            });
            document.querySelector(`#${selectId}`).innerHTML = options;
        }

        // Khi người dùng thay đổi lựa chọn tỉnh (province1)
        $("#province1").change(() => {
            let provinceCode = $("#province1").val(); // Lấy mã tỉnh đã chọn
            let provinceName = $("#province1 option:selected").data("name"); // Lấy tên tỉnh

            // Cập nhật giá trị của input ẩn (province1_value) để gửi lên form
            $("input[name='province1_value']").val(provinceName);

            // Hiển thị lại kết quả khi thay đổi tỉnh (tùy chọn nếu bạn muốn hiển thị thêm)
            printResult(provinceName);
        });

        // Hàm hiển thị kết quả khi thay đổi tỉnh (tùy chọn)
        var printResult = (provinceName) => {
            if (provinceName) {
                console.log("Chọn tỉnh: " + provinceName);
            }
        }
    </script>
@endsection
