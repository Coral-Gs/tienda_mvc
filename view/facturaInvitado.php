<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--VISTA DE FACTURA DE USUARIO-->

<!--Vista para acceder a la factura una vez el usuario decide finalizar compra-->
<br><br>
<h3 class="mensaje-factura"><?= $mensaje_factura ?></h3>
<!--Muestro los datos del carrito en forma de factura de compra-->
<div class="contenedor-factura">
    <div class="factura">
        <p>Nombre: <?= $nombre_usuario ?></p>
        <p>Email: <?= $email ?></p>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
            </tr>
            <!--Recorro el carrito como un array normal-->
            <?php foreach ($carrito_invitado as $producto) : ?>
                <tr>
                    <td><?= $producto['nombre'] ?></td>
                    <td><?= $producto['cantidad'] ?></td>
                    <td><?= $producto['precio'] ?> €</td>
                    <td><?= $producto['precio'] * $producto['cantidad'] ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td><strong>Total: <?= $total_carrito ?> €</strong></td>
            </tr>
        </table>
    </div>
    <div class="formulario-factura">
        <!--Formulario para generar factura y vaciar el carrito-->
        <?= $boton_finalizar ?>
        <!--Formulario para volver a la página de tienda después de comprar-->
        <form method="POST" action="../controller/c.tiendaInvitado.php">
            <input type="submit" name="seguir_compra" value="Seguir comprando" class="boton-seguir">
        </form>
    </div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>