<!DOCTYPE html>
<html lang=" en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chocolat - Tienda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../assets/estilos.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-12" id="header">
                <img src="../assets/logo_claro.png" width="200" />
            </div>
        </div>
        <div class="row" id="menu">
            <div class="col-sm-10 col-lg-10" id="mensaje-inicial">
                <h4>¡Bienvenid@, <?= $nombre_usuario ?>!</h4>
            </div>
            <div class="col-sm-2 col-lg-2">
                <!--El formulario redirige al controlador de acceso para acceder como usuario/registrarse-->
                <form method='post' action='../controller/c.index.php'>
                    <input type="submit" name="login" value="Acceder" class="boton-acceder">
                    <input type="submit" name="registro" value="Registro" class="boton-registro"><br><br>
                </form>
            </div>
        </div>