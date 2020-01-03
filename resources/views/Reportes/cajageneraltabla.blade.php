<hr>
<h4 class="text-primary">Pasajes Vendidos Pagados</h4>
<div class="table-responsive ">
    <table class="table table-sm table-hover table-bordered nowrap" style="font-size:11pt">
        <thead class="bg-primary">
            <tr>
                <th>Nº</th>
                <th >Counter</th>
                <th>Codigo</th>
                <th>Pasajero</th>
                <th>Tipo Pax</th>
                <th>Aerolinea</th>
                <th>Tarifa $</th>
                <th>Tax/TUUA $</th>
                <th>Service Fee $</th>
                <th>Total $</th>
                <th>Pago S/</th>
                <th>Pago $</th>
                <th>Visa</th>
                <th>Dep. S/</th>
                <th>Dep. $</th>
                <th>Fecha</th>
                <th>Acciones</th>

            </tr>
        </thead>
        <tbody>
            <tr v-if="total_reporte == 0">
                <td colspan="15" class="text-center text-danger">-- DATOS NO REGISTRADOS --</td>
            </tr>
            <tr v-else v-for="(repo,index) in reporte" :key="repo.id">
                <td>@{{index+1}}</td>
                <td>@{{repo.counter}}</td>
                <td>@{{repo.viajecode}}</td>
                <td>@{{repo.pasajero}}</td>
                <td>@{{repo.etapa_mini }}</td>
                <td>@{{repo.aero}}</td>
                <td>@{{repo.tarifa.toFixed(2)}}</td>
                <td>@{{repo.tax}}</td>
                <td>@{{repo.service_fee}}</td>
                <td>@{{repo.total}}</td>
                <td>@{{repo.pago_soles}}</td>
                <td>@{{repo.pago_dolares}}</td>
                <td>@{{repo.pago_visa}}</td>
                <td>@{{repo.deposito_soles}}</td>
                <td>@{{repo.deposito_dolares}}</td>
                <td>@{{repo.created_at_venta}}</td>
                <td>
                    <a :href=" 'imprimirPasaje/'+repo.id" class="btn btn-success btn-xs"
                        target="_blank" title="Imprimir Pasaje">
                        <i class="fas fa-print"></i>
                    </a>
                    <button type="button" class="btn btn-warning btn-xs"
                        title="Editar Pasajes Pagados" @click="editarPasajePagado(repo.id)">
                        <i class="fas fa-edit"></i>
                    </button>
                    <span v-if="repo.deleted_at=='' || repo.deleted_at==null">
                        <button type="button" class="btn btn-danger btn-xs"
                            title="Eliminar Pasaje" @click="eliminar(repo.id)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </span>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="8" class="text-right">TOTALES</th>
                <th>US$ @{{parseFloat(repo_service_fee).toFixed(2)}}</th>
                <th>US$ @{{parseFloat(suma_reporte).toFixed(2)}}</th>
                <th>S/ @{{parseFloat(repo_soles).toFixed(2)}}</th>
                <th>$ @{{parseFloat(repo_dolares).toFixed(2)}}</th>
                <th> @{{parseFloat(repo_visa).toFixed(2)}}</th>
                <th>S/ @{{parseFloat(repo_depo_soles).toFixed(2)}}</th>
                <th>$ @{{parseFloat(repo_depo_dolares).toFixed(2)}}</th>
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>
</div>
<!--<div class="row">
    <div class="col-md-3">
        Cantidad Pagados: <b>@{{ parseInt(total_reporte)}}</b>
    </div>
    <div class="col-md-3">
        Pago Soles: <b>S/ @{{ parseFloat(repo_soles).toFixed(2)}}</b>
    </div>
    <div class="col-md-3">
        Pago Dolares: <b>$ @{{ parseFloat(repo_dolares).toFixed(2)}}</b>
    </div>
    <div class="col-md-3">
        Pago Visa: <b>@{{ parseFloat(repo_visa).toFixed(2)}}</b>
    </div>
    <div class="col-md-3">
        Dep&oacute;sito Soles: <b>S/ @{{ parseFloat(repo_depo_soles).toFixed(2)}}</b>
    </div>
    <div class="col-md-3">
        Dep&oacute;sito Dolares: <b>$ @{{ parseFloat(repo_depo_dolares).toFixed(2)}}</b>
    </div>
