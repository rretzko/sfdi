<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'StudentFolder.info') }}</title>

        <!-- App Icons -->
	    <link rel="shortcut icon" href="{{ url('public/studentfolder.ico') }}">
        <link rel="icon" type="image/x-icon" href="{{url('public/studentfolder.ico')}}">

        <!-- Scripts -->
        <!-- <script src="assets/js/app.js') }}" defer></script> -->
        <script src="{{url('public/js/bootstrap.js')}}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{url('public/css/bootstrap.css')}}" rel="stylesheet">
        <!-- {{-- <link href="{{asset('css/main.css')}}" rel="stylesheet"> --}} -->
        <link href="/assets/css/main.css" rel="stylesheet">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            .main
            {
                position: absolute;
                display: grid;
                grid-template-columns: 10% auto 10%;
                grid-template-rows: 10% auto 10%;
                height: calc(100vh - 200px);
                top: 100px;
                width: 100vw;
            }

            .container
            {
                background-color: transparent;
                grid-column-start: 2;
                grid-column-end: 3;
                grid-row-start: 2;
                grid-row-end: 3;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .nav_guest,
            .nav_student
            {
                background-color: rgba(255, 255, 255, .8);
                display: flex;
                justify-content: space-around;
                position: absolute;;
                top: 90px;
                width: 100%;
            }

                .nav_guest.links > a{
                    color: black;
                }

            .nav_student
            {
                background-color: rgba(255, 0, 0, 1);
                display: none;
                visibility: hidden;
            }

                .nav_student.links > a{
                        color: white;
                        font-size: 1.15rem;
                }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            /** NOTE: max-height! **/
            @media only screen and (max-height: 360px)
            {
                .main
                {
                    grid-template-columns: 20% auto 20%;
                    grid-template-rows: 10% auto 10%;
                }
            }

            @media only screen and (min-width: 400px)
            {
                .main
                {
                    grid-template-columns: 10% auto 10%;
                    grid-template-rows: 20% 60% 40%;
                }
            }

            @media only screen and (min-width: 600px)
            {
                .nav_guest {
                    background-color: transparent;
                    justify-content: flex-end;
                    position: absolute;
                    top: 10px;
                    width: 100%;
                }

                    .nav_guest.links > a
                    {
                        color: white;
                    }
            }

            @media only screen and (min-width: 800px)
            {
                .col-md-8 /*bootstrap class*/
                {
                    flex: 1 0 auto;
                    max-width: 100%;
                }

                .main
                {
                    grid-template-columns: 15% auto 15%;
                    grid-template-rows: 20% auto 20%;
                }

                .container
                {
                    grid-column-start: 2;
                    grid-column-end: 3;
                    grid-row-start: 2;
                    grid-row-end: 3;
                }


                .nav_student
                {
                    display: flex;
                    flex-wrap: wrap;
                    visibility: visible;
                }

                    .nav_student.links > a
                    {
                        color: white;
                        font-size: .8rem;
                    }
            }
        </style>
    </head>
    <body>
        @yield('header_site')
        @yield('nav_guest')
        @yield('nav_student')
        @yield('content')

        <!--Start of Tawk.to Script-->
        <script type="text/javascript">
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/5f43e1aacc6a6a5947ae5885/default';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
            })();
        </script>
        <!--End of Tawk.to Script-->
    </body>
</html>
