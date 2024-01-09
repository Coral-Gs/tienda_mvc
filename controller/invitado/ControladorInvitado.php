<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--ClASE CONTROLADOR INVITADO-->

<!--El controlador de invitado contiene las funciones para gestionar el carrito de invitado-->

<?php

include_once '../../model/Producto.php';

class ControladorInvitado
{
    private $nombre_invitado;
    private $carrito_invitado;

    //Constructor para añadir el nombre y el carrito de invitado

    public function __construct($nombre_invitado, $carrito_invitado)
    {
        $this->nombre_invitado = $nombre_invitado;
        $this->carrito_invitado = $carrito_invitado;
    }

    //GETTERS

    public function getNombreInvitado()
    {
        return $this->nombre_invitado;
    }
    public function getCarritoInvitado()
    {
        return $this->carrito_invitado;
    }
    public function setCarritoInvitado($carrito_invitado)
    {
        $this->carrito_invitado = $carrito_invitado;
    }


    //Función para buscar producto por ID en el carrito de invitado
    public function buscarProductoInvitado($id_producto)
    {
        $carrito_invitado = $this->carrito_invitado;
        $id_existe = false;
        foreach ($carrito_invitado as $prod) {
            if ($prod['id_producto'] == $id_producto) {
                $id_existe = true;
            }
        }
        return $id_existe;
    }

    //Función que modifica la cantidad de un producto por ID del carrito de invitado
    public function modificarCantidadProducto($id_producto, $operacion)
    {
        $carrito_invitado = $this->carrito_invitado;

        foreach ($carrito_invitado as &$prod) {
            if ($prod['id_producto'] == $id_producto) {
                if ($operacion == "sumar") {
                    $prod['cantidad'] += 1;
                } elseif ($operacion == "restar" && $prod['cantidad'] > 1) {
                    $prod['cantidad'] -= 1;
                }
            }
        }
        return $carrito_invitado;
    }

    //Función que agrega un producto por ID al carrito de invitado
    public function agregarProductoCarrito($id_producto)
    {
        $carrito_invitado = $this->carrito_invitado;

        //Búsqueda inicial del producto en la BD
        //Creo un objeto de producto con su ID y obtengo sus datos
        $producto = new Producto();
        $producto->setIdProducto($id_producto);
        $resultados = $producto->obtenerDatosProductoPorId();
        //Recorro los resultados del producto y asigno variables
        foreach ($resultados as $resultado) {
            $nombre = $resultado->getNombre();
            $precio = $resultado->getPrecio();
        }

        //Introduzco los datos del producto en el array
        $nuevo_producto = array('id_producto' => $id_producto, 'nombre' => $nombre, 'precio' => $precio, 'cantidad' => 1);
        array_push($carrito_invitado, $nuevo_producto);
        return $carrito_invitado;
    }

    //Función para eliminar producto del carrito por ID
    //El parámetro carrito_invitado se pasa por referencia para modificarlo directamente en memoria
    public function eliminarProductoCarrito($id_producto)
    {
        $carrito_invitado = $this->carrito_invitado;

        foreach ($carrito_invitado as $clave => $prod) {
            if ($prod['id_producto'] == $id_producto) {
                unset($carrito_invitado[$clave]);
            }
        }
        return $carrito_invitado;
    }

    //Función para calcular el total del carrito
    public function totalCarritoInvitado()
    {
        $carrito_invitado = $this->carrito_invitado;

        $totalCarrito = 0;
        foreach ($carrito_invitado as $prod) {
            $precio = $prod['precio'];
            $cantidad = $prod['cantidad'];
            $totalCarrito = $totalCarrito + ($precio * $cantidad);
        }
        return $totalCarrito;
    }

    //Función para vaciar el carrito
    public function vaciarCarritoInvitado()
    {
        $carrito_invitado = $this->carrito_invitado;
        $carrito_invitado = [];
        return $carrito_invitado;
    }
}
