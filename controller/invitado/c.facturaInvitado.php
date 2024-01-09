<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--CONTROLADOR DE FACTURA INVITADO-->

<!--El controlador de factura procesa la información que llega de la vista de factura-->

<?php

//Incuyo modelos y funciones que voy a utilizar
include_once '../../model/Producto.php';
include_once 'ControladorInvitado.php';

//MANEJO DE DATOS DE COOKIES

//Página privada: si no hay cookies, redirige a la página de acceso
if (!isset($_COOKIE['carrito_invitado'])) {
    header('location:../c.index.php');
}

//Asigno los valores de las cookies
$nombre_usuario = $_COOKIE['nombre_invitado'];
$email = 'usuario invitado';
$carrito_invitado = unserialize($_COOKIE['carrito_invitado']);
$mensaje_factura = $nombre_usuario . ', estos son los detalles de tu pedido:';

//Creo instancias y variables que necesito para la factura
$invitado = new ControladorInvitado($nombre_usuario, $carrito_invitado);
$total_carrito = $invitado->totalCarritoInvitado();
$boton_finalizar = '<form method="POST" action="../../controller/invitado/c.facturaInvitado.php">
            <input type="submit" name="factura" value="Finalizar compra y vaciar carrito" class="boton-finalizar">
        </form>';

//Cuando el usuario presiona "Finalizar compra y vaciar carrito" llamo a una función para vaciar el carrito
//y actualizo cookies
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['factura'])) {
        $mensaje_factura = '¡Gracias por tu compra! Esta es tu factura:';
        $carrito_invitado_vacio = $invitado->vaciarCarritoInvitado();
        //Actualizo cookies y boton de finalizar
        $carrito_invitado_cookie = serialize($carrito_invitado_vacio);
        setcookie('nombre_invitado', $nombre_usuario, time() + 3600 * 24 * 30, "/"); //Creo de nuevo la cookie de nombre_invitado para que tenga la misma duración que el carrito
        setcookie('carrito_invitado', $carrito_invitado_cookie, time() + 3600 * 24 * 30, "/");
        $boton_finalizar = '';
    }
}

//MOSTRAR LA INFORMACIÓN EN LA VISTA

//Llamo a la cabecera
include_once '../../view/invitado/headerInvitado.php';
//Llamo a la factura
include_once '../../view/invitado/facturaInvitado.php';


?>