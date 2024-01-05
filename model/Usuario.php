<?php
//Incluyo la clase de conexión a la BD y la clase producto
require_once 'TiendaDB.php';
require_once 'Producto.php';

class Usuario
{
    private $id_usuario;
    private $nombre;
    private $email;
    private $contrasenia;
    private $cookie_id;

    //En todas las funciones utilizo el método estático de conexión de la clase TiendaDB
    //consultas preparadas para mayor seguridad y evitar la inyección de SQL
    //y la estructura try-catch para capturar excepciones en caso de error en la ejecución de alguna consulta

    //Función pública estática para obtener los datos de un usuario

    public static function mostrarDatosUsuario($email)

    {
        try {
            //Conexión a BD
            $conexion = TiendaDB::conexionDB();

            //1. Prepara la consulta
            $sql = 'SELECT * FROM usuario WHERE email=:email;';
            $consulta = $conexion->prepare($sql);
            //2. Une los parámetros
            $consulta->bindParam(':email', $email);
            //3. Ejecuta la consulta
            $consulta->execute();
            //4. Retorna los resultados
            $resultados = $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
            return $resultados;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        } finally {

            //Cierro la conexión para liberar recursos
            if ($conexion) {
                $conexion = null;
            }
        }
    }

    //Función estática para buscar un usuario por email

    public static function buscarUsuario($email)
    {

        try {
            //Conexión a BD
            $conexion = TiendaDB::conexionDB();

            //1. Prepara la consulta
            $sql = 'SELECT * FROM usuario WHERE email=:email;';
            $consulta = $conexion->prepare($sql);
            //2. Une los parámetros
            $consulta->bindParam(':email', $email);
            //3. Ejecuta la consulta
            $consulta->execute();
            //4. Verifico si hay resultados
            if ($consulta->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        } finally {

            //Cierro la conexión para liberar recursos
            if ($conexion) {
                $conexion = null;
            }
        }
    }


    //Función estática para registrar nuevo usuario a la BD usuarios. 
    //Toma por parámetros el nombre, email y la contraseña previamente validados
    public static function crearUsuario($nombre, $email, $hash)
    {

        try {
            //Conexión a BD
            $conexion = TiendaDB::conexionDB();

            //1. Prepara la consulta
            $sql = 'INSERT INTO usuario(nombre, email, contrasenia) VALUES (:nombre, :email,:pass);';
            $consulta = $conexion->prepare($sql);

            //2. Une los parámetros
            $consulta->bindParam(':nombre', $nombre);
            $consulta->bindParam(':email', $email);
            $consulta->bindParam(':pass', $hash);

            //3. Ejecuta la consulta
            $consulta->execute();

            //Capturo el error y muestro el mensaje en caso de ejecución fallida
        } catch (PDOException $e) {

            echo 'Error: ' . $e->getMessage();
        } finally {

            //Cierro la conexión para liberar recursos
            if ($conexion) {
                $conexion = null;
            }
        }
    }

    //Función estática para obtener ID de invitado mediante su email
    public static function buscarIdUsuario($email)
    {

        try {
            //Conexión a BD
            $conexion = TiendaDB::conexionDB();

            //1. Prepara la consulta
            $sql = 'SELECT id_usuario FROM usuario WHERE email=:email;';
            $consulta = $conexion->prepare($sql);
            //2. Une los parámetros
            $consulta->bindParam(':email', $email);
            //3. Ejecuta la consulta
            $consulta->execute();
            //4. Retorna el id de usuario
            while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                return $row['id_usuario'];
            }
            //Capturo el error y muestro el mensaje en caso de ejecución fallida
        } catch (PDOException $e) {

            echo 'Error: ' . $e->getMessage();
        } finally {

            //Cierro la conexión para liberar recursos
            if ($conexion) {
                $conexion = null;
            }
        }
    }

    //Métodos getters para obtener la información de los productos

    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    public function getNombreUsuario()
    {
        return $this->nombre;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPass()
    {
        return $this->contrasenia;
    }

    public function getImagen()
    {
        return $this->cookie_id;
    }

    public function buscarUsuarioHash($email)
    {
        try {
            //Conexión a BD
            $conexion = TiendaDB::conexionDB();

            //1. Prepara la consulta
            $sql = 'SELECT * FROM usuario WHERE email=:email';
            $consulta = $conexion->prepare($sql);
            //2. Une los parámetros
            $consulta->bindParam(':email', $email);
            //3. Ejecuta la consulta
            $consulta->execute();
            //4. Retorna el hash de contraseña del usuario buscado
            while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                return $row['contrasenia'];
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        } finally {

            //Cierro la conexión para liberar recursos
            if ($conexion) {
                $conexion = null;
            }
        }
    }

    public function coincideContraseniaHash($contrasenia, $contraseniaBD)
    {
        return password_verify($contrasenia, $contraseniaBD);
    }

    //Función estática para crear un usuario invitado que puede ser usada desde fuera de la clase
    //Sin necesidad de instanciarla (desde ControladorUsuario.php)

    public static function crearUsuarioInvitado($nombre, $cookie_id)
    {
        try {
            //Conexión a BD
            $conexion = TiendaDB::conexionDB();

            //1. Prepara la consulta
            $sql = 'INSERT INTO usuario(nombre, email, contrasenia, cookie_id) VALUES (:nombre,  :email , "usuario_invitado", :id_invitado);';
            $consulta = $conexion->prepare($sql);

            //2. Une los parámetros
            $consulta->bindParam(':nombre', $nombre);
            $consulta->bindParam(':id_invitado', $cookie_id);
            $consulta->bindValue(':email', $cookie_id . '@chocolat.com');

            //3. Ejecuta la consulta
            $consulta->execute();

            //Capturo el error y muestro el mensaje en caso de ejecución fallida
        } catch (PDOException $e) {

            echo 'Error: ' . $e->getMessage();
        } finally {

            //Cierro la conexión para liberar recursos
            if ($conexion) {
                $conexion = null;
            }
        }
    }

    //Función estática para buscar ID de usuario invitado que puede ser usada desde fuera de la clase
    //Sin necesidad de instanciarla (por ejemplo desde ControladorUsuario.php)

    public static function buscarIdInvitado($cookie_id)
    {
        try {
            //Conexión a BD
            $conexion = TiendaDB::conexionDB();

            //1. Prepara la consulta
            $sql = 'SELECT id_usuario FROM usuario WHERE cookie_id=:id;';
            $consulta = $conexion->prepare($sql);
            //2. Une los parámetros
            $consulta->bindParam(':id', $cookie_id);
            //3. Ejecuta la consulta
            $consulta->execute();
            //4. Retorna el id de usuario
            while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                return $row['id_usuario'];
            }
            //Capturo el error y muestro el mensaje en caso de ejecución fallida
        } catch (PDOException $e) {

            echo 'Error: ' . $e->getMessage();
        } finally {

            //Cierro la conexión para liberar recursos
            if ($conexion) {
                $conexion = null;
            }
        }
    }
}
