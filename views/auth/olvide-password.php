<h1 class="nombre-pagina">Olvide mi Password</h1>
<p class="descripcion-pagina">Restablece tu password escribiendo tu email a continuacion</p>

<?php require_once __DIR__."/../templates/alertas.php"; ?>

<form action="/olvide" class="formulario" method="POST">

      <div class="campo">

            <label for="email">Email:</label>
            <input type="email" id="email" placeholder="Tu email" name="email">
        </div>

<input type="submit" class="boton" value="Enviar Instrucciones">


</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia session</a>
    <a href="crear-cuenta">¿Aun no tienes una cuenta? crear una</a>
</div>

<footer class="footer text-white">
    <p class="text-center">&copy; <span>Miguel Angel Suarez | <?php echo(date('Y') ); ?></span>. Todos los derechos reservados</p>
</footer>