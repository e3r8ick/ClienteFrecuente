<?php

//se inicializa la sesion
session_start();

//Print de prueba
	echo "<script>console.log( 'Debug Objects: " . "entroR". "' );</script>";

/*if (isset($_SESSION['username'])) {//se valida si ya esta una sesion activa.
	header('location: ../../index.php');
}*/

//se valida que los campos de usuario y de clave no hayan sido enviados con texto vacio.
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['passwordC'])) {

	// se establecen las variables de POST en variables locales.
	$user = $_POST['username'];
	$pass = $_POST['password'];
	$passC = $_POST['passwordC'];

	//se incluye una sola vez la clase conexion y la clase de metodos, para poder accesar a sus funciones.
	require_once ('../conexion/conexion.php');
	require_once ('../conexion/metodos.php');

	//creamos el hash de las contraseña
	$hash = password_hash ( $pass , PASSWORD_BCRYPT);
	echo "<script>console.log( 'Debug Objects: " .$hash. "' );</script>";

	if(password_verify ( $passC , $hash )){
		echo "<script>console.log( 'Debug Objects: " ."iguales". "' );</script>";
		//se instancia la clase de metodos.
		$metodos = new Metodos();
		//se obtienen el usuario que coincide en el usuario, clave y cia.
		$result = $metodos->RegisterUser($user,$pass,$passC);
		$result = $metodos->LoginUser($pass,$user);


		//se establecen las variables de sesion iniciales.
		$_SESSION['username'] = $result['COD_CLIENTE'];
		//$_SESSION['nombre-usuario'] = $result['DES_USUARIO'];

		//y se redirecciona a la pagina de inicio del usuario.
		header('location: ../perfil.php');

		//se valida que el resultado traiga datos, en caso de que no traiga nada
		//el usuario no existe o las credenciales no coinciden.
	}else{
		header('location: ../registro.php?msg=CONTRASEÑAS NO COINCIDEN.');
	}

}else{
		//se redirecciona al login con un mensaje de error
		header('location: ../registro.php?msg=DEBE LLENAR TODOS LOS CAMPOS.');
}
return $result;

?>
