@extends('layouts.master')

@section ('estilos')
<style>
    @media print
    {
        .no-print, .no-print *
        {
            display: none !important;
        }
    }
</style>
@endsection
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
                        <li class="breadcrumb-item active">Nuevo Pasaje</li>
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
                               <font style="font-size:20pt;font-weight:900">REGISTRO PASAJE</font>
                               <a class="btn btn-danger no-print"
                                        href="pasajeVentas">
                                   Ver Pasajes vendidos
                                </a>
                                <a class="btn btn-info no-print"
                                         href="opcionalesVentas">
                                    Registrar Adicionales
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
                                                                v-model="pasaje.pasajero" placeholder="Nombre pasajero: (RAMIREZ/HECTOR) ">
                                                        <small class="text-danger" v-for="error in errores.pasajero">@{{ error }}</small>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tipo_documento_id" class="col-md-3 col-form-label">FOID/DNI</label>
                                                    <div class="col-md-4">
                                                        <select class="form-control" v-model="pasaje.tipo_documento_id" name="tipo_documento_id">
                                                            <option value="">-Tipo Doc.-</option>
                                                            <option v-for="tipo in tipoDocumentos" :key="tipo.id" :value="tipo.id">
                                                                @{{tipo.nombre_corto}}
                                                            </option>
                                                        </select>
                                                        <small class="text-danger" v-for="error in errores.tipo_documento_id">@{{ error }}</small>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="text" name="numero_documento" class="form-control" id="numero_documento"
                                                                v-model="pasaje.numero_documento" placeholder="Número Documento ">
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
                                                <h3 class="card-title">Fecha Venta</h3>
                                            <!-- /.card-tools -->
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label for="created_at_venta" class="col-md-3 col-form-label">FECHA VENTA</label>
                                                    <div class="col-md-6">
                                                        <input type="date" name="created_at_venta" v-model="pasaje.fecha_venta"
                                                                class="form-control" id="created_at_venta">
                                                        <small class="text-danger" v-for="error in errores.fecha_venta">@{{ error }}</small>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="ticker_number" class="col-md-3 col-form-label">Nro. Ticket</label>
                                                    <div class="col-md-6">
                                                        <input type="text" name="ticket_number" id="ticket_number" v-model="pasaje.ticket_number"
                                                                class="form-control" placeholder="Número Ticket">
                                                        <small class="text-danger" v-for="error in errores.ticket_number">@{{ error }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- /.card-body -->
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-danger">
                                            <div class="card-header">
                                                <h3 class="card-title">Datos Aerolínea</h3>
                                            <!-- /.card-tools -->
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label for="aerolinea_id" class="col-md-3 col-form-label">L&Iacute;NEA A&Eacute;REA</label>
                                                            <div class="col-md-6">
                                                                <select name="aerolinea_id" class="form-control" v-model="pasaje.aerolinea_id" @change="filtroPorId">
                                                                    <option value="">-SELECCIONAR-</option>
                                                                    <option v-for="aero in aerolineas" :key="aero.id" :value="aero.id">
                                                                        @{{aero.name}}
                                                                    </option>
                                                                </select>
                                                                <small class="text-danger" v-for="error in errores.aerolinea_id">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="direccion" class="col-md-3 col-form-label">DIRECCI&Oacute;N</label>
                                                            <div class="col-md-9">
                                                                <textarea  name="direccion"  class="form-control" v-model="pasaje.direccion"
                                                                        id="direccion" placeholder="Dirección" readonly rows="2"></textarea>
                                                                <small class="text-danger" v-for="error in errores.direccion">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="direccion" class="col-md-3 col-form-label">R.U.C.</label>
                                                            <div class="col-md-9">
                                                                <input type="text" name="ruc"  class="form-control" v-model="pasaje.ruc"
                                                                        id="ruc" placeholder="R.U.C" readonly>
                                                                <small class="text-danger" v-for="error in errores.ruc">@{{ error }}</small>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label for="ticket_number" class="col-md-4 col-form-label">Nro. de Boleto</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="ticket_number" id="ticket_number" v-model="pasaje.ticket_number"
                                                                        class="form-control" placeholder="Número Ticket">
                                                                <small class="text-danger" v-for="error in errores.ticket_number">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="inputEmail1" class="col-md-4 col-form-label">CODIGO RESERVA</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="viajecode" id="product_code" v-model="pasaje.codigo"
                                                                        class="form-control" id="viajecode" placeholder="Codigo de Viaje: (TNJEUV)">
                                                                <small class="text-danger" v-for="error in errores.codigo">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-warning border-warning">
                                            <div class="card-header">
                                                <h3 class="card-title">Detalles Vuelo</h3>
                                            <!-- /.card-tools -->
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label for="inputEmail1" class="col-md-2 col-form-label">RUTA</label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="ruta" class="form-control" v-model="pasaje.ruta"
                                                                        id="name_factura" placeholder="Ruta: (IQT-LIM) (IQT-LIM-IQT)">
                                                                <small class="text-danger" v-for="error in errores.ruta">@{{ error }}</small>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select name="tipo_viaje" class="form-control" v-model="pasaje.tipo_viaje" @change="cambiarHorario">
                                                                    <option value="">-TIPO VIAJE-</option>
                                                                    <option value="1">IDA</option>
                                                                    <option value="2">IDA Y VUELTA</option>
                                                                </select>
                                                                <small class="text-danger" v-for="error in errores.tipo_viaje">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="fecha_vuelo" class="col-md-2 col-form-label">Fecha</label>
                                                            <div class="col-md-4" title="Fecha Viaje">
                                                                <input type="date" name="fecha_vuelo" class="form-control" v-model="pasaje.fecha_vuelo"
                                                                        id="fecha_vuelo" placeholder="Fecha: 08 NOV">
                                                                        <small class="text-danger" v-for="error in errores.fecha_vuelo">@{{ error }}</small>
                                                            </div>
                                                            <label for="hora_vuelo" class="col-md-3 col-form-label">Hora Ida</label>
                                                            <div class="col-md-3">
                                                                <input type="text" name="hora_vuelo" class="form-control" v-model="pasaje.hora_vuelo"
                                                                        id="hora_vuelo" placeholder="16:30">
                                                                <small class="text-danger" v-for="error in errores.hora_vuelo">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" v-if="hora_regreso">
                                                            <label for="fecha_retorno" class="col-md-2 col-form-label">Fec. Ret.</label>
                                                            <div class="col-md-4" title="Fecha de Retorno">
                                                                <input type="date" name="fecha_retorno" class="form-control" v-model="pasaje.fecha_retorno"
                                                                        id="fecha_vuelo" placeholder="Fecha: 08 NOV">
                                                                        <small class="text-danger" v-for="error in errores.fecha_vuelo">@{{ error }}</small>
                                                            </div>
                                                            <label for="hora_vuelta" class="col-md-3 col-form-label">Hora Vuelta</label>
                                                            <div class="col-md-3">
                                                                <input type="text" name="hora_vuelta" class="form-control" v-model="pasaje.hora_vuelta"
                                                                        id="hora_vuelta" placeholder="16:30">
                                                                <small class="text-danger" v-for="error in errores.hora_vuelta">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label for="vuelo" class="col-md-2 col-form-label text-right">VUELO</label>
                                                            <div class="col-md-4">
                                                                <input type="text" name="vuelo" class="form-control" v-model="pasaje.vuelo"
                                                                        id="vuelo" placeholder="Vuelo: 3453453">
                                                                <small class="text-danger" v-for="error in errores.vuelo">@{{ error }}</small>
                                                            </div>
                                                            <label for="vuelo" class="col-md-2 col-form-label text-right">CL</label>
                                                            <div class="col-md-4">
                                                                <input type="text" name="cl" class="form-control" v-model="pasaje.cl"
                                                                        id="cl" placeholder="cl: R">
                                                                <small class="text-danger" v-for="error in errores.cl">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="st" class="col-md-2 col-form-label text-right">ST</label>
                                                            <div class="col-md-3">
                                                                <input type="text" name="st" class="form-control" v-model="pasaje.st"
                                                                        id="st" placeholder="Ejem: 0K">
                                                                <small class="text-danger" v-for="error in errores.st">@{{ error }}</small>
                                                            </div>
                                                            <label for="vuelo" class="col-md-3 col-form-label text-right">BAG/EQUIP</label>
                                                            <div class="col-md-4">
                                                                <input type="text" name="equipaje" class="form-control" v-model="pasaje.equipaje"
                                                                        id="equipaje" placeholder="Ejem: 10 K">
                                                                <small class="text-danger" v-for="error in errores.equipaje">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
                                                                <input type="text" name="monto_neto" id="monto_neto" v-model="pasaje.monto_neto"
                                                                    class="form-control" placeholder="Monto" value='0.00'>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <select name="moneda" class="form-control" v-model="pasaje.moneda">
                                                                    <option value="USD">D&oacute;lares</option>
                                                                </select>
                                                                <small class="text-danger" v-for="error in errores.moneda">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="moneda" class="col-md-3 col-form-label">Tipo Cambio</label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="cambio" id="cambio" v-model="pasaje.cambio"
                                                                    class="form-control" placeholder="Tipo cambio: 3.56" value='0.00'>
                                                            </div>
                                                        </div>
                                                        <!--<div class="form-group row">
                                                            <label for="inputEmail1" class="col-md-4 col-form-label">Exonerado del IGV</label>
                                                            <div class="col-md-6">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="not_igv" v-model="pasaje.not_igv" checked @change="calcularIgv">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>-->
                                                        <div class="form-group row">
                                                            <label for="pago_soles" class="col-md-4 col-form-label">Pago Soles</label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="pago_soles" id="pago_soles" v-model="pasaje.pago_soles"
                                                                    class="form-control" placeholder="Pago Soles (S/)">
                                                                <small class="text-danger" v-for="error in errores.pago_soles">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="pago_dolares" class="col-md-4 col-form-label">Pago Dolares</label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="pago_dolares" id="pago_dolares" v-model="pasaje.pago_dolares"
                                                                    class="form-control" placeholder="Pago Soles (USD$)">
                                                                <small class="text-danger" v-for="error in errores.pago_dolares">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="pago_visa" class="col-md-4 col-form-label">Pago Visa</label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="pago_visa" id="pago_visa" v-model="pasaje.pago_visa"
                                                                    class="form-control" placeholder="Pago Visa">
                                                                <small class="text-danger" v-for="error in errores.pago_visa">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="deposito_soles" class="col-md-4 col-form-label">Dep&oacute;sito Soles</label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="deposito_soles" id="deposito_soles" v-model="pasaje.deposito_soles"
                                                                    class="form-control" placeholder="Pago Visa">
                                                                <small class="text-danger" v-for="error in errores.deposito_soles">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="deposito_dolares" class="col-md-4 col-form-label">Dep&oacute;sito Dolares</label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="deposito_dolares" id="deposito_dolares" v-model="pasaje.deposito_dolares"
                                                                    class="form-control" placeholder="Pago Visa">
                                                                <small class="text-danger" v-for="error in errores.deposito_dolares">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label for="tarifa" class="col-md-4 col-form-label">Air Fare/Tarifa Neta</label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="tarifa" id="tarifa" v-model="pasaje.tarifa"
                                                                    class="form-control" placeholder="Tarifa" @change="calcularTotal">
                                                                <small class="text-danger" v-for="error in errores.tarifa">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="tax" class="col-md-3 col-form-label">Tax/TUAA</label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="tax" id="tax" v-model="pasaje.tax"
                                                                    class="form-control" placeholder="Tax / Impuestos" @change="calcularTotal">
                                                                <small class="text-danger" v-for="error in errores.tax">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="service_fee" class="col-md-3 col-form-label">Service FEE</label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="service_fee" id="service_fee" v-model="pasaje.service_fee"
                                                                    class="form-control" placeholder="Service FEE" @change="calcularTotal">
                                                                <small class="text-danger" v-for="error in errores.service_fee">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="sub_total" class="col-md-3 col-form-label">Sub Total</label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="sub_total" id="sub_total" v-model="pasaje.sub_total"
                                                                    class="form-control" placeholder="Sub Total" readonly >
                                                                <small class="text-danger" v-for="error in errores.sub_total">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="igv" class="col-md-3 col-form-label">I.G.V.:</label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="igv" id="igv" v-model="pasaje.igv"
                                                                    class="form-control" placeholder="0.00"  @change="calcularTotal" >
                                                                <small class="text-danger" v-for="error in errores.igv">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="total" class="col-md-3 col-form-label">TOTAL</label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="total" id="total" v-model="pasaje.total"
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

                                <div class="row no-print">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-lg-offset-2 col-lg-10">
                                                <button type="button" class="btn btn-success" @click="guardar">
                                                    <i class="fa fa-save"></i> Registrar</button>
                                                <span v-if="impresion==true">
                                                    <a href="pasajePdf" target="_blank" class="btn btn-primary">
                                                        <i class="fas fa-print"></i> Imprimir</a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripties')
    <script src="js/sistema/nuevo-pasaje.js"></script>
@endsection
