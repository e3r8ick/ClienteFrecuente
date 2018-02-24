<?php

//se inicializa la sesion
/*session_start();

//Print de prueba
echo "<script>console.log( 'Debug Objects: " . "entro". "' );</script>";

if (isset($_SESSION['username'])) {//se valida si ya esta una sesion activa.
	header('location: ../../index.php');
}
//
mail ( "eguicoro2@gmail.com" , "Ayuda" , "Hello World" );
echo "<script>console.log( 'Debug Objects: " . "Correo Enviado". "' );</script>";
//se valida que los campos de usuario y de clave no hayan sido enviados con texto vacio.
if (isset($_POST['COD_CLIENTE']) && isset($_POST['NOMBRE']) &&isset($_POST["MENSAJE"])) {
  //mail ( "eguicoro2@gmail.com" , "Ayuda" , "Hello World" );

}else{
	//se redirecciona al login con un mensaje de error
	//header('location: ../ayuda.php');
}*/
mail ( "eguicoro2@gmail.com" , "Ayuda" , "Hello World" );

?>
