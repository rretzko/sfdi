@extends('layouts.page')

@section('title')
Parents
@endsection

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="page-title m-0">Parents/Guardians</h1>
                </div>
                <div class="col-md-4">
                    <div class="text-right">
                        <div class="dropdown">
                            <a href="{{route('addParent')}}" class="btn btn-primary">
                                <i class="ti-plus mr-1"></i> Add Parent/Guardian
                            </a>
                        </div>
                    </div>
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

                <h4 class="mt-0 header-title">My Parents/Guardians</h4>
                <p class="text-muted m-b-30 font-14">You can edit their details using the below table:</p>

                <div class="parentspage">
                    {!!$table_parents!!} 
                </div>

            </div>
        </div>
    </div>
</div>

@endsection