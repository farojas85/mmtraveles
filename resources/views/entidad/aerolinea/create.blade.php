<!-- sample modal content -->
<div id="aero-create" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="aero-createLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="aero-create-title">Nueva Empresa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="aero-create-body">
                <div class="form-group row">
                    <div class="col-12">
                        <input type="text" class="form-control" name="razon_social" v-model="empresa.razon_social"
                            placeholder="Razón Social" >
                        <small class="text-danger" v-for="error in errores.razon_social">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <input type="text" class="form-control" v-model="empresa.nombre_comercial"
                            placeholder="Nombre Comercial" >
                            <small class="text-danger" v-for="error in errores.nombre_comercial">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <input type="text" class="form-control" v-model="empresa.ruc"
                            placeholder="Ingrese R.U.C" >
                            <small class="text-danger" v-for="error in errores.ruc">@{{ error }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <input type="text" class="form-control" v-model="empresa.direccion"
                            placeholder="Dirección" >
                        <small class="text-danger" v-for="error in errores.direccion">@{{ error }}</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="aero-create-footer">
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
