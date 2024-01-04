


<?php
//Creo una clase abstracta para la conexión a la BD y un método estático público para la conexión a BD
//Puesto que no necesito instanciarla y de esta manera puedo usar la conexión directamente
//Desde cualquier lugar del código

abstract class TiendaDB
{
    private static $servidor = '127.0.0.1';
    private static $db = 'tienda';
    private static $usuario = 'admin_tienda';
    private static $pass = 'admin_tienda123';

    public static function conexionDB()
    {
        try {
            //Creo un nuevo objeto de conexión PDO y los datos de conexión
            $conexion = new PDO('mysql:host=' . self::$servidor . ';dbname=' . self::$db, self::$usuario, self::$pass);
            //Le indico con el atributo ATTR_ERRMODE que si hay algún error en la conexión 
            //lance un error con ERRMODE_EXCEPTION
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Si todo va bien, retorna la conexion
            return $conexion;

            //Capturo la excepción en caso de error y muestro el mensaje
        } catch (PDOException $error) {
            echo 'Error: ' . $error->getMessage();
        }
    }
}
