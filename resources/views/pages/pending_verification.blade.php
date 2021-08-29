@extends('layouts.page')

@section('title')
Pending Email Verification
@endsection

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8 bg-white">
                    <h2 class="page-title m-0">Next Steps</h2>
                    <p>Before leaving StudentFolder.info:
                        <ol>
                        <li><span class="text-danger">Click the <a href="{{ route('schools') }}">Schools</a> link to identify your school and teacher.</span>
                                <ul>
                                    <li style="font-size: smaller;">Note: <b>No events will display</b> until your teacher has accepted your registration!</li>
                                </ul></li>
                            <li>Click the <a href="{{ route('parents') }}">Parents</a> link to provide contact information for parents/guardians.</li>
                            <li>Click the <a href="{{ route('profile') }}">Profile</a> link to add additional information about yourself.</li>
                    </ol>
                    </p>
               <!--     <h2 class="page-title m-0">Pending Email Verification</h2>
                    <p>An email has been sent to your primary email address.</p>
                    <p><b>Please log out</b> and then use the link in that message to verify your primary email address.</p>
                    <p>No further emails can be sent until that address is verified.</p>
                -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

@endsection
