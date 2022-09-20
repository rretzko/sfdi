@section('nav_guest')
    @if (Route::has('login'))
        <div class="nav_guest links">
            @auth
                <a href="{{ url('/home') }}">Home</a>
            @else
                <!-- {{-- <a href="{{ route('guest.pitch_files') }}">Pitch Files</a> --}} -->

                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif
@endsection
