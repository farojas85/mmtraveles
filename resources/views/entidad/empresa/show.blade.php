<!-- sample modal content -->
<div id="empresa-show" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="empresa-showLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="empresa-show-title">Mostrar Empresa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="empresa-show-body">
                <div class="form-group row">
                    <div class="col-12">
                        <input type="text" class="form-control" name="razon_social" v-model="empresa.razon_social"
                            placeholder="Razón Social" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <input type="text" class="form-control" v-model="empresa.nombre_comercial"
                            placeholder="Nombre Comercial" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <input type="text" class="form-control" v-model="empresa.ruc"
                            placeholder="Ingrese R.U.C"  disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <input type="text" class="form-control" v-model="empresa.direccion"
                            placeholder="Dirección"  disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <div class="checkbox checkbox-success mb-2">
                            <input id="empresa-estado-show" type="checkbox" v-model="empresa.estado" disabled>
                            <label for="empresa-estado-show" v-if="empresa.estado == 1">Activo</label>
                            <label for="empresa-estado-show" v-else>Inactivo</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="empresa-show-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
