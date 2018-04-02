<?php
  include_once '../conexion/conexion.php';
  $con = new Conexion();
  $conexion = $con->get_Conexion();

  //se crea la sentencia SQL
  $sql = "SELECT FREC_ESTADO,
          ULTIMO_ENVIO,
          PUNTOS_ACTIVOS,
          PUNTOS_BLOQUEADOS
          FROM GEN_CLIENTE
          WHERE COD_CLIENTE = ?";

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

    //fecha actual
    $fecha = getdate();
    $fechaA = array($fecha['mday'], $fecha['mon'], $fecha['year']);
    echo($fechaA[0].'-'.$fechaA[1].'-'.$fechaA[2]);

    //fecha de ultimo envio de estado de cuenta
    $fechaE = split('[/.-]', $result[1]);
    echo($fechaE[0].'-'.$fechaE[1].'-'.$fechaE[2]);


    //creamos fechas con el formato de php para comparar
    $fechaA = date_create($fechaA[0]."-".$fechaA[1]."-".$fechaA[2]);
    $fechaE = date_create($fechaE[0]."-".$fechaE[1]."-".(intval($fechaE[2])+2000));
    $intervalo = date_diff($fechaA, $fechaE);

    if($result[0]!=null){
      if (strcmp($result[0],"Semanal")==0) {
        if ($intervalo->format('%R%a días')<=7) {
          echo "Semanal";
        }
      }elseif (strcmp($result[0],"Quincenal")==0) {
        if ($intervalo->format('%R%a días')<=15) {
          echo "Quincenal";
        }
      }elseif (strcmp($result[0],"Mensual")==0) {
        if ($intervalo->format('%R%a días')<=31) {
          echo "Mensual";
        }
      }elseif (strcmp($result[0],"Bimestral")==0) {
        if ($intervalo->format('%R%a días')<=61) {
          echo "Bimestral";
        }
      }
    }
  }else{
    //si el statement da error
    echo "<script>console.log( 'Debug Objects: " . "falso". "' );</script>";
  }
?>
