@extends('admin.index')

@section('content')
    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <h3 class="fw-bold">Danh sách xe chuẩn bị và đang trả xe</h3>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Danh sách các đơn trả xe</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            @can('admin-employee')
                                <th>Tên khách hàng</th>
                                <th>Số điện thoại</th>
                            @endcan
                            <th>Tên xe</th>
                            <th>Địa chỉ</th>
                            <th>Thời gian trả</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listbookingDetails as $bookingDetail)
                            <tr>
                                <td>{{ $bookingDetail->id }}</td>
                                @can('admin-employee')
                                    <td>{{ $bookingDetail->booking->user->first_name }}
                                        {{ $bookingDetail->booking->user->last_name }}</td>
                                    <td>{{ $bookingDetail->booking->user->phone_number }}</td>
                                @endcan
                                <td>{{ $bookingDetail->car->name }}</td>
                                <td>{{ $bookingDetail->returnAddress->street }},
                                    {{ $bookingDetail->returnAddress->ward }},
                                    {{ $bookingDetail->returnAddress->district }},
                                    {{ $bookingDetail->returnAddress->province }}</td>
                                <td>{{ $bookingDetail->returnAddress->return_time }}</td>
                                <td> {{ $bookingDetail->return_status }}</td>
                                <td>
                                    <a href="{{ route('booking.showReturnCarDetail', $bookingDetail->id) }}"
                                        class="btn btn-primary btn-sm">
                                        Chi tiết
                                    </a>


                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
