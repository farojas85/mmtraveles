<hr>
<h4 class="text-primary">Pasajes Vendidos</h4>
<div class="table-responsive ">
    <table class="table table-sm table-hover table-bordered nowrap">
        <thead class="bg-navy">
            <tr>
                <th>Nº</th>
                <th >Counter</th>
                <th>Codigo</th>
                <th>Pasajero</th>
                <th>Aerolinea</th>
                <th>Tarifa</th>
                <th>Tax/TUUA</th>
                <th>Service Fee</th>
                <th>Total</th>
                <th>Pago S/</th>
                <th>Pago $</th>
                <th>Visa</th>
                <th>Dep. S/</th>
                <th>Dep. $</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody >
            <tr v-if="total_reporte == 0">
                <td colspan="12">-- DATOS NO REGISTRADOS --</td>
            </tr>
            <tr v-else v-for="(repo,index) in reporte" :key="repo.id">
                <td>@{{index+1}}</td>
                <td>@{{repo.counter}}</td>
                <td>@{{repo.viajecode}}</td>
                <td>@{{repo.pasajero}}</td>
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
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="8" class="text-right">TOTAL</th>
                <th>@{{parseFloat(suma_reporte).toFixed(2)}}</th>
                <th colspan="6"></th>
            </tr>
        </tfoot>
    </table>
</div>
<h6>TOTAL Vendido: <b>$ @{{ parseFloat(suma_reporte).toFixed(2)}}</b>&nbsp;  Cantidad Pasajes: <b>@{{total_reporte}}<b></h6>
<hr>
<h4 class="text-danger">Deudas</h4>
<div class="table-responsive">
    <table class="table table-sm table-hover table-bordered nowrap">
        <thead class="bg-navy">
            <tr>
                <th>Nº</th>
                <th>Counter</th>
                <th>Pasajero</th>
                <th>Codigo</th>
                <th>Deuda Detalle</th>
                <th>Deuda Monto</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="total_deudas == 0">
                <td colspan="7">-- DATOS NO REGISTRADOS --</td>
            </tr>
            <tr v-else v-for="(deuda,index) in deudas" :key="deuda.id">
                <td>@{{index+1}}</td>
                <td>@{{deuda.counter}}</td>
                <td>@{{deuda.pasajero}}</td>
                <td>@{{deuda.viajecode}}</td>
                <td>@{{deuda.deuda_detalle}}</td>
                <td>@{{deuda.deuda_monto}}</td>
                <td>@{{deuda.created_at_venta}}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">TOTAL</th>
                <th>@{{parseFloat(suma_deudas).toFixed(2)}}</th>
            </tr>
        </tfoot>
    </table>
</div>
<h6>TOTAL Deuda: <b>$ @{{ parseFloat(suma_deudas).toFixed(2)}}</b>&nbsp;  Cantidad Deudas: <b>@{{total_deudas}}<b></h6>
<hr>
<h4 class="text-success">Adicionales</h4>
<div class="table-responsive">
    <table class="table table-sm table-hover table-bordered nowrap">
        <thead class="bg-navy">
            <tr>
                <th>Nº</th>
                <th>Counter</th>
                <th>Pasajero</th>
                <th>Detalle</th>
                <th>Monto</th>
                <th>Service Fee</th>
                <th>Importe</th>
                <th>Pago S/</th>
                <th>Pago $</th>
                <th>Visa</th>
                <th>Dep. S/</th>
                <th>Dep. $</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="total_adicionales == 0">
                <td colspan="13">-- DATOS NO REGISTRADOS --</td>
            </tr>
            <tr v-else v-for="(adicional,index) in adicionales" :key="adicionales.id">
                <td>@{{index+1}}</td>
                <td></td>
                <td>@{{adicional.detalle_otro}}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6" class="text-right">TOTAL</th>
                <th>@{{parseFloat(suma_adicionales).toFixed(2)}}</th>
                <th colspan="6" class="text-right"></th>
            </tr>
        </tfoot>
    </table>
</div>
