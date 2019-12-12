@extends('layouts.master')

@section('contenido')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><i class="fas fa-cart-plus mr-1"></i> PASAJES</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Pasajes</li>
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
                            <h3 class="card-title" >
                               <font style="font-size:20pt;font-weight:900">LISTADO DE PASAJES</font>
                               <a class="btn btn-info no-print"
                                    href="pasajeCreate">
                                    Registrar Pasaje
                                </a>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="input-group input-group-sm" title="Local">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Lugar:</span>
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
                                            <span class="input-group-text">Local:</span>
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
                            <div class="row mt-2 ">
                                <div class="col-md-4">
                                    <div class="input-group input-group-sm" title="Fecha Inicio">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Fecha Inicio:</span>
                                        </div>
                                        <input type="date" name="fecha_ini" class="form-control" v-model="busqueda.fecha_ini">
                                    </div>
                                    <small class="text-danger" v-for="error in errores.fecha_ini">@{{ error }}</small>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-sm" title="Fecha Inicio">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text ">Fecha Final:</span>
                                        </div>
                                        <input type="date" name="fecha_fin" class="form-control" v-model="busqueda.fecha_fin">
                                    </div>
                                    <small class="text-danger" v-for="error in errores.fecha_fin">@{{ error }}</small>
                                </div>
                                    <div class="col-md-4">
                                    <button type="button" class="btn btn-primary btn-sm" @click="listaPasaje">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nº</th>
                                                    <th >Counter</th>
                                                    <th>Codigo</th>
                                                    <th>Pasajero</th>
                                                    <th>Aerolinea</th>
                                                    <th>Monto</th>
                                                    <th>Pago S/</th>
                                                    <th>Pago $</th>
                                                    <th>Visa</th>
                                                    <th>Dep. S/</th>
                                                    <th>Dep. $</th>
                                                    <th>Fecha</th>
                                                    <th>Impr.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-if="total_pasajes == 0">
                                                    <td colspan="13" class="text-center text-danger">-- DATOS NO REGISTRADOS --</td>
                                                </tr>
                                                <tr v-else v-for="(repo,index) in pasajes" :key="repo.id">

                                                    <td>@{{index+1}}</td>
                                                    <td>
                                                        @{{repo.counter}}
                                                    </td>
                                                    <td>@{{repo.viajecode}}</td>
                                                    <td>@{{repo.pasajero}}</td>
                                                    <td>@{{repo.aero }}</td>
                                                    <td>@{{repo.total}}</td>
                                                    <td>@{{repo.pago_soles}}</td>
                                                    <td>@{{repo.pago_dolares}}</td>
                                                    <td>@{{repo.pago_visa}}</td>
                                                    <td>@{{repo.deposito_soles}}</td>
                                                    <td>@{{repo.deposito_dolares}}</td>
                                                    <td>@{{repo.created_at_venta}}</td>
                                                    <td>
                                                        <a :href=" 'imprimirPasaje/'+repo.id" class="btn btn-success btn-xs"  title="Mostrar Empresa"
                                                            target="_blank">
                                                            <i class="fas fa-print"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="5" class="text-right">Total Pasaje</th>
                                                    <th>@{{suma_reporte.toFixed(2) }}</th>
                                                    <th colspan="7"></th>
                                                </tr>
                                            </tfoot>
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
    <script src="js/sistema/ver-pasajes.js"></script>
@endsection
