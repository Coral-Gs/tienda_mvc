<?php
//Incluyo la clase de conexión a la BD y la clase producto
require_once 'TiendaDB.php';
require_once 'Producto.php';

//La clase carrito para la tabla carrito de la BD y las funciones para manejarlo

class Carrito
{
    protected $id_usuario;
    protected $id_producto;
    protected $cantidad;

    //En todas las funciones utilizo el método estático de conexión de la clase TiendaDB
    //consultas preparadas para mayor seguridad y evitar la inyección de SQL
    //y la estructura try-catch para capturar excepciones en caso de error en la ejecución de alguna consulta

    //GETTERS
    public function getIdUsuario()
    {
        return $this->id_usuario;
    }
    public function getIdProducto()
    {
        return $this->id_producto;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }
    //SETTER para añadir id_usuario a objeto carrito
    public function setIdUsuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    //Función para obtener los datos del carrito, es decir id_producto y cantidad de cada uno
    public function obtenerDatosCarrito()
    {
        $id_usuario = $this->id_usuario;

        try {
            //Conexióna BD
            $conexion = TiendaDB::conexionDB();

            //1. Prepara la consulta
            $sql = 'SELECT * FROM carrito WHERE id_usuario=:id_usuario';
            $consulta = $conexion->prepare($sql);
            //2. Une los parámetros
            $consulta->bindParam(':id_usuario', $id_usuario);
            //3. Ejecuta la consulta
            $consulta->execute();
            //4. Devuelve los resultados como un objeto de Carrito por cada fila
            $resultados = $consulta->fetchAll(PDO::FETCH_CLASS, 'Carrito');
            return $resultados;
        } catch (PDOException $e) {
            return 'Error: ' . $e->getMessage();
        } finally {

            //Cierro la conexión para liberar recursos
            if ($conexion) {
                $conexion = null;
            }
        }
    }

    //Función  para mostrar si un producto existe o no en el carrito de un usuario
    public function buscarProductoCarrito($id_producto)
    {
        $id_usuario = $this->id_usuario;

        try {
            //Conexióna BD
            $conexion = TiendaDB::conexionDB();

            //1. Prepara la consulta
            $sql = 'SELECT * FROM carrito WHERE id_usuario=:id_usuario AND id_producto=:id_producto;';
            $consulta = $conexion->prepare($sql);
            //2. Une los parámetros
            $consulta->bindParam(':id_usuario', $id_usuario);
            $consulta->bindParam(':id_producto', $id_producto);
            //3. Ejecuta la consulta
            $consulta->execute();
            //4. Verifico si hay resultados o no
            if ($consulta->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return 'Error: ' . $e->getMessage();
        } finally {

            //Cierro la conexión para liberar recursos
            if ($conexion) {
                $conexion = null;
            }
        }
    }

    //Función para agregar un producto al carrito
    public function agregarProducto($id_producto)
    {
        $id_usuario = $this->id_usuario;

        try {
            //Conexióna BD
            $conexion = TiendaDB::conexionDB();

            //1. Creo la sentencia SQL
            $sql = 'INSERT INTO carrito (id_usuario, id_producto) VALUES (:id_usuario, :id_producto);';
            //2. Preparo la consulta almacenada
            $consulta = $conexion->prepare($sql);
            //3. Uno los datos que recibe la función a la consulta
            $consulta->bindParam(':id_usuario', $id_usuario);
            $consulta->bindParam(':id_producto', $id_producto);
            //4. Ejecuto la consulta
            $consulta->execute();
        } catch (PDOException $e) {
            return 'Error: ' . $e->getMessage();
        } finally {

            //Cierro la conexión para liberar recursos
            if ($conexion) {
                $conexion = null;
            }
        }
    }


    //Función para modificar cantidad de un producto desl carrito
    public function modificarCantidadProducto($id_producto, $operacion)
    {

        $id_usuario = $this->id_usuario;

        try {
            //Conexióna BD
            $conexion = TiendaDB::conexionDB();
            //Dependiendo de la operación dada utilizo una sentencia SQL u otra
            if ($operacion == 'sumar') {
                $sql = 'UPDATE carrito SET cantidad = cantidad+1 WHERE id_usuario=:id_usuario AND id_producto=:id_producto;';
            } elseif ($operacion == 'restar') {
                $sql = 'UPDATE carrito SET cantidad = cantidad-1 WHERE id_usuario=:id_usuario AND id_producto=:id_producto;';
            }
            //Preparo la consulta, uno parámetros y ejecuto
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(':id_usuario', $id_usuario);
            $consulta->bindParam(':id_producto', $id_producto);
            $consulta->execute();
        } catch (PDOException $e) {
            return 'Error: ' . $e->getMessage();
        } finally {

            //Cierro la conexión para liberar recursos
            if ($conexion) {
                $conexion = null;
            }
        }
    }

    //Función para eliminar un producto del carrito
    //Elimina por id_producto seleccionado + id_usuario asociado
    public function eliminarProducto($id_producto)
    {
        $id_usuario = $this->id_usuario;

        try {
            //Conexióna BD
            $conexion = TiendaDB::conexionDB();

            $sql = 'DELETE FROM carrito WHERE id_usuario=:id_usuario AND id_producto=:id_producto;';
            //Preparo la consulta, uno parámetros y ejecuto
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(':id_usuario', $id_usuario);
            $consulta->bindParam(':id_producto', $id_producto);
            $consulta->execute();
        } catch (PDOException $e) {
            return 'Error: ' . $e->getMessage();
        } finally {

            //Cierro la conexión para liberar recursos
            if ($conexion) {
                $conexion = null;
            }
        }
    }
    //Función para vaciar el carrito
    //Elimina todas las ocurrencias del id_usuario seleccionado de la tabla carritos, es decir, todos los productos

    public function vaciarCarrito()

    {
        $id_usuario = $this->id_usuario;
        try {
            //Conexióna BD
            $conexion = TiendaDB::conexionDB();

            $sql = 'DELETE FROM carrito WHERE id_usuario=:id_usuario';
            //Preparo la consulta, uno parámetros y ejecuto
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(':id_usuario', $id_usuario);
            $consulta->execute();
        } catch (PDOException $e) {
            return 'Error: ' . $e->getMessage();
        } finally {

            //Cierro la conexión para liberar recursos
            if ($conexion) {
                $conexion = null;
            }
        }
    }
}

//CLASE PRODUCTOCARRITO
//Creo una clase que hereda de la clase Carrito y que además añade atributos de la clase Producto

class DetalleCarrito extends Carrito
{
    public $nombre;
    public $descripcion;
    public $precio;
    public $imagen;

