<?php
  include_once '../conexion/conexion.php';
  $con = new Conexion();
  $conexion = $con->get_Conexion();

  $Pusuario = $_COOKIE["COD_CLIENTE"];

  if (!empty($_POST)){
    $Pfecha1 = null;
    $Pfecha2 = null;
  }

  //se crea la sentencia SQL
  $sql = "SELECT FECHA, DOCUMENTO, SUCURSAL, ARTICULO, MONTO, PUNTOSOBT, PUNTOSUSA, PUNTOS, PUNTOSTRA FROM FREPUNTOS WHERE CLIENTE = ?";

  //se prepara el statement con la sentencia previamente creada
  $stmt = $conexion->prepare($sql);

  if ($stmt) {
    //se realiza un execute y un fetch donde se obtienen los datos de la primera fila
    //que coincida con el usuario y la clave ademas del cia.
    //en el execute se agregan las variables por medio de un array.
    $stmt->execute(array($Pusuario));
    //se toman todos los resultados y se unen
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach($stmt->fetchAll() as $k=>$v) {
        //echo $v;
        $result = json_encode($v);
    }

    //se cierra la conexion
    $conexion = null;

    //se retorna el $result;
    //$result = json_encode($result);
    echo ($result);
    //header('location: ../historial.php');

  }else{
    //si el statement da error
    echo "<script>console.log( 'Debug Objects: " . "falso". "' );</script>";
  }
?>
