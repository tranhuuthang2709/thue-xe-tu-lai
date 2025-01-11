<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Thuê xe tự lái</title>
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
                            <a href="{{ route('home') }}" class="btn sign-up">
                                <span><i class="fe feather-corner-down-left" aria-hidden="true"></i></span> Quay lại
                            </a>
                        </div>
                        <h1>Thay đổi mật khẩu</h1>
                        <p class="account-subtitle">Vui lòng nhập thông tin để thay đổi mật khẩu</p>
                        <form action="{{ route('change_password') }}" method="POST">
                            @csrf
                            <div class="input-block">
                                <label class="form-label">Mật khẩu cũ <span class="text-danger">*</span></label>
                                <div class="pass-group">
                                    <input type="password" name="old_password" class="form-control pass-input">
                                    <span class="fas fa-eye-slash toggle-password"></span>
                                </div>
                            </div>
                            @if ($errors->has('old_password'))
                                <span class="error-message text-danger">* {{ $errors->first('old_password') }}</span>
                            @endif
                            <div class="input-block">
                                <label class="form-label">Mật khẩu mới <span class="text-danger">*</span></label>
                                <div class="pass-group">
                                    <input type="password" name="new_password" class="form-control pass-input">
                                    <span class="fas fa-eye-slash toggle-password"></span>
                                </div>
                            </div>
                            @if ($errors->has('new_password'))
                                <span class="error-message text-danger">* {{ $errors->first('new_password') }}</span>
                            @endif
                            <div class="input-block">
                                <label class="form-label">Nhập lại mật khẩu <span class="text-danger">*</span></label>
                                <div class="pass-group">
                                    <input type="password" name="confirm_password" class="form-control pass-input">
                                    <span class="fas fa-eye-slash toggle-password"></span>
                                </div>
                            </div>
                            @if ($errors->has('confirm_password'))
                                <span class="error-message text-danger">*
                                    {{ $errors->first('confirm_password') }}</span>
                            @endif
                            <button type="submit" class="btn btn-outline-light w-100 btn-size mt-1">Thay đổi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('user') }}/assets/js/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('user') }}/assets/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('user') }}/assets/js/script.js"></script>
</body>

</html>
