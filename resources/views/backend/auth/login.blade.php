<!doctype html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">


    <link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{asset('backend/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/vendor/font-awesome/css/font-awesome.min.css')}}">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{asset('backend/assets/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/css/color_skins.css')}}">
</head>

<body class="theme-cyan">
<!-- WRAPPER -->
<div id="wrapper">
    <div class="vertical-align-wrap">
        <div class="vertical-align-middle auth-main">
            <div class="auth-box">
                <div class="top">
                    <img src="{{asset('backend/images/logo-white.svg')}}" alt="Lucid">
                </div>
                <div class="card">
                    <div class="header">
                        <p class="lead">Login to your account</p>
                    </div>
                    <div class="body">
                        <form method="POST" action="{{ route('admin.login') }}">
                            @csrf

                            <div class="form-group">
                                <label for="signin-email" class="control-label sr-only">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="signin-email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="signin-password" class="control-label sr-only">Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="signin-password" placeholder="Password" required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group clearfix">
                                <label class="fancy-checkbox element-left">
                                    <input type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                    <span>Remember me</span>
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
                            <div class="bottom">
                                @if (Route::has('password.request'))
                                    <span class="helper-text m-b-10"><i class="fa fa-lock"></i> <a href="{{ route('password.request') }}">Forgot password?</a></span>
                                @endif

{{--                                <span>Don't have an account? <a href="{{route('register')}}">Register</a></span>--}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END WRAPPER -->
</body>
</html>
