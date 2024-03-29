<!-- sample modal content -->
<div id="user-show" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="user-showLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="user-show-title">Mostrar Usuario</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="user-show-body">
                <div class="form-group row">
                    <div class="col-12">
                        <input type="text" class="form-control" name="name" v-model="user.name"
                            placeholder="Nombre(s)..." >
                        <small class="text-danger" v-for="error in errores.name">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <input type="text" class="form-control" name="lastname" v-model="user.lastname"
                            placeholder="Apellidos..." >
                        <small class="text-danger" v-for="error in errores.lastname">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <input type="email" class="form-control" name="email" v-model="user.email"
                            placeholder="Correo Electrónico" >
                        <small class="text-danger" v-for="error in errores.email">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <input type="text" class="form-control" name="username" v-model="user.username"
                            placeholder="Nombre de Usuario" >
                        <small class="text-danger" v-for="error in errores.username">@{{ error }}</small>
                    </div>
                </div>
                <!--<div class="form-group row">
                    <div class="col-12">
                        <input type="password" class="form-control" name="password" v-model="user.password"
                            placeholder="Contraseña de Usuario" >
                        <small class="text-danger" v-for="error in errores.password">@{{ error }}</small>
                    </div>
                </div>-->
                <div class="form-group row">
                    <div class="col-12">
                        <select class="form-control" v-model="user.local_id">
                            <option value="">-LOCAL-</option>
                            <option v-for="local in locales" :key="local.id"
                                    :value="local.id">@{{local.nombre}}</option>
                        </select>
                        <small class="text-danger" v-for="error in errores.local_id">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <select class="form-control" v-model="user.role_id">
                            <option value="">-ROL-</option>
                            <option v-for="role in roles" :key="role.id"
                                    :value="role.id">@{{role.name}}</option>
                        </select>
                        <small class="text-danger" v-for="error in errores.role_id">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <div class="checkbox checkbox-success mb-2">
                            <input id="user-estado-show" type="checkbox" v-model="user.is_active" disabled>
                            <label for="user-estado-show" v-if="user.is_active == 1">Activo</label>
                            <label for="user-estado-show" v-else>Inactivo</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="user-show-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
