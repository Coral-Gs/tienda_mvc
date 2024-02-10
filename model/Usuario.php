<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--MODELO USUARIO-->

<!--Modelo Usuario maneja todas las operaciones relacionadas con la tabla Usuario en la BD-->

<?php
//Incluyo la clase de conexión a la BD y la clase ControladorUsuario
require_once 'TiendaDB.php';
require_once 'ControladorUsuario.php';

class Usuario
{
    //Cada propiedad de la clase corresponde a cada campo de la tabla Producto en la BD

    private $id_usuario;
    private $nombre;
    private $email;
    private $contrasenia;

    //En todas las funciones utilizo el método estático de conexión de la clase TiendaDB
    //consultas preparadas para mayor seguridad y evitar la inyección de SQL
    //y la estructura try-catch para capturar excepciones en caso de error en la ejecución de alguna consulta

    //Métodos getters para obtener la información de los usuarios

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


    //Función pública estática para obtener los datos de un usuario. 
    //Devuelve la fila como un objeto Usuario y puedo acceder a los datos con los Getters

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
            //4. Obtengo los resultados como un array de objetos de clase Usuario
            //para después poder usar los métodos getters y obtener los datos que me interesan del usuario.
            //He intentado usar fetch para que me devuelva una sola fila en lugar de fetchAll pero me daba error
            //al usarlo con FETCH_CLASS, de modo que lo he dejado como fetchAll (aunque según la consulta que realizo solo me debería devolver una fila de todas maneras)
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

    //Función estática para buscar un usuario por email. 
    //Devuelve true si ha encontrado al usuario o false si no existte en la BD

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
            //4. Verifico si hay resultados con la función rowCount()
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
    public static function crearUsuario($nombre, $email, $contrasenia)
    {

        //Uso la función estátita hashContrasenia de ControladorUsuario
        //Para crear un hash de contraseña según el parámetro de contraseña pasado, aporta más seguridad a las contraseñas de usuario
        //Ya que no las guardo como texto plano en la BD 
        $hash = ControladorUsuario::hashContrasenia($contrasenia);

        try {
            //Conexión a BD
            $conexion = TiendaDB::conexionDB();

            //1. Preparo la consulta
            $sql = 'INSERT INTO usuario(nombre, email, contrasenia) VALUES (:nombre, :email,:pass);';
            $consulta = $conexion->prepare($sql);

            //2. Uno los parámetros con bindParam()
            $consulta->bindParam(':nombre', $nombre);
            $consulta->bindParam(':email', $email);
            $consulta->bindParam(':pass', $hash);

            //3. Ejecutao la consulta
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

    //Función estática para obtener ID de usuario mediante su email
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

    //Función estática para comprobar si la contraseña asociada al email que ha introducido el usuario
    //Concuerda con el hash asociado en la BD, según el email introducido
    //Devuelve un valor booleano true si coinciden o false si no coinciden
    public static function comprobarContraseniaHash($contrasenia, $email)
    {
        $usuarioHash = '';
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
            //4. Recupera el hash de contraseña del usuario buscado en la BD
            while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $usuarioHash = $row['contrasenia'];
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        } finally {

            //Cierro la conexión para liberar recursos
            if ($conexion) {
                $conexion = null;
            }
        }
        //Verifica si la contraseña introducida concuerda con el hash asociado en la BD
        //Si concuerda, me devuelve True y si no False
        if (password_verify($contrasenia, $usuarioHash)) {
            return true;
        } else {
            return false;
        }
    }
}
