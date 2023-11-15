<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>PDF - Generator</title>

    @include('includes.header')

    <style>
        .center-body {
            position: fixed;
            top: 0;
            left: 0;
             z-index: 1100;
            height: 100vh;
            width: 100%;
            background-color: #000000ad;
        }

        .loader-circle-9 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 70px;
            height: 70px;
            background: white;
            border: 3px solid #3c3c3c;
            border-radius: 50%;
            text-align: center;
            line-height: 70px;
            font-family: sans-serif;
            font-size: 12px;
            color: #003f77;
            text-transform: uppercase;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .loader-circle-9:before {
            content: "";
            position: absolute;
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100%;
            border: 3px solid transparent;
            border-top: 3px solid #003f77;
            border-right: 3px solid #003f77;
            border-radius: 50%;
            animation: animateC 2s linear infinite;
        }

        .loader-circle-9 span {
            display: block;
            position: absolute;
            top: calc(50% - 2px);
            left: 50%;
            width: 50%;
            height: 4px;
            background: transparent;
            transform-origin: left;
            animation: animate 2s linear infinite;
        }

        .loader-circle-9 span:before {
            content: "";
            position: absolute;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #003f77;
            top: -6px;
            right: -8px;
            box-shadow: 0 0 20px #003f77;
        }

        @keyframes animateC {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes animate {
            0% {
                transform: rotate(45deg);
            }

            100% {
                transform: rotate(405deg);
            }
        }
    </style>

</head>

<body>
    @yield('content')
    @include('includes.footer')
    @yield('insertjavascript')

    <div class="center-body d-none" id="loader">
        <div class="loader-circle-9">Loading
            <span></span>
        </div>
    </div>
</body>

</html>
