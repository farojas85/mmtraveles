@extends('layouts.master')

@section('contenido')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0 text-dark"><i class="fas fa-file-excel mr-1"></i> REPORTE PLANTILLAS</h3>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Reporte Plantillas</li>
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
                                <font style="font-weight:900">Reporte Plantillas</font>
                            - <small>Exportar en Formato Excel</small>
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <select name="aerolinea_id" class="form-control" v-model="busqueda.aerolinea_id">
                                        <option value="">-AEROL&Iacute;NEA-</option>
                                        <option v-for="aero in aerolineas" :key="aero.id" :value="aero.id">
                                            @{{aero.name}}
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
                                    <button type="button" class="btn btn-success" @click="buscar">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
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
<script src="js/reportes/reporte-plantillas.js"></script>
@endsection
