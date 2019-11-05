@extends('layouts.master')

@section('contenido')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><i class="fas fa-hotel mr-1"></i> EMPRESA</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Entidad</li>
                        <li class="breadcrumb-item active">Empresas</li>
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
                                    Listado de Empresas
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        @can('empresas.create')
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded" @click="nuevo">
                                            <i class="fas fa-plus"></i> Nueva Empresa
                                        </button>
                                        @endcan
                                        @can('empresas.showdelete')
                                        <button type="button" class="btn btn-danger btn-sm btn-rounded" @click="">
                                            <i class="far fa-trash-alt"></i> Mostrar Eliminados
                                        </button>
                                        @endcan
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control"  placeholder="Buscar..." @change="">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-info">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-striped table-bordered table-hover">
                                                <thead class="">
                                                    <tr>
                                                        <th class="text-center" width="5%">#</th>
                                                        <th class="">Raz&oacute;n Social</th>
                                                        <th class="">Nombre Comercial</th>
                                                        <th class="">Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-if="total_empresas == 0">
                                                        <td class="text-center" colspan="4">-- Datos No Registrados - Tabla Vac&iacute;a --</td>
                                                    </tr>
                                                    <tr v-else v-for="empresa in empresas.data" :key="empresa.id">
                                                            <td class="text-center">@{{ empresa.id}}</td>
                                                            <td>@{{ empresa.razon_social }}</td>
                                                            <td>@{{ empresa.nombre_comercial }}</td>
                                                            <td>
                                                                @can('empresas.show')
                                                                <button type="button" class="btn btn-info btn-xs"
                                                                    title="Mostrar Rol" @click="">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                                @endcan
                                                                @can('empresas.edit')
                                                                <button type="button" class="btn btn-warning btn-xs"
                                                                    title="Editar Rol" @click="" >
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                @endcan
                                                                @can('empresas.destroy')
                                                                <button type="button" class="btn btn-danger btn-xs"
                                                                    title="Eliminar Rol" @click="">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                                @endcan
                                                            </td>
                                                        </tr>
                                                </tbody>
                                            </table>
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
    <script src="js/entidad/empresa.js"></script>
@endsection

@include('entidad.empresa.create')
@include('entidad.empresa.show')
@include('entidad.empresa.edit')
