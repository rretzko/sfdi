<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

	<!-- App Icons -->
	<link rel="shortcut icon" href="{{ url('studentfolder.ico') }}">
        <link rel="icon" type="image/x-icon" href="{{url('studentfolder.ico')}}">

	<title>
		@if(View::hasSection('title'))
			@yield('title') - StudentFolder.info
		@else
			{{ config('app.name', 'StudentFolder.info') }}
		@endif
	</title>
	<meta name="description" content="StudentFolder.info is a custom app designed for Students. " />

	<!-- DataTables -->
    @if(config('app.url') === 'http://localhost')
        <link href="http://localhost/dev/sfdi/public/assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="http://localhost/dev/sfdi/public/assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    @else
        <link href="https://studentfolder.info/assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="https://studentfolder.info/assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    @endif

	<!-- App css -->
    @if(config('app.url') === 'http://localhost')
        <link href="http://localhost/dev/sfdi/public/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="http://localhost/dev/sfdi/public/assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="http://localhost/dev/sfdi/public/assets/css/main.css" rel="stylesheet" type="text/css" />
        <link href="http://localhost/dev/sfdi/public/assets/css/style.css" rel="stylesheet" type="text/css" />
    @elseif(config('app.url') ==='https://sfdi-39uni.ondigitalocean.app')
        <link href="https://sfdi-39uni.ondigitalocean.app/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="https://sfdi-39uni.ondigitalocean.app/assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="https://sfdi-39uni.ondigitalocean.app/assets/css/main.css" rel="stylesheet" type="text/css" />
        <link href="https://sfdi-39uni.ondigitalocean.app/assets/css/style.css" rel="stylesheet" type="text/css" />
    @else
        <link href="https://studentfolder.info/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="https://studentfolder.info/assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="https://studentfolder.info/assets/css/main.css" rel="stylesheet" type="text/css" />
        <link href="https://studentfolder.info/assets/css/style.css" rel="stylesheet" type="text/css" />
    @endif

<style>
    #topnav {
        top: -88px;
    }
</style>

</head>


