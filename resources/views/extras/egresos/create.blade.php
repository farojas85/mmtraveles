<!-- sample modal content -->
<div id="egresos-create" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="egresos-createLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title" id="egresos-create-title">Nuevo Egreso</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="egresos-create-body">
                <div class="form-group row">
                    <label  class="col-form-label col-md-3 text-right">Tipo</label>
                    <div class="col-md-9">
                        <select class="form-control" v-model="extra.tipo">
                            <option value="">-Seleccione-</option>
                            <option value="A">LOCALES</option>
                            <option value="B">OTROS</option>
                        </select>
                        <small class="text-danger" v-for="error in errores.local_id">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row" v-if="extra.tipo=='A'">
                    <label for="local_id" class="col-form-label col-md-3 text-right">Local</label>
                    <div class="col-md-9">
                        <select class="form-control" v-model="extra.local_id" id="local_id" @change="listarRubros">
                            <option value="">-Seleccione-</option>
                            <option v-for="local in locales" :key="local.id"
                                    :value="local.id">@{{local.nombre}}</option>
                        </select>
                        <small class="text-danger" v-for="error in errores.local_id">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row" v-if="extra.tipo=='A'">
                    <label class="col-form-label col-md-3 text-right">Rubro</label>
                    <div class="col-md-9">
                        <select class="form-control" v-model="extra.rubro">
                            <option value="">-Seleccione-</option>
                            <option v-for="rubro in rubros" :key="rubro.rubro"
                                    :value="rubro.rubro">@{{rubro.rubro}}</option>
                        </select>
                        <small class="text-danger" v-for="error in errores.rubro">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="rubro" class="col-form-label col-md-3 text-right">Concepto</label>
                    <div class="col-md-9">
                        <textarea class="form-control" v-model="extra.concepto"  rows="2" placeholder="Ingrese Concepto"></textarea>
                        <small class="text-danger" v-for="error in errores.rubro">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="fecha" class="col-form-label col-md-3 text-right">Fecha</label>
                    <div class="col-md-5">
                        <input type="date" v-model="extra.fecha"  class="form-control">
                        <small class="text-danger" v-for="error in errores.fecha">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="gasto_soles" class="col-form-label col-md-3 text-right">Monto Soles</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" v-model="extra.gasto_soles"
                            placeholder="Monto Soles" >
                        <small class="text-danger" v-for="error in errores.gasto_soles">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="gasto_dolares" class="col-form-label col-md-3 text-right">Monto Dolares</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control"  v-model="extra.gasto_dolares"
                            placeholder="Monto Dolares" >
                        <small class="text-danger" v-for="error in errores.gasto_dolares">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="gasto_visa" class="col-form-label col-md-3 text-right">Monto Visa</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control"  v-model="extra.gasto_visa"
                            placeholder="Monto Visa" >
                        <small class="text-danger" v-for="error in errores.gasto_visa">@{{ error }}</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="egresos-create-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cerrar
                </button>
                <button type="submit" class="btn btn-success waves-effect waves-light"
                        @click="">
                    <i class="fa fa-save"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>
