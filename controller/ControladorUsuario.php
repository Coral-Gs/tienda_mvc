<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--CLASE CONTROLADOR USUARIO

La clase controladorUsuario contiene funciones para validar los datos de registro del usuario-->

<?php

class ControladorUsuario
{
    //Función para validar si el nombre solo contiene caracteres permitidos y mínimo 2 caracteres y máximo 25

    public static function validarNombre($nombre)
    {
        $mensajes_error = []; //Creo array para almacenar mensajes de error
        $caracteresPermitidos = "aábcdeéfghiíjklmnoópqrstuúüvwxyzAÁBCDEÉFGHÍIJKLMNOÓPQRSTUÚVWXYZ- ";

        //Comrpuebo si el nombre contiene solo caracteres permitidos
        if (strspn($nombre, $caracteresPermitidos) != strlen($nombre)) {
            $mensajes_error[] = 'El nombre no puede contener números ni caracteres especiales';
        }
        //Compruebo si el nombre tiene entre 2 y 25 caracteres {
        if (!((strlen($nombre) >= 2) && (strlen($nombre) <= 25))) {
            $mensajes_error[] = 'El nombre debe tener entre 2 y 25 caracteres';
        }

        if (!empty($mensajes_error)) {
            return $mensajes_error;
        } else {
            return true;
        }
    }

    //Función para validar contraseña
    //Verifica si contiene letras, números, al menos una mayúscula y un caracter especial
    public static function validarContrasenia($pass)
    {
        $mensajes_error = []; //Creo array para almacenar mensajes de error
        $pass = trim($pass); //Elimino espacios en blanco
        //Comprueba si la contraseña tiene entre 8 y 10 caracteres (ambos incluidos)
        if (strlen($pass) < 8 || strlen($pass) > 10) {

            $mensajes_error[] = 'La contraseña debe tener entre 8 y 10 caracteres';
        }
        //Comprueba si la contraseña contiene letras
        if (!preg_match('/[A-Z]/', $pass)) {
            $mensajes_error[] = 'La contraseña debe contener al menos una letra';
        }
        //Comprueba si tiene números
        if (!preg_match('/[0-9]/', $pass)) {
            $mensajes_error[] = 'La contraseña debe contener al menos un número';
        }

        //Comprueba si tiene al menos un caracter especial de la lista
        if (!preg_match('/[\.\_\-\^\#\!]/', $pass)) {
            $mensajes_error[] = 'La contraseña debe contener al menos un caracter especial ._-^#!';
        }

        //Retorno mensajes de error si hay alguno
        if (!empty($mensajes_error)) {
            return $mensajes_error;
        }

        //Si las condiciones anteriores se cumplen, retorna true
        return true;
    }

    //Función para comprobar si las contraseñas introducidas coinciden

    public static function compararContrasenias($pass1, $pass2)
    {
        if ($pass1 === $pass2) {
            return true;
        } else {
            return false;
        }
    }

    //Función para generar un hash para la contraseña del usuario y ofrecer mayor seguridad 
    public static function hashContrasenia($contrasenia)
    {
        return password_hash($contrasenia, PASSWORD_BCRYPT);
    }
}
