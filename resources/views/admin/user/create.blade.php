@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">Thêm mới người dùng</h3>
            <a href="{{ route('admin.users.index') }}" class="ms-auto text-end btn btn-secondary">Quay lại</a>
        </div>
        <div class="col-sm-8 mx-auto">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Thêm mới người dùng</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        <div class="form-group row mb-3">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">Họ</label>
                                <input type="text" name="first_name" class="form-control" placeholder="Nhập họ"
                                    value="{{ old('first_name') }}">
                                @if ($errors->has('first_name'))
                                    <span class="error-message text-danger">* {{ $errors->first('first_name') }}</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Tên</label>
                                <input type="text" name="last_name" class="form-control" placeholder="Nhập tên"
                                    value="{{ old('last_name') }}">
                                @if ($errors->has('last_name'))
                                    <span class="error-message text-danger">* {{ $errors->first('last_name') }}</span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Nhập email"
                                    value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="error-message text-danger">* {{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu">
                                @if ($errors->has('password'))
                                    <span class="error-message text-danger">* {{ $errors->first('password') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row  mb-3">
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="text" name="phone_number" class="form-control"
                                    placeholder="Nhập số điện thoại" value="{{ old('phone_number') }}">
                                @if ($errors->has('phone_number'))
                                    <span class="error-message text-danger">* {{ $errors->first('phone_number') }}</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="role" class="form-label">Vai trò</label>
                                <select name="role" class="form-control">
                                    <option value="customer">Khách hàng</option>
                                    <option value="employee">Nhân viên</option>
                                    <option value="lessor">Người cho thuê</option>
                                    <option value="admin">Quản trị viên</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group text-end">
                            <button type="submit" class="btn btn-success">Lưu</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
