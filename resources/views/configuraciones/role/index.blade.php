<div class="row">
    <div class="col-md-6">
        @can('roles.create')
        <button type="button" class="btn btn-primary btn-sm btn-rounded" @click="nuevoRole">
            <i class="fas fa-plus"></i> Nuevo Rol
        </button>
        @endcan
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
                <thead class="">
                    <tr>
                        <th class="text-center" width="5%">#</th>
                        <th class="">Nombre</th>
                        <th class="">Nombre Enlace</th>
                        <th class="">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="total_roles == 0">
                        <td class="text-center" colspan="4">-- Datos No Registrados - Tabla Vac&iacute;a --</td>
                    </tr>
                    <tr v-else v-for="role in roles.data" :key="role.id">
                            <td class="text-center">@{{ role.id}}</td>
                            <td>@{{ role.name }}</td>
                            <td>@{{ role.guard_name }}</td>
                            <td>
                                @can('roles.show')
                                <button type="button" class="btn btn-info btn-xs"
                                    title="Mostrar Rol" @click="">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @endcan
                                @can('roles.edit')
                                <button type="button" class="btn btn-warning btn-xs"
                                    title="Editar Rol" @click="" >
                                    <i class="fas fa-edit"></i>
                                </button>
                                @endcan
                                @can('roles.destroy')
                                <button type="button" class="btn btn-danger btn-xs"
                                    title="Eliminar Rol" @click="">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endcan
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('configuraciones.role.create')
@include('configuraciones.role.show')
@include('configuraciones.role.edit')
