<!-- sample modal content -->
<div id="empresa-create" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="empresa-createLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="empresa-create-title">Nueva Empresa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="empresa-create-body">
                <div class="form-group row">
                    <div class="col-12">
                        <input type="text" class="form-control" v-model="empresa.razon_social"
                            placeholder="Razón Social" >
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <input type="text" class="form-control" v-model="empresa.nombre_comercial"
                            placeholder="Nombre Comercial" >

                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <input type="text" class="form-control" v-model="empresa.ruc"
                            placeholder="Ingrese R.U.C" >
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <input type="text" class="form-control" v-model="empresa.direccion"
                            placeholder="Dirección" >
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="empresa-create-footer">
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
