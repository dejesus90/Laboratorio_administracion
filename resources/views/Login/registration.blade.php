@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">

                <div class="card-body">
                    <!-- Formulario de registro -->
                    <form method="POST" enctype="multipart/form-data" action="{{ route('register') }}">
                        @csrf
                        <h4>Datos Solicitante</h4>
                        <hr>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nombre*</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Apellidos*</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Email*</label>
                                <input type="email" class="form-control" id="inputEmail4" name="email" placeholder="Email" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Password*</label>
                                <input type="password" class="form-control" id="inputPassword4" name="password" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Cedula*</label>
                                <input type="text" class="form-control" id="decula" name="cedula" placeholder="Cedula" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Cargo*</label>
                                <input type="text" class="form-control" id="cargo" name="cargo" placeholder="Cargo" required>
                            </div>
                        </div>
                        <h4>Datos Laboratorio</h4>
                        <hr>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Laboratorio*</label>
                                <input type="text" class="form-control" id="laboratorio" name="nombre_laboratorio" placeholder="Laboratorio" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Direccion*</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Direccion">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Telefono*</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono">
                            </div>
                            <div class="form-group col-md-4">
                                <label>RUT*</label>
                                <input type="text" class="form-control" id="rut" name="rut" placeholder="RUT" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Comercio*</label>
                                <input type="text" class="form-control" id="comercio" name="comercio" placeholder="Comercio" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputState">Pais</label>
                                <select id="pais" name="pais" class="form-control" onchange="filterEstado()">
                                    <option value="0" selected>Selecciona</option>
                                    @foreach ($data as $datapais)
                                        <option  value="{{$datapais->id}}">{{$datapais->pais}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputState">Estado</label>
                                <select id="estado" name="estado" class="form-control">
                                <option selected>Selecciona</option>
                                <option>...</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputZip">Zip Code</label>
                                <input type="text" id="zipcode" name="zipcode" class="form-control" >
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="documento_rut" name="documento_rut" accept=".pdf" required>
                                    <label class="custom-file-label" for="validatedCustomFile" id="documento_rut_label">Cocumento R.U.T.</label>
                                    <div class="invalid-feedback">Example invalid custom file feedback</div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="documento_comercio" name="documento_comercio" accept=".pdf"  required>
                                    <label class="custom-file-label" for="validatedCustomFile" id="documento_camara_label" >Documento Camara Comercio</label>
                                    <div class="invalid-feedback">Example invalid custom file feedback</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="logolab" name="logolab" accept=".jpg"  required>
                                    <label class="custom-file-label" for="validatedCustomFile" id="documento_logo_label" >Logo</label>
                                    <div class="invalid-feedback">Example invalid custom file logo</div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Enviar Solicitud</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    let paisesLista = JSON.parse('<?php echo $data ?>');
    function filterEstado(){
        let val = document.getElementById('pais').value;
        let filterEstados = paisesLista.filter(pais => pais.id == val);
        let select = document.getElementById('estado');
        select.innerHTML = '';
        if(filterEstados){
            filterEstados[0].estados.forEach(element => {
                let opt = document.createElement('option');
                opt.value = element.id;
                opt.innerHTML = element.estado;
                select.appendChild(opt);
            });
        }
        
        
    }
    window.onload = function() {

        $('#documento_rut').change(function() {
            $("#documento_rut_label").text(this.files[0].name);
        });
        $('#documento_comercio').change(function() {
            $("#documento_camara_label").text(this.files[0].name);
        });
        $('#logolab').change(function() {
            $("#documento_logo_label").text(this.files[0].name);
        });
    }
</script>