    //Métodos getter

    public function getNombre()
    {
        return $this->nombre;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function getPrecio()
    {
        return $this->precio;
    }
    public function getImagen()
    {
        return $this->imagen;
    }

    //Función para obtener los datos del carrito
    //Devuelve un array de objetos de la clase ProductoCarrito. 
    //Cada fila de la tabla es un objeto ProductoCarrito, por lo que puedo acceder a las propiedades
    //De cada cada uno utilizando getters de esta clase y de la clase padre Carrito

    public function mostrarDatosCarrito()
    {
        $id_usuario = $this->id_usuario;
        try {
            $conexion = TiendaDB::conexionDB();

            //Utilizo un JOIN para obtener los datos de los productos del carrito
            //ON para unir las dos tablas y WHERE para seleccionar el id_usuario deseado
            $sql = 'SELECT carrito.id_usuario, producto.id_producto, producto.nombre, producto.descripcion, producto.precio, producto.imagen, carrito.cantidad
                FROM carrito
                JOIN producto ON carrito.id_producto=producto.id_producto
                WHERE carrito.id_usuario=:id_usuario;';
            //Preparo la consulta, uno parámetros y ejecuto
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(':id_usuario', $id_usuario);
            $consulta->execute();

            $resultados = $consulta->fetchAll(PDO::FETCH_CLASS, 'DetalleCarrito');
            return $resultados;
        } catch (PDOException $e) {
            return 'Error: ' . $e->getMessage();
        } finally {

            //Cierro la conexión para liberar recursos
            if ($conexion) {
                $conexion = null;
            }
        }
    }

    //Función para calcular el total del carrito de un usuario
    public function totalCarrito()
    {
        $id_usuario = $this->id_usuario;

        try {
            $conexion = TiendaDB::conexionDB();

            //Utilizo un JOIN para obtener la suma total del carrito
            //ON para unir las dos tablas y la clausula GROUP BY para agrupar por ID de usuario
            $sql = 'SELECT carrito.id_usuario, SUM(producto.precio * carrito.cantidad) AS total_carrito
        FROM carrito
        JOIN producto ON carrito.id_producto=producto.id_producto
        WHERE id_usuario=:id_usuario
        GROUP BY carrito.id_usuario;';
            //Preparo la consulta, uno parámetros y ejecuto
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(':id_usuario', $id_usuario);
            $consulta->execute();

            //Obtengo los resultados con fetch en lugar de fetchAll porque solo quiero obtener una fila
            $row = $consulta->fetch(PDO::FETCH_ASSOC);
            //Si hay resultado aparece el total y si no 0.
            if ($row) {
                return $row['total_carrito'];
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            return 'Error: ' . $e->getMessage();
        } finally {

            //Cierro la conexión para liberar recursos
            if ($conexion) {
                $conexion = null;
            }
        }
    }
}
