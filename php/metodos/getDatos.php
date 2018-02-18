<?php
  include_once '../conexion/conexion.php';
  $con = new Conexion();
  $conexion = $con->get_Conexion();

  //se crea la sentencia SQL
  $sql = "SELECT NOM_CLIENTE, COD_CLIENTE, CEDULA, NUM_TELEFONO1, NUM_TELEFONO2, NUM_FAX, EMAIL, DIRECCION_ENVIO, FREC_ESTADO FROM GEN_CLIENTE WHERE COD_CLIENTE = ?";

  //se prepara el statement con la sentencia previamente creada
  $stmt = $conexion->prepare($sql);

  if ($stmt) {
    //se realiza un execute y un fetch donde se obtienen los datos de la primera fila
    //que coincida con el usuario y la clave ademas del cia.
    //en el execute se agregan las variables por medio de un array.
    $stmt->execute(array($_COOKIE["COD_CLIENTE"]));
    $result = $stmt->fetch();

    //se cierra la conexion
    $conexion = null;

    //se setea el cookie con el nombre del usuario
    setcookie("NOM_CLIENTE", $result[0], time() + 86400, "/");

    //se retorna el $result;
    $result = json_encode($result);
    echo ($result);
  }else{
    //si el statement da error
    echo "<script>console.log( 'Debug Objects: " . "falso". "' );</script>";
  }
?>
