<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inspectorate Automation System </title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/LandingPage/style.css') }}">
    {{-- <style>
        * {
            box-sizing: border-box;
        }

        body {
            /* background-color: #e8eceb; */
            padding: 0;
            margin: 0;
            /* background-image: url('{{ asset('assets/backend/images/backgroundimage.jpeg') }}'); */
            background-size: cover;
            font-family: "Arial", sans-serif;
            height: 100vh;
        }


        .container {
            width: 1100px !important;
            padding: 0 !important;
            margin-right: auto;
            margin-left: auto;


            @media screen and (min-width: 992px) and (max-width: 1439px) {
                max-width: 1279px !important;
                padding: 0 !important;
                margin: 0 80px !important;
                width: auto !important;
            }

            @media screen and (max-width: 991px) {
                max-width: 959px !important;
                margin: 0 16px !important;
                padding: 0 !important;
                width: auto !important;
            }
        }

        .gradient-cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 32px;
            padding: 30px;


            @media screen and (max-width: 991px) {
                grid-template-columns: 1fr;
            }
        }

        .container-title {
            text-align: center;
            padding: 0 !important;
            margin-bottom: 20px;
            font-size: 40px;
            color: #262626;
            font-weight: 600;
            line-height: 60px;
        }

        .card {
            max-width: 500px;
            border: 0;
            width: 100%;
            margin-inline: auto;
            box-sizing: border-box;
            box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
            border-radius: 45px;
        }

        .container-card {

            position: relative;
            border: 2px solid transparent;

            background-clip: padding-box;
            border-radius: 45px;
            padding: 30px;



            img {
                margin-bottom: 20px;
            }
        }

        .bg-green-box,
        .bg-white-box,
        .bg-yellow-box,
        .bg-blue-box {
            position: relative;
        }

        .bg-green-box::after,
        .bg-white-box::after,
        .bg-yellow-box::after,
        .bg-blue-box::after {
            position: absolute;
            top: -1px;
            bottom: -1px;
            left: -1px;
            right: -1px;
            content: "";
            z-index: -1;
            border-radius: 45px;
        }

        .bg-green-box::after {
            background: #1b6dbf;
        }

        .bg-white-box::after {
            background: #4E0473;
        }

        .bg-yellow-box::after {
            background: #196536;
        }

        .bg-blue-box::after {
            background: #f74b38;
        }

        .card-title {
            font-weight: 600;
            color: white;

            line-height: 40px;
            font-style: normal;
            font-size: 22px;
            padding-bottom: 8px;
        }

        .card-description {
            font-weight: 600;
            line-height: 32px;
            color: hsla(0, 0%, 100%, 0.5);
            font-size: 16px;
            max-width: 470px;
        }

        .custom-button {
            padding: 10px 20px;
            border-radius: 7px;
            background-color: transparent;
            font-size: 16px;
            cursor: pointer;
            outline: none;
            transition: all 0.3s ease;
        }

        .custom-button:hover {
            background-color: #3a4440;
            color: rgb(227, 227, 227);
        }

        .btn_1 {
            border: 1px solid #ffff;
            color: #ffff;
        }

        .btn_2 {
            border: 1px solid #ffff;
            color: #ffff;
        }

        .btn_3 {
            border: 1px solid #ffff;
            color: #ffff;
        }

        .btn_4 {
            border: 1px solid #ffff;
            color: #ffff;
        }

        .login_btn {
            display: flex;
            justify-content: right;
        }
    </style>
    <style>
        *{
        box-sizing: border-box;
        padding: 0;
        margin: 0;
        }
        body {
            font-family: Arial,
        }

        .landing-body {
            background-color: #196536;
            background-image: url('')
            width: 100%;
            height: 100vh;
        }

        .inspectorate-box div h2 {
            background-color: #4F9DDB;
            padding: 20px;
            border-radius: 20px;
            text-align: center;
        }
        .card{
        border-radius:5px !important;
        }
        .inspectorate-box{
        display: flex;
        width: 100%;
        height: 100vh;
        flex-direction: column;
        justify-content: space-between;
        padding: 50px 0 30px 0;

        }
        .card-body{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        }
        .card-title{
        color: #262626;
        }
    </style> --}}
    <style>
        .card{
            box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px;
        }
    </style>
</head>

