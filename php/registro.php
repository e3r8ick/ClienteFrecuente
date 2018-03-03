<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>

	<?php
	//Se inicia la sesion en php
	session_start();
	//se valida si ya hay una sesion existente
	if (isset($_SESSION['username'])) {
		//si existe una sesion, se redirecciona al usuario a la pantalla de inicio.
		header('location: php/perfil.php');
	}
	?>
<LINK REL=StyleSheet HREF="../css/login.css" TYPE="text/css">
</head>

<body onload="error();">
<form class="login" action="metodos/register.php" method="post">
    <h1 class="login-title">Cliente Frecuente</h1>
    <input type="text" id="username" name="username" class="login-input" placeholder="Cod Cliente" autofocus required="true">
    <input type="password" id="password" name="password" class="login-input" placeholder="Contraseña" required="true">
    <input type="password" id="passwordC" name="passwordC" class="login-input" placeholder="Confirmar Contraseña" required="true">

    <?php
      //se incluyen los archivos necesarios.
      require_once ('conexion/conexion.php');
      require_once ('conexion/metodos.php');
      echo "<script>console.log( 'Debug Objects: " . "sirve1". "' );</script>";
    ?>

    <input type="submit" value="Registrar" class="login-button">
  </form>

  <script>
	function error(){
		var direccion = String(document.location);
		var res = direccion.split("msg=");
		if((res[1].localeCompare("DATOS%20INCORRECTOS2"))==0){
			alert("Usuario o Contraseña Incorrecto");
		}
		else if ((res[1].localeCompare("DATOS%20INCORRECTOS1"))==0) {
			alert("Usuario o Contraseña Incorrecto");
		}
		else if ((res[1].localeCompare("CONTRASENAS%20NO%20COINCIDEN"))==0) {
			alert("Las Contraseñas No Coinciden");
		}
    else if ((res[1].localeCompare("CodUsuario"))==0) {
			alert("El Codigo de Usuario indicado No Existe");
		}
	}
	</script>
</body>
</html>
