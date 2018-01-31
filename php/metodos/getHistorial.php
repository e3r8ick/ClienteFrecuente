<?php
  include_once '../conexion/conexion.php';
  $con = new Conexion();
  $conexion = $con->get_Conexion();

  $Pusuario = $_COOKIE["COD_CLIENTE"];
  $Pfecha1 = $_POST['date1'];
  $Pfecha2 = $_POST['date2'];

  //se crea la sentencia SQL
  $sql = "SELECT FECHA, DOCUMENTO, SUCURSAL, ARTICULO, MONTO, PUNTOSOBT, PUNTOSUSA, PUNTOS, PUNTOSTRA FROM FREPUNTOS WHERE CLIENTE = ?";

  //se prepara el statement con la sentencia previamente creada
  $stmt = $conexion->prepare($sql);

  if ($stmt) {
    //se realiza un execute y un fetch donde se obtienen los datos de la primera fila
    //que coincida con el usuario y la clave ademas del cia.
    //en el execute se agregan las variables por medio de un array.
    $stmt->execute(array($Pusuario));
    $result = $stmt->fetch();

    //se cierra la conexion
    $conexion = null;

    //se retorna el $result;
    $result = json_encode($result);
    echo ($result);
    header('location: ../historial.php');

  }else{
    //si el statement da error
    echo "<script>console.log( 'Debug Objects: " . "falso". "' );</script>";
  }
?>
