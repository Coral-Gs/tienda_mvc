<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--VISTA DE BUSCADOR/FILTRO DE PRODUCTOS-->

<!--Vista que muestra el buscador y el formulario que se envía por GET para que el usuario pueda interactuar. 
La información se envía al controlador c.tienda para recuperar los datos de los modelos y devolverlos a la vista-->


<div class="row">
    <!--Formulario se envía por el método GET al controlador de tienda-->
    <form method="get" action="../controller/c.tienda.php" id="buscador">
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