<div class="modal fade show" id="adicional-edit" aria-modal="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title">Editar Adicional</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="adicional-edit-body">
                <span v-if="adicional">
                    <input type="hidden" v-model="adicional.id" >
                    <div class="form-group row">
                        <label class="col-form-label col-form-label-sm col-md-1">Counter: </label>
                        <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm"
                                    v-model="adicional.counter" disabled>
                        </div>
                        <label class="col-form-label col-form-label-sm col-md-1">Pasajero: </label>
                        <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm" v-model="adicional.pasajero">
                        </div>
                        <label class="col-form-label col-form-label-sm col-md-1">Fecha: </label>
                        <div class="col-md-3">
                            <input type="date" class="form-control form-control-sm" v-model="adicional.fecha">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label col-form-label-sm" >Adicional</label>
                        <div class="col-md-4">
                            <select class="form-control" v-model="adicional_add.adicional_id" id="adicional_id"
                                @change="filtroPorId">
                                <option value="">-Adicionales.-</option>
                                <option v-for="adic in adicional_filtro" :key="adic.id" :value="adic.id">
                                    @{{adic.descripcion}}
                                </option>
                            </select>
                            <small class="text-danger" v-for="error in errores.adicional_id">@{{ error }}</small>
                            <input type="text" class="form-control form-control-sm"
                                    v-model="adicional_add.detalle" id="detalle" title="Detalle Otros"
                                    placeholder="Detalle Descripción">
                            <small class="text-danger" v-for="error in errores.detalle">@{{ error }}</small>
                        </div>
                        <div class="col-md-2"><input type="text" class="form-control form-control-sm" placeholder="Monto" v-model="adicional_add.monto" id="montod" title="Monto Del Detalle"></div>
                        <div class="col-md-2"><input type="text" class="form-control form-control-sm" placeholder="Service FEE" v-model="adicional_add.service_fee" id="fee" title="Ingrese Service Fee"></div>
                        <div class="col-md-2"><button type="button" class="btn btn-primary btn-sm" @click="agregarAdicionalTabla">A&ntildeadir</button></div>
                    </div>
                    <div class="form-group row">
                        <table class="table table-sm table-bordered">
                            <thead class="bg-navy">
                                <tr>
                                    <th>#</th>
                                    <th>Adicional</th>
                                    <th>Monto</th>
                                    <th>Service Fee</th>
                                    <th>Importe</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(detalle,index) in adicional.adicional_detalle" :key="detalle.id">
                                    <td>@{{index+1}}</td>
                                    <td>@{{detalle.detalle}}</td>
                                    <td>@{{ parseFloat(detalle.monto).toFixed(2)}}</td>
                                    <td>@{{ parseFloat(detalle.service_fee).toFixed(2)}}</td>
                                    <td>@{{ parseFloat(detalle.importe).toFixed(2)}}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            @click="eliminarAdicionalTabla(index)"><i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right"> TOTAL US$</th>
                                    <th>@{{ parseInt(adicional.total).toFixed(2)}}</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-form-label-sm col-md-1">Pago S/: </label>
                        <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm"
                                    v-model="adicional.pago_soles" placeholder="Soles (S/)">
                        </div>
                        <label class="col-form-label col-form-label-sm col-md-1">Pago $: </label>
                        <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm"
                                    v-model="adicional.pago_dolares" placeholder="Dolares ($)">
                        </div>
                        <label class="col-form-label col-form-label-sm col-md-1">Visa $: </label>
                        <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm"
                                    v-model="adicional.pago_visa" placeholder="Visa ">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-form-label-sm col-md-3">Dep&oacute;sito Soles: </label>
                        <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm"
                                    v-model="adicional.deposito_soles" placeholder="Soles (S/)">
                        </div>
                        <label class="col-form-label col-form-label-sm col-md-3">Dep&oacute;sito Dolares: </label>
                        <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm"
                                    v-model="adicional.deposito_dolares" placeholder="Dolares ($)">
                        </div>
                    </div>
                </span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success"  @click="actualizarAdicional">
                   <i class="fas fa-save"></i> Actualizar
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>
