<?php

//se inicializa la sesion
session_start();

//Print de prueba
echo "<script>console.log( 'Debug Objects: " . "entro". "' );</script>";

if (isset($_SESSION['username'])) {//se valida si ya esta una sesion activa.
	header('location: ../../index.php');
}

//se valida que los campos de usuario y de clave no hayan sido enviados con texto vacio.
if (isset($_POST['COD_CLIENTE']) && isset($_POST['NOMBRE']) &&isset($_POST["MENSAJE"])) {
  bool mail ( string $to , string $subject , string $message [, string $additional_headers [, string $additional_parameters ]] )

}else{
	//se redirecciona al login con un mensaje de error
	header('location: ../../index.php?msg=DEBE LLENAR AMBOS CAMPOS.');
}

?>
