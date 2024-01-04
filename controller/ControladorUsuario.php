<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--CLASE CONTROLADOR USUARIO

La clase controladorUsuario contiene funciones para validar los datos de registro del usuario-->

<?php

class ControladorUsuario
{

    //Función para validar si el nombre solo contiene caracteres permitidos 

    public static function nombreValido($nombre)
    {

        $caracteresPermitidos = "aábcdeéfghiíjklmnoópqrstuúüvwxyzAÁBCDEÉFGHÍIJKLMNOÓPQRSTUÚVWXYZ- ";

        return strspn($nombre, $caracteresPermitidos) == strlen($nombre);
    }

    //Función para validar contraseña
    //Verifica si contiene letras, números, al menos una mayúscula y un caracter especial
    public static function contraseniaValida($pass)
    {
        //Comprueba si la contraseña tiene entre 8 y 10 caracteres (ambos incluidos)
        if (strlen($pass) < 8 || strlen($pass) > 10) {

            return false;
        }
        //Comprueba si la contraseña contiene letras
        if (!preg_match('/[A-Z]/', $pass)) {
            return false;
        }
        //Comprueba si tiene números
        if (!preg_match('/[0-9]/', $pass)) {
            return false;
        }

        //Comprueba si tiene al menos un caracter especial de la lista
        if (!preg_match('/[\.\_\-\^\(\)\#\!]/', $pass)) {
            return false;
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

    //Función para verificar que el hash generado y la contraseña que le corresponde
    public static function coincidenContrasenias($contrasenia, $contraseniaBD)
    {
        return password_verify($contrasenia, $contraseniaBD);
    }
}
