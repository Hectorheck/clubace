@extends('layouts.compact_menu')

{{-- Page title --}}
@section('title')
View Tipo Users @parent
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
                    <li class="breadcrumb-item">
                        <a href="#">Tipo Users</a>
                    </li>
                    <li class="breadcrumb-item active">View Tipo Users</li>
                </ol>
            </div>
        </div>
    </div>
</header>

<div class="outer">
    <div class="inner bg-container">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="card">
            <div class="table-responsive">
                <table class="table table-default">
                    @include('tipo_users.show_fields')

                </table>
            </div>
        </div>
        <a href="{{ route('tipoUsers.index') }}" class="btn btn-primary mt-2">Back</a>
    </div>
</div>
@endsection