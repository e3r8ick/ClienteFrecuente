<?php
  include_once '../conexion/conexion.php';
  $con = new Conexion();
  $conexion = $con->get_Conexion();

  $row = array();


  //se crea la sentencia SQL para cualquier usuario
  $sql = "SELECT FREPUNTOS.FECHA,
          FREPUNTOS.DOCUMENTO,
          FRECOMPANIA.DES_CIA,
          FRESUCURSAL.DESCRIPCION,
          FREPUNTOS.ARTICULO,
          FREPUNTOS.MONTO,
          FREPUNTOSV.PUNTOSOBT AS PUNTOSOBTOTALES,
          FREPUNTOSV.PUNTOSTRA AS PUNTOSTRANTOTALES,
          FREPUNTOS.PUNTOSOBT,
          FREPUNTOS.PUNTOSTRA
          FROM FREPUNTOS INNER JOIN FREPUNTOSV ON FREPUNTOS.CLIENTE = FREPUNTOSV.CLIENTE
          INNER JOIN FRECOMPANIA ON FREPUNTOS.CIA = FRECOMPANIA.COD_CIA
          INNER JOIN FRESUCURSAL ON FREPUNTOS.SUCURSAL = FRESUCURSAL.SUCURSAL
          WHERE (FREPUNTOS.CLIENTE = ?) AND (to_char(FREPUNTOS.FECHA,'YYYYMMDD') BETWEEN ? AND ?)";

  //se crea la sentencia SQL para admin con nombre
  $sqlAdminN = "SELECT FREPUNTOS.FECHA,
          FREPUNTOS.DOCUMENTO,
          FREPUNTOS.CLIENTE,
          FRECOMPANIA.DES_CIA,
          FRESUCURSAL.DESCRIPCION,
          FREPUNTOS.ARTICULO,
          FREPUNTOS.MONTO,
          FREPUNTOSV.PUNTOSOBT AS PUNTOSOBTOTALES,
          FREPUNTOSV.PUNTOSTRA AS PUNTOSTRANTOTALES,
          FREPUNTOS.PUNTOSOBT,
          FREPUNTOS.PUNTOSTRA
          FROM FREPUNTOS INNER JOIN FREPUNTOSV ON FREPUNTOS.CLIENTE = FREPUNTOSV.CLIENTE
          INNER JOIN FRECOMPANIA ON FREPUNTOS.CIA = FRECOMPANIA.COD_CIA
          INNER JOIN FRESUCURSAL ON FREPUNTOS.SUCURSAL = FRESUCURSAL.SUCURSAL
          WHERE (FREPUNTOS.CLIENTE = ?) AND (to_char(FREPUNTOS.FECHA,'YYYYMMDD') BETWEEN ? AND ?)";

  //se crea la sentencia SQL para admin solo con fechas
  $sqlAdmin = "SELECT FREPUNTOS.FECHA,
          FREPUNTOS.DOCUMENTO,
          FREPUNTOS.CLIENTE,
          FRECOMPANIA.DES_CIA,
          FRESUCURSAL.DESCRIPCION,
          FREPUNTOS.ARTICULO,
          FREPUNTOS.MONTO,
          FREPUNTOSV.PUNTOSOBT AS PUNTOSOBTOTALES,
          FREPUNTOSV.PUNTOSTRA AS PUNTOSTRANTOTALES,
          FREPUNTOS.PUNTOSOBT,
          FREPUNTOS.PUNTOSTRA
          FROM FREPUNTOS INNER JOIN FREPUNTOSV ON FREPUNTOS.CLIENTE = FREPUNTOSV.CLIENTE
          INNER JOIN FRECOMPANIA ON FREPUNTOS.CIA = FRECOMPANIA.COD_CIA
          INNER JOIN FRESUCURSAL ON FREPUNTOS.SUCURSAL = FRESUCURSAL.SUCURSAL
          WHERE (to_char(FREPUNTOS.FECHA,'YYYYMMDD') BETWEEN ? AND ?)";

  //caso de admin
  if((isset($_COOKIE["ADMIN"])) and ((strcmp($_COOKIE["ADMIN"],"1"))==0)){
    //caso de admin con busqueda de cliente
    if(((strcmp($_COOKIE["COD_CLIENTE"],"04"))!=0)){
      $stmt = $conexion->prepare($sqlAdminN);

      //hay que cambiar el formato de las fechas prque se guardan de manera diferente a como se usan en Sql
      //se quitan los -
      $fecha1 = str_replace("-","",$_COOKIE["FECHA1"]);
      $fecha2 = str_replace("-","",$_COOKIE["FECHA2"]);
      //se separan los números
      $fecha1 = str_split($fecha1,2);
      $fecha2 = str_split($fecha2,2);
      //formamos la fecha con el formato correto
      $fecha1 = "20".$fecha1[1].$fecha1[2].$fecha1[3];
      $fecha2 = "20".$fecha2[1].$fecha2[2].$fecha2[3];

      if ($stmt) {
        //se realiza un execute y un fetch donde se obtienen los datos de la primera fila
        //que coincida con el usuario y la clave ademas del cia.
        //en el execute se agregan las variables por medio de un array.
        $stmt->execute(array($_COOKIE["COD_CLIENTE"],$fecha1, $fecha2));
        //echo "<script>console.log( 'Debug Objects: " . json_encode($fecha1). json_encode($fecha2). "' );</script>";
        while($fila = $stmt->fetch()){
          $row[] = $fila;
        }

        //se cierra la conexion
        $conexion = null;

        //se retorna el $result;
        $result = json_encode($row);
        echo ($result);
      //  header('location: ../mostrarhistorial.php');

      }else{
        //si el statement da error
        echo "<script>console.log( 'Debug Objects: " . "falso". "' );</script>";
      }
      //se setea de nuevo el codigo del admin
      setCookie("COD_CLIENTE","04", time() + 86400,"/");
    }else {
      $stmt = $conexion->prepare($sqlAdmin);

      //hay que cambiar el formato de las fechas prque se guardan de manera diferente a como se usan en Sql
      //se quitan los -
      $fecha1 = str_replace("-","",$_COOKIE["FECHA1"]);
      $fecha2 = str_replace("-","",$_COOKIE["FECHA2"]);
      //se separan los números
      $fecha1 = str_split($fecha1,2);
      $fecha2 = str_split($fecha2,2);
      //formamos la fecha con el formato correto
      $fecha1 = "20".$fecha1[1].$fecha1[2].$fecha1[3];
      $fecha2 = "20".$fecha2[1].$fecha2[2].$fecha2[3];

      if ($stmt) {
        //se realiza un execute y un fetch donde se obtienen los datos de la primera fila
        //que coincida con el usuario y la clave ademas del cia.
        //en el execute se agregan las variables por medio de un array.
        $stmt->execute(array($fecha1, $fecha2));
        //echo "<script>console.log( 'Debug Objects: " . json_encode($fecha1). json_encode($fecha2). "' );</script>";
        while($fila = $stmt->fetch()){
          $row[] = $fila;
        }

        //se cierra la conexion
        $conexion = null;

        //se retorna el $result;
        $result = json_encode($row);
        echo ($result);
      //  header('location: ../mostrarhistorial.php');

      }else{
        //si el statement da error
        echo "<script>console.log( 'Debug Objects: " . "falso". "' );</script>";
      }
    }
  }else{
    //caso de cualquier usuario
    //se prepara el statement con la sentencia previamente creada
    $stmt = $conexion->prepare($sql);

    //hay que cambiar el formato de las fechas prque se guardan de manera diferente a como se usan en Sql
    //se quitan los -
    $fecha1 = str_replace("-","",$_COOKIE["FECHA1"]);
    $fecha2 = str_replace("-","",$_COOKIE["FECHA2"]);
    //se separan los números
    $fecha1 = str_split($fecha1,2);
    $fecha2 = str_split($fecha2,2);
    //formamos la fecha con el formato correto
    $fecha1 = "20".$fecha1[1].$fecha1[2].$fecha1[3];
    $fecha2 = "20".$fecha2[1].$fecha2[2].$fecha2[3];

    if ($stmt) {
      //se realiza un execute y un fetch donde se obtienen los datos de la primera fila
      //que coincida con el usuario y la clave ademas del cia.
      //en el execute se agregan las variables por medio de un array.
      $stmt->execute(array($_COOKIE["COD_CLIENTE"], $fecha1, $fecha2));
      //echo "<script>console.log( 'Debug Objects: " . json_encode($fecha1). json_encode($fecha2). "' );</script>";
      while($fila = $stmt->fetch()){
        $row[] = $fila;
      }

      //se cierra la conexion
      $conexion = null;

      //se retorna el $result;
      $result = json_encode($row);
      echo ($result);
    //  header('location: ../mostrarhistorial.php');

    }else{
      //si el statement da error
      echo "<script>console.log( 'Debug Objects: " . "falso". "' );</script>";
    }
  }
?>
