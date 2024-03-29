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
                                    <button type="button" class="btn btn-primary" @click="listarActivos">
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
                                    <div class="btn-group" v-if="show_pasaje!=''">
                                        <button type="button" class="btn btn-info bt-sm btn-rounded">Mostrar</button>
                                        <button type="button" class="btn btn-info bt-sm btn-rounded dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                            <span class="sr-only">Toggle Dropdown</span>
                                            <div class="dropdown-menu" role="menu">
                                                <a class="dropdown-item" href="#" @click="listarTodos">Todos</a>
                                                <a class="dropdown-item" href="#" @click="listarActivos">Activos</a>
                                                <a class="dropdown-item" href="#" @click="listarEliminados">Eliminados Temporalmente</a>
                                            </div>
                                        </button>
                                    </div>
                                    <div class="table-responsive">

                                        <table class="table table-sm table-hover table-bordered">

                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" v-model="seleccionarTodo" @click="seleccionar_todo"></th>
                                                    <th>Nº</th>
                                                    <th >Counter</th>
                                                    <th>Pasajero</th>
                                                    <th>Aerolinea</th>
                                                    <th>Total</th>
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
                                                <tr v-else v-for="(repo,index) in reporte" :key="repo.id" :class="{ 'table-danger' : repo.deleted_at }">
                                                    <td><input type="checkbox" v-model="pasajesEliminar" :value="repo.id"></td>
                                                    <td>@{{index+1}}</td>
                                                    <td>@{{repo.counter}}</td>
                                                    <td>@{{repo.pasajero}}</td>
                                                    <td>@{{repo.aero}}</td>
                                                    <td>@{{repo.total}}</td>
                                                    <td>
                                                        @{{repo.pago_soles.toFixed(2)}}
                                                    </td>
                                                    <td>
                                                        @{{repo.pago_dolares.toFixed(2)}}
                                                    </td>
                                                    <td>@{{repo.pago_visa}}</td>
                                                    <td>@{{repo.created_at}}</td>
                                                    <td>
                                                        <span v-if="repo.deleted_at=='' || repo.deleted_at==null">
                                                           <!-- <button type="button" class="btn btn-warning btn-xs" title="Editar Pasaje"
                                                                @click=editarPasaje(repo.id)>
                                                                <i class="fas fa-edit"></i>
                                                            </button>-->
                                                            <a :href=" 'imprimirPasaje/'+repo.id" class="btn btn-success btn-xs"
                                                                target="_blank" title="Imprimir Pasaje">
                                                                <i class="fas fa-print"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-danger btn-xs"
                                                                title="Eliminar Pasaje" @click="eliminar(repo.id)">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </span>
                                                        <span v-else>
                                                            <button type="button" class="btn btn-danger btn-xs"
                                                                title="Restaurar Pasaje" @click="restaurar(repo.id)">
                                                                <i class="fas fa-trash-restore"></i>
                                                            </button>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
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
    <div class="modal" tabindex="-1" role="dialog" id="editar-pasaje">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Pasaje</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" v-if="pasaje">
                    @include('pasaje.editar')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripties')
    <script src="js/sistema/pasaje-emitidos.js" ></script>
@endsection
