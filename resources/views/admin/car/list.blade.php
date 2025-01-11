@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">Danh sách xe</h3>
            <a href="{{ route('car.create') }}" class="ms-auto text-end btn btn-success"> Thêm mới</a>
        </div>

        <table class="table table-bordered table-striped table-hover text-center">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Tên xe</th>
                    <th>Ảnh</th>
                    <th>Tình trạng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cars as $car)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $car->name }}</td>
                        <td><img src="{{ asset('storage/img_car/' . $car->main_image) }}" alt="Ảnh sản phẩm" width="50"
                                height="50">
                        <td>{{ $car->status }}</td>
                        <td class="project-actions text-center">
                            <a href="{{ route('car.editStatus', $car->id) }}" class="btn btn-secondary btn-sm">
                                <i class="fa fa-archive"></i> Trạng thái
                            </a>
                            <a href="{{ route('car.edit', $car->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-pencil-alt"></i> Sửa
                            </a>

                            <form action="{{ route('car.destroy', $car->id) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bạn có chắc muốn xóa xe này?')">
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
