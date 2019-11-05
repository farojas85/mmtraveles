<div class="table-responsive">
    <table class="table table-sm table-hover table-bordered">
        <thead>
            <tr>
                <th>Nº</th>
                <th >Counter</th>
                <th>Codigo</th>
                <th>Pasajero</th>
                <th>Aerolinea</th>
                <th>Pasaje</th>
                <th>Pago S/</th>
                <th>Pago $</th>
                <th>Visa</th>
                <th>Dep. S/</th>
                <th>Dep. $</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="total_reporte == 0">
                <td colspan="12">-- DATOS NO REGISTRADOS --</td>
            </tr>
            <tr v-else v-for="(repo,index) in reporte" :key="repo.id">
                <td>@{{index+1}}</td>
                <td>@{{repo.counter}}</td>
                <td>@{{repo.viajecode}}</td>
                <td>@{{repo.pasajero}}</td>
                <td>@{{repo.aero}}</td>
                <td>@{{repo.pasaje_total.toFixed(2)}}</td>
                <td>@{{repo.pago_soles.toFixed(2)}}</td>
                <td>@{{repo.pago_dolares.toFixed(2)}}</td>
                <td>@{{repo.pago_visa.toFixed(2)}}</td>
                <td>@{{repo.deposito_soles.toFixed(2)}}</td>
                <td>@{{repo.deposito_dolares.toFixed(2)}}</td>
                <td>@{{repo.created_at}}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">Total Pasaje</th>
                <th>@{{suma_reporte.toFixed(2)}}</th>
                <th colspan="6"></th>
            </tr>
        </tfoot>
    </table>
</div>
