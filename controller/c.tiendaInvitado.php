<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--CONTROLADOR DE TIENDA INVITADO-->

<!--El controlador de tienda invitado procesa la información que llega de la vista de tienda del formulario del carrito
llamando a los modelos necesarios para actualizar el carrito en la BD-->

<?php
//Incuyo modelos y controladores que voy a utilizar
include_once '../model/Producto.php';
include_once 'c.ControladorInvitado.php';

$carrito_invitado = array();

//Compruebo si ya hay productos en la cookie
if (!empty($_COOKIE['carrito_invitado'])) {
    $carrito_invitado = unserialize($_COOKIE['carrito_invitado']);
}
var_dump($_COOKIE['nombre_invitado']);

//Creo un nuevo objeto de invitado y las variables que voy a necesitar
$invitado = new ControladorInvitado($_COOKIE['nombre_invitado'], $carrito_invitado);
$nombre_usuario = $invitado->getNombreInvitado();
$total_carrito = $invitado->totalCarritoInvitado();

//Obtengo los datos de los productos, el carrito inicial que contiene la cookie y el total del carrito
$productos = Producto::mostrarDatosProductos();

//Compruebo si hay algun filtro activo
include 'c.buscador.php';

//Compruebo si hay artículos inicialmente en el carrito para mostrar o no el total, el botón finalizar compra y el mensaje de carrito vacío
$boton_finalizar = '';
$mensaje_carrito = '';
$total = '';

if (empty($carrito_invitado)) {
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

        //Si pulsa el boton de comprar
        if (isset($_POST[$boton_comprar])) {

            //Compruebo si el producto está ya en el carrito en la cookie
            $producto_en_carrito = $invitado->buscarProductoInvitado($id_producto);

            //Si está, sumo 1 a la cantidad del producto en la cookie
            if ($producto_en_carrito) {
                $operacion = 'sumar';
                //1.Consulto cookie, 2. Modifico cookie
                $carrito_invitado = unserialize($_COOKIE['carrito_invitado']);
                $carrito_invitado = $invitado->modificarCantidadProducto($id_producto, $operacion);
            } else {
                //Si no está, añado el nuevo producto al carrito en la cookie
                //1.Consulto cookie, 2. Modifico cookie
                $carrito_invitado = unserialize($_COOKIE['carrito_invitado']);
                $carrito_invitado = $invitado->agregarProductoCarrito($id_producto);
            }
        }
    }
}

//LÓGICA DE BOTONES DEL CARRITO
//Se pueden añadir o restar unidades de un producto con los botones '+' y '-'
//Se pueden eliminar productos con el boton 'eliminar'
//Primero compruebo si hay productos en el carrito

if ($total_carrito != 0) {

    foreach ($carrito_invitado as $producto) {

        $id_producto = $producto['id_producto'];
        $boton_sumar = 'sumar' . $id_producto;
        $boton_restar = 'restar' . $id_producto;
        $boton_eliminar = 'eliminar' . $id_producto;

        //Si se ha pulsado el boton + se suma una unidad a la cantidad del producto
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST[$boton_sumar])) {
                $operacion = 'sumar';

                //1.Consulto cookie, 2. Modifico cookie
                $carrito_invitado = unserialize($_COOKIE['carrito_invitado']);
                $carrito_invitado = $invitado->modificarCantidadProducto($id_producto, $operacion);

                //Si se ha pulsado el boton - compruebo la cantidad del producto
            } elseif (isset($_POST[$boton_restar])) {
                $operacion = 'restar';

                //Si la cantidad es mayor que 1 se resta 1 unidad
                if ($producto['cantidad'] > 1) {

                    $operacion = 'restar';
                    //1.Consulto cookie, 2. Modifico cookie
                    $carrito_invitado = unserialize($_COOKIE['carrito_invitado']);
                    $carrito_invitado = $invitado->modificarCantidadProducto($id_producto, $operacion);


                    //Si la cantidad es igual a 1 se elimina el producto
                } else {
                    //1.Consulto cookie, 2. Modifico cookie
                    $carrito_invitado = unserialize($_COOKIE['carrito_invitado']);
                    $carrito_invitado = $invitado->eliminarProductoCarrito($id_producto);
                }

                //Si se ha pulsado el boton 'eliminar's se elimina el producto del carrito
            } elseif (isset($_POST[$boton_eliminar])) {
                //1.Consulto cookie, 2. Modifico cookie
                $carrito_invitado = unserialize($_COOKIE['carrito_invitado']);
                $carrito_invitado = $invitado->eliminarProductoCarrito($id_producto);
            }
        }
    }
}
echo '<pre>';
var_dump($carrito_invitado);
echo '</pre>';

$carrito_invitado = $carrito_invitado;
$carrito_invitado_cookie = serialize($carrito_invitado);
$total_carrito = $invitado->totalCarritoInvitado();
//3. Actualizo la cookie para guardar las modificaciones efectuadas en el array
setcookie('carrito_invitado', $carrito_invitado_cookie, time() + 3600, "/");



//OBTENER PRODUCTOS DEL CARRITO ACTUALIZADOS
//Vuelvo a llamar a la función para obtener todos los datos del carrito y el total actualizados

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

//Incluyo la vista de la tienda
include '../view/tiendaInvitado.php';
