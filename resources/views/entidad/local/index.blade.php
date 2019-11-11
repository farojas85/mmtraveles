@extends('layouts.master')

@section('contenido')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><i class="fas fa-map-marked-alt mr-1"></i> LOCALES</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Entidad</li>
                        <li class="breadcrumb-item active">Locales</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Listado de Locales</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary btn-sm btn-rounded" @click="nuevo">
                                        <i class="fas fa-plus"></i> Nuevo Local
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm btn-rounded" @click="mostrarEliminados" v-if="showdeletes == false">
                                        <i class="far fa-trash-alt"></i> Mostrar Eliminados
                                    </button>
                                    <button type="button" class="btn btn-info btn-sm btn-rounded" @click="mostrarTodos" v-else>
                                        <i class="fas fa-eye"></i> Mostrar Activos
                                    </button>
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
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th class="text-center" width="5%">#</th>
                                                    <th class="">nombre</th>
                                                    <th class="">Empresa</th>
                                                    <th class="">Lugar</th>
                                                    <th class="">Estado</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-if="total_locales==0">
                                                    <td colspan="6" class="text-center text-danger">
                                                        --Datos No Registrados - tabla Vac&iacute;a--
                                                    </td>
                                                </tr>
                                                <tr v-else v-for="local in locales.data" :key="local.id">
                                                    <td>@{{local.id }}</td>
                                                    <td>@{{ local.nombre }}</td>
                                                    <td>@{{ local.empresa.razon_social }}</td>
                                                    <td>@{{ local.lugar.name }}</td>
                                                    <td class="text-center">
                                                        <span v-if="local.estado == 1" class="badge badge-success">Activo</span>
                                                        <span v-else class="badge badge-danger">Inactivo</span>
                                                    </td>
                                                    <td>
                                                        <span v-if="showdeletes==false">
                                                        <button type="button" class="btn btn-info btn-xs"
                                                            title="Mostrar Empresa" @click="mostrar(local.id)">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-warning btn-xs"
                                                            title="Editar Local" @click="editar(local.id)" >
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-xs"
                                                            title="Eliminar Local" @click="eliminar(local.id)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        </span>
                                                        <span v-else>
                                                            <button type="button" class="btn btn-danger btn-xs"
                                                                title="Restaurar Local" @click="restaurar(local.id)">
                                                                <i class="fas fa-trash-restore"></i>
                                                            </button>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <nav>
                                        <ul class="pagination">
                                            <li v-if="locales.current_page > 1" class="page-item">
                                                <a href="#" aria-label="Previous" class="page-link"
                                                    @click.prevent="changePage(locales.current_page - 1)">

                                                    <span><i class="fas fa-backward"></i></span>
                                                </a>
                                            </li>
                                            <li v-for="page in pagesNumber" class="page-item"
                                                v-bind:class="[ page == isActived ? 'active' : '']">
                                                <a href="#" class="page-link"
                                                    @click.prevent="changePage(page)">@{{ page }}</a>
                                            </li>
                                            <li v-if="locales.current_page < locales.last_page" class="page-item">
                                                <a href="#" aria-label="Next" class="page-link"
                                                    @click.prevent="changePage(locales.current_page + 1)">
                                                    <span aria-hidden="true"><i class="fas fa-forward"></i></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('entidad.local.create')
        @include('entidad.local.show')
        @include('entidad.local.edit')
    </section>
@endsection

@section('scripties')
    <script src="js/entidad/local.js"></script>
@endsection
