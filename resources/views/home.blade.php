@extends('layouts.master')

@section('estilos')
@endsection

@section('contenido')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Bienvenidos al Sistema M & M Travel</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Inicio</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <input type="hidden" id="role_name_name" value="{{$role_name}}" >
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$aerolinea_count}}</h3>

                            <p>AeroL&iacute;neas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-plane"></i>
                        </div>
                        <a href="aerolinea" class="small-box-footer">M&aacute;s Informaci&oacute;n<i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{$user_count}}</h3>
                            <p>Usuarios</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            <!--M&aacute;s Informaci&oacute;n-->
                            <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            @if($role_name =='Administrador' || $role_name == 'Gerente' || $role_name == 'Responsable')
            <div class="row">
                <div class="col-md-6">
                    <div class="card caard-default">
                        <div class="card-header">
                            <h3 class="card-title">
                                Total Pasajes Por Counter
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <label for="" class="col-md-3 col-form-label text-right">Fecha Inicio</label>
                                <div class="col-md-8">
                                    <input type="date" class="form-control" id="fecha_dia_ini" onchange="">
                                </div>
                            </div>
                            <div class="row">
                                <label for="" class="col-md-3 col-form-label text-right">Fecha Final</label>
                                <div class="col-md-8">
                                    <input type="date" class="form-control" id="fecha_dia_fin" onchange="pagadosDia()">
                                </div>
                            </div>
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="pieChart" style="height: 300px; min-height: 230px; display: block; width: 488px;" width="488" height="300" class="chartjs-render-monitor"></canvas>
                            <div class="row">
                                <label for="" class="col-md-6">TOTAL</label>
                                <input type="text" class="form-control col-md-6" id="total_counter">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card caard-default">
                        <div class="card-header">
                            <h3 class="card-title">
                                Total pasajes por Aerolinea
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <label for="" class="col-md-3 col-form-label text-right">Fecha Inicio</label>
                                <div class="col-md-8">
                                    <input type="date" class="form-control" id="fecha_dia_aero_ini" onchange="">
                                </div>
                            </div>
                            <div class="row">
                                <label for="" class="col-md-3 col-form-label text-right">Fecha Final</label>
                                <div class="col-md-8">
                                    <input type="date" class="form-control" id="fecha_dia_aero_fin" onchange="aeroDia()">
                                </div>
                            </div>
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="pieChartAero" style="height: 300px; min-height: 230px; display: block; width: 488px;" width="488" height="300" class="chartjs-render-monitor"></canvas>
                            <div class="row">
                                <label for="" class="col-md-6">TOTAL</label>
                                <input type="text" class="form-control col-md-6" id="total_aero">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-md-12" id="resumen-tabla">

                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripties')
<script src="js/sistema/home.js"></script>
@endsection
