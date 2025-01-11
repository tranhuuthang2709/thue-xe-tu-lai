@extends('user.index')

@section('content')
    <section class="seller-registration py-5">
        <div class="container-fluid">
            <div class="registration-box card shadow-sm p-4 mb-4 bg-white rounded">
                <h3 class="font-weight-bold text-center">Đăng ký làm người cho thuê</h3>
                <p class="text-center mb-4">Để trở thành người cho thuê xe, vui lòng xác nhận thông tin
                    và đồng ý với các điều khoản dưới đây.</p>

                <!-- Điều khoản sử dụng -->
                <div class="terms-container mb-4">
                    <h4 class="font-weight-bold">Điều khoản sử dụng</h4>
                    <ul class="list-unstyled">
                        <li><i class="feather-check-circle"></i> Bạn phải là chủ sở hữu xe hoặc có quyền cho thuê xe.</li>
                        <li><i class="feather-check-circle"></i> Bạn cam kết cung cấp thông tin chính xác về xe và tình trạng
                            xe.</li>
                        <li><i class="feather-check-circle"></i> Bạn đồng ý với các quy định của hệ thống trong việc cho
                            thuê xe.</li>
                        <li><i class="feather-check-circle"></i> Hệ thống có quyền từ chối xe nếu vi phạm các điều khoản
                            trên.</li>


                    </ul>
                </div>

                <form action="{{ route('lessor.register') }}" method="POST" onsubmit="return checkTerms()">
                    @csrf

                    <div class="form-group">
                        <label class="d-flex align-items-center">
                            <input type="checkbox" name="terms" required class="mr-2">
                            <span>Tôi đồng ý với các Điều khoản và điều
                                kiện</span>
                        </label>
                    </div>

                    <!-- Thao tác -->
                    <div class="d-flex justify-content-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Đăng ký làm người bán</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        // Kiểm tra nếu người dùng đã đồng ý với các điều khoản
        function checkTerms() {
            var checkbox = document.querySelector('input[name="terms"]');
            if (!checkbox.checked) {
                alert("Vui lòng đồng ý với điều khoản và điều kiện trước khi đăng ký.");
                return false;
            }
            return true;
        }
    </script>
@endsection
