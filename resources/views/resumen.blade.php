<div class="card caard-default">
    <div class="card-header">
        <h3 class="card-title">
            Resumen Ventas por Día
        </h3>
    </div>
    <div class="card-body">
    @if($role_name =='Administrador' || $role_name == 'Gerente' || $role_name == 'Responsable')
        <div class="row">
            <label for="" class="col-md-1 col-form-label">Fecha: </label>
            <input type="date" class="form-control col-md-2" id="fecha_dia_resumen" onchange="resumenDia()">
        </div>
        <div class="table-responsive" >
            <table class="table table-striped table-hovered table-sm table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Counter</th>
                        <th>Fecha</th>
                        <th>Pago Soles</th>
                        <th>Pago Dolares</th>
                        <th>Pago Visa</th>
                        <th>Dep&oacute;sito Soles</th>
                        <th>Dep&oacute;sito D&oacute;lares</th>
                        <th>Service Fee</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pasaje as $resumen)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$resumen->name." ".$resumen->lastname}}</td>
                        <td>{{$resumen->fecha}}</td>
                        <td class="text-center">{{number_format($resumen->pago_soles,2)}}</td>
                        <td class="text-center">{{number_format($resumen->pago_dolares,2)}}</td>
                        <td class="text-center">{{number_format($resumen->pago_visa,2)}}</td>
                        <td class="text-center">{{number_format($resumen->deposito_soles,2)}}</td>
                        <td class="text-center">{{number_format($resumen->deposito_dolares,2)}}</td>
                        <td class="text-center">{{number_format($resumen->service_fee,2)}}</td>
                    </tr>
                    @empty
                    <tr>
                        <td class="text-center text-danger" colspan="9">--Pasajes No Registrados --</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @else
    <div class="table-responsive" >
        <table class="table table-striped table-hovered table-sm table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Pago Soles</th>
                    <th>Pago Dolares</th>
                    <th>Pago Visa</th>
                    <th>Dep&oacute;sito Soles</th>
                    <th>Dep&oacute;sito D&oacute;lares</th>
                    <th>Service Fee</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pasaje as $resumen)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$resumen->fecha}}</td>
                    <td class="text-center">{{number_format($resumen->pago_soles,2)}}</td>
                    <td class="text-center">{{number_format($resumen->pago_dolares,2)}}</td>
                    <td class="text-center">{{number_format($resumen->pago_visa,2)}}</td>
                    <td class="text-center">{{number_format($resumen->deposito_soles,2)}}</td>
                    <td class="text-center">{{number_format($resumen->deposito_dolares,2)}}</td>
                    <td class="text-center">{{number_format($resumen->service_fee,2)}}</td>
                </tr>
                @empty
                <tr>
                    <td class="text-center text-danger" colspan="9">--Pasajes No Registrados --</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    @endif
    </div>
</div>
