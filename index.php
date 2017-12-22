<?php
//Se inicia la sesion en php
session_start();
//se valida si ya hay una sesion existente
if (isset($_SESSION['username'])) {
	//si existe una sesion, se redirecciona al usuario a la pantalla de inicio.
	header('location: user/index.php');
}

?>
<LINK REL=StyleSheet HREF="css/login.css" TYPE="text/css">

<form class="login" action="php/login.php" method="post">
    <h1 class="login-title">Cliente Frecuente</h1>
    <input type="text" class="login-input" placeholder="Cod Cliente" autofocus required="true">
    <input type="password" class="login-input" placeholder="Contraseña" required="true">
    <input type="submit" value="Ingresar" class="login-button">
    <p class="login-lost"><a href="php/registro.php">¿No tiene cuenta? Registrar</a></p>
  </form>

  <?php
    //se incluyen los archivos necesarios.
    require_once ('php/conexion/conexion.php');
    echo "<script>console.log( 'Debug Objects: " . "sirve1". "' );</script>";
  ?>
