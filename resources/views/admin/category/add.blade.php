@extends('admin.index')
@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">Thêm mới danh mục </h3>
            <a href="{{ route('category.index') }}" class="ms-auto text-end btn btn-secondary">Quay lại</a>
        </div>
        <div class="col-sm-8 mx-auto">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Thêm danh mục</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('category.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="category_name" class="form-label">Tên danh mục</label>
                            <input type="text" name="name" class="form-control" placeholder="Nhập tên danh mục"
                                value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="error-message text-danger">* {{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group text-end">
                            <button type="submit" class="btn btn-success">Lưu</button>
                            <a href="{{ route('category.index') }}" class="btn btn-secondary">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
