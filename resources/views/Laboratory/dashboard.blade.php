@extends('layouts.appadmin')
@section('content_admin')
<div class="ibox">
    <div class="ibox-head">
        <div class="ibox-title">Muestars</div>
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