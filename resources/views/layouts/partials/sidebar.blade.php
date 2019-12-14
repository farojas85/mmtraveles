
<aside class="main-sidebar sidebar-light-info elevation-4">
    <!-- Brand Logo -->
    <a href="/home" class="brand-link">
        <img src="images/logo.png" height="26" alt="AdminLTE Logo" class=""
            style="opacity: .8">
        <span class="brand-text font-weight-light"><b>M & M Travel</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="images/user_512.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <b>{{ Auth::user()->name}}</b>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-header">NAVEGACI&Oacute;N</li>
                <li class="nav-item">
                    <a href="/home" class="nav-link {{ Request::is('home')? 'active' :''}}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Inicio</p>
                    </a>
                </li>
                <!-- Add icons to the links using the .nav-icon class
        with font-awesome or any other icon font library -->
                @can('administracion.index')
                <li class="nav-item has-treeview {{ (Request::is('configuraciones') || Request::is('user')) ? 'menu-open' :''}}">
                    <a href="#" class="nav-link {{ (Request::is('configuraciones') || Request::is('user') )? 'active' :''}}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Administraci&oacute;n
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="user" class="nav-link {{ (Request::is('user') )? 'active' :''}}">
                                <i class="far fa-user nav-icon"></i>
                                <p>Usuarios</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="configuraciones" class="nav-link {{ (Request::is('configuraciones') )? 'active' :''}}">
                                <i class="fas fa-users-cog nav-icon"></i>
                                <p>Configuraciones</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan
                @can('extras.index')
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cube"></i>
                        <p>
                            Extras
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-sign-in-alt nav-icon"></i>
                                <p>Entradas de Dinero</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-sign-out-alt nav-icon"></i>
                                <p>Salidas de Dinero</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan
                @can('pagos.index')
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-money-bill-alt"></i>
                        <p>
                            Pagos
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-user-tag nav-icon"></i>
                                <p>Personal</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-tags nav-icon"></i>
                                <p>Pagos Fijos</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan
                @can('pasajes.index')
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-plane-departure"></i>
                        <p>
                            Pasajes
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('pasajes.create')
                        <li class="nav-item">
                            <a href="pasajeCreate" class="nav-link">
                                <i class="fas fa-cart-plus nav-icon"></i>
                                <p>Registrar Pasaje</p>
                            </a>
                        </li>
                        @endcan

                       {{-- @if($role_name=='Gerente' || $role_name=='Administrador' || $role_name=='Responsable') --}}
                       @can('pasajes.comisiones')
                        <li class="nav-item">
                            <a href="pasaje-emitidos" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pasajes Emitidos</p>
                            </a>
                        </li>
                        @endcan
                        {{-- @endif --}}
                        @can('pasajes.depositos')
                        <li class="nav-item">
                            <a href="opcionalesListado" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Adicionales</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('entidad.index')
                <li class="nav-item has-treeview {{  ( Request::is('empresas') || Request::is('aerolinea') || Request::is('locales') || Request::is('ciudad') )? 'menu-open' :''}}">
                    <a href="#" class="nav-link {{  ( Request::is('empresas') || Request::is('aerolinea') || Request::is('locales') || Request::is('ciudad') )? 'active' :''}} ">
                        <i class="nav-icon far fa-building"></i>
                        <p>
                            Entidad
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="empresas" class="nav-link {{ Request::is('empresas') ? 'active' :''}}">
                                <i class="fas fa-hotel nav-icon"></i>
                                <p>Empresas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="locales" class="nav-link {{ Request::is('locales') ? 'active' :''}}">
                                <i class="fas fa-map-marked-alt nav-icon"></i>
                                <p>Locales</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/aerolinea" class="nav-link {{ Request::is('aerolinea') ? 'active' :''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Aerol&iacute;neas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ciudades</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan
                @can('counters.index')
                <li class="nav-item">
                    <a href="home" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Counters</p>
                    </a>
                </li>
                @endcan
                @can('reporte-caja-general.index')
                <li class="nav-header">REPORTES</li>
                <li class="nav-item">
                    <a href="reporte-caja-general" class="nav-link">
                        <i class="nav-icon far fa-file-alt"></i>
                        <p>
                            Reporte Caja General
                        </p>
                    </a>
                </li>
                @endcan
                @can('reporte-plantilla.index')
                <li class="nav-item">
                    <a href="reporte-plantilla" class="nav-link">
                        <i class="nav-icon fas fa-file-excel"></i>
                        <p>
                            Reporte Plantillas
                        </p>
                    </a>
                </li>
                @endcan
                @can('reporte-resumido.index')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-file-alt"></i>
                        <p>
                            Reporte Resumido
                        </p>
                    </a>
                </li>
                @endcan
                @can('reporte-costamar.index')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-file-alt"></i>
                        <p>
                            Reporte COSTAMAR/KIU
                        </p>
                    </a>
                </li>
                @endcan
                @can('reporte-caja-viva.index')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-file-alt"></i>
                        <p>
                            Reporte Caja VIVA
                        </p>
                    </a>
                </li>
                @endcan
                @can('reporte-comisiones-generales.index')
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon far fa-file-alt"></i>
                        <p>
                            R. Comisiones Generales
                        </p>
                    </a>
                </li>
                @endcan
                @can('reporte-comisiones-deudas.index')
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-file-alt"></i>
                        <p>
                            Comisiones y Deudas
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Service FEE Genereal</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>COSTAMAR</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>KIU</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>SABRE</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>VIVA</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan
                @can('reporte-trimestre.index')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-file-alt"></i>
                        <p>
                            Back End KIU Trimestre
                        </p>
                    </a>
                </li>
                @endcan
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
