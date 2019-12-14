<div class="row">
    <div class="col-md-6">
        @can('roles.create')
        <button type="button" class="btn btn-primary btn-sm btn-rounded" @click="nuevoPermiso">
            <i class="fas fa-plus"></i> Nuevo Permiso
        </button>
        @endcan
    </div>
    <div class="col-md-6 text-right">
        <div class="input-group input-group-sm">
            <input type="text" class="form-control"  placeholder="Buscar..." @change="buscarPermiso">
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
                        <th class="">Nombre</th>
                        <th class="">Nombre Enlace</th>
                        <th class="">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="total_permissions == 0">
                        <td class="text-center" colspan="4">-- Datos No Registrados - Tabla Vac&iacute;a --</td>
                    </tr>
                    <tr v-else v-for="(permiso,index) in permissions.data" :key="permiso.id">
                            <td class="text-center">@{{ parseInt(desde_permission) + parseInt(index)}}</td>
                            <td>@{{ permiso.name }}</td>
                            <td>@{{ permiso.guard_name }}</td>
                            <td>
                                <button type="button" class="btn btn-info btn-xs"
                                    title="Mostrar Permiso" @click="mostrarPermiso(permiso.id)">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-warning btn-xs"
                                    title="Editar Permiso" @click="editarPermiso(permiso.id)" >
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-xs"
                                    title="Eliminar Permiso" @click="eliminarPermiso(permiso.id)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <nav>
            <ul class="pagination">
                <li v-if="permissions.current_page > 1" class="page-item">
                    <a href="#" aria-label="Previous" class="page-link">
                        <span><i class="fas fa-fast-backward"></i></span>
                    </a>
                </li>
                <li v-for="page in pagesNumberPermission" class="page-item"
                    v-bind:class="[ page == isActivedPermission ? 'active' : '']">
                    <a href="#" class="page-link"
                        @click.prevent="changePagePermission(page)">@{{ page }}</a>
                </li>
                <li v-if="permissions.current_page < permissions.last_page" class="page-item">
                    <a href="#" aria-label="Next" class="page-link"
                        @click.prevent="changePagePermission(permissions.current_page + 1)">
                        <span aria-hidden="true"><i class="fas fa-fast-forward"></i></span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
@include('configuraciones.permission.create')
@include('configuraciones.permission.show')
@include('configuraciones.permission.edit')
