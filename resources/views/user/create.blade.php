<!-- sample modal content -->
<div id="user-create" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="user-createLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="user-create-title">Nuevo Usuario</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="user-create-body">
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
                <div class="form-group row">
                    <div class="col-12">
                        <input type="password" class="form-control" name="password" v-model="user.password"
                            placeholder="Contraseña de Usuario" >
                        <small class="text-danger" v-for="error in errores.password">@{{ error }}</small>
                    </div>
                </div>
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
            </div>
            <div class="modal-footer" id="user-create-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cerrar
                </button>
                <button type="submit" class="btn btn-success waves-effect waves-light"
                        @click="guardar">
                    <i class="fa fa-save"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>
