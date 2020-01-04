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
            <div class="row">
                @if($role_name =='Administrador' || $role_name == 'Gerente')
                <div class="col-md-6">
                    <div class="card caard-default">
                        <div class="card-header">
                            <h3 class="card-title">
                                Total Pasajes Por Counter
                            </h3>
                        </div>
                        <div class="card-body">
                            <input type="date" class="form-control" id="fecha_dia" onchange="pagadosDia()">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="pieChart" style="height: 300px; min-height: 230px; display: block; width: 488px;" width="488" height="300" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-md-6">
                    <div class="card caard-default">
                        <div class="card-header">
                            <h3 class="card-title">
                                Total pasajes por Aerolinea
                            </h3>
                        </div>
                        <div class="card-body">
                            <input type="date" class="form-control" id="fecha_dia_aero" onchange="aeroDia()">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="pieChartAero" style="height: 300px; min-height: 230px; display: block; width: 488px;" width="488" height="300" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripties')
<script src="js/sistema/home.js"></script>
@endsection
