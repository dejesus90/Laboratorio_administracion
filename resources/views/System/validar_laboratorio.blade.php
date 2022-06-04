@extends('layouts.approot')
@section('content_root')
<div class="ibox">
    <div class="ibox-head">
        <div class="ibox-title">Validar Laboratorio</div>
        <div class="btn-group">
            <button class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i
                    class="fa fa-cogs"></i> Acciones <i class="fa fa-angle-down"></i></button>
            <ul class="dropdown-menu" x-placement="bottom-start"
                style="position: absolute; transform: translate3d(0px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
                <li>
                    <a class="dropdown-item" onclick="activarLab()">Activar</a>
                </li>
                <li>
                    <a class="dropdown-item" href="javascript:;">Desactivar</a>
                </li>
            </ul>
        </div>
        <input class="form-control" id="lab" type="hidden" value="{{$datalab->id}}">
        @csrf
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Informacion Usuario</div>

            </div>
            <div class="ibox-body">
                <form>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label>Nombre</label>
                            <input class="form-control" id="nombre" type="text" placeholder="Nombre"
                                value="{{$datalab->infousuario->nombre}}">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label>Apellidos</label>
                            <input class="form-control" type="text" placeholder="Apellidos"
                                value="{{$datalab->infousuario->apellidos}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" type="text" placeholder="Email address"
                            value="{{$datalab->infousuario->email}}">
                    </div>
                    <div class="form-group">
                        <label>Cedula</label>
                        <input class="form-control" type="text" placeholder="Cedula"
                            value="{{$datalab->infousuario->cedula}}">
                    </div>
                    <div class="form-group">
                        <label>Cargo</label>
                        <input class="form-control" type="text" placeholder="Cargo"
                            value="{{$datalab->infousuario->cargo}}">
                    </div>

                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Informacion Laboratorio</div>

                    </div>
                    <div class="ibox-body">
                        <form>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Laboratorio</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" placeholder="Laboratorio"
                                        value="{{$datalab->nombre}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Direccion</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" placeholder="Direccion"
                                        value="{{$datalab->direccion}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label>Telefono</label>
                                    <input class="form-control" type="text" placeholder="Telefono"
                                        value="{{$datalab->telefono}}">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label>RUT</label>
                                    <input class="form-control" type="text" placeholder="RUT" value="{{$datalab->rut}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label>Pais</label>
                                    <select id="pais" name="pais" class="form-control">
                                        <option value="{{$datalab->paisLab->id}}">{{$datalab->paisLab->pais}}</option>
                                    </select>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label>Estado</label>
                                    <select id="pais" name="pais" class="form-control" onchange="filterEstado()">
                                        @foreach ($datalab->paisLab->estados as $estado)
                                        @if($estado->id == $datalab->estado_id)
                                        <option value="{{$estado->id}}">{{$estado->estado}}</option>
                                        @endif

                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Documentos Laboratorio</div>
                    </div>
                    <div class="ibox-body">
                        <div>
                        <img src="{{ asset('img/logos/'.$datalab->logotipo) }}" class="img img-thumbnail">
                        </div>
                        <ul class="list-group list-group-full">
                            <li class="list-group-item active"> <a style="margin-left:10" class="btn btn-outline-primary" href="{{ url('download-file/1/'. $datalab->file_rut) }}" role="button"><i class="fa fa-download"></i> Documento RUT</a></li>
                            <li class="list-group-item active"> <a style="margin-left:10" class="btn btn-outline-primary" href="{{ url('download-file/2/'. $datalab->file_comercio) }}" role="button"><i class="fa fa-download"></i> Documento Camara Comercio</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    // document.addEventListener("DOMContentLoaded", function(event) {
    //código a ejecutar cuando el DOM está listo para recibir acciones
    // console.log($("#lab").val());
    async function activarLab (){
        await fetch('/activarlaboratorio', {
            method: "POST",
            body: JSON.stringify({id:$("#lab").val()}),
            headers: {
                "Content-type": "application/json; charset=UTF-8",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .then(
            response => response.json()
            // console.log(response);
            
        ) 
        .then(
            json => console.log(json)
            
        )
        .catch(err => console.log(err));
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Laboratorio Activado',
            showConfirmButton: false,
            timer: 1500
            })
    }
    

    // });
</script>