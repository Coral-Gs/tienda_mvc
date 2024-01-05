<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--CONTROLADOR DE FACTURA-->


<!--El controlador de factura procesa la información que llega de la vista de factura-->

<?php

//Inicio la sesión
session_start();

//Incuyo modelos que voy a utilizar
include_once '../model/Carrito.php';
include_once '../model/Producto.php';

//MANEJO DE DATOS DE SESIÓN

//Página privada, si no hay sesión iniciada, redirige a la página de acceso
if (!isset($_SESSION['id_usuario'])) {
    header('location:../view/acceso.php');
}

//Asigno los valores de la sesión a id usuario y nombre usuario e inicializo otras variables
$id_usuario = $_SESSION['id_usuario'];
$nombre_usuario = $_SESSION['nombre'];
$email = $_SESSION['email'];
$mensaje_factura = $nombre_usuario . ', estos son los detalles de tu pedido:';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
}

//Si el usuario la cierra con el botón salir se redirige a la página de acceso
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['salir'])) {

        session_destroy();
        header('location:../view/acceso.php');
    }
}

//Creo instancias y variables que necesito para la factura
$carrito = new Carrito();
$carrito->setIdUsuario($id_usuario);
$detalle_carrito = new DetalleCarrito();
$detalle_carrito->setIdUsuario($id_usuario);

//Obtengo los datos de los productos y el total del carrito
$productos_carrito = $detalle_carrito->mostrarDatosCarrito();
$total_carrito = $detalle_carrito->totalCarrito();

//Cuando el usuario presiona "Finalizar compra y vaciar carrito" llamo a una función para vaciar el carrito
//Con más tiempo podría haber hecho una transacción en BBDD de modo que se generase una factura al tiempo
//que se vacía el carrito, teniendo también la tabla "factura" y su correspondiente modelo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['factura'])) {
        $mensaje_factura = 'Factura de  compra:';
        $carrito->vaciarCarrito();
    }
}

//MOSTRAR LA INFORMACIÓN EN LA VISTA

//Llamo a la cabecera
include '../view/header.php';
//Llamo a la factura
include '../view/factura.php'


?>