@extends('layouts.auth')
@extends('navs.navGuest')
@extends('headers.headerSite')

@section('title')
    Register
@endsection

@section('content')

    <div style="padding:0.5rem; font-size: 1rem;">
        <div>
            Your password-reset email has been sent to:
        </div>
        <ul>
            @foreach($emails AS $email)
                <li><b>*****{{ substr($email,strpos($email,'@')) }}</b></li>
            @endforeach
        </ul>
        <div style="margin-bottom: 0.5rem;">
            <p>
                If you do not receive the password-reset email, please note that your school email server may be blocking
                external emails.
            </p>
            <p>
                If you are using a school email address, please ask your Director to update your record with a
                non-school email address (ex. google, hotmail, etc).
            </p>
        </div>
        <div>
            <p>
                If you do not receive the password-reset email, you may also use the green Chat button at the
                bottom-right-hand corner of this page.
            </p>
            <p>
                You <b><u>must</u></b> include
            </p>
            <ul>
                <li>Your name,</li>
                <li>a non-school email address,</li>
                <li>Your teacher's name, and </li>
                <li>Your school name in this request.</li>
            </ul>
        </div>
    </div>

    @push('scripts')
        <script src="https://studentfolder.info/public/assets/js/tdr_main.js"></script>
    @endpush

@endsection

