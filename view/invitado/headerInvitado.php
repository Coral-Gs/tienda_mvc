<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--VISTA HEADER INVITADO-->

<!DOCTYPE html>
<html lang=" en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chocolat - Tienda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../assets/estilos.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-10" id="header-logged">
                <img src="../../assets/logo_claro.png" width="200" id='logo' />
            </div>
            <div class="col-sm-12 col-lg-2" id="menu">
                <!--Saludo a usuario invitado-->
                <img src="../../assets/user.png" id="icono-usuario" />
                <h4 id="mensaje-inicial">¡Hola, <?= $nombre_usuario ?>!</h4>
                <!--Enlaces que dirigen al controlador de login y de registro-->
                <a href="../../controller/c.login.php" class="boton-acceder-invitado">Acceder</a>
                <a href="../../controller/c.registro.php" class="boton-registro-invitado">Registro</a>
                <br><br>
            </div>
        </div>