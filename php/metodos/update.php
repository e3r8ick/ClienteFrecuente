<?php
include_once '../conexion/conexion.php';

//post
$selectOption = $_POST['frec'];

//codigo de usuario del cookie
$Pusuario = $_COOKIE["COD_CLIENTE"];

//se instancia la clase conexion y se le otorga el string de conexion a una nueva variable
$con = new Conexion();
$conexion = $con->get_Conexion();

try{
  //setear los errores
  //$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //se crea la sentencia SQL
  //$sql = "UPDATE GEN_CLIENTE SET CONTRASENIA='".$Ppassword."' WHERE COD_CLIENTE='".$Pusuario."';";
  $sql = "UPDATE GEN_CLIENTE SET FREC_ESTADO = ? WHERE COD_CLIENTE = ?";
  //prepara el statement
  $stmt = $conexion->prepare($sql);
  // ejecuta el query
  $stmt->execute(array($selectOption, $Pusuario));
  //echo "<script>console.log( 'Debug Objects: " .$sql. "' );</script>";
  echo "<script>console.log( 'Debug Objects: " .$stmt->rowCount(). "' );</script>";
  header('location: ../perfil.php');
}
catch(PDOException $e){
    echo "<script>console.log( 'Debug Objects: " .$e->getMessage(). "' );</script>";
}

$conexion = null;
return true;
?>
