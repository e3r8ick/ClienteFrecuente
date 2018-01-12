<?php 
//clase para cerrar sesion, en esta clase solo se inicializa la sesion 
//se destruye y se redirecciona a la pagina de inicio.

session_start();
session_destroy();
if (isset($_GET['no-cod'])) {
	header('location: ../index.php?msg= USUARIO NO TIENE CODIGO DE AGENTE.');
}else{
	header('location: ../index.php?msg= SESION FINALIZADA CORRECTAMENTE.');
}
?>