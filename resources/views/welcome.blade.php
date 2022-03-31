<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratorio</title>
    <link href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
    <style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;

    }

    .card {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        width: 400px;
        height: auto;
        position: relative;
        border-radius: 2px;
        background-color: #fff;
        box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12), 0 3px 1px -2px rgba(0, 0, 0, 0.2);
        text-align: center;
        margin: 20px;
        padding: 20px;
        transition: all 0.3s cubic-bezier(.25, .8, .25, 1);
    }

    .card:nth-child(2) {
        background-color: #ff5252;
        color: #fff;
    }

    .card-circle {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 80px;
        height: 80px;
        border: 2px solid #e0e0e0;
        border-radius: 50%;
        margin-bottom: 10px;
        padding: 20px;
    }

    .text-content {
        font-family: 'Roboto', sans-serif;
        padding-top: 20px;
    }

    .card-title {
        font-size: 24px;
        font-weight: 500;
        line-height: 48px;
    }

    p {
        font-size: 15px;
        font-weight: 400;
        line-height: 30px;
    }

    i {
        color: #2196F3;
    }

    .fa-css3 {
        color: #fff;
    }

    .card:hover {
        cursor: pointer;
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
    }
    </style>
</head>

<body>
    <div class="card" onclick="irpaciente()">
        <div class="card-circle">
        <i class="fa fa-address-book fa-4x" ></i>
            <!-- <i class="fa fa-user-o"></i> -->
        </div>
        <div class="text-content">
            <span class=card-title><strong>Soy Paciente</strong></span>
            <p>Consulta los resultados de tus analisis solicitados, tener a la mano la informacion necesaria.</p>
        </div>
    </div>
    <div class="card" onclick="irlaboratorio()">
        <div class="card-circle">
            <!-- <i class="fab fa-flask fa-4x"></i> -->
            <i class="fa fa-user-o fa-4x" style="color:#ffffff"></i>
        </div>
        <div class="text-content">
            <span class=card-title><strong>Soy Laboratorio</strong></span>
            <p>Registrate y empieza a utlizar la plataforma, dando de alta tus pacientes y analisis a realizar en laboratorio.</p>
        </div>
    </div>
    <script type="text/javascript">
        function irpaciente(){
            window.location.href = '/consultar';
        }
        function irlaboratorio(){
            window.location.href = '/login';
        }
    </script>
</body>

</html>