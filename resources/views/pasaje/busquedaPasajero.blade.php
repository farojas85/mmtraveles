@extends('layouts.master')

@section('contenido')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><i class="fas fa-search mr-1"></i> B&uacute;squeda Pasajeros</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">B&uacute;squeda Pasajeros</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title" >
                               <font style="font-size:20pt;font-weight:900">Listado de Pasajeros</font>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 text-right">
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" v-model="texto" placeholder="Buscar..." @change="buscarPasajero">
                                    </div>
                                    <small class="text-danger" v-for="error in errores.texto">@{{ error }}</small>
                                </div>
                            </div>
                            <div class="row" v-if="seleccionar_pasajero ==false ">
                                <div class="col-md-6">
                                    <table class="table table-bordered table-sm">
                                        <tbody>
                                            <tr v-if="total_pasajeros==0">
                                                <td colspan="3" class="text-danger">-Pasajero y/o Numero Documento No registrado-</td>
                                            </tr>
                                            <tr v-if="total_pasajeros>0" v-for="(pasajero,index) in pasajeros">
                                                <td>@{{(index+1)}}</td>
                                                <td>@{{ pasajero.pasajero }}</td>
                                                <td style="cursor:pointer"><span @click="listarPasajes(pasajero.numero_documento)"><i class="fas fa-eye text-primary"></i></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row" v-if="seleccionar_pasajero== true">
                                <h4 class="text-primary mt-2">Pasajes Vendidos Pagados</h4>
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
                                            <tr v-for="(repo,index) in pagados" >
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
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripties')
    <script src="js/sistema/buscar-pasajero.js"></script>
@endsection
