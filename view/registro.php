 <!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
 <!--VISTA DE REGISTRO DE USUARIO-->

 <!--Vista para registrarse como nuevo usuario que luego muestra a la tienda
El formulario regirige al controlador principal para procesar la información.
En caso de querer hacer login, hay otro formulario que redirige al controlador principal-->
 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Chocolat - Registro</title>
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
             <h1>Nuevo usuario</h1>
             <!--Formulario de log in validado en cliente con HTML-->
             <form method='POST' action='../controller/c.registro.php' class="container">
                 <label>Nombre: </label>
                 <input type="text" name="nombre" required><br><br>
                 <label>Email: </label>
                 <input type="email" name="email" required><br><br>
                 <label>Contraseña: </label>
                 <input type="password" name="pass1" required><br><br>
                 <label>Repite la contraseña: </label>
                 <input type="password" name="pass2" required><br><br>
                 <input type="submit" name="enviar" value="REGISTRARSE" class="boton-acceder">
                 <a href="../controller/c.login.php">Ya estoy registrado</a><br>
                 <?= $enlace_volver ?>

             </form>
         </div>
         <div class="contenedor-mensajes">
             <ul>
                 <?php
                    foreach ($mensajes as $mensaje) : ?>
                     <li>
                         <?php echo $mensaje ?>
                     </li>
                 <?php endforeach ?>
             </ul>
         </div>
     </div>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
 </body>

 </html>