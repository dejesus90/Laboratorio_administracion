@extends('layouts.appadmin')
@section('content_admin')
<div class="ibox">
    <div class="ibox-head">
        <div class="ibox-title">Usuarios</div>
        <div class="btn-group">
            <button class="btn btn-success" data-toggle="modal" data-target="#modalagregar">Agregar</button>
        </div>
    </div>
    <div class="ibox-body">
        <table class="table table-striped table-bordered table-hover table-responsive" id="example-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Cargo</th>
                    <th>Cedula</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
               @foreach($usuariosLab as $usuarios)
               <tr>
                    <td>{{ $usuarios->id }}</td>                    
                    <td>{{ $usuarios->nombre }} {{ $usuarios->apellidos }}</td>
                    <td>{{ $usuarios->email }}</td>
                    <td>{{ $usuarios->cargo }}</td>
                    <td>{{ $usuarios->cedula }}</td>
                    <td style="text-align:center">
                        <button class="btn btn-outline-danger btn-sm delete cursor" data-id="{{$usuarios->id}}">Eliminar</button>
                    </td>
                </tr>
               @endforeach
            </tbody>
        </table>
    </div>
    <!-- modal paciente -->
    <div class="modal fade" id="modalagregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="register">
                        <div class="row">
                        <div class="col-sm-6 form-group">
                                <label>Nombre *</label>
                                <input class="form-control" id="nombre" name="nombre" type="text" placeholder="Nombre">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label>Apelidos *</label>
                                <input class="form-control" id="apellidos" name="apellidos" type="text" placeholder="Apellidos">
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label>Cedula *</label>
                                <input class="form-control" id="cedula"  name="cedula" type="text" placeholder="Cedula">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label>Cargo *</label>
                                <input class="form-control" id="cargo" name="cargo" type="text" placeholder="Cargo">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label>Correo *</label>
                                <input class="form-control" id="email"  name="email" type="email" placeholder="Correo">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label>Contraseña *</label>
                                <input class="form-control" id="password"  name="password" type="text" placeholder="Contraseña">
                            </div>
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
    });

    $( "#btn-save" ).click(function() {
        let form = $('form#register').serializeArray();
        // console.log(form);
        if ($("#nombre").val().trim() == '') {
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
        if ( $("#password").val() == '') {
            mensajealerta('Agregar Contraseña','alerta','warning')
            return
        }
        // json
        let datas = {
            nombre: $("#nombre").val().trim(),
            apellidos:  $("#apellidos").val().trim(),
            email:  $("#email").val().trim(),
            password:  $("#password").val().trim(),
            cedula: $("#cedula").val().trim(),
            cargo: $("#cargo").val().trim(),

        }
        // 
        $( "#btn-save" ).attr('disabled',true);
        $.ajax({
            // la URL para la petición
            url : '/registrarUsuario',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : datas ,
            type : 'POST',
            success : function(json) {
                $("#btn-save").attr('disabled',false);
                $("#modalagregar").modal('hide');
                location.reload();
            }
        });
    });
    $(".delete").click(function(){
        let ideliminar = $(this).attr('data-id');
        console.log(ideliminar);
        Swal.fire({
            // title: 'Are you sure?',
            text: "Eliminar Usuario del sistema?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, Eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    // la URL para la petición
                    url : '/eliminarUsuario',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data : {id:ideliminar} ,
                    type : 'POST',
                    success : function(json) {
                        console.log(json);
                        // $("#btn-save").attr('disabled',false);
                        // $("#modalagregar").modal('hide');
                        location.reload();
                    }
                }); 
            }
        })
    })
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