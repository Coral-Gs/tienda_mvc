<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--ACCESO A TIENDA-->

<!--Vista inicial de acceso al programa se mostrará en caso de que el usuario no haya iniciado sesión-->

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chocolat - Acceso</title>
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
        <!--El usuario puede acceder mediante login o registro, que iniciaría una sesión de usuario
        en servidor-->
        <section class="formulario-acceso">
            <h2>Acceso a tienda</h2>
            <!--El formulario redirige al controlador de acceso para acceder como usuario/registrarse-->
            <form method='post' action='../controller/c.index.php'>
                <input type="submit" name="login" value="Acceder" class="boton-acceder">
                <input type="submit" name="registro" value="Registro" class="boton-registro"><br><br>
            </form>
            <!--El formulario redirige al controlador de acceso para acceder como invitado-->
            <!--Validación en cliente del campo nombre de invitado: es obligatorio y solo permite letras con y sil tildes y espacios-->
            <form method='post' action='../controller/c.index.php'>
                <input type="text" name="nombre_invitado" placeholder="Nombre..." pattern="[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ ]{1,25}" title="Solo letras y espacios hasta 25 caracteres" required>
                <input type="submit" name="invitado" value="Acceder como invitado" class="boton-invitado">
            </form>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>