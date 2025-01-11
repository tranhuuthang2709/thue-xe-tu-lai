<h3>Xin chào!! {{ $user->name }}</h3>
<p>Vui lòng xác nhận email để đăng nhập</p>
<a href="{{ route('verify', $user->email) }}">Nhấn vào đây để xác nhận </a>
