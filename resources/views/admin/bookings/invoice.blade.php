<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hợp Đồng Cho Thuê Xe #{{ $booking->id }}</title>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            font-style: normal;
            font-weight: normal;
            src: url("https://dejavu-fonts.github.io/downloads/DejaVuSans.ttf") format("truetype");
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 14px;
            line-height: 1.5;
            margin: 40px;
        }

        h1,
        h3 {
            text-align: center;
        }

        h2 {
            text-align: left;
        }

        .header,
        .footer {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            text-align: left;
            background-color: #f1f1f1;
        }

        .section {
            margin-bottom: 20px;
        }

        .signature {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-top: 50px;
        }

        .signature div {
            width: 45%;
            text-align: center;
            border-top: 1px solid #000;
        }



        .total {
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>HỢP ĐỒNG CHO THUÊ XE</h1>
        <p>Hợp đồng cho thuê xe số: <strong>#{{ $booking->id }}</strong></p>
        <p>Ngày thuê: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    </div>
    <div class="section">
        <h2>Thông tin cá nhân:</h2>
        <p><strong>Người tạo hóa đơn: </strong>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }} </p>
        <p><strong>Số điện thoại:</strong> {{ Auth::user()->phone_number }}</p>
        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
        <p><strong>Người thuê:</strong> {{ $booking->user->first_name }} {{ $booking->user->last_name }}</p>
        <p><strong>Số điện thoại:</strong> {{ $booking->user->phone_number }}</p>
        <p><strong>Email:</strong> {{ $booking->user->email }}</p>
    </div>

    <div class="section">
        <h2>Thông tin xe thuê</h2>
        <table>
            <thead>
                <tr>
                    <th>Tên Xe</th>
                    <th>Biển Số Xe</th>
                    <th>Giá Thuê (VND)</th>
                    <th>Ngày Thuê</th>
                    <th>Ngày Trả</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($booking->booking_detail as $detail)
                    <tr>
                        <td>{{ $detail->car->name }}</td>
                        <td>{{ $detail->car->license_plate }}</td>
                        <td>{{ number_format($detail->rental_price) }} VND</td>
                        <td>{{ \Carbon\Carbon::parse($detail->pickup_date)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($detail->return_date)->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section" style="text-align: right">
        <p><strong>Tổng số tiền thuê:</strong> {{ number_format($booking->total_amount) }} VND</p>
        <p><strong>Phương thức thanh toán:</strong> {{ $booking->payment_method }}</p>
    </div>

    <div class="section">
        <h2>Điều khoản hợp đồng</h2>
        <p>1. Bên thuê có trách nhiệm bảo quản xe trong suốt thời gian thuê. Nếu xe bị hư hỏng do lỗi của bên thuê, bên
            thuê phải bồi thường theo giá trị thực tế của xe.</p>
        <p>2. Nếu bên thuê không trả xe đúng hạn, sẽ bị phạt theo quy định của công ty, và chịu các chi phí phát sinh
            (nếu có).</p>
        <p>3. Mọi tranh chấp phát sinh sẽ được giải quyết theo quy định của pháp luật Việt Nam.</p>
        <p>4. Người thuê xe phải có giấy phép lái xe.</p>
    </div>

    <div class="footer">
        <p>Chúng tôi cam kết thực hiện đầy đủ các điều khoản trong hợp đồng này.</p>
    </div>

    <div class="signature">

        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="text-align: center; border: 1px solid #ffffff; padding-top: 20px;">
                    <br>
                    <p><strong>Người tạo hóa đơn:</strong></p>
                    <p>(Ký và ghi rõ họ tên)</p>
                </td>
                <td style="text-align: center; border: 1px solid #ffffff; padding-top: 20px;">
                    <p style="">Ngày ... tháng ... năm ...</p>
                    <p><strong>Người thuê:</strong></p>
                    <p>(Ký và ghi rõ họ tên)</p>
                </td>
            </tr>
        </table>
    </div>


</body>

</html>
