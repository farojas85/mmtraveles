@extends('layouts.master')

@section('contenido')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><i class="fas fa-cart-plus mr-1"></i> PASAJES</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Pasajes</li>
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
                               <font style="font-size:20pt;font-weight:900">LISTADO DE PASAJES</font>
                               <a class="btn btn-info no-print"
                                    href="pasajeCreate">
                                    Registrar Pasaje
                                </a>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nº</th>
                                                    <th >Counter</th>
                                                    <th>Codigo</th>
                                                    <th>Pasajero</th>
                                                    <th>Aerolinea</th>
                                                    <th>Monto</th>
                                                    <th>Pago S/</th>
                                                    <th>Pago $</th>
                                                    <th>Visa</th>
                                                    <th>Dep. S/</th>
                                                    <th>Dep. $</th>
                                                    <th>Fecha</th>
                                                    <th>Impr.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-if="total_pasajes == 0">
                                                    <td colspan="12">-- DATOS NO REGISTRADOS --</td>
                                                </tr>
                                                <tr v-else v-for="(repo,index) in pasajes" :key="repo.id">

                                                    <td>@{{index+1}}</td>
                                                    <td>
                                                        <span v-if="repo.counter_id==null">--</span>
                                                        <span v-else>@{{repo.user.name}}</span>
                                                    </td>
                                                    <td>@{{repo.viajecode}}</td>
                                                    <td>@{{repo.pasajero}}</td>
                                                    <td>@{{repo.aerolinea.name }}</td>
                                                    <td>@{{repo.total}}</td>
                                                    <td>@{{repo.pago_soles}}</td>
                                                    <td>@{{repo.pago_dolares}}</td>
                                                    <td>@{{repo.pago_visa}}</td>
                                                    <td>@{{repo.deposito_soles}}</td>
                                                    <td>@{{repo.deposito_dolares}}</td>
                                                    <td>@{{repo.created_at}}</td>
                                                    <td>
                                                        <a :href=" 'imprimirPasaje/'+repo.id" class="btn btn-success btn-xs"  title="Mostrar Empresa"
                                                            target="_blank">
                                                            <i class="fas fa-print"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="5" class="text-right">Total Pasaje</th>
                                                    <th>@{{suma_reporte.toFixed(2) }}</th>
                                                    <th colspan="7"></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
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
    <script src="js/sistema/ver-pasajes.js"></script>
@endsection
