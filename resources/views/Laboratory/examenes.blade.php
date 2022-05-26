@extends('layouts.appadmin')
@section('content_admin')
<div class="ibox">
    <div class="ibox-head">
        <div class="ibox-title">Pacientes</div>
        <div class="btn-group">
            <button class="btn btn-success" data-toggle="modal" data-target="#modalExamen">Agregar</button>

        </div>
    </div>
    <div class="ibox-body">
        <table class="table table-striped table-bordered table-hover table-responsive" id="example-table"
            cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Codigo</th>
                    <th>Analisis</th>
                    <th>Dias</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                @foreach($analisis as $analisislab)
                <tr>
                    <td>{{ $analisislab->id }}</td>                    
                    <td>{{ $analisislab->codigo }}</td>
                    <td>{{ $analisislab->nombre }}</td>
                    <td>{{ $analisislab->dias_resultado }}</td>
                    <td style="text-align:center">
                        <button class="btn btn-outline-danger btn-sm">Eliminar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- modal paciente -->
    <div class="modal fade" id="modalExamen" tabindex="-1" aria-labelledby="modalExamenLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar Analisis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="register">
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label>Nombre Analisis*</label>
                                <input class="form-control" id="nombre"  name="nombre" type="text" placeholder="Nombre Analisis">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label>Codigo Analisis</label>
                                <input class="form-control" id="codigo" name="codigo" type="text" placeholder="Codigo Analisis">
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <label>Descripcion Breve</label>
                            <input class="form-control" id="descripcion" require name="descripcion" type="text" placeholder="Descripcion Breve">
                        </div> -->
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label>Dias Resultado</label>
                                <input class="form-control" id="diasres" min="1" require name="diasres" type="number" placeholder="Dias Resultado">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="cursor btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="cursor btn btn-primary" id="btn-save">Registrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script type="text/javascript">
window.onload = function() {
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
    // save
    $( "#btn-save" ).click(function() {
        if ($("#nombre").val().trim() == '') {
            mensajealerta('Agregar el nombre analisis','alerta','warning')
            return
        }
        if ($("#codigo").val().trim() == '') {
            mensajealerta('Agregar codigo de analisis','alerta','warning')
            return
        }
        if ($("#diasres").val().trim() == '') {
            mensajealerta('Agregar dias de resultado','alerta','warning')
            return
        }
        let data = {
            nombre: $("#nombre").val().trim(),
            codigo: $("#codigo").val().trim(),
            // descripcion:  $("#descripcion").val().trim(),
            diasres:  $("#diasres").val().trim(),
        }
        // 
        $.ajax({
            // la URL para la petición
            url : '/registrarExamen',
            headers: {
                "Content-type": "application/json; charset=UTF-8",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            // la información a enviar
            // (también es posible utilizar una cadena de datos)
            data : JSON.stringify({ data:data }),
            // especifica si será una petición POST o GET
            type : 'POST',
            // el tipo de información que se espera de respuesta
            dataType : 'json',
            // código a ejecutar si la petición es satisfactoria;
            // la respuesta es pasada como argumento a la función
            success : function(json) {
                $("#btn-save" ).attr('disabled',false);
                $("#modalExamen").modal('hide');
            }
        });
    });
    function mensajealerta(texto,titulo,tipo) {
        Swal.fire({
            title: titulo,
            text: texto,
            icon: tipo,
            confirmButtonText: 'Acceptar'
        })   
    }
}
</script>