@extends('layouts.appadmin')
@section('content_admin')

<div class="ibox">
    <div class="ibox-head">
        <div class="ibox-title">Pacientes</div>
        <div class="btn-group">
            <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Agregar</button>

        </div>
    </div>
    <div class="ibox-body">
        <table class="table table-striped table-bordered table-hover table-responsive" id="example-table"
            cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <th>Cedula</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pacientes as $paciente)
                <tr>
                    <td>{{ $paciente->id }}</td>
                    <td>{{ $paciente->nombre1 }} {{ $paciente->nombre2 }} {{ $paciente->apellidos }}</td>
                    <td>{{ $paciente->email }}</td>
                    <td>{{ $paciente->telefono }}</td>
                    <td>{{ $paciente->cedula }}</td>
                    <td style="text-align:center">
                        <button class="btn btn-outline-danger btn-sm">Eliminar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- modal paciente -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar Paciente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="register">
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="inputState">Tipo de identificacion</label>
                                <select id="tipoide" name="tipoide" class="form-control">
                                    <option value="1" selected>RUT</option>
                                    <option value="2" >Pasaporte</option>
                                    <option value="3" >DNI</option>
                                </select>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label>Cedula</label>
                                <input class="form-control" id="cedula" name="cedula" type="text" placeholder="Cedula">
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-sm-4 form-group">
                                <label>Primer Nombre *</label>
                                <input class="form-control" id="name1"  name="name1" type="text" placeholder="Primer nombre">
                            </div>
                            <div class="col-sm-4 form-group">
                                <label>Segundo nombre</label>
                                <input class="form-control" id="name2" name="name2" type="text" placeholder="Segundo nombre">
                            </div>
                            <div class="col-sm-4 form-group">
                                <label>Apellidos *</label>
                                <input class="form-control" id="apellidos" require name="apellidos" type="text" placeholder="Apellidos">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label>Email *</label>
                                <input class="form-control" id="email" require name="email" type="email" placeholder="Email address">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label>Telefono *</label>
                                <input class="form-control" id="telefono" require name="telefono" type="text" placeholder="Telefono">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="inputState">Examen a realizar</label>
                                <select id="analisis" name="analisis" class="form-control">
                                    <option value="0" selected>Selecciona</option>
                                    @foreach($mueestrasresumen['examenes'] as $examen)
                                    <option value="{{$examen->id}}" >{{$examen->nombre}} ({{$examen->codigo}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <input class="form-control" id="nuevo" name="nuevo" type="hidden" value="0" >
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class=" cursor btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class=" cursor btn btn-primary" id="btn-save">Registrar</button>
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
        let form = $('form#register').serializeArray();
        // console.log(form);
        if ($("#name1").val().trim() == '') {
            mensajealerta('Agregar el nombre','alerta','warning')
            return
        }
        if ($("#apellidos").val().trim() == '') {
            mensajealerta('Agregar apellidos','alerta','warning')
            return
        }
        if ($("#email").val().trim() == '') {
            mensajealerta('Agregar correo','alerta','warning')
            return
        }
        if ( $("#cedula").val() == '') {
            mensajealerta('Agregar Cedula','alerta','warning')
            return
        }
        if ( $("#analisis").val() == 0) {
            mensajealerta('Selecciona Analisis','alerta','warning')
            return
        }
        // json
        let datas = {
            tipoide: $("#tipoide").val(),
            nombre1: $("#name1").val().trim(),
            nombre2: $("#name2").val().trim(),
            apellidos:  $("#apellidos").val().trim(),
            email:  $("#email").val().trim(),
            // password:  $("#password").val().trim(),
            telefono: $("#telefono").val().trim(),
            cedula: $("#cedula").val().trim(),
            analisis: $("#analisis").val(),
            nuevo: $("#nuevo").val().trim(),

        }
        // 
        $( "#btn-save" ).attr('disabled',true);
        $.ajax({
            // la URL para la petición
            url : '/registrarPaciente',
            headers: {
                "Content-type": "application/json; charset=UTF-8",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            // la información a enviar
            // (también es posible utilizar una cadena de datos)
            data : JSON.stringify({ datas:datas }),
            // especifica si será una petición POST o GET
            type : 'POST',
            // el tipo de información que se espera de respuesta
            // dataType : 'json',
            // código a ejecutar si la petición es satisfactoria;
            // la respuesta es pasada como argumento a la función
            success : function(json) {
                $("#btn-save").attr('disabled',false);
                $("#nuevo").val(0);
                $("#exampleModal").modal('hide');
            }
        });
    });
    $("#cedula").focusout(function(){
        let valor =  $(this).val().trim();
        let tipoide = $("#tipoide").val();
        if(valor != ''){
            $.ajax({
                url : '/buscarPaciente',
                headers: {
                    "Content-type": "application/json; charset=UTF-8",
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // la información a enviar
                data : JSON.stringify({ tipoide:tipoide,cedula:valor }),
                dataType : 'json',
                type : 'POST',
                success : function(response) {
                    console.log(response);
                    if(response.data){
                        $("#nuevo").val(response.data.id);
                        $("#name1").val(response.data.nombre1);
                        $("#name2").val(response.data.nombre2);
                        $("#apellidos").val(response.data.apellidos);
                        $("#email").val(response.data.email);
                        $("#telefono").val(response.data.telefono);
                    }
                }
            });
        }
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