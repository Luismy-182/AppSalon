<h1 class="nombre-pagina">Crear</h1>
<p class="descripcion-pagina">Crea un nuevo servicio</p>


<?php 
include_once __DIR__.'/../templates/barra.php';
include_once __DIR__.'/../templates/alertas.php';
?>

<form action="/servicios/crear" method="POST" class="formulario">

    <?php include_once __DIR__ . '/formulario.php'; ?>
    <input type="submit" class="boton" value="Guardar servicio">
</form>