<body>
    {{-- <div class="background">
        <div class="">
            <a href="{{ url('/admin/login') }}">
                <div style="">
                    <img src={{ asset('assets/backend/images/bgimg2.jpeg') }} width="100%" height="900px">
                </div>
            </a>
            <p class="container-title">Welcome to Inspectorate Automation System</p>

            <div class="gradient-cards">
                <div class="card">
                    <div class="container-card bg-green-box">
                        <svg width="80" height="80" viewBox="0 0 120 120" fill="none">
                            <rect x="1" y="1" width="118" height="118" rx="24"
                                fill="url(#paint0_linear_1366_4547)" fill-opacity="0.2" stroke="#ffff" stroke-width="2">
                            </rect>

                            <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-family="Arial"
                                font-size="24" fill="#ffff">IE&amp;I</text>

                            <defs>
                                <linearGradient id="paint0_linear_1366_4547" x1="0.0063367" y1="0.168432"
                                    x2="120.853" y2="119.009" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#2FCB89" stop-opacity="0.7"></stop>
                                    <stop offset="0.489583" stop-color="#2FCB89" stop-opacity="0"></stop>
                                    <stop offset="1" stop-color="#2FCB89" stop-opacity="0.7"></stop>
                                </linearGradient>
                                <radialGradient id="paint1_radial_1366_4547" cx="0" cy="0" r="1"
                                    gradientUnits="userSpaceOnUse"
                                    gradientTransform="translate(60 60) rotate(96.8574) scale(122.674 149.921)">
                                    <stop stop-color="#54E8A9"></stop>
                                    <stop offset="1" stop-color="#1A3E31" stop-opacity="0.2"></stop>
                                </radialGradient>
                            </defs>
                        </svg>

                        <p class="card-title">Inspectorate of Electronics & <br> Instruments </p>
                        <div class="login_btn">
                            <button class="custom-button btn_1"
                                onclick="window.location.href = '{{ url('/admin/login') }}'">Login</button>

                        </div>


                    </div>

                </div>

                <div class="card">
                    <div class="container-card bg-white-box">
                        <svg width="80" height="80" viewBox="0 0 120 120" fill="none">
                            <rect x="1" y="1" width="118" height="118" rx="24"
                                fill="url(#paint0_linear_1366_4565)" fill-opacity="0.2" stroke="#ffff" stroke-width="2">
                            </rect>
                            <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-family="Arial"
                                font-size="24" fill="#ffff">IGS&amp;C</text>

                            <defs>
                                <linearGradient id="paint0_linear_1366_4565" x1="0" y1="0"
                                    x2="120" y2="120" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="white" stop-opacity="0.7"></stop>
                                    <stop offset="0.505208" stop-color="white" stop-opacity="0"></stop>
                                    <stop offset="1" stop-color="white" stop-opacity="0.7"></stop>
                                </linearGradient>
                                <radialGradient id="paint1_radial_1366_4565" cx="0" cy="0" r="1"
                                    gradientUnits="userSpaceOnUse"
                                    gradientTransform="translate(60 60) rotate(96.8574) scale(122.674 149.921)">
                                    <stop stop-color="white"></stop>
                                    <stop offset="1" stop-color="#363437" stop-opacity="0.2"></stop>
                                </radialGradient>
                            </defs>
                        </svg>
                        <p class="card-title">Inspectorate of General Stores & <br> Clothing</p>
                        <div class="login_btn">
                            <button class="custom-button btn_2"
                                onclick="window.location.href = '{{ url('/admin/login') }}'">Login</button>
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="container-card bg-yellow-box">
                        <svg width="80" height="80" viewBox="0 0 120 120" fill="none">
                            <rect x="1" y="1" width="118" height="118" rx="24"
                                fill="url(#paint0_linear_1366_4557)" fill-opacity="0.2" stroke="#ffff"
                                stroke-width="2">
                            </rect>
                            <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-family="Arial"
                                font-size="24" fill="#ffff">IV&amp;EE</text>
                            <defs>
                                <linearGradient id="paint0_linear_1366_4557" x1="-0.0208152" y1="-0.102528"
                                    x2="119.899" y2="119.817" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FFE34B" stop-opacity="0.7"></stop>
                                    <stop offset="0.510417" stop-color="#FFE34B" stop-opacity="0"></stop>
                                    <stop offset="1" stop-color="#FFE34B" stop-opacity="0.7"></stop>
                                </linearGradient>
                                <radialGradient id="paint1_radial_1366_4557" cx="0" cy="0" r="1"
                                    gradientUnits="userSpaceOnUse"
                                    gradientTransform="translate(60 60) rotate(96.8574) scale(122.674 149.921)">
                                    <stop stop-color="#FFEE24"></stop>
                                    <stop offset="1" stop-color="#302A1A" stop-opacity="0.2"></stop>
                                </radialGradient>
                            </defs>
                        </svg>
                        <p class="card-title">Inspectorate of Vehicle & <br> Engineering Equipment </p>
                        <div class="login_btn">
                            <button class="custom-button btn_3"
                                onclick="window.location.href = '{{ url('/admin/login') }}'">Login</button>
                        </div>


                    </div>
                </div>

                <div class="card">
                    <div class="container-card bg-blue-box">
                        <svg width="80" height="80" viewBox="0 0 120 120" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect x="1" y="1" width="118" height="118" rx="24"
                                fill="url(#paint0_linear_1366_4582)" fill-opacity="0.2" stroke="#ffff"
                                stroke-width="2">
                            </rect>
                            <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-family="Arial"
                                font-size="24" fill="#ffff">IA&amp;E</text>

                            <defs>
                                <linearGradient id="paint0_linear_1366_4582" x1="120.194" y1="119.827"
                                    x2="-13.1225" y2="17.1841" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#61A0FF" stop-opacity="0.7"></stop>
                                    <stop offset="0.489583" stop-color="#61A0FF" stop-opacity="0"></stop>
                                    <stop offset="1" stop-color="#61A0FF" stop-opacity="0.7"></stop>
                                </linearGradient>
                                <radialGradient id="paint1_radial_1366_4582" cx="0" cy="0" r="1"
                                    gradientUnits="userSpaceOnUse"
                                    gradientTransform="translate(60 60) rotate(96.8574) scale(122.674 149.921)">
                                    <stop stop-color="#87A1FF"></stop>
                                    <stop offset="1" stop-color="#16161D" stop-opacity="0.2"></stop>
                                </radialGradient>
                            </defs>
                        </svg>
                        <p class="card-title">Inspectorate of Armaments & <br> Explosives</p>
                        <div class="login_btn">
                            <button class="custom-button btn_4"
                                onclick="window.location.href = '{{ url('/admin/login') }}'">Login</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="landing-body">
    <div class="container">
            <div class="inspectorate-box">
                <div>
                    <h2 class="text-light"> <b>WELCOME TO INSPECTORATE AUTOMATION SYSTEM</b> </h2>
                </div>
                <div class="d-flex">
                    <div class="col-3 p-1">
                        <div class="card" >
                            <img class="card-img-top" src="{{asset('assets/backend/images/IA&E.png')}}" alt="image">
                            <div class="card-body">
                              <h5 class="card-title p-0 m-0">IA&E</h5>
                              <p class="card-text text-center ">Inspectorate of Armaments & Explosives</p>
                              <a href="{{url('admin/login')}}" class="btn btn-success">Login</a>
                            </div>
                          </div>
                    </div>
                    <div class="col-3 p-1">
                        <div class="card" >
                            <img class="card-img-top" src="{{asset('assets/backend/images/IV&EE.png')}}" alt="image">
                            <div class="card-body">
                              <h5 class="card-title p-0 m-0 ">IV&EE</h5>
                              <p class="card-text text-center">Inspectorate of Vehicle & Engineers Equipment</p>
                              <a href="{{url('admin/login')}}" class="btn btn-success">Login</a>
                            </div>
                          </div>
                    </div>

                    <div class="col-3 p-1">
                        <div class="card" >
                            <img class="card-img-top" src="{{asset('assets/backend/images/IGS&C.png')}}" alt="image">
                            <div class="card-body">
                              <h5 class="card-title p-0 m-0">IGS&C</h5>
                              <p class="card-text text-center">Inspectorate of General Stores & Clothing</p>
                              <a href="{{url('admin/login')}}" class="btn btn-success">Login</a>
                            </div>
                          </div>
                    </div>
                    <div class="col-3 p-1">
                        <div class="card" >
                            <img class="card-img-top" src="{{asset('assets/backend/images/IE&I.png')}}" alt="image">
                            <div class="card-body">
                              <h5 class="card-title p-0 m-0">IE&I</h5>
                              <p class="card-text text-center">Inspectorate of Electronics & Instruments  </p>
                              <a href="{{url('admin/login')}}" class="btn btn-success">Login</a>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
    </div>
    </div>
</body>

</html>
