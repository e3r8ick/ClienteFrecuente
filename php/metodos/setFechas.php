<?php
  include_once '../conexion/conexion.php';
  $con = new Conexion();
  $conexion = $con->get_Conexion();

  if (isset($_POST['date1']) && isset($_POST['date2']) && $_POST['date1']!=null && $_POST['date2']!=null) {
    //se acomodan las fechas en orden, porque el cookie las cambia
    $fecha1 = str_replace("-","",$_POST['date1']);
    $fecha2 = str_replace("-","",$_POST['date2']);

    $fecha1 = str_split($fecha1,2);
    $fecha2 = str_split($fecha2,2);
    if(intval($fecha2[1])>intval($fecha1[1])){
      // se establecen las variables de POST en cookies
      setcookie("FECHA1", $_POST["date1"], time() + 86400,"/");
      setcookie("FECHA2", $_POST["date2"], time() + 86400,"/");
    }elseif (intval($fecha2[1])==intval($fecha1[1])) {
      if(intval($fecha2[2])>intval($fecha1[2])) {
        setcookie("FECHA1", $_POST["date1"], time() + 86400,"/");
        setcookie("FECHA2", $_POST["date2"], time() + 86400,"/");
      }elseif (intval($fecha2[2])==intval($fecha1[2])) {
        if (intval($fecha2[3])>intval($fecha1[3])) {
          setcookie("FECHA1", $_POST["date1"], time() + 86400,"/");
          setcookie("FECHA2", $_POST["date2"], time() + 86400,"/");
        }else{
          header('location: ../historial.php?msg=FECHA INCORRECTA');
        }
      }else{
        header('location: ../historial.php?msg=FECHA INCORRECTA');
      }
    }else{
      header('location: ../historial.php?msg=FECHA INCORRECTA');
    }

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
