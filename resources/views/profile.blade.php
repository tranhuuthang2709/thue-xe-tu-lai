@extends('user.index')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm rounded">
                    <div class="card-header bg-warning text-center">
                        <h3 style="color: white">Cập nhật thông tin cá nhân</h3>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">Họ <span class="text-danger">*</span></label>
                                    <input type="text" id="first_name" name="first_name"
                                        value="{{ old('first_name', $user->first_name) }}" class="form-control"
                                        placeholder="Nhập họ">
                                    @if ($errors->has('first_name'))
                                        <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Tên <span class="text-danger">*</span></label>
                                    <input type="text" id="last_name" name="last_name"
                                        value="{{ old('last_name', $user->last_name) }}" class="form-control"
                                        placeholder="Nhập tên">
                                    @if ($errors->has('last_name'))
                                        <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="form-control" placeholder="Nhập email">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Số điện thoại <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="phone_number" name="phone_number"
                                    value="{{ old('phone_number', $user->phone_number) }}" class="form-control"
                                    placeholder="Nhập số điện thoại">
                                @if ($errors->has('phone_number'))
                                    <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between mt-5 mb-3">
                                <a href="{{ route('home') }}" class="btn btn-secondary">Quay lại trang chủ</a>
                                <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
