@extends('layouts.master')

@section('contenido')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">PASAJES EMITIDOS</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Reporte Pasajes</li>
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
                               <font style="font-weight:900">Reporte Pasajes</font>
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group" title="Fecha Inicio">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Fecha Inicio:</span>
                                        </div>
                                        <input type="date" name="fecha_ini" class="form-control" v-model="busqueda.fecha_ini">
                                    </div>
                                    <small class="text-danger" v-for="error in errores.fecha_ini">@{{ error }}</small>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group" title="Fecha Inicio">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text ">Fecha Final:</span>
                                        </div>
                                        <input type="date" name="fecha_fin" class="form-control" v-model="busqueda.fecha_fin">
                                    </div>
                                    <small class="text-danger" v-for="error in errores.fecha_fin">@{{ error }}</small>
                                </div>
                                 <div class="col-md-4">
                                    <button type="button" class="btn btn-primary" @click="buscar">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <span v-if="pasajesEliminar.length>0">
                                        <button class="btn btn-danger btn-sm" @click="eliminarSeleccionados">
                                            <i class="fas fa-tasks"></i> Eliminar Seleccionados
                                        </button>
                                    </span>
                                    <div class="table-responsive">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover table-bordered">

                                                <thead>
                                                    <tr>
                                                        <th><input type="checkbox" v-model="seleccionarTodo" @click="seleccionar_todo"></th>
                                                        <th>Nº</th>
                                                        <th >Counter</th>
                                                        <th>Pasajero</th>
                                                        <th>Aerolinea</th>
                                                        <th>Moneda</th>
                                                        <th>Tarifa Neta</th>
                                                        <th>Pago S/</th>
                                                        <th>Pago $</th>
                                                        <th>Visa</th>
                                                        <th>Fecha</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-if="total_reporte == -1">
                                                        <td colspan="12" class="text-center text-danger" >-- REGISTROS NO ENCONTRADOS --</td>
                                                    </tr>
                                                    <tr v-else-if="total_reporte == 0">
                                                        <td colspan="12" class="text-center text-danger" >--DATOS NO SELECCIONADOS --</td>
                                                    </tr>
                                                    <tr v-else v-for="(repo,index) in reporte" :key="repo.id">
                                                        <td><input type="checkbox" v-model="pasajesEliminar" :value="repo.id"></td>
                                                        <td>@{{index+1}}</td>
                                                        <td>@{{repo.counter}}</td>
                                                        <td>@{{repo.pasajero}}</td>
                                                        <td>@{{repo.aero}}</td>
                                                        <td>
                                                            <span v-if="repo.moneda=='PEN' ">Soles(S/)</span>
                                                            <span v-else>Dolares(U$)</span>
                                                        </td>
                                                        <td>@{{repo.tarifa}}</td>
                                                        <td>
                                                            @{{repo.pago_soles.toFixed(2)}}
                                                        </td>
                                                        <td>
                                                            @{{repo.pago_dolares.toFixed(2)}}
                                                        </td>
                                                        <!--<td>
                                                            <span v-if="repo.moneda=='OD'">@{{(repo.total*repo.cambio).toFixed(2)}}</span>
                                                            <span v-else>@{{repo.total}}</span>
                                                        </td>
                                                        <td>
                                                             <span v-if="repo.moneda=='PEN'">@{{(repo.total/repo.cambio).toFixed(2)}}</span>
                                                            <span v-else>@{{repo.total}}</span>
                                                        </td>-->
                                                        <td>@{{repo.pago_visa}}</td>
                                                        <td>@{{repo.created_at}}</td>
                                                        <td>
                                                            <a :href=" 'imprimirPasaje/'+repo.id" class="btn btn-success btn-xs"  title="Mostrar Empresa"
                                                                target="_blank">
                                                                <i class="fas fa-print"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-danger btn-xs"
                                                                title="Eliminar Empresa" @click="eliminar(repo.id)">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- Pagination -->
                                    <!--<nav>
                                        <ul class="pagination">
                                            <li v-if="reporte.current_page > 1" class="page-item">
                                                <a href="#" aria-label="Previous" class="page-link"
                                                    @click.prevent="changePage(reporte.current_page - 1)">

                                                    <span><i class="fas fa-backward"></i></span>
                                                </a>
                                            </li>
                                            <li v-for="page in pagesNumber" class="page-item"
                                                v-bind:class="[ page == isActived ? 'active' : '']">
                                                <a href="#" class="page-link"
                                                    @click.prevent="changePage(page)">@{{ page }}</a>
                                            </li>
                                            <li v-if="reporte.current_page < reporte.last_page" class="page-item">
                                                <a href="#" aria-label="Next" class="page-link"
                                                    @click.prevent="changePage(reporte.current_page + 1)">
                                                    <span aria-hidden="true"><i class="fas fa-forward"></i></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>-->
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
    <script src="js/sistema/pasaje-emitidos.js" ></script>
@endsection