<body>

	<div class="header-bg">
		<!-- Navigation Bar-->
		<header id="topnav">
			<div class="topbar-main">
				<div class="container">

                                    <!-- CSRF Ensure _token value exists -->
                                    @csrf

					<!-- Logo-->
					<div>
						<a href="{{route('event')}}" class="logo" style="color: #fff;font-size: 15px;font-weight: 300;line-height: 57px;letter-spacing: 1px;">StudentFolder.info</a>
					</div>
					<!-- End Logo-->

					<div class="menu-extras topbar-custom navbar p-0">
						<ul class="list-inline ml-auto mb-0">
							<li class="list-inline-item dropdown notification-list">
								<a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"aria-haspopup="false" aria-expanded="false">
									<i class="mdi mdi-bell-outline noti-icon"></i>
									<span class="badge badge-pill noti-icon-badge"></span>
								</a>
								<div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg dropdown-menu-animated">
									<!-- item-->
									<div class="dropdown-item noti-title">
										<h5>No unread alerts</h5>
									</div>

									<div class="slimscroll-noti">

									</div>

								</div>
							</li>
							<li class="list-inline-item dropdown notification-list nav-user">
								<a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
									<span class="d-none d-md-inline-block ml-1" id="welcomeUserName">Welcome, {{ Auth::user()->person->first }} </span>
								</a>
							</li>
							<li class="menu-item list-inline-item">
								<!-- Mobile menu toggle-->
								<a class="navbar-toggle nav-link">
									<div class="lines">
										<span></span>
										<span></span>
										<span></span>
									</div>
								</a>
								<!-- End mobile menu toggle-->
							</li>
						</ul>
					</div>
					<!-- end menu-extras -->

					<div class="clearfix"></div>

				</div> <!-- end container -->
			</div>
			<!-- end topbar-main -->

			<!-- MENU Start -->
			<div class="navbar-custom">
				<div class="container">

					<div id="navigation">

						<!-- Navigation Menu-->
						<ul class="navigation-menu">
							<li class="{{ Route::currentRouteNamed( 'events' ) ?  'has-submenu active' : '' }}"><a href="{{route('events')}}"><i class="dripicons-calendar"></i> {{ __('Events') }}</a></li>
							<li class="{{ Route::currentRouteNamed( 'profile' ) ?  'has-submenu active' : '' }}"><a href="{{route('profile')}}"><i class="dripicons-user"></i> {{ __('Profile') }}</a></li>
							<li class="{{ Route::currentRouteNamed( 'schools' ) ?  'has-submenu active' : '' }}"><a href="{{route('schools')}}"><i class="dripicons-graduation"></i> {{ __('Schools') }}</a></li>
							<li class="{{ Route::currentRouteNamed( 'parents' ) ?  'has-submenu active' : '' }}"><a href="{{route('parents')}}"><i class="dripicons-user-group"></i> {{ __('Parents') }}</a></li>
							<li class="{{ Route::currentRouteNamed( 'credentials' ) ?  'has-submenu active' : '' }}"><a href="{{route('credentials')}}"><i class="dripicons-lock"></i> {{ __('Change Password') }}</a></li>
                                       <!-- {--                  <li class="{{ Route::currentRouteNamed( 'log' ) ?  'has-submenu active' : '' }}"><a href="{{route('log')}}"><i class="dripicons-mail"></i> {{ __('Message Log') }}</a></li> --} -->
							<li class=""><a href="{{route('sfdi.login.destroy')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="dripicons-exit"></i> {{ __('LogOut') }}</a></li>
                            @if(config('app.url') === 'http://localhost')
							    <form id="logout-form" action="{{ route('sfdi.login.destroy') }}" method="POST" style="display: none;">@csrf</form>
                            @else
                                <form id="logout-form" action="https://studentfolder.info/sfdi/logout" method="POST" style="display: none;">@csrf</form>
                            @endif
                            @if(auth()->id() === 2626)
                                <a href="{{ route('admin') }}">Admin</a>
                            @endif
						</ul>
						<!-- End navigation menu -->
					</div> <!-- end #navigation -->
				</div> <!-- end container -->
			</div> <!-- end navbar-custom -->
		</header>
		<!-- End Navigation Bar-->

	</div>
	<!-- header-bg -->

	<div class="wrapper">
		<div class="container">

			@yield('content')



		</div> <!-- end container -->
	</div>
	<!-- end wrapper -->


	<!-- Footer
	<footer class="footer">
		<div class="container">
			<div class="row">
				<div class="col-12">
					&copy; 2020 <a href="http://studentfolder.info/">StudentFolder.info</a> <span class="d-none d-md-inline-block"> - Crafted with <i class="mdi mdi-heart text-danger"></i> by <a href="https://www.newwavedigitaldesigns.com/">New Wave Digital Designs</a>.</span>
				</div>
			</div>
		</div>
	</footer>
	 End Footer -->

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

	<!-- jQuery  -->
    @if(config('app.url') === 'http://localhost')
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
            <script src="{{ asset('js/notifications.js') }}"></script>
            <script src="{{ asset('js/tdr_main.js') }}"></script>
    @else
        <script src="https://studentfolder.info/assets/js/jquery.min.js"></script>
        <script src="https://studentfolder.info/assets/js/bootstrap.bundle.min.js"></script>
        <script src="https://studentfolder.info/assets/js/jquery.slimscroll.js"></script>
        <script src="https://studentfolder.info/assets/js/app.js"></script>
        <script src="https://studentfolder.info/assets/js/notifications.js"></script>
        <script src="https://studentfolder.info/assets/js/tdr_main.js"></script>

    @endif

	@yield('pagescripts')
</body>
</html>
