@extends('layouts.master')

@section('contenido')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><i class="fas fa-plane mr-1"></i> AEROL&Iacute;NEAS</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Empresa</li>
                        <li class="breadcrumb-item active">Aerol&iacute;nea</li>
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
                                Listado de Aerol&iacute;neas
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary btn-sm btn-rounded" @click="">
                                        <i class="fas fa-plus"></i> Nueva Aerol&iacute;nea
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm btn-rounded" @click="">
                                        <i class="far fa-trash-alt"></i> Mostrar Eliminados
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
                                        <table class="table table-sm table-striped table-bordered table-hover nowrap">
                                            <thead >
                                                <tr>
                                                    <th class="text-center" width="15%">Codigo</th>
                                                    <th >Nombre</th>
                                                    <th class="text-center">Costamar</th>
                                                    <th class="text-center">KIU</th>
                                                    <th class="text-center">Sabre</th>
                                                    <th >Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-if="total_aerolineas == 0">
                                                    <td class="text-center" colspan="4">-- Datos No Registrados - Tabla Vac&iacute;a --</td>
                                                </tr>
                                                <tr v-else v-for="aerolinea in aerolineas.data" :key="aerolinea.id">
                                                    <td>@{{ aerolinea.barcode}}</td>
                                                    <td>@{{ aerolinea.name }}</td>
                                                    <td class="text-center">
                                                        <i class="fas fa-check text-success" v-if="aerolinea.costamar"></i>
                                                    </td>
                                                    <td class="text-center">
                                                        <i class="fas fa-check text-success" v-if="aerolinea.kiu"></i>
                                                    </td>
                                                    <td class="text-center">
                                                        <i class="fas fa-check text-success" v-if="aerolinea.sabre"></i>
                                                    </td>
                                                    <td>
                                                        <span v-show="!showdeletes">
                                                        <button type="button" class="btn btn-info btn-xs"
                                                            title="Mostrar Área" @click="">
                                                            <i class="fas fa-eye"></i>
                                                        </button>

                                                        <button type="button" class="btn btn-warning btn-xs"
                                                            title="Editar Área" @click="" >
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-xs"
                                                            title="Eliminar Área" @click="">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        </span>
                                                        <span v-show="showdeletes">
                                                        <button type="button" class="btn btn-danger btn-xs"
                                                            title="Restaurar Área Eliminado" @click="">
                                                            <i class="fas fa-trash-restore-alt"></i>
                                                        </button>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Pagination -->
                                    <nav>
                                        <ul class="pagination">
                                            <li v-if="aerolineas.current_page > 1" class="page-item">
                                                <a href="#" aria-label="Previous" class="page-link"
                                                    @click.prevent="changePage(aerolineas.current_page - 1)">

                                                    <span><i class="fas fa-backward"></i></span>
                                                </a>
                                            </li>
                                            <li v-for="page in pagesNumber" class="page-item"
                                                v-bind:class="[ page == isActived ? 'active' : '']">
                                                <a href="#" class="page-link"
                                                    @click.prevent="changePage(page)">@{{ page }}</a>
                                            </li>
                                            <li v-if="aerolineas.current_page < aerolineas.last_page" class="page-item">
                                                <a href="#" aria-label="Next" class="page-link"
                                                    @click.prevent="changePage(aerolineas.current_page + 1)">
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
    </section>
@endsection

@section('scripties')
    <script src="js/entidad/aerolinea.js"></script>
@endsection
