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


//Creo array de mensajes al usuario y enlace de volver
$mensajes = array();
$enlace_volver = '';

//Si exiten cookies, el enlace 'volver' regirige a la tienda de invitado, si no, al acceso principal
if (!empty($_COOKIE['nombre_invitado'])) {
    $enlace_volver = '<a href="invitado/c.tiendaInvitado.php">Volver</a>';
} else {
    $enlace_volver = '<a href="c.index.php">Volver</a>';
}

//Si se ha enviado el formulario y he recibido los datos por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['submit'])) {

        $email = $_POST['email'];
        $contrasenia = $_POST['pass'];

        //Valido si los campos de email y password están vacíos
        if (!empty($email) && !empty($contrasenia)) {

            //Compruebo que la contraseña introducida coincide con el hash asignado según el email
            $datos_validos = Usuario::comprobarContraseniaHash($contrasenia, $email);

            if ($datos_validos) {

                //Si la contraseña es correcta recorro datos de usuario y asigno a variables globables de sesión
                $datos_usuario = Usuario::mostrarDatosUsuario($email);
                foreach ($datos_usuario as $dato) {
                    $_SESSION['id_usuario'] = $dato->getIdUsuario();
                    $_SESSION['nombre'] = $dato->getNombreUsuario();
                    $_SESSION['email'] = $dato->getEmail();
                }
                header('location:c.index.php');
            } else {
                //De lo contrario, lanzo un mensaje de error
                $mensajes[] = '¡El usuario o la contraseña no son válidos!';
            }
        } else if (empty($email) && empty($contrasenia)) {
            $mensajes[] = '¡Por favor, introduce tu email y contraseña!';
        }
    }
}

//MUESTRO LA INFORMACIÓN EN LA VISTA EN CASO DE QUE HAYA HABIDO ALGÚN ERROR
//Si el proceso se ha completado correctamente, se habría redirigido a c.index.php');

include '../view/login.php';
