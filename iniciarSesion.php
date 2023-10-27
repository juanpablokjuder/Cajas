<?php
require "app/app.php";


if($_SERVER['REQUEST_METHOD']=="POST"){
    // ver($_POST);
    $user = new usuario;
    $user->nombre=$_POST['nombre'];
    $user->contra=$_POST['contra'];
    $usuario = new Usuarios;
    if($usuario->iniciarSesion($user->nombre,$user->contra)){
        header("Location: index.php");
    }
}

html("Iniciar Sesion");

?>
<section class="fondoIniciarSesion">
    <form action="" method="post">
        <h1>Iniciar Sesion</h1>
        <input type="text" placeholder="nombre" name="nombre" required>
        <input type="password" placeholder="conrtaseña" name="contra" required>
        <button type="submit" class="btn">Iniciar</button>
    </form>
</section>