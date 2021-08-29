<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- App Icons -->
	<link rel="shortcut icon" href="{{ url('public/studentfolder.ico') }}">
        <link rel="icon" type="image/x-icon" href="{{url('public/studentfolder.ico')}}">
        
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet"> 

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                background-image: url('images/tmp_bookcase.jpg');
                /*background-image: url('images/tmp_desktop.jpg');
                background-image: url('images/tmp_electronics.jpg');*/
                background-size: cover;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-size: 14px;
                font-weight: 200;
                height: 101vh;
                margin: 0;
            }
            
            body
            {
                background-color: blanchedalmond;
                /*background-image: url('images/tmp_bookcase.jpg');*/
                background-image: url('images/tmp_desktop.jpg');
                /*background-image: url('images/tmp_electronics.jpg');*/
                background-repeat: no-repeat;
                background-size: cover;
            }
            
            #header_Site
            {
                background-color: rgba(0, 0, 0, .8);
                display: flex;
                position: absolute;
                top: 0;
                left: 0;
                height: 80px;
                width: 100vw;
            }
            
                #logo
                {
                    background-color: white;
                    border-radius: 15px;
                    display: flex;
                    flex-direction: column;
                    margin-top: 10px;
                    position: absolute;
                    top: 5px;
                    left: 5px;
                }
                
                    #logo img
                    {
                        width: 50px;
                    }
                    
                #site_Name
                {
                    color: white;
                    font-size: 1.5rem;
                    font-weight: bold;
                    padding-top: 25px;
                    text-align: center;
                    width: 100%;
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

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }
            
                .top-right.links > a {
                    color: white;
                }

            .nav_guest {
                background-color: rgba(255, 255, 255, .8);
                display: flex;
                justify-content: space-around;
                position: absolute;;
                top: 90px;
                width: 100%;
            }
            
                .nav_guest.links > a {
                    color: black;
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
            
            @media only screen and (min-width: 600px)
            {
                .nav_guest {
                    background-color: transparent;
                    justify-content: flex-end;
                    position: absolute;
                    top: 10px;
                    width: 100%;
                }
                
                    .nav_guest.links > a {
                        color: white;
                    }
            }
            
        </style>
    </head>
    <body>
        @yield('header_site')
        <!-- @yield('nav_guest') -->
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
