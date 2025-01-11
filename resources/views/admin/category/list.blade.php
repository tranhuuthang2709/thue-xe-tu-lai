@extends('admin.index')
@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">Danh sách danh mục</h3>
            <a href="{{ route('category.create') }}" class="ms-auto text-end btn btn-success"> Thêm mới</a>
        </div>
        <table class="col-sm-4 table table-bordered table-striped table-hover text-center">
            <thead class="table-dark ">
                <tr>
                    <th>STT</th>
                    <th>Tên danh mục</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cate as $cate)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $cate->name }}</td>
                        <td class="project-actions text-center ">
                            <a href="{{ route('category.edit', $cate->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-pencil-alt"></i>
                                Edit
                            </a>
                            <form action="{{ route('category.destroy', $cate->id) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bạn có chắc muốn xóa danh mục này?')">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection
