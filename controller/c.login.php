<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--CONTROLADOR DE LOGIN-->

<?php
//El controlador de login valida y procesa los datos del formulario que viene de la vista de usuario view/login.php
//Después devuelve la vista correspondiente

//Iniciamos la sesión de usuario
session_start();

//Incluyo el modelo Usuario.php y Producto.php para poder usar sus funciones
include_once '../model/Usuario.php';
include_once '../model/Producto.php';


//Creo variables globales de sesión 
if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['id_usuario'] = null;
}

if (!isset($_SESSION['nombre'])) {
    $_SESSION['nombre'] = null;
}

if (!isset($_SESSION['email'])) {
    $_SESSION['email'] = null;
}
if (!isset($_SESSION['pass'])) {
    $_SESSION['pass'] = null;
}

//Si se ha enviado el formulario y he recibido los datos por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['submit'])) {

        $email = $_POST['email'];
        $pass = $_POST['pass'];

        //Valido si los campos de email y password están vacíos
        if (!empty($email) && !empty($pass)) {
            //Creo un objeto de usuario
            $usuario = new Usuario();

            //Busco el usuario y el hash asociado a su contraseña
            $hash_BD = $usuario->buscarUsuarioHash($email);

            //Compruebo que la contraseña introducida coincide con el hash asignado
            $datos_validos = $usuario->coincideContraseniaHash($pass, $hash_BD);

            if ($datos_validos) {

                //Si la contraseña es correcta, obtengo los datos del usuario mediante su email
                //llamando a la función estática mostrarDatosUsuario();
                //Recorro datos de usuario y asigno a variables globables de sesión
                $datos_usuario = Usuario::mostrarDatosUsuario($email);
                foreach ($datos_usuario as $dato) {
                    $_SESSION['nombre'] = $dato->getNombreUsuario();
                    $_SESSION['id_usuario'] = $dato->getIdUsuario();
                }
                $_SESSION['email'] = $email;
                $_SESSION['pass'] = $pass;

                header('location:c.index.php');
            } else {
                //De lo contrario, lanzo un mensaje de error
                include '../view/login.php';
                echo '<div style="text-align:center"><strong>¡El usuario o la contraseña no son válidos!</strong</div>';
            }
        } else if (empty($email) && empty($pass)) {
            include '../view/login.php';
            echo '<div style="text-align:center"><strong>¡Por favor, introduce tu email y contraseña!</strong</div>';
        }
    }
}
