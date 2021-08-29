@extends('layouts.page')

@section('title')
Messages
@endsection

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="page-title m-0">Message</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="mt-0 header-title">My Message</h4>
                <div class="col-12 d-flex flex-row">
                    <label class="col-1">Sent</label>
                    <div class="col-11 flex-start">{{$missive->created_at}}</div>
                </div>
                
                <div class="col-12 d-flex flex-row">
                    <label class="col-1">Subject</label>
                    <div class="col-11 flex-start">{{$missive->header}}</div>
                </div>
                
                <div class="col-12 d-flex flex-row">
                    <label class="col-1">Sent By</label>
                    <div class="col-11 flex-start">{{$sender}}</div>
                </div>
                
                <div class="col-12 d-flex flex-row">
                    <label class="col-1">Status</label>
                    <div class="col-11 flex-start">{{$missive->statusDescr}}</div>
                </div>
                
                <div class="col-12 d-flex flex-row">
                    <label class="col-1">Message</label>
                    <div class="col-11 flex-start">{!! $missive->missive !!}</div>
                </div>

                

            </div>
        </div>
    </div>
</div>
@endsection
