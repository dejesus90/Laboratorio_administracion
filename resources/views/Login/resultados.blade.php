@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{ __('Descargar Resultados') }}
                    <!-- <button type="button" class="btn btn-link float-right">inicio</button> -->
                    <a class="btn btn-sm btn-outline-primary float-right" href="/" role="button">inicio</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('buscarResultado') }}">
                        @csrf
                        
                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">Tipo Identificacion</label>

                            <div class="col-md-6">
                                <select id="tipoide" name="tipoide" class="form-control">
                                    <option value="1" selected>Cedula</option>
                                    <option value="2" >NUIP</option>
                                    <option value="3" >Tarjeta de Identidad</option>
                                    <option value="4" >Pasaporte</option>
                                    <option value="5" >PEP</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cedula" class="col-md-4 col-form-label text-md-right">Cedula</label>

                            <div class="col-md-6">
                                <input id="cedula" type="text" class="form-control" name="cedula" autocomplete="off"  required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="codigo" class="col-md-4 col-form-label text-md-right">Codigo Muestra</label>

                            <div class="col-md-6">
                                <input id="codigo" type="text" class="form-control" name="codigo" autocomplete="off" required>
                            </div>
                        </div>
                        

                        <div class="form-group row mb-4">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    {{ __('Descargar') }}
                                </button>
                                
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection