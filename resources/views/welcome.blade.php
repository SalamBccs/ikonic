<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ikonic Task</title>

    <!-- ************************************************************************ !-->
    <!-- ***                                                               *** !-->
    <!-- ***       ¤ Designed and Developed by                             *** !-->
    <!-- ***                                                               *** !-->
    <!-- ***                                                              *** !-->
    <!-- ************************************************************************ !-->

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Fonts -->
    <link rel="icon" type="image/x-icon" href="{{ asset('admin/favicon/favicon.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?version = 6.8">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-multiselect.css') }}">
    <!-- Google tag (gtag.js) -->
    {{-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-DL5C6Y9MRT"></script> --}}
    <script>
        function isLocalhost(url) {
            return url.includes('localhost') || url.includes('127.0.0.1');
        }
        if (location.protocol !== 'https:' && isLocalhost(window.location.origin) == false) {
            location.replace(`https:${location.href.substring(location.protocol.length)}`);
        }
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-DL5C6Y9MRT');
    </script>


    <style type="text/css">
        .secod-bg {
            position: relative;
            width: 200px !important;
        }

        .frst-bg {
            position: relative;
            width: 200px !important;

        }

        .frst-bg .userName {
            right: unset;
            left: 8px;
        }

        .userName {
            position: absolute;
            right: 8px;
            top: 4px;
            font-size: 10px;
        }

        .chat.firstView .msg li.second div {
            float: left;
            border-radius: 22px 1px 22px 0px !important;
            background: #fff;
        }

        .chat .msg li div {
            padding: 20px 20px 10px 20px !important;

        }

        .chat .msg p {
            margin-bottom: 0px !important;
        }

        .chat.firstView .msg li.first div {
            border-radius: 0px 22px 0px 21px !important;
            text-align: end !important;
        }

        .time-btn {
            display: flex;

        }

        .time-btn button {
            margin: auto;
            margin-top: -45px;
            padding: 5px 25px;
            border: none;
            outline: none;
            background: #28a745;
            border: 1px solid #28a745;
            color: #fff;
            border-radius: 8px;
            transition: all 0.5s;
        }

        .time-btn button:hover {
            background: transparent;
            color: #000;
            transition: all 0.5s;
        }
    </style>
    <style>
        .loader-wrapper {
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #242f3f;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999999;
        }

        .loader {
            display: inline-block;
            position: relative;
            top: 5%;
            border: 4px solid #Fff;
            animation: loader 2s infinite ease;
        }

        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid blue;
            border-bottom: 16px solid blue;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        ion-icon {
            pointer-events: none;
            cursor: pointer;
        }

        table tr th {
            text-align: center !important;
        }

        .chat .modalAttachment .preview {
            display: block;
            position: absolute;
            z-index: 1;
            width: 75%;
            height: -webkit-fill-available;
            top: 300px;
            left: 0px;
            padding: 40px;
            -webkit-transform: translate(0%, -50%);
            transform: translate(3%, -15%);
        }

        .chat .modalAttachment .preview img {
            display: block;
            max-width: 70%;
            height: 100%;
            top: 200px;
            border-radius: 10px;
        }

        .dfg-popup-container {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 999;
        }

        .dfg-popup-image-big {
            max-width: 80%;
            max-height: 80%;
            margin: auto;
            display: block;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
        }

        .dfg-popup-container.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body class="antialiased">
    <div class="loader-wrapper" id="loader-overlay" style="display: none;">
        <span class="loader"><span class="loader-inner"></span></span>
    </div>
    <div id="app"></div>
    <script src="{{ asset('js/app.js') }}?version = 6.8"></script>
    <script src="{{ asset('js/scripts.js') }}?version = 6.8"></script>
    <script>
        $(window).on("load", function() {
            $(".loader-wrapper").fadeOut(5000);
        });
        window.assetsPath = "{{ asset('/') }}"

    </script>
    <script src="{{ asset('js/bootstrap-multiselect.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>
