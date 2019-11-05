<!-- sample modal content -->
<div id="role-create" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="role-createLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="role-create-title">Nuevo Rol</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="role-create-body">
                <div class="form-group row">
                    <div class="col-12">
                        <input type="text" class="form-control" v-model="role.name"
                            placeholder="Nombre Rol" >
                        <small class="text-danger" v-for="error in errores.name">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <input type="text" class="form-control" v-model="role.guard_name"
                            placeholder="Guarda Name / Enlace" >
                        <small class="text-danger" v-for="error in errores.guard_name">@{{ error }}</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="role-create-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cerrar
                </button>
                <button type="button" class="btn btn-success waves-effect waves-light"
                        @click="">
                    <i class="fa fa-save"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>
