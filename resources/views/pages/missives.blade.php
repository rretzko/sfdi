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
                    <h1 class="page-title m-0">Messages</h1>
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

                <h4 class="mt-0 header-title">My Messages</h4>
                <p class="text-muted m-b-30 font-14">All sent messages are displayed in the table below:</p>

                <div class="parentspage">
                    {!!$table!!}  
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
