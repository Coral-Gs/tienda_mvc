<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--VISTA DE TIENDA INVITADO-->

<!--MUESTRA DE PRODUCTOS-->
<!--Envía datos al controlador de carrito c.tiendaInvitado.php-->

<div class="row">
    <h3 class="categoria-productos"><?php echo $titulo_tienda ?></h3>
    <div class="col-sm-10 col-md-9 col-lg-10">
        <div class="row" id="contenedor-tienda">
            <!--VISUALIZACIÓN DE PRODUCTOS Y FORMULARIO PARA COMPRAR CADA PRODUCTO-->
            <!--El boton para comprar cada producto está compuesto por ' comprar+idproducto', de modo que al darle a comprar tenga acceso a los datos del producto correspondiente el array $productos contendrá todos los productos o productos filtrados/buscados y muestro la información con un foreach-->
            <?php
            //Muestro los productos al usuario con/ sin filtrado con un foreach que recorre array asociativo $productos
            foreach ($productos as $producto) : ?>
                <div class="col-sm-4 col-md-3 col-lg-2" id="contenedor-producto">
                    <div class='producto'>
                        <form method="post" action="../../controller/invitado/c.tiendaInvitado.php">
                            <!-- Uso el método base64_encode($str) de PHP para codificar los datos de las imágenes que obtengo de la base de datos 
                            y poder mostrarlas directamente, en lugar de utilizar enlaces externos. El atributo data:image/jpeg;base64 especifica que 
                            es una imagen en formato base64-->
                            <img src="data:image/jpeg;base64,<?= base64_encode($producto->getImagen()) ?>" alt="Imagen del producto" width="100"><br>
                            <?= $producto->getNombre() ?><br>
                            <?= $producto->getPrecio() ?> €<br>
                            <input type="submit" name="comprar<?= $producto->getIdProducto() ?>" value="Añadir al carrito" class="boton-comprar">
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!--CARRITO DE LA COMPRA-->

    <div class="col-sm-2 col-md-3 col-lg-2" id="contenedor-carrito">
        <p class="cabecera-carrito">Carrito</p>
        <?php
        echo $mensaje_carrito;
        //Muestro productos del carrito con un foreach que recorre array asociativo $productos_carrito
        foreach ($carrito_invitado as $producto_carrito) :
        ?>
            <form method="post" action="../../controller/invitado/c.tiendaInvitado.php">
                <div class="producto-carrito">
                    <img src="data:image/jpeg;base64,<?= base64_encode(Producto::obtenerImagenPorId($producto_carrito['id_producto'])) ?>" alt="Imagen del producto" width="50"><br>
                    <?= $producto_carrito['nombre'] ?><br>
                    <?= $producto_carrito['precio'] ?> €<br><br>

                    <!--Botones para sumar y restar unidades de un producto del carrito y eliminar productos-->
                    <input type="submit" name="restar<?= $producto_carrito['id_producto'] ?>" value="-">
                    <?= $producto_carrito['cantidad'] ?>
                    <input type="submit" name="sumar<?= $producto_carrito['id_producto']  ?>" value="+"><br><br>
                    <input type="submit" name="eliminar<?= $producto_carrito['id_producto']  ?>" value="Eliminar" class="boton-eliminar">
                </div>
            </form>
        <?php endforeach;
        echo '<strong>' . $total . '</strong>';
        echo $boton_finalizar; ?>
    </div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>