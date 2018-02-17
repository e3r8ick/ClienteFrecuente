<?php
  include_once '../conexion/conexion.php';
  $con = new Conexion();
  $conexion = $con->get_Conexion();


  if (isset($_POST['date1']) && isset($_POST['date2'])) {

  	// se establecen las variables de POST en cookies
    setcookie("FECHA1", $_POST["date1"]);
    setcookie("FECHA2", $_POST["date2"]);
    header('location: ../mostrarhistorial.php');
  }else{
    header('location: ../historial.php');
  }
?>