</div>-->
<hr>
<h4 class="text-danger">Deudas</h4>
<div class="table-responsive">
    <table class="table table-sm table-hover table-bordered nowrap" style="font-size:11pt">
        <thead class="bg-danger">
            <tr>
                <th>Nº</th>
                <th>Counter</th>
                <th>Pasajero</th>
                <th>Tipo Pax</th>
                <th>Codigo</th>
                <th>Deuda Detalle</th>
                <th>Deuda Monto $</th>
                <th>Pago S/</th>
                <th>Pago US$</th>
                <th>Deuda Visa</th>
                <th>Depo S/</th>
                <th>Depo US$</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="total_deudas == 0">
                <td colspan="15" class="text-center text-danger">-- DATOS NO REGISTRADOS --</td>
            </tr>
            <tr v-else v-for="(deuda,index) in deudas" :key="deuda.id">
                <td>@{{index+1}}</td>
                <td>@{{deuda.counter}}</td>
                <td>@{{deuda.pasajero}}</td>
                <td>@{{deuda.etapa_mini }}</td>
                <td>@{{deuda.viajecode}}</td>
                <td>@{{deuda.deuda_detalle}}</td>
                <td>@{{deuda.deuda_monto}}</td>
                <td>@{{deuda.deuda_soles}}</td>
                <td>@{{deuda.deuda_dolares}}</td>
                <td>@{{deuda.deuda_visa}}</td>
                <td>@{{deuda.deuda_depo_soles}}</td>
                <td>@{{deuda.deuda_depo_dolares}}</td>
                <td>@{{deuda.created_at_venta}}</td>
                <td>
                    <a :href=" 'imprimirPasaje/'+deuda.id" class="btn btn-success btn-xs"
                        target="_blank" title="Imprimir Pasaje">
                        <i class="fas fa-print"></i>
                    </a>
                    <button type="button" class="btn btn-warning btn-xs"
                        title="Editar Deudas" @click="editarPasajePagado(deuda.id)">
                        <i class="fas fa-edit"></i>
                    </button>
                    <span v-if="deuda.deleted_at=='' || deuda.deleted_at==null">
                        <button type="button" class="btn btn-danger btn-xs"
                            title="Eliminar Pasaje" @click="eliminar(deuda.id)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </span>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7" class="text-right">TOTAL</th>
                <th>@{{parseFloat(suma_deuda_soles).toFixed(2)}}</th>
                <th>@{{parseFloat(suma_deuda_dolares).toFixed(2)}}</th>
                <th>@{{parseFloat(suma_deuda_visa).toFixed(2)}}</th>
                <th>@{{parseFloat(suma_deuda_depo_soles).toFixed(2)}}</th>
                <th>@{{parseFloat(suma_deuda_depo_dolares).toFixed(2)}}</th>
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>
</div>
<!--<div class="row">
    <div class="col-md-3">
        Cantidad Deuda: <b>@{{ parseInt(total_deudas)}}</b>
    </div>
    <div class="col-md-3">
        Deuda Soles: <b>S/ @{{ parseFloat(suma_deuda_soles).toFixed(2)}}</b>
    </div>
    <div class="col-md-3">
        Deuda Dolares: <b>$ @{{ parseFloat(suma_deuda_dolares).toFixed(2)}}</b>
    </div>
    <div class="col-md-3">
        Deuda Visa: <b>@{{ parseFloat(suma_deuda_visa).toFixed(2)}}</b>
    </div>
    <div class="col-md-3">
        Deuda Dep&oacute;sito Soles: <b>S/ @{{ parseFloat(suma_deuda_depo_soles).toFixed(2)}}</b>
    </div>
    <div class="col-md-3">
        Deuda Dep&oacute;sito Dolares: <b>$ @{{ parseFloat(suma_deuda_depo_dolares).toFixed(2)}}</b>
    </div>
