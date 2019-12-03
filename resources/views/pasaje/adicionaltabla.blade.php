<div class="table-responsive">
    <table class="table table-sm table-hover table-bordered">
        <thead>
            <tr>
                <th>Nº</th>
                <th >Descripci&oacute;n</th>
                <th>Monto</th>
                <th>Service Fee</th>
                <th>Importe</th>
            </tr>
        </thead>
        <tbody>
        @php
            $suma_total = 0;
        @endphp
        @forelse($opcional_detalle as $od)
        @php
            $suma_total += $od->importe;
        @endphp
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$od->detalle_otro}}</td>
                <td>{{number_format($od->monto,2)}}</td>
                <td>{{number_format($od->service_fee,2)}}</td>
                <td>{{number_format($od->importe,2)}}</td>
            </tr>
        @empty
        @endforelse
            <tr>
                <th colspan=4 class="text-right"> TOTAL</th>
                <td>{{number_format($suma_total,2)}}</td>
            </tr>
        </tbody>
    </table>
</div>