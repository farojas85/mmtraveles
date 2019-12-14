<!-- sample modal content -->
<div id="permission-edit" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="permission-editLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="permission-edit-title">Editar Permiso</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="permission-edit-body">
                <div class="form-group row">
                    <label class="col-form-label col-md-3">Nombre</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" v-model="permission.name"
                            placeholder="Nombre de Permiso" >
                        <small class="text-danger" v-for="error in errores.name">@{{ error }}</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="permission-edit-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cerrar
                </button>
                <button type="button" class="btn btn-success waves-effect waves-light" @click="actualizarPermiso">
                    <i class="fa fa-save"></i> Actualizar
                </button>
            </div>
        </div>
    </div>
</div>
