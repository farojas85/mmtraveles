@extends('layouts.master')

@section('contenido')
    <!-- Content Header (Page header) -->
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
                               <font style="font-size:20pt;font-weight:900">Registro Adicionales</font>
                               <a class="btn btn-primary no-print"
                                    href="pasajeCreate">
                                    Registrar Pasaje
                                </a>
                            </h3>
                        </div>
                        <div class="card-body">
                            <form  class="form-horizontal" role="form">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h3 class="card-title">Cliente</h3>
                                            <!-- /.card-tools -->
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label for="inputEmail1" class="col-md-3 col-form-label">PASAJERO</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="pasajero" class="form-control" id="pasajero"
                                                                v-model="opcional.pasajero" placeholder="Nombre pasajero: (RAMIREZ/HECTOR) ">
                                                        <small class="text-danger" v-for="error in errores.pasajero">@{{ error }}</small>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tipo_documento_id" class="col-md-3 col-form-label">FOID/DNI</label>
                                                    <div class="col-md-4">
                                                        <select class="form-control" v-model="opcional.tipo_documento_id" name="tipo_documento_id">
                                                            <option value="">-Tipo Doc.-</option>
                                                            <option v-for="tipo in tipoDocumentos" :key="tipo.id" :value="tipo.id">
                                                                @{{tipo.nombre_corto}}
                                                            </option>
                                                        </select>
                                                        <small class="text-danger" v-for="error in errores.tipo_documento_id">@{{ error }}</small>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="text" name="numero_documento" class="form-control" id="numero_documento"
                                                                v-model="opcional.numero_documento" placeholder="Número Documento ">
                                                        <small class="text-danger" v-for="error in errores.numero_documento">@{{ error }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- /.card-body -->
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card card-success">
                                            <div class="card-header">
                                                <h3 class="card-title">Fecha</h3>
                                            <!-- /.card-tools -->
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label for="created_at_venta" class="col-md-3 col-form-label">FECHA VENTA</label>
                                                    <div class="col-md-6">
                                                        <input type="date" name="created_at_venta" v-model="opcional.fecha_venta"
                                                                class="form-control" id="created_at_venta">
                                                        <small class="text-danger" v-for="error in errores.fecha_venta">@{{ error }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- /.card-body -->
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-success">
                                            <div class="card-header">
                                                <h3 class="card-title">Datos Adicionales</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label class="col-md-1 col-form-label col-form-label-sm" >Adicional</label>
                                                    <div class="col-md-4">
                                                        <select class="form-control" v-model="adicional.adicional_id" name="adicional_name" id="adicional_name"
                                                            @change="filtroPorId">
                                                            <option value="">-Adicionales.-</option>
                                                            <option v-for="adic in adicionales" :key="adic.id" :value="adic.id">
                                                                @{{adic.descripcion}}
                                                            </option>
                                                        </select>
                                                        <small class="text-danger" v-for="error in errores.tipo_documento_id">@{{ error }}</small>
                                                        <input type="text" class="form-control form-control-sm"
                                                                v-model="adicional.detalle" id="detalle" title="Detalle Otros"
                                                                placeholder="Otra descripción">
                                                    </div>
                                                    <div class="col-md-2"><input type="text" class="form-control form-control-sm" placeholder="Monto" v-model="adicional.monto" id="montod" title="Monto Del Detalle"></div>
                                                    <div class="col-md-2"><input type="text" class="form-control form-control-sm" placeholder="Service FEE" v-model="adicional.service_fee" id="fee" title="Ingrese Service Fee"></div>
                                                    <div class="col-md-2"><button type="button" class="btn btn-danger btn-sm" @click="agregarAdicional">A&ntildeadir</button></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-sm table-bordered">
                                                                <thead class="bg-dark">
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Id</th>
                                                                        <th>Detalle</th>
                                                                        <th>Monto</th>
                                                                        <th>Service FEE</th>
                                                                        <th>Importe</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-if="opcional.adicionales.length==0">
                                                                        <td colspan="5" class="text-danger text-center">--Datos No Añadidos--</td>
                                                                    </tr>
                                                                    <tr v-else v-for="(adic,index) in opcional.adicionales">
                                                                        <td><button type="button" class="btn btn-danger btn-sm" @click="eliminar(index)"><i class="fas fa-trash"></i></button></td>
                                                                        <td>@{{adic.adicional_id}}</td>
                                                                        <td>@{{adic.detalle }}</td>
                                                                        <td>@{{adic.monto.toFixed(2)}}</td>
                                                                        <td>@{{adic.service_fee.toFixed(2)}}</td>
                                                                        <td>@{{adic.importe.toFixed(2)}}</td>
                                                                    </tr>
                                                                    <tr v-if="opcional.adicionales.length>0">
                                                                        <td colspan="3"></td>
                                                                        <td></td>
                                                                        <th class="bg-dark text-right">TOTAL</th>
                                                                        <td>@{{ total_importe }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card card-info">
                                                            <div class="card-header">
                                                                <h3 class="card-title">Detalles Montos</h3>
                                                            <!-- /.card-tools -->
                                                            </div>
                                                            <!-- /.card-header -->
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group row">
                                                                            <label for="moneda" class="col-md-3 col-form-label">Monto</label>
                                                                            <div class="col-md-6">
                                                                                <input type="text" name="monto_neto" id="monto_neto" v-model="total_importe"
                                                                                    class="form-control" placeholder="Monto" value='0.00'>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <select name="moneda" class="form-control" v-model="opcional.moneda">
                                                                                    <option value="USD">D&oacute;lares</option>
                                                                                </select>
                                                                                <small class="text-danger" v-for="error in errores.moneda">@{{ error }}</small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="moneda" class="col-md-3 col-form-label">Tipo Cambio</label>
                                                                            <div class="col-md-6">
                                                                                <input type="text" name="cambio" id="cambio" v-model="opcional.cambio"
                                                                                    class="form-control" placeholder="Tipo cambio: 3.56" value='0.00'>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="pago_soles" class="col-md-4 col-form-label">Pago Soles</label>
                                                                            <div class="col-md-6">
                                                                                <input type="text" name="pago_soles" id="pago_soles" v-model="opcional.pago_soles"
                                                                                    class="form-control" placeholder="Pago Soles (S/)">
                                                                                <small class="text-danger" v-for="error in errores.pago_soles">@{{ error }}</small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="pago_dolares" class="col-md-4 col-form-label">Pago Dolares</label>
                                                                            <div class="col-md-6">
                                                                                <input type="text" name="pago_dolares" id="pago_dolares" v-model="opcional.pago_dolares"
                                                                                    class="form-control" placeholder="Pago Soles (USD$)">
                                                                                <small class="text-danger" v-for="error in errores.pago_dolares">@{{ error }}</small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="pago_visa" class="col-md-4 col-form-label">Pago Visa</label>
                                                                            <div class="col-md-6">
                                                                                <input type="text" name="pago_visa" id="pago_visa" v-model="opcional.pago_visa"
                                                                                    class="form-control" placeholder="Pago Visa">
                                                                                <small class="text-danger" v-for="error in errores.pago_visa">@{{ error }}</small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="deposito_soles" class="col-md-4 col-form-label">Dep&oacute;sito Soles</label>
                                                                            <div class="col-md-6">
                                                                                <input type="text" name="deposito_soles" id="deposito_soles" v-model="opcional.deposito_soles"
                                                                                    class="form-control" placeholder="Pago Visa">
                                                                                <small class="text-danger" v-for="error in errores.deposito_soles">@{{ error }}</small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="deposito_dolares" class="col-md-4 col-form-label">Dep&oacute;sito Dolares</label>
                                                                            <div class="col-md-6">
                                                                                <input type="text" name="deposito_dolares" id="deposito_dolares" v-model="opcional.deposito_dolares"
                                                                                    class="form-control" placeholder="Pago Visa">
                                                                                <small class="text-danger" v-for="error in errores.deposito_dolares">@{{ error }}</small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group row">
                                                                            <label for="sub_total" class="col-md-3 col-form-label">Sub Total</label>
                                                                            <div class="col-md-6">
                                                                                <input type="text" name="sub_total" id="sub_total" v-model="opcional.sub_total"
                                                                                    class="form-control" placeholder="Sub Total" readonly >
                                                                                <small class="text-danger" v-for="error in errores.sub_total">@{{ error }}</small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="igv" class="col-md-3 col-form-label">I.G.V.:</label>
                                                                            <div class="col-md-6">
                                                                                <input type="text" name="igv" id="igv" v-model="opcional.igv"
                                                                                    class="form-control" placeholder="0.00"  @change="calcularTotal" >
                                                                                <small class="text-danger" v-for="error in errores.igv">@{{ error }}</small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="total" class="col-md-3 col-form-label">TOTAL</label>
                                                                            <div class="col-md-6">
                                                                                <input type="text" name="total" id="total" v-model="opcional.total"
                                                                                    class="form-control" placeholder="TOTAL" readonly>
                                                                                <small class="text-danger" v-for="error in errores.total">@{{ error }}</small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
    <script src="js/sistema/opcionales.js"></script>
@endsection
