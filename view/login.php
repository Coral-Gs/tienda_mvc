<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--VISTA DE LOGIN DE USUARIO-->

<!--Vista para acceder a la tienda mediante login para usuarios ya registrados
El formulario regirige al controlador controller/login.php para procesar la información.
En caso de querer registrarse, hay otro formulario que redirige al controlador de acceso-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chocolat - Login</title>
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
        <div class="formulario-login">
            <h1>¡Hola de nuevo!</h1><br>
            <!--Formulario de login que se envía al controlador de login-->
            <form method="post" action=../controller/c.login.php>
                <label>Email: </label>
                <!-- Utilizo las etiquetas de validación en cliente de email y required-->
                <input type="email" name="email" required><br><br>
                <label>Contraseña: </label>
                <input type="password" name="pass" required><br><br>
                <input type="submit" name="submit" value="LOGIN" class="boton-acceder">
                <a href="../view/registro.php">Registrarme</a> <br>
                <a href="../view/acceso.php">Volver</a>
            </form>
        </div>
        <br><br>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>