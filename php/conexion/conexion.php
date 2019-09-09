<?php
	//clase de conexion
	class Conexion{

		//funcion publica para obtener una instancia de la conexion a la BD
		public function get_Conexion(){
			$host='192.168.179.239';
			//Esta conexion debe poseer la facilidad de realizar inserts, updates y selects

			//se determina el tns
			$tns ='
			  (DESCRIPTION =
			    (ADDRESS = (PROTOCOL = TCP)(HOST = '.$host.')(PORT = 1521))
			    (CONNECT_DATA =
			      (SERVER = DEDICATED)
			      (SERVICE_NAME = LANCOP)
			    )
			  )';

			//este usuario solo debe poder realizar selects.
			//se determina el usuario de la base de datos
			$db_username = "LANCOP";
			//se determina la clave del usuario de la Base de datos.
			$db_password = "LANCOP1978";

			//se realiza un try catch de
			try{
			    $conn = new PDO("oci:dbname=".$tns,$db_username,$db_password);
			    //$conn->exec("SET CHARACTER SET utf8");
			    return $conn;
			}catch(PDOException $e){
			    echo ($e->getMessage());
			    return 'Error al conectar';
			}

		}

	}

?>
