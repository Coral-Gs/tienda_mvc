<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--CONTROLADOR DE TIENDA INVITADO-->

<!--El controlador de tienda invitado muestra los productos que recibe del modelo Producto
y procesa la información que llega de los formularios de la vista tiendaInvitado.php,
utilizando las funciones necesarias de la clase ControladorInvitado para manejar los productos del carrito
almacenados en la cookie carrito_invitado-->

<?php
//Incuyo modelos y controladores que voy a utilizar
include_once '../../model/Producto.php';
include_once 'ControladorInvitado.php';

//Página privada: si no hay cookies creadas redirige a la página de acceso
if (!isset($_COOKIE['carrito_invitado']) || !isset($_COOKIE['nombre_invitado'])) {

    header('location:../c.index.php');
}

//Creo el array vacío carrito_invitado
//Compruebo si ya hay productos en la cookie con el método unserialize() y si es así, se lo asigno a la variable carrito_invitado
$carrito_invitado = array();
if (!empty($_COOKIE['carrito_invitado'])) {
    $carrito_invitado = unserialize($_COOKIE['carrito_invitado']);
}

//Creo un nuevo objeto de controladorInvitado para utilizar sus funciones
$invitado = new ControladorInvitado($_COOKIE['nombre_invitado'], $carrito_invitado);

//Obtengo los datos de los productos de tienda, el carrito inicial que contiene la cookie y el total del carrito
$nombre_usuario = $invitado->getNombreInvitado();
$total_carrito = $invitado->totalCarritoInvitado();
$productos = Producto::mostrarDatosProductos();

//Compruebo si hay algun filtro activo con el controlador de buscador
include '../c.buscador.php';

//Compruebo si hay artículos inicialmente en el carrito para mostrar o no el total, el botón finalizar compra y el mensaje de carrito vacío
//Si el total es 0 no hay productos en el carrito y por tanto no muestro el botón ni el total

$boton_finalizar = '';
$mensaje_carrito = '';
$total = '';

if (empty($carrito_invitado)) {
    $mensaje_carrito = 'El carrito está vacío';
    $boton_finalizar = '';
    $total = '';
} else {
    $mensaje_carrito = '';
    $boton_finalizar = ' <form method="post" action="../controller/c.facturaInvitado.php">
                    <input type="submit" name="finalizar-compra" value="Finalizar compra" class="boton-comprar">
                </form>';
    $total = 'Total: ' . $total_carrito . '€';
}

//LÓGICA BOTONES PARA AÑADIR AL CARRITO DESDE LA TIENDA
//La primera vez que se pulsa se añade al carrito 1 unidad del producto
//Si se vuelve a pulsar para el mismo producto aumenta en 1 la cantidad de dicho producto, sin duplicarse en el carrito

//Compruebo si se ha enviado el formulario por post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Recorro los productos de la tabla para buscar el ID y comprobar qué producto se ha seleccionado 
    foreach ($productos as $producto) {
        $id_producto = $producto->getIdProducto();
        $boton_comprar = 'comprar' . $id_producto;

        //Si pulsa el boton de comprar
        if (isset($_POST[$boton_comprar])) {

            //Compruebo si el producto está ya en el carrito 
            $producto_en_carrito = $invitado->buscarProductoInvitado($id_producto);

            //Si está, sumo 1 a la cantidad del producto con modificarCantidadProducto()
            if ($producto_en_carrito) {
                $operacion = 'sumar';

                $carrito_invitado = $invitado->modificarCantidadProducto($id_producto, $operacion);
            } else {
                //Si no está, añado el nuevo producto al carrito con la función específica
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

    //Recorro productos del carrito
    foreach ($carrito_invitado as $producto) {

        //Asigno valores a los botones de manejo del carrito añadiendo el id del producto
        $id_producto = $producto['id_producto'];
        $boton_sumar = 'sumar' . $id_producto;
        $boton_restar = 'restar' . $id_producto;
        $boton_eliminar = 'eliminar' . $id_producto;

        //Si se ha pulsado el boton '+' se suma una unidad a la cantidad del producto con la función modificarCantidadProducto()
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST[$boton_sumar])) {
                $operacion = 'sumar';

                $carrito_invitado = $invitado->modificarCantidadProducto($id_producto, $operacion);

                //Si se ha pulsado el boton '-' compruebo la cantidad del producto
            } elseif (isset($_POST[$boton_restar])) {
                $operacion = 'restar';

                //Si la cantidad es mayor que 1 se resta 1 unidad (también lo compruebo en la dunción modificarCantidadProducto() por si acaso)
                if ($producto['cantidad'] > 1) {

                    $operacion = 'restar';
                    $carrito_invitado = $invitado->modificarCantidadProducto($id_producto, $operacion);

                    //Si la cantidad es igual a 1 se elimina el producto
                } else {
                    $carrito_invitado = $invitado->eliminarProductoCarrito($id_producto);
                }

                //Si se ha pulsado el boton 'eliminar's se elimina el producto del carrito
            } elseif (isset($_POST[$boton_eliminar])) {
                $carrito_invitado = $invitado->eliminarProductoCarrito($id_producto);
            }
        }
    }
}

//Actualizo la información de la cookie con los últimos datos del array del carrito con setcookie()
//Usando de nuevo la función serialize() para poder introducir los datos en la cookie porque no acepta el array directamente
$carrito_invitado = $carrito_invitado;
$carrito_invitado_cookie = serialize($carrito_invitado);
setcookie('carrito_invitado', $carrito_invitado_cookie, time() + 3600 * 24 * 30, "/");
setcookie('nombre_invitado', $nombre_usuario, time() + 3600 * 24 * 30, "/"); //Actualizo de nuevo la cookie de nombre_invitado también para que tenga la misma duración que el carrito

//Actualizo total del carrito para poder mostrar en la vista la última información
$invitado->setCarritoInvitado($carrito_invitado);
$total_carrito = $invitado->totalCarritoInvitado();

//Compruebo total carrito actualizado para mostrar o no el botón 'finalizar compra' y el total
//Si el total es 0 no hay productos en el carrito y por tanto no muestro el botón ni el total
if ($total_carrito == 0) {
    $mensaje_carrito = 'El carrito está vacío';
    $boton_finalizar = '';
    $total = '';
} else {
    $mensaje_carrito = '';
    $boton_finalizar = ' <form method="post" action="../../controller/invitado/c.facturaInvitado.php">
                    <input type="submit" name="finalizar-compra" value="Finalizar compra" class="boton-comprar">
                </form>';
    $total = 'Total: ' . $total_carrito . '€';
}

//MOSTRAR LA INFORMACIÓN EN LA VISTA

//Incluyo la cabecera
include_once '../../view/invitado/headerInvitado.php';
//Incluyo el buscador
include_once '../../view/invitado/buscadorInvitado.php';
//Incluyo la vista de la tienda
include_once '../../view/invitado/tiendaInvitado.php';
