@extends('layouts.master')

@section('contenido')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><i class="far fa-user mr-1"></i> Usuarios</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Usuario</li>
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
                               Listado de Usuarios
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary btn-sm btn-rounded" @click="nuevo">
                                        <i class="fas fa-plus"></i> Nuevo Usuario
                                    </button>
                                </div>
                                <div class="col-md-6 text-right">
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control"  placeholder="Buscar..." @change="buscar">
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
                                            <thead class="thead-dark" >
                                                <tr>
                                                    <th class="text-center" width="5%">#</th>
                                                    <th>Nombres y Apellidos</th>
                                                    <th class="text-center">Usuario</th>
                                                    <th class="text-center">Correo</th>
                                                    <th class="text-center">Rol</th>
                                                    <th >Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-if="total_users==0">
                                                    <td colspan="6" class="text-center text-danger">--Datos No Registrados --</td>
                                                </tr>
                                                <tr v-else v-for="(user,index) in users.data" :key="user.id">
                                                    <td class="text-center">@{{parseInt(desde)+ parseInt(index) }}</td>
                                                    <td>@{{user.name}} @{{user.lastname}}</td>
                                                    <td>@{{user.username}}</td>
                                                    <td>@{{user.email}}</td>
                                                    <td v-for="role in user.roles" :key='role.id'>
                                                        <span v-show="role.name=='Gerente'" class="badge badge-success">@{{role.name}}</span>
                                                        <span v-show="role.name=='Administrador'" class="badge badge-primary">@{{role.name}}</span>
                                                        <span v-show="role.name=='Responsable'" class="badge badge-danger">@{{role.name}}</span>
                                                        <span v-show="role.name=='Usuario'" class="badge badge-secondary">@{{role.name}}</span>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-xs"
                                                            title="Mostrar Usuario" @click="mostrar(user.id)">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-warning btn-xs"
                                                            title="Editar Usuario" @click="editar(user.id)" >
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-xs"
                                                            title="Eliminar Usuario" @click="eliminar(user.id)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <nav>
                                        <ul class="pagination">
                                            <li v-if="users.current_page > 1" class="page-item">
                                                <a href="#" aria-label="Previous" class="page-link"
                                                    @click.prevent="changePage(users.current_page - 1)">

                                                    <span><i class="fas fa-backward"></i></span>
                                                </a>
                                            </li>
                                            <li v-for="page in pagesNumber" class="page-item"
                                                v-bind:class="[ page == isActived ? 'active' : '']">
                                                <a href="#" class="page-link"
                                                    @click.prevent="changePage(page)">@{{ page }}</a>
                                            </li>
                                            <li v-if="users.current_page < users.last_page" class="page-item">
                                                <a href="#" aria-label="Next" class="page-link"
                                                    @click.prevent="changePage(users.current_page + 1)">
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
        @include('user.create')
        @include('user.show')
        @include('user.edit')
    </section>
@endsection

@section('scripties')
    <script src="js/sistema/user.js"></script>
@endsection
