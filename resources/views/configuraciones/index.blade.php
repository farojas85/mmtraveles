@extends('layouts.master')

@section('contenido')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><i class="fas fa-users-cog mr-1"></i> Configuraciones</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Configuraciones</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                               Configuraciones
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="card card-primary card-outline">
                                <div class="card-header p-0 pt-1 border-bottom-0">
                                    <ul class="nav nav-tabs navtab-bg nav-justified">
                                        <li class="nav-item">
                                            <a href="#tab-roles" data-toggle="tab" aria-expanded="false" class="nav-link show active">
                                                Roles
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#tab-permisos" data-toggle="tab" aria-expanded="true" class="nav-link" >
                                                Permisos
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#tab-permiso-role" data-toggle="tab" aria-expanded="false" class="nav-link"  >
                                                Permisos / Roles
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab-roles">
                                            @include('configuraciones.role.index')
                                        </div>
                                        <div class="tab-pane" id="tab-permisos">
                                            @include('configuraciones.permission.index')
                                        </div>
                                        <div class="tab-pane" id="tab-permiso-role">
                                            @include('configuraciones.permission_role.index')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripties')
    <script src="js/sistema/configuracion.js"></script>
@endsection
