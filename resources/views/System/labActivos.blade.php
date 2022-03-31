@extends('layouts.approot')
@section('content_root')
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="ibox bg-success color-white widget-stat">
            <div class="ibox-body">
                <h2 class="m-b-5 font-strong">{{count($activos)}}</h2>
                <div class="m-b-5">Activos</div><i class="ti-bar-chart widget-stat-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="ibox bg-info color-white widget-stat">
            <div class="ibox-body">
                <h2 class="m-b-5 font-strong">{{count($data)}}</h2>
                <div class="m-b-5">Pendientes</div><i class="ti-bar-chart widget-stat-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="ibox bg-warning color-white widget-stat">
            <div class="ibox-body">
                <h2 class="m-b-5 font-strong">{{count($rechazados)}}</h2>
                <div class="m-b-5">Rechazados</div><i class="ti-bar-chart widget-stat-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="ibox bg-danger color-white widget-stat">
            <div class="ibox-body">
                <h2 class="m-b-5 font-strong">{{count($activos) + count($data) + count($rechazados)}}</h2>
                <div class="m-b-5">Total</div><i class="ti-bar-chart widget-stat-icon"></i>
            </div>
        </div>
    </div>
</div>
<div class="ibox">
    <div class="ibox-head">
        <div class="ibox-title">Solicitudes Pendientes</div>
    </div>
    <div class="ibox-body">
        <table class="table table-striped table-bordered table-hover table-responsive" id="example-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Direccion</th>
                    <th>RUT</th>
                    <th>Pais</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activos as $laboratorio)
                <tr>
                    <td>{{ $laboratorio->id }}</td>
                    <td>{{ $laboratorio->nombre }}</td>
                    <td>{{ $laboratorio->direccion }}</td>
                    <td>{{ $laboratorio->rut }}</td>
                    <td>{{ $laboratorio->paisLab->pais }}</td>
                    <td style="text-align:center">
                        <button class="btn btn-outline-danger btn-sm">Desactivar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
<script type="text/javascript">
window.onload = function() {
    // $(function() {
    $('#example-table').DataTable({
        pageLength: 10,
        //"ajax": './assets/demo/data/table_data.json',
        /*"columns": [
            { "data": "name" },
            { "data": "office" },
            { "data": "extn" },
            { "data": "start_date" },
            { "data": "salary" }
        ]*/
    });
    // })
}
</script>