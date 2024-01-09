<!doctype html>
<html lang="es" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('recursos/css/estilos.css') }}">
    <link rel="stylesheet" href="{{ asset('recursos/css/responsive.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100 bg-login">  	
    <div class="mt-auto">
        <div class="bloque-footer pd-cuadro box-cuadro pt-25 bloque-footer-radius">
            <div class="container">
                <form action="" class="w-100">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img class="logoaceblub" src="img/logoaceclub.png" alt="">
                        </div>
                        <div class="col-12 text-center">
                            <h2>Registro</h2>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group"> <!-- AGREGAR LA CLASE ERROR PARA MARCAR EL ERROR -->
                                <label for="">Email</label>
                                <input type="email" class="form-control" id="" placeholder="">
                                <small class="mensaje-error">Error al ingresar este campo</small>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group error"> <!-- AGREGAR LA CLASE ERROR PARA MARCAR EL ERROR -->
                                <label for="">Usuario</label>
                                <input type="text" class="form-control" id="" placeholder="">
                                <small class="mensaje-error">Error al ingresar este campo</small>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group"> <!-- AGREGAR LA CLASE ERROR PARA MARCAR EL ERROR -->
                                <label for="">Contraseña</label>
                                <input type="text" class="form-control" id="" placeholder="">
                                <small class="mensaje-error">Error al ingresar este campo</small>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="row">
                                <div class="col">
                                    <button type="button" class="btn btn-success mb-25 mt-25">Registrar</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <p class="fz14">¿Tienes una cuenta? <a href="ingresar.html">Ingresa aquí</a></p>
                        </div>
                    </div>
                 </form>
            </div>
        </div>
    </div>
  	
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  </body>
</html>