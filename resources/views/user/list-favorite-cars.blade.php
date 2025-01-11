@extends('user.index')

@section('content')
    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row align-items-center text-center">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title">Danh sách xe yêu thích</h2>
                </div>
            </div>
        </div>
    </div>
    <section class="section car-listing">
        <div class="container">
            <div class="row">
                @if ($favorite->isEmpty())
                    <div class="text-center">
                        <h3>Không có xe yêu thích nào!</h3>
                        <a href="{{ route('list_car') }}">Quay lại danh sách xe</a>
                    </div>
                @else
                    @foreach ($favorite as $item)
                        @php
                            $car = $item->car;
                        @endphp
                        <div class="listview-car">
                            <div class="card">
                                <div class="blog-widget d-flex">
                                    <div class="blog-img position-relative">
                                        <a href="{{ route('detail', $car->id) }}">
                                            <img src="{{ asset('storage/img_car/' . $car->main_image) }}" width="350px"
                                                class="img-fluid" alt="blog-img">
                                        </a>
                                    </div>
                                    <div class="bloglist-content w-100">
                                        <div class="card-body">
                                            <div class="blog-list-head d-flex">
                                                <div class="blog-list-title">
                                                    <h3><a href="{{ route('detail', $car->id) }}">{{ $car->name }}</a>
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
                                                    @else
                                                        <p class="discount-price me-3">
                                                            {{ number_format($car->price) }} VND</p>
                                                    @endif
                                                    <span>/ Ngày</span>
                                                </div>
                                            </div>
                                            <div class="listing-details-group mt-2">
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
                                                                class="feather-calendar me-2"></i></span>Xem xe ngay</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="blog-pagination">
                <nav>
                    <ul class="pagination page-item justify-content-center">
                        <li class="previtem">
                            <a class="page-link" href="{{ $favorite->previousPageUrl() }}">
                                <i class="fas fa-regular fa-arrow-left me-2"></i> Trước
                            </a>
                        </li>
                        <li class="nextlink">
                            <a class="page-link" href="{{ $favorite->nextPageUrl() }}">
                                Sau <i class="fas fa-regular fa-arrow-right ms-2"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
@endsection
