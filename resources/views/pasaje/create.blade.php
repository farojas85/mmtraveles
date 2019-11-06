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
                            </h3>
                        </div>
                        <div class="card-body">
                            <form  class="form-horizontal" role="form">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label for="inputEmail1" class="col-md-2 control-label">PASAJERO</label>
                                                    <div class="col-md-10">
                                                        <input type="text" name="pasajero" class="form-control" id="pasajero"
                                                               v-model="pasaje.pasajero" placeholder="Nombre pasajero: (RAMIREZ/HECTOR) ">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label for="inputEmail1" class="col-md-2 control-label">CODIGO</label>
                                                    <div class="col-md-10">
                                                        <input type="text" name="viajecode" id="product_code" v-model="pasaje.codigo"
                                                                class="form-control" id="viajecode" placeholder="Codigo de Viaje: (TNJEUV)">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <img v-for="emp in empresa" :src="emp.foto" height="100">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col md-8">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label for="inputEmail1" class="col-md-2 control-label">RUTA</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="ruta" class="form-control" v-model="pasaje.ruta"
                                                                id="name_factura" placeholder="Ruta: (IQT-LIM) (IQT-LIM-IQT)">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <select name="tipo_viaje" class="form-control" v-model="pasaje.tipo_viaje">
                                                            <option value="1">IDA</option>
                                                            <option value="2">IDA Y VUELTA</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label for="inputEmail1" class="col-md-3 control-label">Exonerado del IGV</label>
                                                    <div class="col-md-6">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="not_igv" v-model="pasaje.not_igv">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <img :src="logo_linea"  height="100" width='220'>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="inputEmail1" class="col-md-2 control-label">L&Iacute;NEA A&Eacute;REA</label>
                                            <div class="col-md-6">
                                                <select name="aerolinea_id" class="form-control" v-model="pasaje.aerolinea_id"
                                                    @change="seleccionarImage">
                                                    <option value="">-SELECCIONAR-</option>
                                                    <option v-for="aero in aerolineas" :key="aero.id" :value="aero.id">
                                                        @{{aero.name}}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="internacional" class="col-md-2 control-label">PORCENTAJE</label>
                                            <div class="col-md-6">
                                                <select name="internacional" class="form-control">
                                                    <option value="0">NINGUNO</option>
                                                    <option value="1">1 %</option>
                                                    <option value="2">2 %</option>
                                                    <option value="3">3 %</option>
                                                    <option value="4">4 %</option>
                                                    <option value="5">5 %</option>
                                                    <option value="6">6 %</option>
                                                    <option value="7">7 %</option>
                                                    <option value="8">8 %</option>
                                                    <option value="9">9 %</option>
                                                    <option value="10">10 %</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="razon_social" class="col-md-2 control-label">RAZ&Oacute;N SOCIAL</label>
                                            <div class="col-md-6">
                                                <input type="text" name="razon_social" class="form-control"
                                                    v-model="pasaje.razon_social" placeholder="Razón Social">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="direccion" class="col-md-2 control-label">DIRECCI&Oacute;N</label>
                                            <div class="col-md-6">
                                                <input type="text" name="direccion"  class="form-control" v-model="pasaje.direccion"
                                                        id="direccion" placeholder="Dirección">
                                            </div>
                                        </div>
                                    </div>
                                </div>-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="pasaje_total" class="col-md-2 control-label">PASAJE TOTAL</label>
                                            <div class="col-md-6">
                                                <input type="text" name="pasaje_total" value="0" class="form-control"
                                                    v-model="pasaje.pasaje_total" placeholder="Pasaje Total">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="monto_neto" class="col-md-2 control-label">MONTO NETO</label>
                                            <div class="col-md-6">
                                                <input type="text" name="monto_neto" value="0" v-model="pasaje.monto_neto"
                                                    class="form-control" id="inputEmail1" placeholder="Monto Neto">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="tuaa" class="col-md-2 control-label">TUAA</label>
                                            <div class="col-md-6">
                                                <input type="text" name="tuaa" value="0" class="form-control"  v-model="pasaje.tuaa"
                                                    placeholder="TUAA">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="pago_soles" class="col-md-2 control-label">PAGO SOLES</label>
                                            <div class="col-md-6">
                                                <input type="text" name="pago_soles" value="0" v-model="pasaje.pago_soles"
                                                        class="form-control" id="pago_soles" placeholder="Pago Soles">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="pago_dolares" class="col-md-2 control-label">PAGO D&Oacute;LARES</label>
                                            <div class="col-md-6">
                                                <input type="text" name="pago_dolares" value="0" v-model="pasaje.pago_dolares"
                                                     class="form-control"  placeholder="Pago Dolares">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="pago_visa" class="col-md-2 control-label">PAGO VISA</label>
                                            <div class="col-md-6">
                                                <input type="text" name="pago_visa" value="0" v-model="pasaje.pago_visa"
                                                     class="form-control"  placeholder="Pago Visa">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="deposito_soles" class="col-md-2 control-label">DEP&Oacute;SITO SOLES</label>
                                            <div class="col-md-6">
                                                <input type="text" name="deposito_soles" value="0" v-model="pasaje.deposito_soles"
                                                        class="form-control" id="deposito_soles" placeholder="Pago Soles">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="deposito_dolares" class="col-md-2 control-label">DEP&Oacute;SITO DOLARES</label>
                                            <div class="col-md-6">
                                                <input type="text" name="deposito_dolares" value="0" v-model="pasaje.deposito_dolares"
                                                        class="form-control" id="deposito_dolares" placeholder="Depósito Dolares">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="telefono" class="col-md-2 control-label">TEL&Eacute;FONO</label>
                                            <div class="col-md-6">
                                                <input type="text" name="telefono" v-model="pasaje.telefono"
                                                        class="form-control" id="telefono" placeholder="Teléfono">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="observaciones" class="col-md-2 control-label">OBSERVACIONES</label>
                                            <div class="col-md-6">
                                                <input type="text" name="observaciones" v-model="pasaje.observaciones"
                                                        class="form-control" id="observaciones" placeholder="OBSERVACIONES">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="def" class="col-md-12">La presente fecha solo se registra si el pasaje es de otro dia</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="created_at_venta" class="col-md-2 control-label">FECHA VENTA</label>
                                            <div class="col-md-6">
                                                <input type="date" name="created_at_venta" v-model="pasaje.fecha_venta"
                                                        class="form-control" id="created_at_venta">
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
