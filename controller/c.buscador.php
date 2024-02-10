<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--CONTROLADOR DE BUSCADOR/FILTRO-->

<!--El controlador de buscador procesa la información que llega de la vista buscador.php

Utilizo el método GET puesto que no es información sensible y de este modo el usuario podría
guardar la URL para futuras visitas o para compartir el enlace con otras personas. 
Utilizo el array súperglobal de GET para saber qué categoría se ha seleccionado 
y obtener los productos buscados con los métodos estáticos de la clase Producto-->

<?php

//El título de la tienda varía en función de la categoría o nombre buscado
$titulo_tienda = '';

//Compruebo si se ha enviado el formulario por GET y si se ha escogido una categoría o si se ha buscado un producto

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    //Si he elegido una categoría que no sea la de 'todos' me muestra los productos seleccionados
    if (isset($_GET['categoria']) && $_GET['categoria'] != "todos") {
        $categoria = $_GET['categoria'];
        $productos = Producto::filtrarProductosCategoria($categoria);
        $titulo_tienda = 'Selección de ' . $categoria;

        //Si en lugar de eso he elegido buscar un producto por nombre, me saca el producto buscado o que contenga esa palabra 
        //y si no existe el producto en la tienda muestra un mensaje de que no se ha encontrado el producto
    } elseif (isset($_GET['producto-buscado'])) {
        $producto_buscado = $_GET['producto-buscado'];
        //Para obtener el producto/los productos buscados, llamo a la función estática correspondiente
        //pasandole por parámetro lo que ha introducido el usuario en la búsqueda
        $productos = Producto::filtrarProductosNombre($producto_buscado);
        //Si me devuelve algún producto el título será 'resultados de búsqueda' y si no un mensaje de que no se ha encontrado
        if (!empty($productos)) {
            $titulo_tienda = 'Resultados de búsqueda';
        } else {
            $titulo_tienda = 'Lo sentimos, no se ha encontrado ningún producto con ese nombre.';
        }
    }
}
