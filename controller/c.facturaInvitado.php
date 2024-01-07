<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--CONTROLADOR DE FACTURA INVITADO-->

<!--El controlador de factura procesa la información que llega de la vista de factura-->

<?php

//Incuyo modelos y funciones que voy a utilizar
include_once '../model/Producto.php';
include_once 'ControladorInvitado.php';

//MANEJO DE DATOS DE COOKIES

//Página privada, si no hay cookies (o sesión iniciada para usuarios), redirige a la página de acceso
if (!isset($_COOKIE['carrito_invitado'])) {
    header('location:../view/acceso.php');
}

//Asigno los valores de las cookies
$nombre_usuario = $_COOKIE['nombre_invitado'];
$email = 'usuario invitado';
$carrito_invitado = unserialize($_COOKIE['carrito_invitado']);
$mensaje_factura = $nombre_usuario . ', estos son los detalles de tu pedido:';

//Creo instancias y variables que necesito para la factura
$invitado = new ControladorInvitado($nombre_usuario, $carrito_invitado);
$total_carrito = $invitado->totalCarritoInvitado();
$total = 0;
$boton_finalizar = '<form method="POST" action="../controller/c.facturaInvitado.php">
            <input type="submit" name="factura" value="Finalizar compra y vaciar carrito" class="boton-finalizar">
        </form>';

//Si el carrito no tiene nada, el total es 0 (aunqueno aparecería la opción de finalizar compra)
if ($total_carrito != 0) {
    $total = $total_carrito;
}

//Cuando el usuario presiona "Finalizar compra y vaciar carrito" llamo a una función para vaciar el carrito
//y actualizo cookies
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['factura'])) {
        $mensaje_factura = '¡Gracias por tu compra! Esta es tu factura:';
        $carrito_invitado_vacio = $invitado->vaciarCarritoInvitado();
        //Actualizo cookie y boton de finalizar
        $carrito_invitado_cookie = serialize($carrito_invitado_vacio);
        setcookie('carrito_invitado', $carrito_invitado_cookie, time() + 3600 * 24 * 30, "/");
        $boton_finalizar = '';
    }
}

//MOSTRAR LA INFORMACIÓN EN LA VISTA

//Llamo a la cabecera
include '../view/headerInvitado.php';
//Llamo a la factura
include '../view/facturaInvitado.php';


?>