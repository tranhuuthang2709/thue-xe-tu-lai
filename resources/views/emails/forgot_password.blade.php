<h3>Xin chào!! {{ $user->name }}</h3>
<p>Có phải bạn đã quên mật khẩu đăng nhập vui lòng:</p>
<a href="{{ route('reset_password', $token) }}">Nhấn vào đây để tạo lại mật khẩu mới </a>
