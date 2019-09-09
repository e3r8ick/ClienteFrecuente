<?php

//se inicializa la sesion
session_start();

//Print de prueba
echo "<script>console.log( 'Debug Objects: " . "entro". "' );</script>";

if (isset($_SESSION['username'])) {//se valida si ya esta una sesion activa.
	header('location: ../../index.php');
}

//se valida que los campos de usuario y de clave no hayan sido enviados con texto vacio.
if (isset($_POST['username']) && isset($_POST['password'])) {

	// se establecen las variables de POST en variables locales.
	$user = $_POST['username'];
	#hash de las contraseñas
	//$pass = md5($_POST['password']);
	$pass = $_POST['password'];

	//se incluye una sola vez la clase conexion y la clase de metodos, para poder accesar a sus funciones.
	require_once ('../conexion/conexion.php');
	require_once ('../conexion/metodos.php');

	//se instancia la clase de metodos.
	$metodos = new Metodos();
	//se obtienen el usuario que coincide en el usuario, clave y cia.
	$result = $metodos->LoginUser($pass,$user);

	//se valida que el resultado traiga datos, en caso de que no traiga nada
	//el usuario no existe o las credenciales no coinciden.
	if ($result['COD_CLIENTE'] != null) {

		//se valida que el resultado del query y los datos introducidos sean correctos.
		if ($user == $result['COD_CLIENTE'] && $pass == $result['CONTRASENIA']) {

			//se establecen las variables de sesion iniciales.
			$_SESSION['username'] = $result['COD_CLIENTE'];
			//si el usuario es 001 el admin se direcciona al admin
			if((strcmp ($_SESSION['username'], "04"))==0){
				setcookie("ADMIN", "1", time() + 86400,"/");
				setcookie("COD_CLIENTE", $_SESSION['username'], time() + 86400, "/");
				header('location: ../admin.php');
			}else{
				// se redirecciona a la pagina de inicio del usuario.
				header('location: ../perfil.php');
				//seteamos el cookie del codigod e Cliente
				setcookie("COD_CLIENTE", $_SESSION['username'], time() + 86400, "/");
			}
		}else{
			//se redirecciona al login con un mensaje de error
			header('location: ../../index.php?msg=DATOS INCORRECTOS1');
		}

	}else{
		//se redirecciona al login con un mensaje de error
		header('location: ../../index.php?msg=DATOS INCORRECTOS2');
	}

}else{
	//se redirecciona al login con un mensaje de error
	header('location: ../../index.php?msg=DEBE LLENAR AMBOS CAMPOS');
}

?>
