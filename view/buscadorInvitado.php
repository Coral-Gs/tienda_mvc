<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--VISTA DE BUSCADOR/FILTRO DE PRODUCTOS-->

<!--Vista que muestra el buscador y los formularios para que el usuario pueda interactuar
utiliza el método GET para manejar la información. La petición se envía al controlador
c.tiendaInvitado para recuperar la información de los modelos y devolverla a la vista-->

<div class="row">
    <form method="get" action="../controller/c.tiendaInvitado.php" id="buscador">
        <select name=" categoria" class="filtro">
            <option value="todos">Todos los productos</option>
            <option value="bombones">Bombones</option>
            <option value="chocolates">Chocolates</option>
            <option value="vinos">Vinos</option>
        </select>
        <input type="text" name="producto-buscado" class="barra-buscador">
        <input type="submit" name="buscar" value="Buscar" class="boton-buscador">
    </form>
</div>