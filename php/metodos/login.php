<?php

//se inicializa la sesion
session_start();

if (isset($_SESSION['username'])) {//se valida si ya esta una sesion activa.
	header('location: ../user/index.php');
}

//se valida que los campos de usuario y de clave no hayan sido enviados con texto vacio.
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['cia'])) {

	// se establecen las variables de POST en variables locales.
	$user = $_POST['username'];
	$pass = $_POST['password'];
	$cia = $_POST['cia'];
	$sucursal = $_POST['sucursal'];

	//se incluye una sola vez la clase conexion y la clase de metodos, para poder accesar a sus funciones.
	require_once ('../conexion-login/conexion.php');
	require_once ('../conexion-login/metodos.php');

	//se instancia la clase de metodos.
	$metodos = new Metodos();
	//se obtienen el usuario que coincide en el usuario, clave y cia.
	$result = $metodos->LoginUser($pass,$user,$cia, $sucursal);

	//se valida que el resultado traiga datos, en caso de que no traiga nada
	//el usuario no existe o las credenciales no coinciden.
	if ($result['COD_USUARIO'] != null) {

		//se valida que el resultado del query y los datos introducidos sean correctos.
		if ($user == $result['COD_USUARIO'] && $pass == $result['CLAVE_USUARIO']) {

			//se establecen las variables de sesion iniciales.
			$_SESSION['username'] = $result['COD_USUARIO'];
			$_SESSION['nombre-usuario'] = $result['DES_USUARIO'];
			$_SESSION['sucursal'] = $sucursal;
			$_SESSION['cia'] = $cia;
			$_SESSION['cod-agente'] = $result['COD_AGENTE'];

			//y se redirecciona a la pagina de inicio del usuario.
			header('location: ../user/index.php');

		}else{
			//se redirecciona al login con un mensaje de error
			header('location: ../index.php?msg=DATOS INCORRECTOS.');
		}

	}else{
		//se redirecciona al login con un mensaje de error
		header('location: ../index.php?msg=DATOS INCORRECTOS.');
	}

}else{
	//se redirecciona al login con un mensaje de error
	header('location: ../index.php?msg=DEBE LLENAR AMBOS CAMPOS.');
}

?>
