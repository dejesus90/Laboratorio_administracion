<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laboratorio</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="{{ asset('css/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/themify-icons/css/themify-icons.css') }}" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <link href="{{ asset('js/vendors/jvectormap/jquery-jvectormap-2.0.3.css') }}" rel="stylesheet" />
    <link href="{{ asset('js/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="{{ asset('css/main.min.css') }}" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
    <style>
    .cursor {
        cursor: pointer;
    }
    </style>
</head>

<body class="fixed-navbar">
    <div class="page-wrapper">
        <!-- START HEADER-->
        <header class="header">
            <div class="page-brand">
                <a class="link" href="index.html">
                    <span class="brand">
                        Laboratorio Control
                    </span>
                    <span class="brand-mini">
                        LC
                    </span>
                </a>
            </div>
            <div class="flexbox flex-1">
                <!-- START TOP-LEFT TOOLBAR-->
                <ul class="nav navbar-toolbar">
                    <li>
                        <a class="nav-link sidebar-toggler js-sidebar-toggler"><i class="ti-menu"></i></a>
                    </li>
                </ul>
                <!-- END TOP-LEFT TOOLBAR-->
                <!-- START TOP-RIGHT TOOLBAR-->
                <ul class="nav navbar-toolbar">
                    <li class="dropdown dropdown-user">
                        <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
                            <img src="{{ asset('img/admin-avatar.png') }}" />
                            <span></span>{{Auth::user()->name}}<i class="fa fa-angle-down m-l-5"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#"><i class="fa fa-user"></i>{{Auth::user()->name}}</a>
                            <li class="dropdown-divider"></li>
                            <a class="dropdown-item" href="{{ url('/signout') }}"><i
                                    class="fa fa-power-off"></i>Logout</a>
                        </ul>
                    </li>
                </ul>
                <!-- END TOP-RIGHT TOOLBAR-->
            </div>
        </header>
        <!-- END HEADER-->
        <!-- START SIDEBAR-->
        <nav class="page-sidebar" id="sidebar">
            <div id="sidebar-collapse">
                <div class="admin-block d-flex">
                    <div>
                        <img src="{{ asset('img/admin-avatar.png') }}" width="45px" />
                    </div>
                    <div class="admin-info">
                        <div class="font-strong">{{Auth::user()->name}}</div><small>Administrator</small>
                    </div>
                </div>
                <ul class="side-menu metismenu">
                    <li>
                        <a class="active" href="/dashboard"><i class="sidebar-item-icon fa fa-th-large"></i>
                            <span class="nav-label">Dashboard</span>
                        </a>
                    </li>
                    <li class="heading">Menu</li>
                    @if($mueestrasresumen['usuario'] == 2)
                    <li>
                        <a href="/usuarios">
                            <i class="sidebar-item-icon fa fa-user-o"></i>
                            <span class="nav-label">Usarios</span>
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="/pacientes"><i class="sidebar-item-icon fa fa-address-card-o"></i>
                            <span class="nav-label">Pacientes</span>
                        </a>
                    </li>
                    @if($mueestrasresumen['usuario'] == 2)
                    <li>
                        <a href="/analisis"><i class="sidebar-item-icon fa fa-flask"></i>
                            <span class="nav-label">Examenes</span>
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="/muestras/laboratorio"><i class="sidebar-item-icon fa fa-hourglass-o"></i>
                            <span class="nav-label">En Laboratorio</span>
                        </a>
                    </li>
                    <li>
                        <a href="/muestras/analisis"><i class="sidebar-item-icon fa fa-exclamation-triangle"></i>
                            <span class="nav-label">En Analisis</span>
                        </a>
                    </li>
                    <li>
                        <a href="/muestras/publicados"><i class="sidebar-item-icon fa fa-heart"></i>
                            <span class="nav-label">Publicados</span>
                        </a>
                    </li>

                </ul>
            </div>
        </nav>
        <!-- END SIDEBAR-->
        <div class="content-wrapper">
            <!-- START PAGE CONTENT-->
            <div class="page-content fade-in-up">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-success color-white widget-stat">
                            <div class="ibox-body">
                                <h2 class="m-b-5 font-strong">{{$mueestrasresumen['laboratorio']}}</h2>
                                <div class="m-b-5">En Laboratorio</div><i class="ti-pulse widget-stat-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-info color-white widget-stat">
                            <div class="ibox-body">
                                <h2 class="m-b-5 font-strong">{{$mueestrasresumen['analisis']}}</h2>
                                <div class="m-b-5">En Analisis</div><i class="ti-pulse widget-stat-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-warning color-white widget-stat">
                            <div class="ibox-body">
                                <h2 class="m-b-5 font-strong">{{$mueestrasresumen['publicados']}}</h2>
                                <div class="m-b-5">Publicados</div><i class="ti-pulse widget-stat-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-danger color-white widget-stat">
                            <div class="ibox-body">
                                <h2 class="m-b-5 font-strong">{{$mueestrasresumen['pacientes']}}</h2>
                                <div class="m-b-5">Pacientes</div><i class="ti-user widget-stat-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                @yield('content_admin')
            </div>
            <!-- END PAGE CONTENT-->
            <footer class="page-footer">
                <div class="to-top"><i class="fa fa-angle-double-up"></i></div>
            </footer>
        </div>
    </div>

    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS-->
    <!-- <link href="{{ asset('css/main.min.css') }}" rel="stylesheet" /> -->
    <script src="{{ asset('js/vendors/dist/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vendors/popper.js/dist/umd/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vendors/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vendors/metisMenu/dist/metisMenu.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vendors/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS-->
    <script src="{{ asset('js/vendors/chart.js/dist/Chart.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vendors/jvectormap/jquery-jvectormap-2.0.3.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('js/vendors/jvectormap/jquery-jvectormap-us-aea-en.js') }}" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="{{ asset('js/app.min.js') }}" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script src="{{ asset('js/scripts/dashboard_1_demo.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vendors/DataTables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>