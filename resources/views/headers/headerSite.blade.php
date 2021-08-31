@section('header_site')
    <section id="header_Site">
        <a href="{{ url('home')}}"><div id="logo"><img src="https://studentfolder.info/assets/images/studentFolder_Logo.png" /></div></a>
        <div id="site_Name">{{config('app.name')}}</div>
    </section>
@endsection
