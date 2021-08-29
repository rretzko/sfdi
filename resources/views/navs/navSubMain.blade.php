@section('nav_sub_main')
    @if (Route::has('login'))
       
        @auth            
            <nav class="navbar navbar-expand-md justify-content-md-around navbar-dark mb-3" id="nav_sub_main"> 

                <div class="container">
                    
                    <button class="navbar-toggler" type="button" 
                            data-toggle="collapse" data-target="#subMainNav"
                            aria-controls="subMainNav" aria-expanded="false" 
                            aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <div class="collapse navbar-collapse" id="subMainNav"> 
                        <div class="navbar-nav"> 
                            <a href="{{url('/')}}" class="nav-item nav-link" title="home">Home</a>
                            <a href="{{ route('logout') }}" class="nav-item nav-link" title="logout" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                            Logout
                            </a>    
                            <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
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
