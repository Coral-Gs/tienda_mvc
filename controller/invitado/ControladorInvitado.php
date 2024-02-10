<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--ClASE CONTROLADORINVITADO-->

<!--El controlador de invitado contiene las funciones para gestionar el carrito de invitado-->

<?php

include_once '../../model/Producto.php';

class ControladorInvitado
{
    //Creo propiedades privadas de nombre de invitado y carrito
    private $nombre_invitado;
    private $carrito_invitado;

    //Creo constructor para añadir el nombre y el carrito de invitado cuando creo un objeto de ControladorInvitado

    public function __construct($nombre_invitado, $carrito_invitado)
    {
        $this->nombre_invitado = $nombre_invitado;
        $this->carrito_invitado = $carrito_invitado;
    }

    //GETTERS y SETTERS para obtener/establecer los datos del carrito

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


    //Función para buscar producto por ID en el carrito de invitado. Devuelve true o false
    public function buscarProductoInvitado($id_producto)
    {
        $carrito_invitado = $this->carrito_invitado;
        //Creo variable booleana que es false inicialmente
        $id_existe = false;

        //Recorro los productos del array de carrito con un foreach
        //y verifico si coincide con alguno el id del producto que le he pasado por parámetro
        //Si es así id_existe passa a ser true
        foreach ($carrito_invitado as $producto) {
            if ($producto['id_producto'] == $id_producto) {
                $id_existe = true;
            }
        }
        //Retorno true si existe el id de producto o false si no existe en el array del carrito
        return $id_existe;
    }

    //Función que modifica la cantidad de un producto del carrito según el ID del producto y la operación. 
    //Retorna el array modificado

    public function modificarCantidadProducto($id_producto, $operacion)
    {
        $carrito_invitado = $this->carrito_invitado;

        //Recorro cada producto del array del carrito pasado por referencia para modificarlo en memoria (porque si no no me lo modificaba)
        foreach ($carrito_invitado as &$producto) {
            //Si el id del producto del carrito coincide con el que le he pasado por parámetro
            //Compruebo la operación que he pasado ('sumar' o 'restar') y sumo o resto 1 a la cantidad
            if ($producto['id_producto'] == $id_producto) {
                if ($operacion == "sumar") {
                    $producto['cantidad'] = $producto['cantidad'] + 1;
                } elseif ($operacion == "restar" && $producto['cantidad'] > 1) { //Compruebo aquí también si la cantidad es mayor a 1
                    $producto['cantidad'] = $producto['cantidad'] - 1;
                }
            }
        }
        //Retorno el array del carrito modificado
        return $carrito_invitado;
    }

    //Función que agrega un producto por ID al carrito de invitado. 
    //Retorna el array del carrito modificado
    public function agregarProductoCarrito($id_producto)
    {
        $carrito_invitado = $this->carrito_invitado;

        //Primero busco el producto en la BD
        //Para ello creo un objeto de producto con su ID y obtengo sus datos
        $producto = new Producto();
        $producto->setIdProducto($id_producto);
        $resultados = $producto->obtenerDatosProductoPorId();
        //Recorro con un foreach los resultados que me ha dado del producto
        //y asigno variables de nombre y precio
        foreach ($resultados as $resultado) {
            $nombre = $resultado->getNombre();
            $precio = $resultado->getPrecio();
        }

        //Introduzco los datos del producto en el array
        //Creando un nuevo array con los datos del nuevo producto
        //Y unsando la función array_push() para meterlo en el array del carrito
        $nuevo_producto = array('id_producto' => $id_producto, 'nombre' => $nombre, 'precio' => $precio, 'cantidad' => 1);
        array_push($carrito_invitado, $nuevo_producto);

        //Devuelvo el array del carrito modificado con el nuevo producto
        return $carrito_invitado;
    }

    //Función para eliminar producto del carrito por ID
    //Retorna el carrito modificado
    public function eliminarProductoCarrito($id_producto)
    {
        $carrito_invitado = $this->carrito_invitado;
        //Recorro el array del carrito como clave -> valor(producto), 
        //como es un array compuesto de arrays, en este caso la clave sería el índice del array (0,1,2..) y el valor sería el contenido de cada array de producto
        //verifico entonces si existe el id producto pasado por parámetro en el valor [¡d_producto] de alguno de los arrays de producto
        //Si es así, elimino esa la clave (es decir, el array completo de producto) con la función unset() 
        foreach ($carrito_invitado as $clave => $producto) {
            if ($producto['id_producto'] == $id_producto) {
                unset($carrito_invitado[$clave]);
            }
        }
        //Retorno el carrito modificado
        return $carrito_invitado;
    }

    //Función para calcular el total del carrito de invitado
    //Devuelve el total del carrito
    public function totalCarritoInvitado()
    {
        $carrito_invitado = $this->carrito_invitado;
        //Inicializo variable total en 0
        $totalCarrito = 0;
        //Recorro cada producto del array carrito
        foreach ($carrito_invitado as $producto) {
            //Saco el precio y la cantidad de cada producto y añado a la suma de totalCarrito su multiplicación
            $precio = $producto['precio'];
            $cantidad = $producto['cantidad'];
            $totalCarrito = $totalCarrito + ($precio * $cantidad);
        }
        //Retorno el total del carrito
        return $totalCarrito;
    }

    //Función para vaciar el carrito
    //Retorna el array carrito vacío usando solo la inicialización por así decirlo ($array = [])
    public function vaciarCarritoInvitado()
    {
        $carrito_invitado = $this->carrito_invitado;
        $carrito_invitado = [];
        return $carrito_invitado;
    }
}
