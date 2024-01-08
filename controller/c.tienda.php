<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--CONTROLADOR DE CARRITO-->


<!--El controlador de carrito procesa la información que llega de la vista de tienda del formulario del carrito
llamando a los modelos necesarios para actualizar el carrito en la BD-->

<?php

//Mantengo inicio de sesión
session_start();

//Incuyo modelos que voy a utilizar
include_once '../model/Carrito.php';
include_once '../model/Producto.php';

//MANEJO DE DATOS DE SESIÓN EN TIENDA
//Página privada, si no hay sesión iniciada, redirige al controlador de acceso
if (!isset($_SESSION['id_usuario'])) {
    header('location:../controller/c.index.php');
}

//Asigno los valores de la sesión a id usuario y nombre usuario
$id_usuario = $_SESSION['id_usuario'];
$nombre_usuario = $_SESSION['nombre'];



//Si el usuario la cerrar sesión, se destruye la sesión y redirige al controlador de acceso
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['salir'])) {

        session_destroy();
        header('location:../controller/c.index.php');
    }
    //Si el usuario selecciona 'finalizar compra' se redirige al controlador de factura
    if (isset($_POST['finalizar-compra'])) {

        header('location:c.factura.php');
    }
}

//MANEJO DE DATOS DE PRODUCTOS Y CARRITO

//Creo instancias y variables que necesito para manejar el carrito
$carrito = new Carrito();
$carrito->setIdUsuario($id_usuario);
$detalle_carrito = new DetalleCarrito();
$detalle_carrito->setIdUsuario($id_usuario);

//Obtengo los datos de los productos, el carrito inicial y el total del carrito
$productos = Producto::mostrarDatosProductos();
$productos_carrito = $detalle_carrito->mostrarDatosCarrito();
$total_carrito = $detalle_carrito->totalCarrito();

//Compruebo si hay algun filtro activo
include 'c.buscador.php';

//Compruebo si hay artículos inicialmente en el carrito para mostrar o no el total, el botón finalizar compra y el mensaje de carrito vacío
$boton_finalizar = '';
$mensaje_carrito = '';
$total = '';

if ($total_carrito == 0) {
    $mensaje_carrito = 'El carrito está vacío';
    $boton_finalizar = '';
    $total = '';
} else {
    $mensaje_carrito = '';
    $boton_finalizar = ' <form method="post" action="../controller/c.factura.php">
                    <input type="submit" name="finalizar-compra" value="Finalizar compra" class="boton-comprar">
                </form>';
    $total = 'Total: ' . $total_carrito . '€';
}

//LÓGICA BOTONES PARA AÑADIR AL CARRITO DESDE LA TIENDA
//La primera vez que se pulsa se añade al carrito 1 unidad del producto
//Si se vuelve a pulsar para el mismo producto aumenta en 1 la cantidad de dicho producto

//Compruebo si se ha enviado el formulario por post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Recorro los productos de la tabla para buscar el ID y comprobar qué producto se ha seleccionado 

    foreach ($productos as $producto) {
        $id_producto = $producto->getIdProducto();
        $boton_comprar = 'comprar' . $id_producto;

        //Si pusla el boton de comprar
        if (isset($_POST[$boton_comprar])) {

            //Compruebo si el producto está ya en el carrito en la BD
            $producto_en_carrito = $carrito->buscarProductoCarrito($id_producto);

            //Si está, sumo 1 a la cantidad del producto
            if ($producto_en_carrito) {
                $operacion = 'sumar';
                $carrito->modificarCantidadProducto($id_producto, $operacion);
            } else {
                //Si no está, añado el nuevo producto al carrito en BD
                $carrito->agregarProducto($id_producto);
            }
        }
    }
}

//LÓGICA DE BOTONES DEL CARRITO
//Se pueden añadir o restar unidades de un producto con los botones '+' y '-'
//Se pueden eliminar productos con el boton 'eliminar'
//Primero compruebo si hay productos en el carrito
if ($total_carrito != 0) {

    $boton_finalizar = true;

    //Obtengo los datos actuales del carrito
    $productos_carrito = $carrito->obtenerDatosCarrito();

    foreach ($productos_carrito as $producto_carrito) {

        $id_producto = $producto_carrito->getIdProducto();
        $boton_sumar = 'sumar' . $id_producto;
        $boton_restar = 'restar' . $id_producto;
        $boton_eliminar = 'eliminar' . $id_producto;

        //Si se ha pulsado el boton + se suma una unidad a la cantidad del producto
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST[$boton_sumar])) {
                $operacion = 'sumar';

                $carrito->modificarCantidadProducto($id_producto, $operacion);

                //Si se ha pulsado el boton - compruebo la cantidad del producto
            } elseif (isset($_POST[$boton_restar])) {
                $operacion = 'restar';

                //Si la cantidad es mayor que 1 se resta 1 unidad
                if ($producto_carrito->getCantidad() > 1) {

                    $carrito->modificarCantidadProducto($id_producto, $operacion);

                    //Si la cantidad es igual a 1 se elimina el producto
                } else {
                    $carrito->eliminarProducto($id_producto);
                }

                //Si se ha pulsado el boton 'eliminar's se elimina el producto del carrito
            } elseif (isset($_POST[$boton_eliminar])) {
                $carrito->eliminarProducto($id_producto);
            }
        }
    }
}

//OBTENER PRODUCTOS DEL CARRITO ACTUALIZADOS
//Vuelvo a llamar a la función para obtener todos los datos del carrito y el total actualiados
$productos_carrito = $detalle_carrito->mostrarDatosCarrito();
$total_carrito = $detalle_carrito->totalCarrito();

//Compruebo si hay  actualizaciones en el carrito para mostrar o no el botón finalizar compra
if ($total_carrito == 0) {
    $mensaje_carrito = 'El carrito está vacío';
    $boton_finalizar = '';
    $total = '';
} else {
    $mensaje_carrito = '';
    $boton_finalizar = ' <form method="post" action="../controller/c.factura.php">
                    <input type="submit" name="finalizar-compra" value="Finalizar compra" class="boton-comprar">
                </form>';
    $total = 'Total: ' . $total_carrito . '€';
}
//MOSTRAR LA INFORMACIÓN EN LA VISTA

//Incluyo la cabecera
include '../view/header.php';
//Incluyo el buscador
include '../view/buscador.php';
//Incluyo la vista de la tienda
include '../view/tienda.php';
