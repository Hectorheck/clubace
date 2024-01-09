@extends('layouts.compact_menu')

{{-- Page title --}}
@section('title')
Create New Tipo Users @parent
@stop

@section('content')
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
                    <li class="breadcrumb-item active">{{ __('Create New') }} Tipo Users</li>
                </ol>
            </div>
        </div>
    </div>
</header>

<div class="outer">
    <div class="inner bg-container">
        @include('adminlte-templates::common.errors')
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="text-white">Create New Tipo Users</h5>
            </div>
            <div class="card-body mt-3">
                <div>
                    {!! Form::open(['route' => 'tipoUsers.store','class' =>
                    'form-horizontal']) !!}

                    @include('tipo_users.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
