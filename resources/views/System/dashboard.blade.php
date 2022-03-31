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
                @foreach($data as $laboratorio)
                <tr>
                    <td>{{ $laboratorio->id }}</td>
                    <td>{{ $laboratorio->nombre }}</td>
                    <td>{{ $laboratorio->direccion }}</td>
                    <td>{{ $laboratorio->rut }}</td>
                    <td>{{ $laboratorio->paisLab->pais }}</td>
                    <td style="text-align:center">
                        <a class="btn btn-outline-success btn-sm" role="button" href="{{ url('/validar-laboratorio/'.$laboratorio->id) }}">Validar</a>
                        <button class="btn btn-outline-warning btn-sm rechazar" data-id="{{$laboratorio->id}}" >Rechazar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- modal rechazo -->
    <div class="modal fade" id="modalrechazo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Rechazar Registro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="register">
                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <label>Motivo Rechazo</label>
                                <textarea class="form-control" id="rechazo" name="rechazo" rows="12" ></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class=" cursor btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class=" cursor btn btn-primary" id="btn-save">Enviar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script type="text/javascript">
window.onload = function() {
    var idlab = 0;
    $('#example-table').DataTable({
        pageLength: 10,
    });
    $(".rechazar").click(function(){
        idlab =  $(this).attr('data-id')
        $('#modalrechazo').modal({
            backdrop: 'static',
            keyboard: false
        })
    });
    $("#btn-save").click(function(){
        if($("#rechazo").val().trim() == ''){

        }
        $.ajax({
            // la URL para la petición
            url: '/rechazarMuestra',
            headers: {
                "Content-type": "application/json; charset=UTF-8",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify({
                idlab: idlab,
                motivo: $("#rechazo").val().trim()
            }),
            type: 'POST',
            success: function(response) {
                console.log(response);
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Laboratorio rechazado',
                    showConfirmButton: true,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        location.reload();
                    }
                })
            }
        });
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