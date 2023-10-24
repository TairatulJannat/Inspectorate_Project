<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
          content="Ndc Database">
    <meta name="keywords" content="Ndc Database">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{asset('assets/frontend/img/army_logo.png')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('assets/frontend/img/army_logo.png')}}" type="image/x-icon">
    <title>Hall Booking</title>
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/backend/css/fontawesome.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/backend/css/icofont.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/backend/css/themify.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/backend/css/flag-icon.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/backend/css/feather-icon.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/backend/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/backend/css/style.css')}}">
    <link id="color" rel="stylesheet" href="{{asset('assets/backend/css/color-1.css')}}" media="screen">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/backend/css/responsive.css')}}">
</head>
<body>
<div class="loader-wrapper">
    <div class="theme-loader">
        <div class="loader-p"></div>
    </div>
</div>
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-5"><img class="bg-img-cover bg-center" src="{{ asset('assets/backend/images/logo/bg_2.jpg') }}" alt="looginpage">
            </div>
            <div class="col-xl-7 p-0">
                <div class="login-card">

                    <form class="theme-form login-form" action="{{ route('login') }}" method="post">
                        @csrf
                        <h4>Hall Booking</h4>
                        <h6>Admin Login</h6>
                        <div class="form-group">
                            <label>Email Address</label>
                            <div class="input-group"><span class="input-group-text"><i class="icon-email"></i></span>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"
                                       required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <div class="input-group"><span class="input-group-text"><i class="icon-lock"></i></span>
                                <input id="myInput" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required
                                       autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="show-hide"><span class="show" onclick="myFunction()"></span></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <input id="checkbox1" type="checkbox">
                                <label class="text-muted" for="checkbox1">Remember password</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">Login</button>
                        </div>

{{--                        <div class="login-social-title">--}}
{{--                            <h5>Security Through Knowledge</h5>--}}
{{--                        </div>--}}


                        <div class="form-group">
                            <ul class="login-social">
                                <li style="margin-top: 20px">
                                    <img class="justify-content-center" src="{{asset('assets/frontend/img/army_logo.png')}}" alt="" style="height:100px;">
                                </li>
                            </ul>
                        </div>


                        <div class="pt-4">
                            <p>Developed by <a href="https://www.tilbd.net/" target="_blank">Trust Innovation Limited</a></p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{asset('assets/backend/js/jquery-3.5.1.min.js')}}"></script>
<script src="{{asset('assets/backend/js/icons/feather-icon/feather.min.js')}}"></script>
<script src="{{asset('assets/backend/js/icons/feather-icon/feather-icon.js')}}"></script>
<script src="{{asset('assets/backend/js/sidebar-menu.js')}}"></script>
<script src="{{asset('assets/backend/js/config.j')}}s"></script>
<script src="{{asset('assets/backend/js/bootstrap/popper.min.js')}}"></script>
<script src="{{asset('assets/backend/js/bootstrap/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/backend/js/script.js')}}"></script>

<script>
    function myFunction() {
        var x = document.getElementById("myInput");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
</body>
</html>


