@extends('admin.index')
@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">Quản lý người dùng</h3>
            <a href="{{ route('admin.users.create') }}" class="ms-auto text-end btn btn-primary">Thêm mới người dùng</a>
        </div>

        <!-- Danh sách người dùng -->
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Danh sách người dùng</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Họ</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Vai trò</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $roles = [
                                'customer' => 'Khách hàng',
                                'employee' => 'Nhân viên',
                                'lessor' => 'Người cho thuê',
                                'admin' => 'Quản trị viên',
                            ];
                        @endphp
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone_number }}</td>
                                <td>{{ $roles[$user->role] ?? $user->role }}</td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-info btn-sm">Sửa</a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
