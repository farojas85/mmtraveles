<!-- sample modal content -->
<div id="local-show" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="local-showLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="local-show-title">Mostar Local</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="local-show-body">
                <div class="form-group row">
                    <div class="col-12">
                        <input type="text" class="form-control" name="nombre" v-model="local.nombre"
                            placeholder="Dirección"  disabled>
                        <small class="text-danger" v-for="error in errores.nombre">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <select class="form-control" v-model="local.empresa_id" disabled>
                            <option value="">-EMPRESA-</option>
                            <option v-for="empresa in empresas" :key="empresa.id"
                                    :value="empresa.id">@{{empresa.razon_social}}</option>
                        </select>
                        <small class="text-danger" v-for="error in errores.empresa_id">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <select class="form-control" v-model="local.lugar_id" disabled>
                            <option value="">-LUGAR-</option>
                            <option v-for="lugar in lugares" :key="lugar.id"
                                    :value="lugar.id">@{{lugar.name}}</option>
                        </select>
                        <small class="text-danger" v-for="error in errores.lugar_id">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <div class="checkbox checkbox-success mb-2">
                            <input id="local-estado-show" type="checkbox" v-model="local.estado" disabled>
                            <label for="local-estado-show" v-if="local.estado == 1">Activo</label>
                            <label for="local-estado-show" v-else>Inactivo</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="local-show-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
