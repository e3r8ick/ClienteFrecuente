<?php
  include_once '../conexion/conexion.php';
  $con = new Conexion();
  $conexion = $con->get_Conexion();

  if (isset($_POST['date1']) && isset($_POST['date2']) && $_POST['date1']!=null && $_POST['date2']!=null) {
  	// se establecen las variables de POST en cookies
    setcookie("FECHA1", $_POST["date1"], time() + 86400,"/");
    setcookie("FECHA2", $_POST["date2"], time() + 86400,"/");

    if((strcmp($_COOKIE["ADMIN"],"1"))==0){
      //caso de admin
      if(isset($_POST['COD_CLIENTE']) && $_POST['COD_CLIENTE']!=null){
        //se cambia el codpara realizar la consulta
        setCookie("COD_CLIENTE",$_POST['COD_CLIENTE'], time() + 86400,"/");
      }
      header('location: ../mostrarhistorialAdmin.php');

    }else{
      //caso de usuario
    header('location: ../mostrarhistorial.php');
    }
  }else{
    header('location: ../historial.php');
  }
?>
