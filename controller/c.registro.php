<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--CONTROLADOR DE LOGIN-->

<?php

//El controlador de registro valida y procesa los datos del formulario que viene de la vista de usuario view/registro.php
//Si el proceso es exitoso, toma el control c.tienda, que le mostrará la vista de tienda como usuario registrado

//Incluyo los modelos y contorladores que voy a necesitar
include_once '../model/Usuario.php';
include_once '../controller/ControladorUsuario.php';

//Iniciamos la sesión de usuario y las superglobales necesarias
session_start();

if (!isset($_SESSION['nombre'])) {
    $_SESSION['nombre'] = null;
}

if (!isset($_SESSION['email'])) {
    $_SESSION['email'] = null;
}

if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['id_usuario'] = null;
}

//Creo array de mensajes al usuario y enlace de volver
$mensajes = array();
$enlace_volver = '';

//Si exiten cookies, el enlace 'volver' regirige a la tienda de invitado, si no al acceso principal
if (!empty($_COOKIE['nombre_invitado'])) {
    $enlace_volver = '<a href="invitado/c.tiendaInvitado.php">Volver</a>';
} else {
    $enlace_volver = '<a href="../view/acceso.php">Volver</a>';
}

//Compruebo si se ha enviado el formulario por POST y creo variables
//En cada comprobación almaceno los mensajes de error en el array $mensajes que me devuelven las funciones
//para mostrarlos al usuario en la vista

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['enviar'])) {

        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $pass1 = $_POST['pass1'];
        $pass2 = $_POST['pass2'];

        //Compruebo si el nombre se ha enviado y es válido

        if (empty($nombre)) {
            $mensajes[] = 'Debes introducir un nombre';
        } else {
            $nombreValido = ControladorUsuario::validarNombre($nombre);
            if ($nombreValido !== true) {
                $mensajes = array_merge($mensajes, $nombreValido);
            } else {

                //Si el nombre es válido, compruebo si el email se ha enviado y es válido

                if (empty($email)) {
                    $mensajes[] = 'Debes introducir un email.';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $mensajes[] =  'Debes introducir un email válido con el formato email@email.com';

                    //Si el email es válido, compruebo si ya existe el usuario en la BD
                } else {

                    $existe_usuario = Usuario::buscarUsuario($email);

                    if ($existe_usuario) {
                        //Si existe lanzo mensaje de error
                        $mensajes[] = 'Ya existe un usuario con el email ' . $email . '.';
                    } else {
                        //Si el email no existe en la base de datos, valido la contraseña

                        if (!empty($pass1) && !empty($pass2)) {

                            $contrasenia_valida = ControladorUsuario::validarContrasenia($pass1);
                            $contrasenias_iguales = ControladorUsuario::compararContrasenias($pass1, $pass2);

                            if ($contrasenia_valida === true && $contrasenias_iguales) {
                                //Si la contraseña es válida y coincide ejecuta el registro en la BD
                                //utilizando la función PASSWORD_HASH de PHP para  encriptar la contraseña
                                Usuario::crearUsuario($nombre, $email, $pass1);

                                //Se asignan los valores a la sesión
                                //Y se redirige al controlador de tienda para mostrarle los datos de la tienda como usuario registrado
                                $_SESSION['nombre'] = $nombre;
                                $_SESSION['email'] = $email;
                                $_SESSION['id_usuario'] = Usuario::buscarIdUsuario($email);
                                header('location:c.tienda.php');
                            } elseif ($contrasenia_valida !== true) {
                                //Almaceno los mensajes de error que me devuelve la función de validarContrasenia
                                //junto con los que pueda haber del resto de validaciones

                                $mensajes = array_merge($mensajes, $contrasenia_valida);
                            } elseif (!$contrasenias_iguales) {
                                //si las contraseñas no coinciden
                                $mensajes[] = '¡Las contraseñas deben coincidir!';
                            }
                        } else {
                            //Si no ha introducido una contraseña
                            $mensajes[] = 'Debes introducir una contraseña';
                        }
                    }
                }
            }
        }
    }
}

//MUESTRO LA INFORMACIÓN EN LA VISTA EN CASO DE QUE HAYA HABIDO ALGÚN ERROR
//Si el proceso se ha completado correctamente, se habría redirigido a c.tienda.php');

include_once '../view/registro.php';
