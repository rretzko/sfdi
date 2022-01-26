@extends('layouts.auth')
@extends('navs.navGuest')
@extends('headers.headerSite')

@section('title')
    Register
@endsection

@section('content')

    @livewire('register')

    @push('scripts')
        <script src="https://studentfolder.info/public/assets/js/tdr_main.js"></script>
    @endpush

@endsection

