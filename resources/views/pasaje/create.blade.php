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
                                    <div class="col-md-12">
                                        <div class="card card-success">
                                            <div class="card-header">
                                                <h3 class="card-title">Fecha Venta</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label for="created_at_venta" class="col-md-2 col-form-label">FECHA VENTA</label>
                                                    <div class="col-md-3">
                                                        <input type="date" name="created_at_venta" v-model="pasaje.fecha_venta"
                                                                class="form-control" id="created_at_venta">
                                                        <small class="text-danger" v-for="error in errores.fecha_venta">@{{ error }}</small>
                                                    </div>
                                                    <label class="col-form-label col-md-2 text-right">Tipo Pasaje:</label>
                                                    <div class="col-md-2">
                                                        <select v-model="pasaje.tipo_pasaje" class="form-control">
                                                            <option v-for="tipopa in tipoPasaje" :key="tipopa" :value="tipopa">
                                                                @{{tipopa}}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <!--<label class="col-form-label col-md-2 text-right" v-if="pasaje.tipo_pasaje=='Adicional'">Ticket Anterior:</label>
                                                    <div class="col-md-2">
                                                        <input type="text" class="form-control" v-model="pasaje.ticket_anterior"
                                                                v-if="pasaje.tipo_pasaje=='Adicional'" @change="">
                                                    </div>-->
                                                </div>
                                                <div class="form-group row">
                                                    <label for="ticker_number" class="col-md-2 col-form-label">Nro. Ticket</label>
                                                    <div class="col-md-3">
                                                        <input type="text" name="ticket_number" id="ticket_number" v-model="pasaje.ticket_number"
                                                                class="form-control" placeholder="Número Ticket">
                                                        <small class="text-danger" v-for="error in errores.ticket_number">@{{ error }}</small>
                                                    </div>
                                                    <label class="col-form-label col-md-2 text-right">LOCAL:</label>
                                                    <div class="col-md-3">
                                                        <select v-model="pasaje.local_id" class="form-control">
                                                            <option value="">-LOCAL-</option>
                                                            <option v-for="local in locales" :key="local.id" :value="local.id">
                                                                @{{local.nombre}}
                                                            </option>
                                                        </select>
                                                        <small class="text-danger" v-for="error in errores.local_id">@{{ error }}</small>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- /.card-body -->
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h3 class="card-title">Datos de Pax</h3>
                                            <!-- /.card-tools -->
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label for="tipo_documento_id" class="col-md-1 col-form-label">FOID/DNI</label>
                                                    <div class="col-md-2">
                                                        <select class="form-control" v-model="pasaje.tipo_documento_id" name="tipo_documento_id">
                                                            <option value="">-Tipo Doc.-</option>
                                                            <option v-for="tipo in tipoDocumentos" :key="tipo.id" :value="tipo.id">
                                                                @{{tipo.nombre_corto}}
                                                            </option>
                                                        </select>
                                                        <small class="text-danger" v-for="error in errores.tipo_documento_id">@{{ error }}</small>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" name="numero_documento" class="form-control" id="numero_documento"
                                                                v-model="pasaje.numero_documento" placeholder="Número Documento ">
                                                        <small class="text-danger" v-for="error in errores.numero_documento">@{{ error }}</small>
                                                    </div>
                                                    <label for="etapa_persona_id" class="col-md-1 col-form-label">TIPO</label>
                                                    <div class="col-md-3">
                                                        <select class="form-control" v-model="pasaje.etapa_persona_id" name="etapa_persona_id">
                                                            <option value="">-TIPO PASAJERO-</option>
                                                            <option v-for="etapa in etapas" :key="etapa.id" :value="etapa.id">
                                                                @{{etapa.abreviatura}} - @{{etapa.nombre}}
                                                            </option>
                                                        </select>
                                                        <small class="text-danger" v-for="error in errores.etapa_persona_id">@{{ error }}</small>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputEmail1" class="col-md-1 col-form-label">Pasajero</label>
                                                    <div class="col-md-3">
                                                        <input type="text" name="pasajero" class="form-control" id="pasajero"
                                                                v-model="pasaje.pasajero" placeholder="Nombre pasajero: (RAMIREZ/HECTOR) ">
                                                        <small class="text-danger" v-for="error in errores.pasajero">@{{ error }}</small>
                                                    </div>
                                                    <label for="telefono_pasajero" class="col-md-1 col-form-label">Tel&eacute;fono</label>
                                                    <div class="col-md-2">
                                                        <input type="text"  class="form-control"
                                                                v-model="pasaje.telefono_pasajero" placeholder="Telefono">
                                                        <small class="text-danger" v-for="error in errores.telefono_pasajero">@{{ error }}</small>
                                                    </div>
                                                    <label for="email_pasajero" class="col-md-2 col-form-label">Correo Electr&oacute;nico</label>
                                                    <div class="col-md-3">
                                                        <input type="text"  class="form-control"
                                                                v-model="pasaje.email_pasajero" placeholder="Correo Electrónico">
                                                        <small class="text-danger" v-for="error in errores.email_pasajero">@{{ error }}</small>
                                                    </div>
                                                </div>
                                            </div>
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
                                                            <label for="inputEmail1" class="col-md-2 col-form-label">Viaje</label>
                                                            <div class="col-md-6">
                                                                <select name="tipo_viaje" class="form-control" v-model="pasaje.tipo_viaje" @change="cambiarHorario">
                                                                    <option value="">-TIPO VIAJE-</option>
                                                                    <option value="1">IDA</option>
                                                                    <option value="2">IDA Y VUELTA</option>
                                                                </select>
                                                                <small class="text-danger" v-for="error in errores.tipo_viaje">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label for="ruta" class="col-md-1 col-form-label">Ruta IDA</label>
                                                            <div class="col-md-2">
                                                                <input type="text" name="ruta" class="form-control" v-model="pasaje.ruta"
                                                                        id="name_factura" placeholder="Ruta: (HUU/LIM)">
                                                                <small class="text-danger" v-for="error in errores.ruta">@{{ error }}</small>
                                                            </div>
                                                            <label for="fecha_vuelo" class="col-md-1 col-form-label">Fecha</label>
                                                            <div class="col-md-2" title="Fecha Viaje">
                                                                <input type="date" name="fecha_vuelo" class="form-control" v-model="pasaje.fecha_vuelo"
                                                                        id="fecha_vuelo" placeholder="Fecha: 08 NOV">
                                                                <small class="text-danger" v-for="error in errores.fecha_vuelo">@{{ error }}</small>
                                                            </div>
                                                            <label for="hora_vuelo" class="col-md-1 col-form-label">Hora Ida</label>
                                                            <div class="col-md-1">
                                                                <input type="text" name="hora_vuelo" class="form-control" v-model="pasaje.hora_vuelo"
                                                                        id="hora_vuelo" placeholder="16:30">
                                                                <small class="text-danger" v-for="error in errores.hora_vuelo">@{{ error }}</small>
                                                            </div>
                                                            <label for="vuelo" class="col-md-1 col-form-label text-right">Vuelo Ida</label>
                                                            <div class="col-md-2">
                                                                <input type="text" name="vuelo" class="form-control" v-model="pasaje.vuelo"
                                                                        id="vuelo" placeholder="Vuelo :122344">
                                                                <small class="text-danger" v-for="error in errores.vuelo">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" v-if="hora_regreso">
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label for="ruta_vuelta" class="col-md-1 col-form-label">Ruta Ret.</label>
                                                            <div class="col-md-2">
                                                                <input type="text" name="ruta" class="form-control" v-model="pasaje.ruta_vuelta"
                                                                        id="name_factura" placeholder="(IQT/(LIM)">
                                                                <small class="text-danger" v-for="error in errores.ruta_vuelta">@{{ error }}</small>
                                                            </div>
                                                            <label for="fecha_retorno" class="col-md-1 col-form-label">Fec. Ret.</label>
                                                            <div class="col-md-2" title="Fecha de Retorno">
                                                                <input type="date" name="fecha_retorno" class="form-control" v-model="pasaje.fecha_retorno"
                                                                        id="fecha_vuelo" placeholder="Fecha: 08 NOV">
                                                                        <small class="text-danger" v-for="error in errores.fecha_vuelo">@{{ error }}</small>
                                                            </div>
                                                            <label for="hora_vuelta" class="col-md-1 col-form-label">Hora Ret.</label>
                                                            <div class="col-md-1">
                                                                <input type="text" name="hora_vuelta" class="form-control" v-model="pasaje.hora_vuelta"
                                                                        id="hora_vuelta" placeholder="16:30">
                                                                <small class="text-danger" v-for="error in errores.hora_vuelta">@{{ error }}</small>
                                                            </div>
                                                            <label for="vuelo" class="col-md-1 col-form-label">Vuelo Rt.</label>
                                                            <div class="col-md-2">
                                                                <input type="text" name="vuelo_vuelta" class="form-control" v-model="pasaje.vuelo_vuelta"
                                                                        id="vuelo_vuelta" placeholder="Vuelo Retorno">
                                                                <small class="text-danger" v-for="error in errores.vuelo_vuelta">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label for="ruta" class="col-md-1 col-form-label">CL IDA</label>
                                                            <div class="col-md-2">
                                                                <input type="text" name="cl" class="form-control" v-model="pasaje.cl"
                                                                        id="cl" placeholder="CL: R">
                                                                <small class="text-danger" v-for="error in errores.cl">@{{ error }}</small>
                                                            </div>
                                                            <label for="equipaje" class="col-md-1 col-form-label">Equipaje</label>
                                                            <div class="col-md-2">
                                                                <input type="text" name="equipaje" class="form-control" v-model="pasaje.equipaje"
                                                                        id="equipaje" placeholder="EQ:10K" title="Equipaje Ida">
                                                                <small class="text-danger" v-for="error in errores.equipaje">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                 <div class="row" v-if="hora_regreso">
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label for="cl_vuelta" class="col-md-1 col-form-label">CL Ret.</label>
                                                            <div class="col-md-2">
                                                                <input type="text" name="cl_vuelta" class="form-control" v-model="pasaje.cl_vuelta"
                                                                        id="cl_vuelta" placeholder="CL: N">
                                                                <small class="text-danger" v-for="error in errores.cl_vuelta">@{{ error }}</small>
                                                            </div>
                                                            <label for="equipaje_vuelta" class="col-md-1 col-form-label">EQU Ret.</label>
                                                            <div class="col-md-2">
                                                                <input type="text" name="equipaje_vuelta" class="form-control" v-model="pasaje.equipaje_vuelta"
                                                                        id="equipaje_vuelta" placeholder="EQ:10K" title="Equipaje Vuelta">
                                                                <small class="text-danger" v-for="error in errores.equipaje_vuelta">@{{ error }}</small>
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
                                                            <label for="moneda" class="col-md-3 col-form-label">Monto Neto</label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="monto_neto" id="monto_neto" v-model="pasaje.monto_neto"
                                                                    class="form-control" placeholder="Monto" @change="">
                                                                <small class="text-danger" v-for="error in errores.monto_neto">@{{ error }}</small>
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
                                                        <div class="form-group row">
                                                            <label for="pago_soles" class="col-md-3 col-form-label">Pago Soles S/ </label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="pago_soles" id="pago_soles" v-model="pasaje.pago_soles"
                                                                    class="form-control" placeholder="Pago Soles">
                                                                <small class="text-danger" v-for="error in errores.pago_soles">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="pago_dolares" class="col-md-3 col-form-label">Pago Dolares $ </label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="pago_dolares" id="pago_dolares" v-model="pasaje.pago_dolares"
                                                                    class="form-control" placeholder="Pago Dólares">
                                                                <small class="text-danger" v-for="error in errores.pago_dolares">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="pago_visa" class="col-md-3 col-form-label">Pago Visa $ </label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="pago_visa" id="pago_visa" v-model="pasaje.pago_visa"
                                                                    class="form-control" placeholder="Pago Visa">
                                                                <small class="text-danger" v-for="error in errores.pago_visa">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="deposito_soles" class="col-md-3 col-form-label">Dep&oacute;sito Soles </label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="deposito_soles" id="deposito_soles" v-model="pasaje.deposito_soles"
                                                                    class="form-control" placeholder="Déposito Soles">
                                                                <small class="text-danger" v-for="error in errores.deposito_soles">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="deposito_dolares" class="col-md-3 col-form-label">Dep&oacute;s. Dolares </label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="deposito_dolares" id="deposito_dolares" v-model="pasaje.deposito_dolares"
                                                                    class="form-control" placeholder="Depósito Dolares">
                                                                <small class="text-danger" v-for="error in errores.deposito_dolares">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label for="tarifa" class="col-md-4 col-form-label">Air Fare/Tarifa Neta</label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="tarifa" id="tarifa" v-model="pasaje.tarifa"
                                                                    class="form-control" placeholder="Tarifa" @change="">
                                                                <small class="text-danger" v-for="error in errores.tarifa">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="tax" class="col-md-3 col-form-label">Tax/TUAA</label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="tax" id="tax" v-model="pasaje.tax"
                                                                    class="form-control" placeholder="Tax / TUAA" @change="">
                                                                <small class="text-danger" v-for="error in errores.tax">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="igv" class="col-md-3 col-form-label">I.G.V.:</label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="igv" id="igv" v-model="pasaje.igv"
                                                                    class="form-control" placeholder="Impuesto / IGV"  @change="calcularTotal" >
                                                                <small class="text-danger" v-for="error in errores.igv">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="service_fee" class="col-md-3 col-form-label">Service FEE</label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="service_fee" id="service_fee" v-model="pasaje.service_fee"
                                                                    class="form-control" placeholder="Service FEE" disabled>
                                                                <small class="text-danger" v-for="error in errores.service_fee">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                        <!--<div class="form-group row">
                                                            <label for="sub_total" class="col-md-3 col-form-label">Sub Total</label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="sub_total" id="sub_total" v-model="pasaje.sub_total"
                                                                    class="form-control" placeholder="Sub Total" readonly >
                                                                <small class="text-danger" v-for="error in errores.sub_total">@{{ error }}</small>
                                                            </div>
                                                        </div>-->
                                                        <div class="form-group row">
                                                            <label for="total" class="col-md-3 col-form-label">TOTAL PAGO</label>
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
                                <div class="row" v-if="pasaje.tipo_pasaje == 'Deuda'">
                                    <div class="col-md-12">
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h3 class="card-title">Detalle Deudas</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label for="moneda" class="col-md-1 col-form-label">Deuda</label>
                                                            <div class="col-md-2">
                                                                <select name="moneda" class="form-control" v-model="pasaje.deuda" @change="seleccionarDeuda">
                                                                    <option value="">-Deuda-</option>
                                                                    <option value="essalud">Es-Salud</option>
                                                                    <option value="otro">Otros</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control form-control-sm"
                                                                        v-model="pasaje.deuda_detalle" id="detalle" title="Detalle Otros"
                                                                        placeholder="Descripción deuda">
                                                                <small class="text-danger" v-for="error in errores.deuda_detalle">@{{ error }}</small>
                                                            </div>
                                                            <label for="moneda" class="col-md-1 col-form-label text-right">Monto $</label>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control form-control-sm"
                                                                        v-model="pasaje.deuda_monto" title="Monto Dolares"
                                                                        placeholder="Monto Deuda">
                                                                <small class="text-danger" v-for="error in errores.deuda_monto">@{{ error }}</small>
                                                            </div>
                                                            <label for="moneda" class="col-md-1 col-form-label text-right">Pago S/</label>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control form-control-sm"
                                                                        v-model="pasaje.deuda_soles" title="Pago Soles"
                                                                        placeholder="Pago S/">
                                                                <small class="text-danger" v-for="error in errores.deuda_soles">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="moneda" class="col-md-1 col-form-label text-right">Pago US$</label>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control form-control-sm"
                                                                        v-model="pasaje.deuda_dolares" title="Pago Dolares"
                                                                        placeholder="Pago US$">
                                                                <small class="text-danger" v-for="error in errores.deuda_dolares">@{{ error }}</small>
                                                            </div>
                                                            <label for="moneda" class="col-md-1 col-form-label text-right">Pago Visa</label>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control form-control-sm"
                                                                        v-model="pasaje.deuda_visa" title="Pago Visa"
                                                                        placeholder="Pago US$">
                                                                <small class="text-danger" v-for="error in errores.deuda_visa">@{{ error }}</small>
                                                            </div>
                                                            <label for="moneda" class="col-md-1 col-form-label text-right">Depo S/</label>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control form-control-sm"
                                                                        v-model="pasaje.deuda_depo_soles" title="Deuda Depósito Soles"
                                                                        placeholder="Depo S/">
                                                                <small class="text-danger" v-for="error in errores.deuda_depo_soles">@{{ error }}</small>
                                                            </div>
                                                            <label for="moneda" class="col-md-1 col-form-label text-right">Depo US$</label>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control form-control-sm"
                                                                        v-model="pasaje.deuda_depo_dolares" title="Deuda Depóstio Dolares"
                                                                        placeholder="Depo US$">
                                                                <small class="text-danger" v-for="error in errores.deuda_depo_dolares">@{{ error }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="row"  v-if="pasaje.tipo_pasaje == 'Adicional'">
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
                                                            @change="filtroPorIdAdicional">
                                                            <option value="">-Adicionales.-</option>
                                                            <option v-for="adic in adicionales" :key="adic.id" :value="adic.id">
                                                                @{{adic.descripcion}}
                                                            </option>
                                                        </select>
                                                        <small class="text-danger" v-for="error in errores.adicional_id">@{{ error }}</small>
                                                        <input type="text" class="form-control form-control-sm"
                                                                v-model="adicional.detalle" id="detalle" title="Detalle Otros"
                                                                placeholder="Detalle Descripción">
                                                        <small class="text-danger" v-for="error in errores.detalle">@{{ error }}</small>
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
                                                                    <tr v-if="pasaje.opcional.adicionales.length==0">
                                                                        <td colspan="5" class="text-danger text-center">--Datos No Añadidos--</td>
                                                                    </tr>
                                                                    <tr v-else v-for="(adic,index) in pasaje.opcional.adicionales">
                                                                        <td><button type="button" class="btn btn-danger btn-sm" @click="eliminarAdicional(index)"><i class="fas fa-trash"></i></button></td>
                                                                        <td>@{{adic.adicional_id}}</td>
                                                                        <td>@{{adic.detalle }}</td>
                                                                        <td>@{{adic.monto.toFixed(2)}}</td>
                                                                        <td>@{{adic.service_fee.toFixed(2)}}</td>
                                                                        <td>@{{adic.importe.toFixed(2)}}</td>
                                                                    </tr>
                                                                    <tr v-if="pasaje.opcional.adicionales.length>0">
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
                                                                                <input type="text" name="monto_pagar" id="monto_pagar" v-model="pasaje.opcional.monto_pagar"
                                                                                    class="form-control" placeholder="Monto" value='0.00' @change="calcularTotal" readonly >
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <select name="moneda" class="form-control" v-model="pasaje.opcional.moneda">
                                                                                    <option value="USD">D&oacute;lares</option>
                                                                                </select>
                                                                                <small class="text-danger" v-for="error in errores.moneda">@{{ error }}</small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="moneda" class="col-md-3 col-form-label">Tipo Cambio</label>
                                                                            <div class="col-md-6">
                                                                                <input type="text" name="cambio" id="cambio" v-model="pasaje.opcional.cambio"
                                                                                    class="form-control" placeholder="Tipo cambio: 3.56" value='0.00'>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="pago_soles" class="col-md-4 col-form-label">Pago Soles</label>
                                                                            <div class="col-md-6">
                                                                                <input type="text" name="pago_soles" id="pago_soles" v-model="pasaje.opcional.pago_soles"
                                                                                    class="form-control" placeholder="Pago Soles (S/)">
                                                                                <small class="text-danger" v-for="error in errores.pago_soles">@{{ error }}</small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="pago_dolares" class="col-md-4 col-form-label">Pago Dolares</label>
                                                                            <div class="col-md-6">
                                                                                <input type="text" name="pago_dolares" id="pago_dolares" v-model="pasaje.opcional.pago_dolares"
                                                                                    class="form-control" placeholder="Pago Soles (USD$)">
                                                                                <small class="text-danger" v-for="error in errores.pago_dolares">@{{ error }}</small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="pago_visa" class="col-md-4 col-form-label">Pago Visa</label>
                                                                            <div class="col-md-6">
                                                                                <input type="text" name="pago_visa" id="pago_visa" v-model="pasaje.opcional.pago_visa"
                                                                                    class="form-control" placeholder="Pago Visa">
                                                                                <small class="text-danger" v-for="error in errores.pago_visa">@{{ error }}</small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="deposito_soles" class="col-md-4 col-form-label">Dep&oacute;sito Soles</label>
                                                                            <div class="col-md-6">
                                                                                <input type="text" name="deposito_soles" id="deposito_soles" v-model="pasaje.opcional.deposito_soles"
                                                                                    class="form-control" placeholder="Pago Visa">
                                                                                <small class="text-danger" v-for="error in errores.deposito_soles">@{{ error }}</small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="deposito_dolares" class="col-md-4 col-form-label">Dep&oacute;sito Dolares</label>
                                                                            <div class="col-md-6">
                                                                                <input type="text" name="deposito_dolares" id="deposito_dolares" v-model="pasaje.opcional.deposito_dolares"
                                                                                    class="form-control" placeholder="Pago Visa">
                                                                                <small class="text-danger" v-for="error in errores.deposito_dolares">@{{ error }}</small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group row">
                                                                            <label for="sub_total" class="col-md-3 col-form-label">Sub Total</label>
                                                                            <div class="col-md-6">
                                                                                <input type="text" name="sub_total" id="sub_total" v-model="pasaje.opcional.sub_total"
                                                                                    class="form-control" placeholder="Sub Total" readonly  >
                                                                                <small class="text-danger" v-for="error in errores.sub_total">@{{ error }}</small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="igv" class="col-md-3 col-form-label">I.G.V.:</label>
                                                                            <div class="col-md-6">
                                                                                <input type="text" name="igv" id="igv" v-model="pasaje.opcional.igv"
                                                                                    class="form-control" placeholder="0.00"  @change="calcularTotalAdicional" >
                                                                                <small class="text-danger" v-for="error in errores.igv">@{{ error }}</small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="total" class="col-md-3 col-form-label">TOTAL</label>
                                                                            <div class="col-md-6">
                                                                                <input type="text" name="total" id="total" v-model="pasaje.opcional.total"
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
