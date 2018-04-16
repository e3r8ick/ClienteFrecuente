<?php
//clase de conexion
class Conexion{
 //funcion publica para obtener una instancia de la conexion a la BD
 public function get_Conexion(){
	 $host='127.0.0.1';
	 //Esta conexion debe poseer la facilidad de realizar inserts, updates y selects
	 //se determina el tns
	 $tns ='
		 (DESCRIPTION =
			 (ADDRESS = (PROTOCOL = TCP)(HOST = '.$host.')(PORT = 1521))
			 (CONNECT_DATA =
				 (SERVER = DEDICATED)
				 (SERVICE_NAME = XE)
			 )
		 )';
	 //este usuario solo debe poder realizar selects.
	 //se determina el usuario de la base de datos
	 $db_username = "FRECUENtE";
	 //se determina la clave del usuario de la Base de datos.
	 $db_password = "FRECUENTE";
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
