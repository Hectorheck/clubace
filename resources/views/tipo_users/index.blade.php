@extends('layouts.compact_menu')

{{-- Page title --}}
@section('title')
Tipo Users @parent
@stop

@section('content')
<!-- Content Header (Page header) -->
<header class="head">
    <div class="main-bar">
        <div class="row">
            <div class="col-lg-6 col-sm-4">
                <h4 class="nav_top_align">
                    <i class="fa fa-th"></i>
                    Tipo Users
                </h4>
            </div>
            <div class="col-lg-6 col-sm-8">
                <ol class="breadcrumb float-right nav_breadcrumb_top_align">
                    <li class="breadcrumb-item">
                        <a href="index">
                            <i class="fa fa-home" data-pack="default" data-tags=""></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item active">Tipo Users</li>
                </ol>
            </div>
        </div>
    </div>
</header>

<!-- Main content -->
<div class="outer">
    <div class="inner bg-container">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title d-inline">Tipo Users</h5>
                <span class="float-right">
                    <a class="btn btn-primary pull-right"
                        href="{{ route('tipoUsers.create') }}">Add New</a>
                </span>
            </div>
            <div class="card-body">
                @include('tipo_users.table')
            </div>
        </div>
        <div class="text-center">
            
        </div>
    </div>
</div>
@endsection
