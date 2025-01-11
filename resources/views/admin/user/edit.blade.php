@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">Cập nhật người dùng</h3>
            <a href="{{ route('admin.users.index') }}" class="ms-auto text-end btn btn-secondary">Quay lại</a>
        </div>
        <div class="col-sm-8 mx-auto">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Cập nhật thông tin người dùng</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="form-group row mb-3">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">Họ</label>
                                <input type="text" name="first_name" class="form-control" placeholder="Nhập họ"
                                    value="{{ old('first_name', $user->first_name) }}">
                                @if ($errors->has('first_name'))
                                    <span class="error-message text-danger">* {{ $errors->first('first_name') }}</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Tên</label>
                                <input type="text" name="last_name" class="form-control" placeholder="Nhập tên"
                                    value="{{ old('last_name', $user->last_name) }}">
                                @if ($errors->has('last_name'))
                                    <span class="error-message text-danger">* {{ $errors->first('last_name') }}</span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row mb-3">
                            <div class="col-md-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Nhập email"
                                    value="{{ old('email', $user->email) }}">
                                @if ($errors->has('email'))
                                    <span class="error-message text-danger">* {{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row  mb-3">
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="text" name="phone_number" class="form-control"
                                    placeholder="Nhập số điện thoại" value="{{ old('phone_number', $user->phone_number) }}">
                                @if ($errors->has('phone_number'))
                                    <span class="error-message text-danger">* {{ $errors->first('phone_number') }}</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="role" class="form-label">Vai trò</label>
                                <select name="role" class="form-control">
                                    <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Khách hàng
                                    </option>
                                    <option value="employee"{{ $user->role == 'employee' ? 'selected' : '' }}>Nhân viên
                                    </option>
                                    <option value="lessor"{{ $user->role == 'lessor' ? 'selected' : '' }}>Người cho thuê
                                    </option>
                                    <option value="admin"{{ $user->role == 'admin' ? 'selected' : '' }}>Quản trị viên
                                    </option>
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

<select name="role" class="form-control">
    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Người dùng</option>
    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Quản trị viên
    </option>
</select>
