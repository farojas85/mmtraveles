<!-- sample modal content -->
<div id="permission-show" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="modelo-showLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelo-show-title">Mostrar Permiso</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="modelo-show-body">
                <div class="form-group row">
                    <label class="col-form-label col-md-2 text-right">Nombre: </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" v-model="permission.name"
                            placeholder="Nombre de Permiso" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-md-2 text-right">Entorno: </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" v-model="permission.guard_name"
                            placeholder="Slug / Ruta" disabled>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="modelo-show-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
