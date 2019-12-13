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
                                    <div class="input-group input-group-sm" title="Local">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Lugar:&nbsp;&nbsp;&nbsp;</span>
                                        </div>
                                        <select class="form-control" v-model="busqueda.lugar" @change="listarLocales">
                                            <option value="">-LUGAR-</option>
                                            <option value="%">TODOS</option>
                                            <option v-for="lugar in lugares" :key='lugar.id' :value="lugar.id">
                                                @{{lugar.name}}
                                            </option>
                                        </select>
                                    </div>
                                    <small class="text-danger" v-for="error in errores.lugar">@{{ error }}</small>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-sm" title="Local">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Local:&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                        </div>
                                        <select class="form-control" v-model="busqueda.local" @change="listarCounters">
                                            <option value="">-LOCAL-</option>
                                            <option value="%">TODOS</option>
                                            <option v-for="local in locales" :key='local.id' :value="local.id">
                                                @{{local.nombre}}
                                            </option>
                                        </select>
                                    </div>
                                    <small class="text-danger" v-for="error in errores.local">@{{ error }}</small>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-sm" title="Counter">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Counter:</span>
                                        </div>
                                        <select class="form-control" v-model="busqueda.counter" @change="listarAerolineas">
                                            <option value="">-COUNTER-</option>
                                            <option value="%">TODOS</option>
                                            <option v-for="counter in counters" :key='counter.id' :value="counter.id">
                                                @{{counter.name}} @{{counter.lastname}}
                                            </option>
                                        </select>
                                    </div>
                                    <small class="text-danger" v-for="error in errores.counter">@{{ error }}</small>
                                </div>
                                <div class="col-md-3 noimpre">
                                    <div class="input-group input-group-sm" title="Counter">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Aerol&iacute;nea:</span>
                                        </div>
                                        <select name="aerolinea_id" class="form-control" v-model="busqueda.aerolinea" >
                                            <option value>-AEROLÍNEA-</option>
                                            <option value="%">TODOS</option>
                                            <option v-for="aero in aerolineas" :key="aero.id" :value="aero.id">
                                                @{{ aero.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <small class="text-danger" v-for="error in errores.aerolinea">@{{ error }}</small>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-3 noimpre">
                                    <div class="input-group input-group-sm" title="Fecha Inicio">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Fec. Ini.</span>
                                        </div>
                                        <input type="date" name="fecha_inicio" class="form-control"
                                                v-model="busqueda.fecha_ini">
                                    </div>
                                    <small class="text-danger" v-for="error in errores.fecha_ini">@{{ error }}</small>
                                </div>
                                <div class="col-md-3 noimpre">
                                    <div class="input-group input-group-sm" title="Fecha Inicio">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Fec. Fin.</span>
                                        </div>
                                        <input type="date" name="fecha_final" class="form-control"
                                            v-model="busqueda.fecha_fin">
                                    </div>
                                    <small class="text-danger" v-for="error in errores.fecha_fin">@{{ error }}</small>
                                </div>
                                <div class="col-md-3 noimpre">
                                    <button type="button" class="btn btn-primary btn-sm" @click="buscar">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                    <a class="btn btn-success btn-sm"
                                        href="excelReporte" >
                                        <i class="fas fa-file-excel"></i> Exportar
                                    </a>
                                </div>
                            </div>
                            <div class="row " id="detalle-tabla">
                                <div class="col-12" v-if="total_reporte >0 || total_deudas >0 || total_adicionales >0">
                                    @include('Reportes.cajageneraltabla')
                                </div>
                                <div class="col-md-12 text-center" v-if="total_reporte ==0 || total_deudas ==0 || total_adicionales ==0">
                                    <p class="text-primary">Seleccione los Datos y haz clic en Buscar</p>
                                    <p class="text-danger"><span class="text-secondary">En esta &aacute;rea se mostrar&aacute;</span> El Listado de Reporte Caja General</p>
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
