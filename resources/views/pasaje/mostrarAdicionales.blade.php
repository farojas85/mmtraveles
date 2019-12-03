@extends('layouts.master')

@section('contenido')
    <!-- Content Header (Page header) -->
    @php
        $roles = Auth::user()->roles;
        foreach($roles as $role)
        {
            $role_name = $role->name;
        }
        
    @endphp
    
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><i class="fas fa-cart-plus mr-1"></i> Adicionales</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Adicionales</li>
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
                               <font style="font-size:20pt;font-weight:900">Listado de Adicionales</font>
                               @if($role->name!='Administrador' && $role->name != 'Gerente')
                               <a class="btn btn-info no-print"
                                    href="opcionalesVentas">
                                    Registrar Adicional
                                </a>
                               <a class="btn btn-info no-print"
                                    href="pasajeCreate">
                                    Registrar Pasaje
                                </a>
                                @endif
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
                                                    <th>Pasajero</th>
                                                    <th>Fecha</th>
                                                    <th>Total</th>
                                                    <th>Pago S/</th>
                                                    <th>Pago $</th>
                                                    <th>Visa</th>
                                                    <th>Dep. S/</th>
                                                    <th>Dep. $</th>
                                                    <th>Acci&oacute;n</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-if="total_opcionales == 0">
                                                    <td colspan="12">-- DATOS NO REGISTRADOS --</td>
                                                </tr>
                                                <tr v-else v-for="(repo,index) in opcionales" :key="repo.id">
                                                    
                                                    <td>@{{index+1}}</td>
                                                    <td>
                                                        <span v-if="repo.counter_id==null">--</span>
                                                        <span v-else>@{{repo.user.name}} @{{repo.user.lastname}}</span>
                                                    </td>
                                                    <td>@{{repo.pasajero}}</td>
                                                    <td>@{{repo.fecha}}</td>
                                                    <td>@{{repo.total}}</td>
                                                    <td>@{{repo.pago_soles}}</td>
                                                    <td>@{{repo.pago_dolares}}</td>
                                                    <td>@{{repo.pago_visa}}</td>
                                                    <td>@{{repo.deposito_soles}}</td>
                                                    <td>@{{repo.deposito_dolares}}</td>
                                                    <td>
                                                        <button class="btn btn-warning btn-xs"
                                                            title="Ver Registro Adicionales" @click="verAdicionales(repo.id)">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="4" class="text-right">Total Pasaje</th>
                                                    <th>@{{suma_reporte.toFixed(2) }}</th>
                                                    <th colspan="6"></th>
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
        <div class="modal" tabindex="-1" role="dialog" id="modal-adicionales">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-adicionales-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-adicionales-body">
                        <p>Modal body text goes here.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripties')
    <script src="js/sistema/ver-adicionales.js"></script>
@endsection