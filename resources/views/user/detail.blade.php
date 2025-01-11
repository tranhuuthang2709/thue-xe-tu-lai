@extends('user.index')
@section('content')
    <section class="product-detail-head">
        <div class="container">
            <div class="detail-page-head">
                <div class="detail-headings">
                    <div class="star-rated">
                        <div class="camaro-info">
                            <h2>{{ $car_detail->name }}</h2>
                            <div class="camaro-location mt-2">
                                <div class="camaro-location-inner">
                                    <i class="feather-map-pin me-2"></i>
                                    <span class="me-2"> <b>Địa chỉ xe :</b> {{ $car_detail->address->street }},
                                        {{ $car_detail->address->ward }}, {{ $car_detail->address->district }},
                                        {{ $car_detail->address->province }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="details-btn">
                    @if (Auth::check())
                        @if (auth()->user()->favorites()->where('car_id', $car_detail->id)->exists())
                            <a style="background: #127384; color: #ffffff;" href="{{ route('favorite', $car_detail->id) }}">
                                <i class="feather-heart"></i> Bỏ thích
                            </a>
                        @else
                            <a href="{{ route('favorite', $car_detail->id) }}"><i class="feather-heart"></i> Yêu thích</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}"><i class="feather-heart"></i>Đăng nhập để yêu thích</a>
                    @endif

                </div>
            </div>
        </div>
    </section>
    <section class="section product-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="detail-product">
                        <div class="slider detail-bigimg">
                            <div class="product-img">
                                <img src="{{ asset('storage/img_car/' . $car_detail->main_image) }}" alt="Slider">
                            </div>
                            @foreach ($car_detail->images as $slider)
                                <div class="product-img">
                                    <img src="{{ asset('storage/img_car/' . $slider->image) }}" alt="Slider">
                                </div>
                            @endforeach

                        </div>
                        <!-- Lặp lại các ảnh nếu có ít hơn 6 ảnh -->
                        @php
                            $images = collect([$car_detail->main_image])
                                ->merge($car_detail->images->pluck('image'))
                                ->toArray();
                            $images = array_pad($images, 6, null);
                            $images = array_filter($images);
                            $total_images = count($images);
                            while (count($images) < 6) {
                                $images[] = $images[$total_images % $total_images];
                                $total_images++;
                            }
                        @endphp
                        <div class="slider slider-nav-thumbnails">
                            <div class="product-img">
                                <img src="{{ asset('storage/img_car/' . $car_detail->main_image) }}" alt="Slider">
                            </div>
                            @foreach ($car_detail->images as $slider)
                                <div class="product-img">
                                    <img src="{{ asset('storage/img_car/' . $slider->image) }}" alt="Slider">
                                </div>
                            @endforeach
                            @foreach ($images as $image)
                                <div class="product-img">
                                    <img src="{{ asset('storage/img_car/' . $image) }}" alt="Slider">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="review-sec specification-card ">
                        <div class="review-header">
                            <h4>Thông số kĩ thuật</h4>
                        </div>
                        <div class="card-body">
                            <div class="lisiting-featues">
                                <div class="row">
                                    <div class="featureslist d-flex align-items-center col-xl-3 col-md-4 col-sm-6">
                                        <div class="feature-img">
                                            <img src="{{ asset('user') }}/assets/img/specification/specification-icon-1.svg"
                                                alt="Icon">
                                        </div>
                                        <div class="featues-info">
                                            <span>Hãng xe </span>
                                            <h6> {{ $car_detail->brand->name }}</h6>
                                        </div>
                                    </div>
                                    <div class="featureslist d-flex align-items-center col-xl-3 col-md-4 col-sm-6">
                                        <div class="feature-img">
                                            <img src="{{ asset('user') }}/assets/img/specification/specification-icon-2.svg"
                                                alt="Icon">
                                        </div>
                                        <div class="featues-info">
                                            <span>Danh mục </span>
                                            <h6> {{ $car_detail->category->name }}</h6>
                                        </div>
                                    </div>
                                    <div class="featureslist d-flex align-items-center col-xl-3 col-md-4 col-sm-6">
                                        <div class="feature-img">
                                            <img src="{{ asset('user') }}/assets/img/specification/specification-icon-3.svg"
                                                alt="Icon">
                                        </div>
                                        <div class="featues-info">
                                            <span>Hộp số </span>
                                            <h6> {{ $car_detail->transmission }}</h6>
                                        </div>
                                    </div>
                                    <div class="featureslist d-flex align-items-center col-xl-3 col-md-4 col-sm-6">
                                        <div class="feature-img">
                                            <img src="{{ asset('user') }}/assets/img/specification/specification-icon-4.svg"
                                                alt="Icon">
                                        </div>
                                        <div class="featues-info">
                                            <span>Nhiên liệu </span>
                                            <h6>
                                                {{ $car_detail->fuel_type == 'gasoline' ? 'Xăng' : ($car_detail->fuel_type == 'oil' ? 'Dầu' : ($car_detail->fuel_type == 'electric' ? 'Điện' : 'Khác')) }}
                                            </h6>

                                        </div>
                                    </div>
                                    <div class="featureslist d-flex align-items-center col-xl-3 col-md-4 col-sm-6">
                                        <div class="feature-img">
                                            <img src="{{ asset('user') }}/assets/img/specification/specification-icon-5.svg"
                                                alt="Icon">
                                        </div>
                                        <div class="featues-info">
                                            <span>Màu xe </span>
                                            <h6>{{ $car_detail->color }}</h6>
                                        </div>
                                    </div>
                                    <div class="featureslist d-flex align-items-center col-xl-3 col-md-4 col-sm-6">
                                        <div class="feature-img">
                                            <img src="{{ asset('user') }}/assets/img/specification/specification-icon-7.svg"
                                                alt="Icon">
                                        </div>
                                        <div class="featues-info">
                                            <span>Năm sản xuất</span>
                                            <h6> {{ $car_detail->manufacture_year }}</h6>
                                        </div>
                                    </div>
                                    <div class="featureslist d-flex align-items-center col-xl-3 col-md-4 col-sm-6">
                                        <div class="feature-img">
                                            <img src="{{ asset('user') }}/assets/img/specification/specification-icon-8.svg"
                                                alt="Icon">
                                        </div>
                                        <div class="featues-info">
                                            <span>Số ghế </span>
                                            <h6> {{ $car_detail->seat }}</h6>
                                        </div>
                                    </div>
                                    <div class="featureslist d-flex align-items-center col-xl-3 col-md-4 col-sm-6">
                                        <div class="feature-img">
                                            <img src="{{ asset('user') }}/assets/img/specification/specification-icon-9.svg"
                                                alt="Icon">
                                        </div>
                                        <div class="featues-info">
                                            <span>Biển số xe </span>
                                            <h6> {{ $car_detail->license_plate }}</h6>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="review-sec extra-service mb-0">
                        <div class="review-header">
                            <h4>Mô tả xe</h4>
                        </div>
                        <div class="description-list">
                            <p>{{ $car_detail->description }}
                            </p>

                        </div>
                    </div>

                    <div class="review-sec listing-review">
                        <div class="review-header">
                            <h4>Bình luận<span class="me-2">({{ $comments->count() }})</span></h4>
                        </div>
                        @foreach ($comments as $item)
                            <div class="review-card" id="comment-{{ $item->id }}">
                                <div class="review-header-group">
                                    <div class="review-widget-header">
                                        <span class="review-widget-img">
                                            {{-- <img src="{{ asset('user') }}/assets/img/profiles/avatar-01.jpg"
                                                class="img-fluid" alt="User"> --}}
                                        </span>
                                        <div class="review-design">
                                            <h6>{{ $item->user->first_name }} {{ $item->user->last_name }}</h6>
                                            <small>{{ $item->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                    </div>
                                    <div class="reviewbox-list-rating">
                                        <p>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <span> (5.0)</span>
                                        </p>
                                    </div>
                                </div>
                                <p id="content-{{ $item->id }}">{{ $item->content }}</p>
                                <form action="{{ route('comment.edit', $item->id) }}" method="POST"
                                    id="edit-form-{{ $item->id }}" class="edit-form" style="display:none;">
                                    @csrf
                                    @method('PUT')
                                    <textarea rows="4" name="content" class="form-control">{{ $item->content }}</textarea>
                                    <button type="submit" class="btn btn-primary mt-2">Cập nhật</button>
                                    <button type="button" class="btn btn-secondary mt-2"
                                        onclick="cancelEdit({{ $item->id }})">Hủy</button>
                                </form>

                                @can('my_comment', $item)
                                    <p class="text-right">
                                        <small><a href="javascript:void(0);"
                                                onclick="editComment({{ $item->id }})">Sửa</a></small>
                                        <small><a href="{{ route('comment.delete', $item->id) }}"
                                                onclick="return confirm('Bạn chắc chắn muốn xóa bình luận này?')">Xóa</a></small>
                                    </p>
                                @endcan


                            </div>
                        @endforeach
                    </div>

                    @auth
                        <form action="{{ route('addcomment', $car_detail->id) }}" method="POST" role="form">
                            @csrf
                            <div class="review-sec leave-reply-form mb-0">
                                <div class="review-header">
                                    <h4>Viết bình luận</h4>
                                </div>
                                <div class="card-body">
                                    <div class="review-list">
                                        <ul>
                                            <li class="review-box feedbackbox mb-0">
                                                <div class="review-details">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="input-block">
                                                                <label>Nội dung bình luận</label>
                                                                <textarea rows="4" name="content" class="form-control"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="submit-btn">
                                                        <button class="btn btn-primary submit-review"
                                                            type="submit">Gửi</button>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endauth

                    @guest
                        <p>Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để thêm bình luận.</p>
                    @endguest

                </div>
                <div class="col-lg-5 theiaStickySidebar">
                    <div class="review-sec mt-0">
                        <div class="review-header">
                            <h3>Đặt xe ngay!</h3>
                            @if ($car_detail->discounted_price > 0)
                                <h6>
                                    <br>
                                    <span class="old-price">{{ number_format($car_detail->price) }}</span>
                                    <span class="discount-price">{{ number_format($car_detail->discounted_price) }}</span>
                                    VND
                                    <span>/ Ngày</span>
                                </h6>
                            @else
                                <h6>
                                    <span class="discount-price">{{ number_format($car_detail->price) }}</span>
                                    <span>/ Ngày</span>
                                </h6>
                            @endif
                        </div>
                        <div class="form-container">
                            <form method="GET" action="{{ route('cart.add', $car_detail->id) }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-block">
                                            <label>Chọn phương thức nhận xe</label>
                                            <div class="form-control">
                                                <label style="margin-right: 30%;">
                                                    <input type="radio" name="pickup_type" value="Tự đến lấy xe"
                                                        checked> Tự đến lấy xe
                                                </label>
                                                <label>
                                                    <input type="radio" name="pickup_type" value="Giao xe tận nơi">
                                                    Giao xe tận nơi
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Các trường liên quan đến nhận xe (Ẩn khi bắt đầu) -->
                                <h5>Địa điểm nhận xe:</h5>
                                <hr>
                                <div class="row d-flex flex-wrap " id="car_address_section">
                                    <div class="col-md-12">
                                        <div class="input-block">
                                            <label>Địa chỉ nhận xe:</label>
                                            <span>{{ $car_detail->address->street }},
                                                {{ $car_detail->address->ward }},
                                                {{ $car_detail->address->district }},
                                                {{ $car_detail->address->province }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row d-flex flex-wrap d-none" id="pickup_location">

                                    <div class="col-md-6">
                                        <div class="input-block">
                                            <label for="pickup_province">Tỉnh/Thành phố </label>
                                            <select class="form-control" id="pickup_province" name="pickup_province">
                                                <option value="">Chọn Tỉnh/Thành phố</option>
                                            </select>
                                            <input type="hidden" name="pickup_province"
                                                value="{{ $car_detail->address->province }}">

                                            @if ($errors->has('pickup_province'))
                                                <span class="error-message">*
                                                    {{ $errors->first('pickup_province') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-block">
                                            <label for="pickup_district">Huyện/Quận </label>
                                            <select class="form-control" id="pickup_district" name="pickup_district">
                                                <option value="">Chọn Huyện/Quận</option>
                                            </select>
                                            <input type="hidden" name="pickup_district"
                                                value="{{ $car_detail->address->district }}">
                                            @if ($errors->has('pickup_district'))
                                                <span class="error-message">*
                                                    {{ $errors->first('pickup_district') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- Địa điểm nhận xe (Ẩn khi bắt đầu) -->
                                <div class="row d-flex flex-wrap d-none" id="pickup_fields">
                                    <div class="col-md-6">
                                        <div class="input-block ">
                                            <label for="pickup_ward">Xã/Phường </label>
                                            <select class="form-control" id="pickup_ward" name="pickup_ward">
                                                <option value="">Chọn Xã/Phường</option>
                                            </select>
                                            <input type="hidden" name="pickup_ward"
                                                value="{{ $car_detail->address->ward }}">
                                            @if ($errors->has('pickup_ward'))
                                                <span class="error-message">* {{ $errors->first('pickup_ward') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block">
                                            <label for="pickup_street">Số nhà, tòa nhà nhận xe</label>
                                            <input type="text" class="form-control" id="pickup_street"
                                                name="pickup_street" placeholder="Nhập địa chỉ nhận xe"
                                                value="{{ $car_detail->address->street }}">
                                            @if ($errors->has('pickup_street'))
                                                <span class="error-message">* {{ $errors->first('pickup_street') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-flex flex-wrap ">
                                    <div class="col-md-12 " id="pickup_time">
                                        <div class="input-block">
                                            <label for="pickup_time">Thời gian nhận xe</label>
                                            <input type="datetime-local" class="form-control" name="pickup_time">
                                        </div>
                                        @if ($errors->has('pickup_time'))
                                            <span class="error-message">* {{ $errors->first('pickup_time') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <!-- Các trường liên quan đến giao xe (Hiển thị khi bắt đầu) -->
                                <div class="row d-flex flex-wrap" id="delivery_location">
                                    <h5>Địa điểm trả xe:</h5>
                                    <hr>
                                    <div class="col-md-6">
                                        <div class="input-block">
                                            <label for="return_province">Tỉnh/Thành phố </label>
                                            <select class="form-control" id="return_province" name="return_province">
                                                <option value="">Chọn Tỉnh/Thành phố</option>
                                            </select>
                                            <input type="hidden" name="return_province">
                                        </div>
                                        @if ($errors->has('return_province'))
                                            <span class="error-message">* {{ $errors->first('return_province') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block">
                                            <label for="return_district">Huyện/Quận </label>
                                            <select class="form-control" id="return_district" name="return_district">
                                                <option value="">Chọn Huyện/Quận</option>
                                            </select>
                                            <input type="hidden" name="return_district">
                                        </div>
                                        @if ($errors->has('return_district'))
                                            <span class="error-message">* {{ $errors->first('return_district') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row d-flex flex-wrap" id="delivery_time">
                                    <div class="col-md-6">
                                        <div class="input-block">
                                            <label for="return_ward">Xã/Phường </label>
                                            <select class="form-control" id="return_ward" name="return_ward">
                                                <option value="">Chọn Xã/Phường</option>
                                            </select>
                                            <input type="hidden" name="return_ward">
                                        </div>
                                        @if ($errors->has('return_ward'))
                                            <span class="error-message">* {{ $errors->first('return_ward') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block">
                                            <label for="return_time">Thời gian trả xe</label>
                                            <input type="datetime-local" class="form-control" id="return_time1"
                                                name="return_time">
                                        </div>
                                        @if ($errors->has('return_time'))
                                            <span class="error-message">* {{ $errors->first('return_time') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row" id="delivery_fields">
                                    <div class="col-md-12">
                                        <div class="input-block">
                                            <label for="return_street">Số nhà, tòa nhà trả xe</label>
                                            <input type="text" class="form-control" id="return_street"
                                                name="return_street" placeholder="Nhập địa chỉ trả xe">
                                        </div>
                                        @if ($errors->has('return_street'))
                                            <span class="error-message">* {{ $errors->first('return_street') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-block">
                                            <p><span id="total_days" style="color: black" readonly></span></p>
                                            <input type="hidden" name="rental_days" id="rental_days_value">
                                            <p><span id="delivery-fee" style="color: black"></span></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mt-3">
                                            <h6><span id="total_price" style="color: black" readonly></span></h6>
                                        </div>
                                    </div>
                                </div>


                                <!-- Submit Button -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-block mb-0">
                                            <div class="search-btn">
                                                <button type="submit" class="btn btn-primary check-available w-100">Xác
                                                    nhận </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="details-car-grid">
                        <div class="details-slider-heading">
                            <h3>Các sản phẩm tương tự:</h3>
                        </div>
                        <div class="car-details-slider owl-carousel">
                            @foreach ($related_cars as $car)
                                <div class="card">
                                    <div class="listing-item pb-0">
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
                                                <div class="listing-price">
                                                    <span><i
                                                            class="feather-map-pin"></i></span>{{ $car->address->province }}
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
                                                            <span class="price">{{ number_format($car->price) }}</span>
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
            </div>
        </div>
    </section>


    </div>

    <div class="progress-wrap active-progress">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919px, 307.919px; stroke-dashoffset: 228.265px;">
            </path>
        </svg>
    </div>
    <script>
        function editComment(commentId) {
            document.getElementById('content-' + commentId).style.display = 'none';
            document.getElementById('edit-form-' + commentId).style.display = 'block';
        }

        function cancelEdit(commentId) {
            document.getElementById('content-' + commentId).style.display = 'block';
            document.getElementById('edit-form-' + commentId).style.display = 'none';
        }
        document.querySelectorAll('input[name="pickup_type"]').forEach((radio) => {
            radio.addEventListener('change', function() {
                // Khi chọn phương thức giao xe tận nơi
                if (this.value === 'Giao xe tận nơi') {
                    document.getElementById('delivery_fields').classList.remove('d-none');
                    document.getElementById('delivery_location').classList.remove('d-none');
                    document.getElementById('delivery_time').classList.remove('d-none');
                    document.getElementById('pickup_fields').classList.remove('d-none');
                    document.getElementById('pickup_location').classList.remove('d-none');
                    document.getElementById('pickup_time').classList.remove('d-none');
                    document.getElementById('car_address_section').classList.add('d-none');

                }
                // Khi chọn phương thức tự đến lấy xe
                else if (this.value === 'Tự đến lấy xe') {
                    document.getElementById('pickup_fields').classList.add('d-none');
                    document.getElementById('pickup_location').classList.add('d-none');
                    document.getElementById('car_address_section').classList.remove('d-none');
                    document.getElementById('pickup_time').classList.remove('d-none');
                    document.getElementById('delivery_fields').classList.remove('d-none');
                    document.getElementById('delivery_location').classList.remove('d-none');
                    document.getElementById('delivery_time').classList.remove('d-none');
                }
            });
        });
        //tính số ngày và tiền
        document.addEventListener('DOMContentLoaded', function() {
            const pricePerDay = {{ $car_detail->discounted_price ?? $car_detail->price }};
            const deliveryFee = 100000; // Phí giao xe
            function calculateRental() {
                const pickupTime = document.querySelector('input[name="pickup_time"]').value;
                const returnTime = document.querySelector('input[name="return_time"]').value;
                const pickupType = document.querySelector('input[name="pickup_type"]:checked').value;

                if (pickupType === 'Tự đến lấy xe') {
                    document.getElementById('delivery-fee').style.display = 'none'; // Ẩn phí giao xe
                } else {
                    document.getElementById('delivery-fee').style.display = 'block'; // Hiển thị phí giao xe
                }
                if (pickupTime && returnTime) {
                    const pickupDate = new Date(pickupTime);
                    const returnDate = new Date(returnTime);

                    // Tính số ngày thuê
                    const timeDiff = returnDate - pickupDate;
                    const daysRented = Math.ceil(timeDiff / (1000 * 3600 * 24)); // Chuyển từ mili giây sang ngày
                    let totalPrice = daysRented * pricePerDay;

                    let deliveryFeeDisplay = 0;
                    if (pickupType === 'Giao xe tận nơi') {
                        deliveryFeeDisplay = deliveryFee;
                        totalPrice += deliveryFeeDisplay;
                    }

                    // Cập nhật vào form
                    document.getElementById('total_days').innerText = 'Số ngày thuê: ' + daysRented;
                    document.getElementById('rental_days_value').value = daysRented;
                    document.getElementById('delivery-fee').innerText = 'Phí giao xe: ' + deliveryFeeDisplay
                        .toLocaleString() + 'VND';
                    document.getElementById('total_price').innerText = 'Tổng số tiền: ' + totalPrice
                        .toLocaleString('vi-VN') + ' VND';
                }
            }

            // Lắng nghe sự thay đổi của các trường thời gian
            document.querySelector('input[name="pickup_time"]').addEventListener('input', calculateRental);
            document.querySelector('input[name="return_time"]').addEventListener('input', calculateRental);

            // Lắng nghe sự thay đổi của phương thức giao nhận xe
            document.querySelectorAll('input[name="pickup_type"]').forEach((radio) => {
                radio.addEventListener('change', function() {
                    calculateRental();
                });
            });
        });
    </script>

    <script src="{{asset('user')}}/assets/plugins/moment/moment.min.js" type="1fd1520c2fe94050b14d329a-text/javascript"></script>
    <script src="{{asset('user')}}/assets/js/bootstrap-datetimepicker.min.js" type="1fd1520c2fe94050b14d329a-text/javascript"></script>

    <script src="{{asset('user')}}/assets/plugins/slick/slick.js" type="1fd1520c2fe94050b14d329a-text/javascript"></script>

    <script src="{{asset('user')}}/assets/js/owl.carousel.min.js" type="1fd1520c2fe94050b14d329a-text/javascript"></script>

    <script src="{{asset('user')}}/assets/plugins/theia-sticky-sidebar/ResizeSensor.js" type="1fd1520c2fe94050b14d329a-text/javascript"></script>
    <script src="{{asset('user')}}/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js" type="1fd1520c2fe94050b14d329a-text/javascript"></script>
    <script src="{{ asset('user') }}/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js"
        data-cf-settings="1fd1520c2fe94050b14d329a-|49" defer></script>
@endsection
