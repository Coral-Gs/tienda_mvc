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

    //Si se ha elegido una categoría diferente de 'todos' muestra los productos seleccionados
    if (isset($_GET['categoria']) && $_GET['categoria'] != "todos") {
        $categoria = $_GET['categoria'];
        $productos = Producto::filtrarProductosCategoria($categoria);
        $titulo_tienda = 'Selección de ' . $categoria;

        //Si se ha elegido buscar un producto muestra el producto buscado o que contenga esa palabra 
        //y si no existe el producto en la tienda muestra un mensaje
    } elseif (isset($_GET['producto-buscado'])) {
        $producto_buscado = $_GET['producto-buscado'];
        $productos = Producto::filtrarProductosNombre($producto_buscado);
        if (!empty($productos)) {
            $titulo_tienda = 'Resultados de búsqueda';
        } else {
            $titulo_tienda = 'Lo sentimos, no se ha encontrado ningún producto con ese nombre.';
        }
    }
}
