@extends('layouts.appadmin')
@section('content_admin')
<div class="ibox">
    <div class="ibox-head">
        <div class="ibox-title">Muestras</div>
        <div class="btn-group">
            <button class="btn btn-success" data-toggle="modal" data-target="#modalmuestras">Agergar</button>

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
                    <th>Paciente</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($muestras as $muestra)
                <tr>
                    <td>{{ $muestra->id }}</td>
                    <td>{{ $muestra->codigo_muestra }}</td>
                    <td>{{ $muestra->examen->nombre }}</td>
                    <td>{{ $muestra->paciente->nombre1 }} {{ $muestra->paciente->nombre2 }}
                        {{ $muestra->paciente->apellidos }}</td>
                    <td style="text-align:center">
                        <div class="btn-group">
                            <!-- info=lab, warning=analisi, publicado=succes -->
                            @php
                            $class = 'btn-info';
                            switch ($muestra->estadomuestra->id){
                            case 1:
                            $class = 'btn-info';
                            break;
                            case 2:
                            $class = 'btn-warning';
                            break;
                            case 3:
                            $class = 'btn-success';
                            break;
                            }
                            @endphp

                            <button class="btn <?php echo $class ?>">{{ $muestra->estadomuestra->estado }}</button>
                            <button class="btn <?php echo $class ?> dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="false"><i class="fa fa-angle-down"></i></button>
                            <ul class="dropdown-menu" x-placement="bottom-start"
                                style="position: absolute; transform: translate3d(56px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">

                                @foreach($estados as $estado)
                                <li>
                                    <a class="dropdown-item estado" data-id="{{$muestra->id}}"
                                        data-estado="{{$muestra->estado_id}}"
                                        data-item="{{$estado->id}}">{{$estado->estado}}</a>
                                </li>
                                @endforeach
                            </ul>
                            @if($muestra->estado_id == 3)
                            <a style="margin-left:10" class="btn btn-outline-primary" href="{{ url('download/'. $muestra->archivo_adjunto) }}" role="button">Resultado</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- modal resultado -->
    <div class="modal fade" id="modalresult" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Publicar Resultado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="register">
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label>Cargar Archivo</label>
                                <input class="form-control" id="fileresult" name="fileresult" type="file" >
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class=" cursor btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class=" cursor btn btn-primary" id="btn-pub">Publicar</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
<script type="text/javascript">
window.onload = function() {
    var idmuestra = 0;
    $('#example-table').DataTable({
        pageLength: 10,
    });
    
    $(".estado").click(function() {
        console.log($(this).attr('data-id'));
        let estado = $(this).attr('data-estado');
        let item = $(this).attr('data-item');
        if (estado == 1 && item == 3 || estado == 2 && item == 3) {
            idmuestra = $(this).attr('data-id');
            $('#modalresult').modal({
                backdrop: 'static',
                keyboard: false
            })
        }
        if(estado == 1 && item == 2 ){
            // cmbiamos a analisis
            $.ajax({
                // la URL para la petición
                url: '/updateMuestra',
                headers: {
                    "Content-type": "application/json; charset=UTF-8",
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: JSON.stringify({
                    idmuestra: $(this).attr('data-id'),
                    cambiar: item
                }),
                type: 'POST',
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Muestra Actualizada',
                        showConfirmButton: true,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    })
                }
            });
        }
        console.log(estado, item);
    });

    $("#btn-pub").click(function() {
        let that = this;
        var formData = new FormData();
        let files = $('#fileresult')[0].files;
        if(files.length == 0){
            return;
        }
        // add assoc key values, this will be posts values
        formData.append("file", files[0]);
        formData.append("idmuestra", idmuestra);
        console.log(formData);
        $.ajax({
            // la URL para la petición
            url: '/publicarMuestra',
            headers: {
                // "Content-type": "application/json; charset=UTF-8",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            type: 'POST',
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Muestra Actualizada',
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
    



}
</script>