</div>-->
<hr>
<h4 class="text-success">Adicionales</h4>
<div class="table-responsive">
    <table class="table table-sm table-hover table-bordered nowrap" style="font-size:11pt">
        <thead class="bg-success">
            <tr>
                <th>Nº</th>
                <th>Counter</th>
                <th>Pasajero</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Pago S/</th>
                <th>Pago $</th>
                <th>Visa</th>
                <th>Dep. S/</th>
                <th>Dep. $</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="total_adicionales == 0">
                <td colspan="14" class="text-center text-danger">-- DATOS NO REGISTRADOS --</td>
            </tr>
            <tr v-else v-for="(adicional,index) in adicionales" :key="adicional.id">
                <td>@{{index+1}}</td>
                <td>@{{adicional.user.name}} @{{adicional.user.lastname}}</td>
                <td>@{{adicional.pasajero}}</td>
                <td>@{{adicional.fecha}}</td>
                <td>@{{adicional.total}}</td>
                <td>@{{adicional.pago_soles}}</td>
                <td>@{{adicional.pago_dolares}}</td>
                <td>@{{adicional.pago_visa}}</td>
                <td>@{{adicional.deposito_soles}}</td>
                <td>@{{adicional.deposito_dolares}}</td>
                <td>
                    <a :href=" 'imprimirAdicional/'+adicional.id" class="btn btn-success btn-xs"
                        target="_blank" title="Imprimir Adicional">
                        <i class="fas fa-print"></i>
                    </a>
                    <button type="button" class="btn btn-warning btn-xs"
                        title="Editar Adiconal" @click="editarAdicional(adicional.id)">
                        <i class="fas fa-edit"></i>
                    </button>
                    <span v-if="adicional.deleted_at=='' || adicional.deleted_at==null">
                        <button type="button" class="btn btn-danger btn-xs"
                            title="Eliminar Adiconal" @click="eliminarAdicional(adicional.id)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </span>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">TOTALES</th>
                <th>$ @{{parseFloat(suma_adicionales).toFixed(2)}}</th>
                <th>S/ @{{parseFloat(adic_soles).toFixed(2)}}</th>
                <th>$ @{{parseFloat(adic_dolares).toFixed(2)}}</th>
                <th>@{{parseFloat(adic_visa).toFixed(2)}}</th>
                <th>S/ @{{parseFloat(adic_depo_soles).toFixed(2)}}</th>
                <th>$ @{{parseFloat(adic_depo_dolares).toFixed(2)}}</th>
                <th colspan="2" class="text-right"></th>
            </tr>
        </tfoot>
    </table>
</div>
<!--<div class="row">
    <div class="col-md-3">
        Cantidad Adicionales: <b>@{{ parseInt(total_adicionales)}}</b>
    </div>
    <div class="col-md-3">
        Adicional Soles: <b>S/ @{{ parseFloat(adic_soles).toFixed(2)}}</b>
    </div>
    <div class="col-md-3">
        Adicional Dolares: <b>$ @{{ parseFloat(adic_dolares).toFixed(2)}}</b>
    </div>
    <div class="col-md-3">
        Adicional Visa: <b>@{{ parseFloat(adic_visa).toFixed(2)}}</b>
    </div>
    <div class="col-md-3">
        Adicional Dep&oacute;sito Soles: <b>S/ @{{ parseFloat(adic_depo_soles).toFixed(2)}}</b>
    </div>
    <div class="col-md-3">
        Adicional Dep&oacute;sito Dolares: <b>$ @{{ parseFloat(adic_depo_dolares).toFixed(2)}}</b>
    </div>
</div>-->
<hr>
<h5 class="text-primary">Resumen General</h5>
<div class="row">
    <div class="col-md-3">
        Cantidad Pagados: <b>@{{ parseInt(total_reporte)}}</b>
    </div>
    <div class="col-md-3">
        Cantidad Deuda: <b>@{{ parseInt(total_deudas)}}</b>
    </div>
    <div class="col-md-3">
        Cantidad Adicionales: <b>@{{ parseInt(total_adicionales)}}</b>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        Total Soles: S/ <b>@{{ parseFloat(total_pago_soles).toFixed(2)}}</b>
    </div>
    <div class="col-md-3">
        Total D&oacute;lares: $ <b>@{{ parseFloat(total_pago_dolares).toFixed(2)}}</b>
    </div>
    <div class="col-md-3">
        Total Visa: US$ <b>@{{ parseFloat(total_visa).toFixed(2)}}</b>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        Total Depo Soles: S/ <b>@{{ parseFloat(total_deposito_soles).toFixed(2)}}</b>
    </div>
    <div class="col-md-3">
        Total Depo D&oacute;lares: $ <b>@{{ parseFloat(total_deposito_dolares).toFixed(2)}}</b>
    </div>
    <div class="col-md-3">
        Total SERVICE FEE: US$ <b>@{{ parseFloat(total_service_fee).toFixed(2)}}</b>
    </div>
</div>
