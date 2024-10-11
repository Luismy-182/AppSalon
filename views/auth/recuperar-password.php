<h1>Recuperar password</h1>

<p class="descripcion-pagina">Coloca tu password a continuacion</p>
<?php require_once __DIR__."/../templates/alertas.php"; ?>
<?php if($error) return; ?>

<form class="formulario" method="POST">

    <div class="campo">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Tu nuevo password">
    </div>
    <input type="submit" class="boton" value="Guardar nuevo password">
</form>


<div class="acciones">
    <a href="/">¿Ya tienes cuenta? inicia sesion</a>
    <a href="/crear-cuenta">¿Aun no tienes cuenta?. obtener una</a>
</div>


<footer class="footer text-white">
    <p class="text-center">&copy; <span>Miguel Angel Suarez | <?php echo(date('Y') ); ?></span>. Todos los derechos reservados</p>
</footer>