<!-- sample modal content -->
<div id="pago-create" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="pago-createLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="pago-create-title">Nuevo Pago</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="pago-create-body">
                <div class="form-group row">
                    <label for="local_id" class="col-form-label col-md-3 text-right">Local</label>
                    <div class="col-md-9">
                        <select class="form-control" v-model="pago.local_id" id="local_id">
                            <option value="">-Seleccione-</option>
                            <option v-for="local in locales" :key="local.id"
                                    :value="local.id">@{{local.nombre}}</option>
                        </select>
                        <small class="text-danger" v-for="error in errores.local_id">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="rubro" class="col-form-label col-md-3 text-right">Rubro</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" v-model="pago.rubro"
                            placeholder="Rubro" >
                        <small class="text-danger" v-for="error in errores.rubro">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="fecha" class="col-form-label col-md-3 text-right">Fecha</label>
                    <div class="col-md-3">
                        <select class="form-control" v-model="pago.fecha" id="fecha">
                            <option value="">-DIA-</option>
                            <option v-for="dia in 31" :key="dia" :value="dia">@{{dia}}</option>
                        </select>
                        <small class="text-danger" v-for="error in errores.fecha">@{{ error }}</small>
                    </div>
                    <div class="col-md-3">
                        <label class="col-form-label">DE CADA MES</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="monto_soles" class="col-form-label col-md-3 text-right">Monto Soles</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" v-model="pago.monto_soles"
                            placeholder="Monto Soles" >
                        <small class="text-danger" v-for="error in errores.monto_soles">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="monto_dolares" class="col-form-label col-md-3 text-right">Monto Dolares</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control"  v-model="pago.monto_dolares"
                            placeholder="Monto Dolares" >
                        <small class="text-danger" v-for="error in errores.monto_dolares">@{{ error }}</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="pago-create-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cerrar
                </button>
                <button type="submit" class="btn btn-success waves-effect waves-light"
                        @click="guardarPago">
                    <i class="fa fa-save"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>
