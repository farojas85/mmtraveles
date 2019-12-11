<form  class="form-horizontal" role="form">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Datos Cliente</h3>
                </div>

                <div class="card-body">
                    <div class="form-group row">
                        <label for="inputEmail1" class="col-md-3 col-form-label">PASAJERO</label>
                        <div class="col-md-9">
                            <input type="text" name="pasajero" class="form-control" id="pasajero"
                                    v-model="pasaje.pasajero" placeholder="Nombre pasajero: (RAMIREZ/HECTOR) ">
                            <small class="text-danger" v-for="error in errores.pasajero">@{{ error }}</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tipo_documento_id" class="col-md-3 col-form-label">FOID/DNI</label>
                        <div class="col-md-4">
                            <select class="form-control" v-model="pasaje.tipo_documento_id" name="tipo_documento_id">
                                <option value="">-Tipo Doc.-</option>
                                <option v-for="tipo in tipoDocumentos" :key="tipo.id" :value="tipo.id">
                                    @{{tipo.nombre_corto}}
                                </option>
                            </select>
                            <small class="text-danger" v-for="error in errores.tipo_documento_id">@{{ error }}</small>
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="numero_documento" class="form-control" id="numero_documento"
                                    v-model="pasaje.numero_documento" placeholder="Número Documento ">
                            <small class="text-danger" v-for="error in errores.numero_documento">@{{ error }}</small>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>
