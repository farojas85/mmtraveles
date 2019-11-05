<!DOCTYPE html>
<html>

<head>
    @include('layouts.partials.header')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper" id="wrapper">
        <!-- Navbar -->
        @include('layouts.partials.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.partials.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('contenido')
        </div>
        <!-- /.content-wrapper -->
        @include('layouts.partials.footer')

        <!-- Control Sidebar -->
        @include('layouts.partials.rightbar')
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    @include('layouts.partials.footer-scripts')
</body>

</html>
