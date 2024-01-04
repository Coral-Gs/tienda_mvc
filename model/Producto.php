<?php

//Incluyo la clase de conexión a la BD
require_once 'TiendaDB.php';

//La clase producto con todas las propiedades de los productos
class Producto
{
    private $id_producto;
    private $nombre;
    private $descripcion;
    private $precio;
    private $imagen;
    private $categoria;

    //Métodos getters para obtener la información de los productos

    public function getIdProducto()
    {
        return $this->id_producto;
    }

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

    public function getCategoria()
    {
        return $this->categoria;
    }

    //Función estática que devuelve un array de objetos con los datos de los productos
    //Que sea pública y estática me permite utilizar la función directamente desde cualquier lugar 
    //sin crear un nuevo objeto de producto. Después puedo acceder a los datos que me interesan
    //a través de los métodos getters, manteniendo el principio de encapsulamiento.

    public static function mostrarDatosProductos()
    {
        //Establezco conexión a BD
        $conexion = tiendaDB::conexionDB();

        try {
            //1. Setencia SQL
            $sql = 'SELECT * from producto;';
            //2. Preparo la consulta
            $consulta = $conexion->prepare($sql);
            //3. Ejecuto la consulta
            $consulta->execute();
            //4. Obtengo los resultados como un array de objetos de clase Producto
            $resultados = $consulta->fetchAll(PDO::FETCH_CLASS, 'Producto');

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
}
