@extends('layouts.master')

@section('contenido')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0 text-dark"><i class="far fa-file-alt mr-1"></i> REPORTE CAJA GENERAL</h3>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Reporte Caja General</li>
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
                            <h6 class="card-title" >
                               <font style="font-weight:900">Reporte Caja</font>
                            - <small>@{{lugar_detalle}}</small>
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <select name="lugar_id" class="form-control" v-model="busqueda.lugar_id">
                                        <option value="">-LUGAR-</option>
                                        <option value="%">TODOS</option>
                                        <option v-for="lugar in lugares" :key="lugar.id" :value="lugar.id">
                                            @{{lugar.name}}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3 noimpre">
                                    <div class="input-group mb-3" title="Fecha Inicio">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Fec. Ini.</span>
                                        </div>
                                        <input type="date" name="fecha_inicio" class="form-control"
                                                v-model="busqueda.fecha_ini">
                                    </div>
                                </div>
                                <div class="col-md-3 noimpre">
                                    <div class="input-group mb-3" title="Fecha Inicio">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Fec. Fin.</span>
                                        </div>
                                        <input type="date" name="fecha_final" class="form-control"
                                            v-model="busqueda.fecha_fin">
                                    </div>
                                </div>
                                <div class="col-md-3 noimpre">
                                    <button type="button" class="btn btn-primary" @click="buscar">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                    <a class="btn btn-success"
                                        href="excelReporte" >
                                        <i class="fas fa-file-excel"></i> Exportar
                                    </a>
                                </div>
                            </div>
                            <div class="row" id="detalle-tabla">
                                <div class="col-md-12 text-center" v-if="total_reporte == 0">
                                    <p class="text-primary">Seleccione los Datos y haz clic en Buscar</p>
                                    <p class="text-danger"><span class="text-secondary">En esta &aacute;rea se mostrar&aacute;</span> El Listado de Reporte Caja General</p>
                                </div>
                                <div class="col-md-12" v-else>
                                    @include('Reportes.cajageneraltabla')
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
<script src="js/reportes/reporte-caja-general.js"></script>
@endsection
