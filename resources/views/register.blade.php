<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from dreamsrent.dreamstechnologies.com/html/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 16 Feb 2024 09:07:13 GMT -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Dreams Rent | Template</title>
    <title>Thuê xe tự lái - Đăng ký</title>
    <link rel="shortcut icon" href="{{ asset('user') }}/assets/img/favicon.jpg">
    <link rel="stylesheet" href="{{ asset('user') }}/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('user') }}/assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{ asset('user') }}/assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('user') }}/assets/css/feather.css">
    <link rel="stylesheet" href="{{ asset('user') }}/assets/css/style.css">
    <link rel="stylesheet" href="{{ asset('user') }}/assets/css/css.css">
</head>

<body>
    <div class="main-wrapper login-body">
        <header class="log-header">
            <a href="{{ route('home') }}"><img class="img-fluid logo-dark" src="{{ asset('user') }}/assets/img/logo.png"
                    alt="Logo"></a>
        </header>
        <div class="login-wrapper">
            <div class="loginbox">
                <div class="login-auth">
                    <div class="login-auth-wrap">
                        <div class="sign-group">
                            <a href="{{ route('home') }}" class="btn sign-up"><span><i
                                        class="fe feather-corner-down-left" aria-hidden="true"></i></span> Quay lại</a>
                        </div>
                        <h1>Đăng kí</h1>
                        <p class="account-subtitle">Chúng tôi sẽ gửi mã xác nhận tới email của bạn.</p>
                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-block">
                                        <label class="form-label">Họ <span class="text-danger">*</span></label>
                                        <input type="text" name="first_name" value="{{ old('first_name') }}"
                                            class="form-control" placeholder>
                                    </div>
                                    @if ($errors->has('first_name'))
                                        <span class="error-message">* {{ $errors->first('first_name') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="input-block">
                                        <label class="form-label">Tên <span class="text-danger">*</span></label>
                                        <input type="text" name="last_name" value="{{ old('last_name') }}"
                                            class="form-control" placeholder>
                                    </div>
                                    @if ($errors->has('last_name'))
                                        <span class="error-message">* {{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="input-block">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                                    placeholder>
                            </div>
                            @if ($errors->has('email'))
                                <span class="error-message">* {{ $errors->first('email') }}</span>
                            @endif
                            <div class="input-block">
                                <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                                    class="form-control" placeholder>
                            </div>
                            @if ($errors->has('phone_number'))
                                <span class="error-message">* {{ $errors->first('phone_number') }}</span>
                            @endif
                            <div class="input-block">
                                <label class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                                <div class="pass-group">
                                    <input type="password" name="password" class="form-control pass-input" placeholder>
                                    <span class="fas fa-eye-slash toggle-password"></span>
                                </div>
                            </div>
                            @if ($errors->has('password'))
                                <span class="error-message">* {{ $errors->first('password') }}</span>
                            @endif
                            <div class="input-block">
                                <label class="form-label">Nhập lại mật khẩu <span class="text-danger">*</span></label>
                                <div class="pass-group">
                                    <input type="password" name="confirm_password" class="form-control pass-input"
                                        placeholder>
                                    <span class="fas fa-eye-slash toggle-password"></span>
                                </div>
                            </div>
                            @if ($errors->has('confirm_password'))
                                <span class="error-message">* {{ $errors->first('confirm_password') }}</span>
                            @endif

                            <button type="submit" class="btn btn-outline-light w-100 btn-size mt-1">Đăng ký</button>
                            <div class="text-center dont-have">Bạn đã có tài khoản? <a href="{{ route('login') }}">Đăng
                                    nhập</a></div>
                        </form>

                    </div>
                </div>
            </div>
        </div>


    </div>
    <script src="{{ asset('user') }}/assets/js/jquery-3.7.1.min.js" type="ce32a1c348b541f5903f49c9-text/javascript"></script>

    <script src="{{ asset('user') }}/assets/js/bootstrap.bundle.min.js" type="ce32a1c348b541f5903f49c9-text/javascript"></script>

    <script src="{{ asset('user') }}/assets/js/script.js" type="ce32a1c348b541f5903f49c9-text/javascript"></script>
    <script src="{{ asset('user') }}/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js"
        data-cf-settings="ce32a1c348b541f5903f49c9-|49" defer></script>
</body>

</html>
