<h1 class="nombre-pagina">Crear cuenta</h1>
<p class="descripcion-pagina">Llena el siguiente formularion para crear una cuenta</p>

 <?php require_once __DIR__."/../templates/alertas.php"; ?>

<form action="/crear-cuenta" class="formulario" method="POST">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" placeholder="Tu nombre" name="nombre" value="<?php echo s($usuario->nombre); ?>"/>
    </div>

    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" placeholder="Tu apellido" name="apellido" value="<?php echo s($usuario->apellido); ?>"/>
    </div>

    <div class="campo">
        <label for="telefono">Telefono</label>
        <input type="number" id="telefono" placeholder="Tu telefono" name="telefono" value="<?php echo s($usuario->telefono); ?>"/>
    </div>

    <div class="campo">
        <label for="email">E-mail</label>
        <input type="email" id="email" placeholder="Tu email" name="email" value="<?php echo s($usuario->email); ?>"/>
    </div>

    
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Tu password" name="password" value="<?php echo s($usuario->password); ?>"/>
    </div>
    <input type="submit" value="Crear cuenta" class="boton" >

</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? inicia session</a>
    <a href="olvide">Olvidaste tu password?</a>
</div>

<footer class="footer text-white">
    <p class="text-center">&copy; <span>Miguel Angel Suarez | <?php echo(date('Y') ); ?></span>. Todos los derechos reservados</p>
</footer>