<style>
    .table-bordered tbody td {
        border-color: #000;
        color: #000;
        text-align: center;
        vertical-align: middle;
    }

    .table-bordered thead th {
        background-color: #0055FF;
        color: #FFF;
        border-color: #000;
        text-align: center;
        vertical-align: middle;
    }
</style>
<table style="color: #000">
    <thead style="font-size:10px;color:red">
        <tr>
            <th>#</th>
            <th>FECHA</th>
            <th>COUNTER</th>
            <th>TICKET</th>
            <th>CODIGO</th>
            <th>AEROLINEA</th>
            <th>PASAJERO</th>
            <th>RUTA</th>
            <th>TARIFA</th>
            <th>TAX/TUAA</th>
            <th>SERVICE_FEE</th>
            <th>TOTAL</th>
            <th>PAGO_SOLES</th>
            <th>PAGO_DOLARES</th>
            <th>PAGO_VISA</th>
            <th>DEPOSITO_SOLES</th>
            <th>DEPOSITO_DOLARES</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($pasajes as $pasaje)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $pasaje['created_at_venta'] }}</td>
            <td>{{ $pasaje['counter'] }}</td>
            <td>{{ $pasaje['ticket'] }}</td>
            <td>{{ $pasaje['viajecode'] }}</td>
            <td>{{ $pasaje['aero'] }}</td>
            <td>{{ $pasaje['pasajero'] }}</td>
            <td>{{ $pasaje['ruta'] }}</td>
            <td>{{ $pasaje['tarifa'] }}</td>
            <td>{{ $pasaje['tax'] }}</td>
            <td>{{ $pasaje['service_fee'] }}</td>
            <td>{{ $pasaje['total'] }}</td>
            <td>{{ $pasaje['pago_soles'] }}</td>
            <td>{{ $pasaje['pago_dolares'] }}</td>
            <td>{{ $pasaje['pago_visa'] }}</td>
            <td>{{ $pasaje['deposito_soles'] }}</td>
            <td>{{ $pasaje['deposito_dolares'] }}</td>
        </tr>
        @empty
        <tr>
            <td>Dato No EXiste</td>
        </tr>
        @endforelse
    </tbody>
</table>
