<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--CONTROLADOR DE LOGIN-->

<?php

//El controlador de registro valida y procesa los datos del formulario que viene de la vista de usuario view/registro.php
//Si el proceso es exitoso, el flujo vuelve al controlador index, que entonces mostrará la vista de tienda como usuario registrado

//Incluyo el modelo Usuario.php, Producto.php y el controlador de usuario para poder usar sus funciones
include_once '../model/Usuario.php';
include_once '../model/Producto.php';
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

//Compruebo si se ha enviado el formulario por POST y creo variables

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['enviar'])) {

        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $pass1 = $_POST['pass1'];
        $pass2 = $_POST['pass2'];


        //Compruebo si el nombre se ha enviado y es válido

        if (empty($nombre)) {
            include '../view/registro.php';
            echo 'Debes introducir un nombre';
        } elseif (!empty($nombre) && (!ControladorUsuario::nombreValido($nombre))) {
            include '../view/registro.php';
            echo '<div style="text-align:center"><strong>El nombre no puede contener números ni caracteres especiales.</strong></div>';
        } else {

            if (empty($email)) {

                include '../view/registro.php';
                echo 'Debes introducir un email.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

                include '../view/registro.php';
                echo 'Debes introducir un email válido con el formato email@email.com';

                //Si es así, compruebo si ya existe el usuario en la BD
            } else {

                $existe_usuario = Usuario::buscarUsuario($email);

                if ($existe_usuario) {
                    //Si existe lanzo mensaje de error
                    include '../view/registro.php';
                    echo '<div style="text-align:center"><strong>Ya existe un usuario con el email ' . $email . '</strong></div>';
                } else {
                    //Si no existe, valido contraseña

                    if (!empty($pass1) && !empty($pass2)) {

                        $contrasenia_valida = ControladorUsuario::contraseniaValida($pass1);
                        $contrasenias_iguales = ControladorUsuario::compararContrasenias($pass1, $pass2);

                        if ($contrasenia_valida && $contrasenias_iguales) {
                            //Si la contraseña es válida y coincide se ejecuta el registro en la BD
                            //utilizando la función PASSWORD_HASH de PHP para  encriptar la contraseña

                            $hash_contrasenia = ControladorUsuario::hashContrasenia($pass1);
                            Usuario::crearUsuario($nombre, $email, $hash_contrasenia);

                            //Se asignan los valores a la sesión
                            //Y se redirige al controlador principal index
                            $_SESSION['nombre'] = $nombre;
                            $_SESSION['email'] = $email;
                            $_SESSION['id_usuario'] = Usuario::buscarIdUsuario($email);
                            header('location:c.index.php');
                        } elseif (!$contrasenia_valida) {
                            include '../view/registro.php';
                            echo '
                                    <h4>La contraseña debe contener:</h4>
                                    <ul>    
                                        <li>Letras y números</li>
                                        <li>Al menos una mayúscula</li>
                                        <li>Entre 8 y 10 caracteres</li>
                                        <li>Al menos un caracter especial ._-^()#!</li>
                                    </ul>
                                ';
                        } elseif (!$contrasenias_iguales) {
                            include '../view/registro.php';
                            echo '<div style="text-align:center"><strong>¡Las contraseñas deben coincidir!</strong></div>';
                        }
                    } else {
                        include '../view/registro.php';
                        echo '<div style="text-align:center"><strong>Debes introducir una contraseña</strong></div>';
                    }
                }
            }
        }
    }
}
