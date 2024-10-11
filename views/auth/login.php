<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Iniciar sesion con tus datos</p>
<?php require_once __DIR__."/../templates/alertas.php"; ?>

<form class="formulario" method="POST"  action="/">
    <div class="campo">
        <label for="email">EMAIL</label>
        <input type="email" id="email" placeholder="Tu Email" name="email"/>
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Tu password">
    </div>
    <input type="submit" value="Iniciar session" class="boton" >

</form>

<div class="acciones">
    <a href="crear-cuenta">¿Aun no tienes cuenta?</a>
    <a href="olvide">Olvidaste tu password?</a>
</div>


<footer class="footer text-white">
    <p class="text-center">&copy; <span>Miguel Angel Suarez | <?php echo(date('Y') ); ?></span>. Todos los derechos reservados</p>
</footer>