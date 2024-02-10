<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--MODELO TIENDADB-->

<!--Clase abstracta con los datos de conexión como propiedades estáticas
que tiene un método estático público para la conexión a BD, puesto que no necesito instanciarla 
y de esta manera puedo usar la conexión directamente desde cualquier lugar del código
tal y como nos enseñaste durante la clase de MVC-->

<?php

abstract class TiendaDB
{
    private static $servidor = '127.0.0.1';
    private static $db = 'tienda';
    private static $usuario = 'admin_tienda';
    private static $pass = 'admin_tienda123';

    public static function conexionDB()
    {
        try {
            //Creo un nuevo objeto de conexión PDO y los datos de conexión necesario para acceder a mi base de datos
            $conexion = new PDO('mysql:host=' . self::$servidor . ';dbname=' . self::$db, self::$usuario, self::$pass);
            //Le indico con el atributo ATTR_ERRMODE que si hay algún error en la conexión 
            //lance un error con ERRMODE_EXCEPTION
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Si todo va bien, retorna la conexion
            return $conexion;

            //Capturo la excepción en caso de error y muestro el mensaje que me lanza
        } catch (PDOException $error) {
            echo 'Error: ' . $error->getMessage();
        }
    }
}
