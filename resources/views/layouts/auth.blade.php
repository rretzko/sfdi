<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

	<!-- App Icons -->
	<link rel="shortcut icon" href="assets/images/favicon.ico">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- App Icons -->
	<link rel="shortcut icon" href="{{ url('public/studentfolder.ico') }}">
        <link rel="icon" type="image/x-icon" href="{{url('public/studentfolder.ico')}}">

	<title>
		@if(View::hasSection('title'))
			@yield('title') - StudentFolder.info
		@else
			{{ config('app.name', 'StudentFolder.info') }}
		@endif
	</title>
	<meta content="Admin Dashboard" name="description" />
<!--
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">

    <link href="assets/css/main.css" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet" >
	-->
<link href="https://studentfolder.info/assets/css/bootstrap.min.css" rel="stylesheet" >
<link href="https://studentfolder.info/assets/css/main.css" rel="stylesheet" >
<link href="https://studentfolder.info/assets/css/style.css" rel="stylesheet" >
        <style>
            .nav_guest,
            .nav_student
            {
                background-color: rgba(255, 2555, 255, .8);
                display: flex;
                justify-content: space-around;
                position: absolute;
                top: 90px;
                width: 100%;
            }

                .nav_guest.links > a
                {
                    color: black;
                    padding: 0 25px;
                    font-size: 13px;
                    font-weight: 600;
                    letter-spacing: .1rem;
                    text-decoration: none;
                    text-transform: uppercase;
                }

            .nav_student
            {
                background-color: rgba(255, 0, 0, 1);
                display: none;
                visibility: hidden;
            }

                .nav_student.links > a
                {
                    color: white;
                    font-size: 1.15rem;
                }

            @media only screen and (min-width: 600px)
            {
                .nav_guest{
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

        </style>

</head>


<body>

        @yield('header_site')
        @yield('nav_guest')
	<!-- Begin page -->
	<div class="account-pages">

		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6 offset-lg-3 col-md-12">
					<div class="card mb-0">
						@yield('content')
					</div>
				</div>
			</div>
			<!-- end row -->
		</div>
	</div>

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


	<!-- JavaScripts  -->
	<script src="{{ asset('js/jquery.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
	<script src="{{ asset('js/app.js') }}"></script>
	@stack('scripts')
</body>
</html>
