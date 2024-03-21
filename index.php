<?php 
 session_start();
 if(!isset($_SESSION["user"])) {
    header("Location:login.php");
 }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Registro de Participantes</title>

    <script src="public/js/face-api.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js" integrity="sha512-7Pi/otdlbbCR+LnW+F7PwFcSDJOuUJB3OxtEHbg4vSMvzvJjde4Po1v4BR9Gdc9aXNUNFVUY+SK51wWT8WF0Gg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        .panel-detector {
            max-width: 100%;
        }
        video {
            position: absolute;
            z-index: 1;
        }

        canvas {
            position: relative;
            z-index: 20;
        }

        .container {
            display: flex;
            align-items: center;
            flex-direction: column;
            gap: 15px;
        }
        .loader{
            position: absolute;
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10;
            background-color: white;
        }
    </style>
</head>

<body>
    <div class="loader">
        <div class="spinner-border" role="status">
            <span class="sr-only"></span>
        </div>
    </div>
    <nav class="navbar navbar-light bg-black w-100 mb-4">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1 text-light">Registro de entregas</span>
                <a href="exit.php" class="nav-link text-light">Salir</a>
            </div>
        </nav>
    <div class="container">
       
        <div style="position: relative">
            <video onloadedmetadata="onPlay(this)" id="inputVideo" autoplay muted playsinline class="panel-detector"></video>
            <canvas id="overlay" class="panel-detector">
        </div>
        <div class="d-flex justify-content-center gap-4">
            <select id="cameraSelect" class="form-select" onchange="changeCamera(this)">
                <!-- Options will be filled dynamically -->
            </select>
            <button class="btn btn-danger" onclick="detenerCamaras()">Detener</button>
            <button class="btn btn-success" onclick="startCamera()">Iniciar</button>
        </div>


        <div id="botones" class="d-none justify-content-center gap-4">
            <button class="btn btn-success" id="guardar"> Guardar</button>
            <button class="btn btn-primary" id="guardar" onclick="reiniciar();"> Reiniciar</button>
        </div>
        <div id="registrado" class="d-none flex-column align-items-center">
            <h2>Esta persona ya esta registrada</h2>
            <button class="btn btn-primary" id="guardar" onclick="reiniciar();"> Reiniciar</button>
        </div>
    </div>


        <script src="public/js/script_webcam.js"></script>
</body>

</html>