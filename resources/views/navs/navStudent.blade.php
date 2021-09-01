@section('nav_student')
    @if (Route::has('login'))

        @auth
            <nav class="navbar navbar-expand-md justify-content-md-around navbar-dark mb-3" id="nav_main">

                <div class="container">

                    <button class="navbar-toggler" type="button"
                            data-toggle="collapse" data-target="#mainNav"
                            aria-controls="mainNav" aria-expanded="false"
                            aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="mainNav">
                        <div class="navbar-nav">
                            <a href="{{url('events')}}" class="nav-item nav-link" title="event">Event(s)</a>
                            <a href="{{route('profile')}}" class="nav-item nav-link {{$nav_links['profile']}}" title="profile">My Profile</a>
                            <a href="{{url('parent')}}" class="nav-item nav-link {{$nav_links['parent']}}" title="parent">Parent Profile</a>
                            <a href="{{url('credentials')}}" class="nav-item nav-link {{$nav_links['credentials']}}" title="credentials">Credentials</a>
                            <a href="{{url('school')}}" class="nav-item nav-link {{$nav_links['school']}}" title="school">School</a>
                            <a href="{{url('student')}}" class="nav-item nav-link {{$nav_links['student']}}" title="student">Student</a>
                            <a href="{{url('history')}}" class="nav-item nav-link disabled" title="history">History</a>
                            <a href="{{ route('logout') }}" class="nav-item nav-link" title="logout" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                            LogOut
                            </a>
                            <form id="frm-logout" action="https://studentfolder.info/logout" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div><!-- navbar-nav -->
                    </div><!-- collapse -->
                </div><!-- collapse container -->
            </nav>
        @else
            <a href="{{ route('login') }}">Login</a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}">Register</a>
            @endif
        @endauth

    @endif
@endsection
