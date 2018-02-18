<?php
  include_once '../conexion/conexion.php';
  $con = new Conexion();
  $conexion = $con->get_Conexion();

  $row = array();


  //se crea la sentencia SQL
  $sql = "SELECT FREPUNTOS.FECHA, FREPUNTOS.DOCUMENTO, FREPUNTOS.SUCURSAL, FREPUNTOS.ARTICULO, FREPUNTOS.MONTO, FREPUNTOSV.PUNTOSOBT, FREPUNTOSV.PUNTOSTRA FROM FREPUNTOS INNER JOIN FREPUNTOSV ON FREPUNTOS.CLIENTE = FREPUNTOSV.CLIENTE WHERE (FREPUNTOS.CLIENTE = ?) AND (FREPUNTOS.FECHA BETWEEN ? AND ?)";

  //se prepara el statement con la sentencia previamente creada
  $stmt = $conexion->prepare($sql);

  //hay que cambiar el formato de las fechas prque se guardan de manera diferente a como se usan en Sql
  $fecha1 = str_split($_COOKIE["FECHA1"], 2);
  $fecha2 = str_split($_COOKIE["FECHA2"], 2);
  if ($stmt) {
    //se realiza un execute y un fetch donde se obtienen los datos de la primera fila
    //que coincida con el usuario y la clave ademas del cia.
    //en el execute se agregan las variables por medio de un array.
    $stmt->execute(array($_COOKIE["COD_CLIENTE"], $_COOKIE["FECHA1"], $_COOKIE["FECHA2"]));
    echo "<script>console.log( 'Debug Objects: " . $_COOKIE["FECHA1"]. "' );</script>";
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
?>
