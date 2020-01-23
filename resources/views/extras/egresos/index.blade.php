@extends('layouts.master')

@section('contenido')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><i class="far fa-money-bill-alt mr-1"></i> Egresos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Egresos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                               Listado de Egresos
                                <button class="btn btn-primary" @click="nuevoEgreso">
                                <i class="fas fa-plus"></i> Nuevo Egreso
                                </button>
                               <button class="btn btn-info" @click="nuevoPago">
                                <i class="fas fa-plus"></i>   Nuevo Pago
                               </button>
                            </h3>
                        </div>
                        <div class="card-body">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('extras.egresos.pagos')
        @include('extras.egresos.create')
    </section>
@endsection

@section('scripties')
    <script src="js/sistema/egresos.js"></script>
@endsection
