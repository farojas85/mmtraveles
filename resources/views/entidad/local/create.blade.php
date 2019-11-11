<!-- sample modal content -->
<div id="local-create" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="local-createLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="local-create-title">Nueva Local</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="local-create-body">
                <div class="form-group row">
                    <div class="col-12">
                        <input type="text" class="form-control" name="nombre" v-model="local.nombre"
                            placeholder="Dirección" >
                        <small class="text-danger" v-for="error in errores.nombre">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <select class="form-control" v-model="local.empresa_id">
                            <option value="">-EMPRESA-</option>
                            <option v-for="empresa in empresas" :key="empresa.id"
                                    :value="empresa.id">@{{empresa.razon_social}}</option>
                        </select>
                        <small class="text-danger" v-for="error in errores.empresa_id">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <select class="form-control" v-model="local.lugar_id">
                            <option value="">-LUGAR-</option>
                            <option v-for="lugar in lugares" :key="lugar.id"
                                    :value="lugar.id">@{{lugar.name}}</option>
                        </select>
                        <small class="text-danger" v-for="error in errores.lugar_id">@{{ error }}</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="local-create-footer">
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
