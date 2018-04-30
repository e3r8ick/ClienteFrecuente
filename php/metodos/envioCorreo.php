<?php
  require('../../fpdf/fpdf.php');
  include '../conexion/conexion.php';

  class pdf extends FPDF
  {
    public $COD_CLIENTE;
    public $FECHA1;
    public $FECHA2;
    //Cabecera de página

    function setValores($COD_CLIENTE, $FECHA1, $FECHA2)
    {
      $this->COD_CLIENTE = $COD_CLIENTE;
      $this->FECHA1 = $FECHA1;
      $this->FECHA2 = $FECHA2;
    }

    function Header()
    {
      //imagen
       $this->Image('../../images/lanco.png',75,8,60);

       $this->SetFont('Arial','B',9);

       //hay que cambiar el formato de las fechas prque se guardan de manera diferente a como se usan en Sql
       //se quitan los -
       $fecha1 = str_replace("-","/",$this->FECHA1);
       $fecha2 = str_replace("-","/",$this->FECHA2);

       $this->Cell(30,7,'Fecha Inicio',1,0,'C');
       $this->Ln();
       $this->Cell(30,7,$fecha1,1,0,'C');
       $this->Ln();
       $this->Cell(30,7,'Fecha Final',1,0,'C');
       $this->Ln();
       $this->Cell(30,7,$fecha2,1,0,'C');
       $this->Ln();
       $this->Ln();
       $this->Ln();
    }

    //get de los datos
    function Datos($header){

      //get de los dato
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
        $stmt->execute(array($this->COD_CLIENTE));
        $result = $stmt->fetch();
          $this->Cell(45,5);
          $this->Cell(100,5,$result[0],'TLR');
          $this->Ln();
          $this->Cell(45,5);
          $this->Cell(100,5,"Codigo de Cliente: ".$result[1],'LR');
          $this->Ln();
          $this->Cell(45,5);
          $this->Cell(100,5,"Cedula: ".$result[2],'LR');
          $this->Ln();
          $this->Cell(45,5);
          $this->Cell(100,5,"Numero de Telefono Primario: ".$result[3],'LR');
          $this->Ln();
          $this->Cell(45,5);
          $this->Cell(100,5,"Numero de Telefono Secundario: ".$result[4],'LR');
          $this->Ln();
          $this->Cell(45,5);
          $this->Cell(100,5,"Numero de Fax: ".$result[5],'LR');
          $this->Ln();
          $this->Cell(45,5);
          $this->Cell(100,5,"Email: ".$result[6],'LR');
          $this->Ln();
          $this->Cell(45,5);
          $this->Cell(100,5,"Frecuencia de envio de Estados de Cuenta: ".$result[8],'LR');
          $this->Ln();
          $this->Cell(45,5);
          $this->MultiCell(100,5,"Direccion de Envio: ".$result[7],'BLR');
          $this->Ln();
          $this->Ln();
          $this->Ln();
          $this->Ln();

        //se cierra la conexion
        $conexion = null;

      }else{
        //si el statement da error
        echo "<script>console.log( 'Debug Objects: " . "falso". "' );</script>";
      }
    }

    //get del historial
     function Historial($header)
     {
       //get del historial
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
               FREPUNTOSV.PUNTOSOBT,
               FREPUNTOSV.PUNTOSTRA
               FROM FREPUNTOS INNER JOIN FREPUNTOSV ON FREPUNTOS.CLIENTE = FREPUNTOSV.CLIENTE
               INNER JOIN FRECOMPANIA ON FREPUNTOS.CIA = FRECOMPANIA.COD_CIA
               INNER JOIN FRESUCURSAL ON FREPUNTOS.SUCURSAL = FRESUCURSAL.SUCURSAL
               WHERE (FREPUNTOS.CLIENTE = ?) AND (FREPUNTOS.FECHA BETWEEN ? AND ?)";

       $stmt = $conexion->prepare($sql);

       if ($stmt) {
         //se realiza un execute y un fetch donde se obtienen los datos de la primera fila
         //que coincida con el usuario y la clave ademas del cia.
         //en el execute se agregan las variables por medio de un array.
         $stmt->execute(array($this->COD_CLIENTE,$this->FECHA1,$this->FECHA2));
         //echo "<script>console.log( 'Debug Objects: " . json_encode($fecha1). json_encode($fecha2). "' );</script>";
         while($fila = $stmt->fetch()){
           $row[] = $fila;
         }

         //se cierra la conexion
         $conexion = null;
      }else{
         //si el statement da error
         echo "<script>console.log( 'Debug Objects: " . "falso". "' );</script>";
      }

        //header de la tabla
       $this->SetFont('Arial','B',7);
       $this->Cell(15,5,"Fecha",1);
       $this->Cell(20,5,"Documento",1);
       $this->Cell(30,5,"Compania",1);
       $this->Cell(20,5,"Sucursal",1);
       $this->Cell(35,5,"Descripcion",1);
       $this->Cell(15,5,"Monto",1);
       $this->Cell(23,5,"Puntos Obtenidos",1);
       $this->Cell(23,5,"Puntos Gastados",1);
       $this->Ln();


       if(count($row)!=0){
          for($i=0, $size=count($row); $i<$size; $i++){
            for($j=0; $j<8; $j++){
              if($j==0 or $j==5){
                $this->Cell(15,5,$row[$i][$j],1);
              }elseif($j==2){
                $this->Cell(30,5,$row[$i][$j],1);
              }elseif ($j==1 or $j==3) {
                $this->Cell(20,5,$row[$i][$j],1);
              }elseif($j==4){
                $this->Cell(35,5,$row[$i][$j],1);
              }else{
                $this->Cell(23,5,$row[$i][$j],1);
              }
            }
            $this->Ln();
          }
          $this->Ln();
          $this->Ln();
          $this->Ln();
          $this->Cell(45,5);
          $this->Cell(50,5,"Puntos Disponibles",1);
          $this->Cell(50,5,"Puntos Bloqueados",1);
          $this->Ln();
          $this->Cell(45,5);
          $this->Cell(50,5,$row[0][6],1);
          $this->Cell(50,5,$row[0][7],1);
          $this->Ln();
        }else{
          $this->Cell(181,5,"No ha realizado ninguna compra este periodo",1,'C');

          $this->Ln();
          $this->Ln();
          $this->Ln();
          $this->Cell(45,5);
          $this->Cell(50,5,"Puntos Disponibles",1);
          $this->Cell(50,5,"Puntos Bloqueados",1);
          $this->Ln();
          $this->Cell(45,5);
          $this->Cell(50,5,"0",1);
          $this->Cell(50,5,"0",1);
          $this->Ln();
        }
      }
    }

  //para que no tire deprecated
  error_reporting(E_ERROR | E_WARNING | E_PARSE);
  $con = new Conexion();
  $conexion = $con->get_Conexion();

  //se crea la sentencia SQL
  $sql = "SELECT FREC_ESTADO,
          ULTIMO_ENVIO,
          COD_CLIENTE
          FROM GEN_CLIENTE
          WHERE ULTIMO_ENVIO IS NOT NULL";

  //se prepara el statement con la sentencia previamente creada
  $stmt = $conexion->prepare($sql);

  if ($stmt) {
    //se realiza un execute y un fetch donde se obtienen los datos de la primera fila
    //que coincida con el usuario y la clave ademas del cia.
    //en el execute se agregan las variables por medio de un array.
    $stmt->execute(array());
    while($fila = $stmt->fetch()){
      $row[] = $fila;
    }

    //se cierra la conexion
    $conexion = null;

    //se retorna el $result;
    $result = $row;
    //se cierra la conexion
    $conexion = null;

    //fecha actual
    $fecha = getdate();
    $fechaA = array($fecha['mday'], $fecha['mon'], $fecha['year']);
    $fechaAS = $fechaA[0]."/".$fechaA[1]."/".$fechaA[2];
    $fechaA = date_create($fechaA[0]."-".$fechaA[1]."-".$fechaA[2]);

    //fecha de ultimo envio de estado de cuenta
    $size = count($result);
    for($i = 0; $i <  $size; $i++){
      $fechaE = split('[/.-]', $result[$i][1]);


      //creamos fechas con el formato de php para comparar
      $fechaES = $fechaE[0]."/".$fechaE[1]."/".(intval($fechaE[2])+2000);
      $fechaE = date_create($fechaE[0]."-".$fechaE[1]."-".(intval($fechaE[2])+2000));
      $intervalo = date_diff($fechaE, $fechaA);
      //echo($intervalo->format('%R%a días'));

      if($result[$i]!=null){
        if (strcmp($result[$i][0],"Semanal")==0) {
          if ($intervalo->format('%R%a días')>=7) {
            //Creación del objeto de la clase heredada
            $pdf=new PDF();
            $pdf->setValores($result[$i][2],$fechaES,$fechaAS);
            //Títulos de las columnas
            $header=array('Columna 1');
            $pdf->AliasNbPages();
            //Primera página
            $pdf->AddPage();
            $pdf->SetY(65);
            $pdf->Datos($header);
            $pdf->Historial($header);
            $pdf->Output('F',$result[$i][2].'.pdf','.pdf');
            modificarUltimoEnvio($result[$i][2],$fechaAS);
          }
        }elseif (strcmp($result[$i][0],"Quincenal")==0) {
          if ($intervalo->format('%R%a días')>=15) {
            //Creación del objeto de la clase heredada
            $pdf=new PDF();
            $pdf->setValores($result[$i][2],$fechaES,$fechaAS);
            //Títulos de las columnas
            $header=array('Columna 1');
            $pdf->AliasNbPages();
            //Primera página
            $pdf->AddPage();
            $pdf->SetY(65);
            $pdf->Datos($header);
            $pdf->Historial($header);
            $pdf->Output('F',$result[$i][2].'.pdf','.pdf');
            modificarUltimoEnvio($result[$i][2],$fechaAS);
          }
        }elseif (strcmp($result[$i][0],"Mensual")==0) {
          if ($intervalo->format('%R%a días')>=31) {
            //Creación del objeto de la clase heredada
            $pdf=new PDF();
            $pdf->setValores($result[$i][2],$fechaES,$fechaAS);
            //Títulos de las columnas
            $header=array('Columna 1');
            $pdf->AliasNbPages();
            //Primera página
            $pdf->AddPage();
            $pdf->SetY(65);
            $pdf->Datos($header);
            $pdf->Historial($header);
            $pdf->Output('F',$result[$i][2].'.pdf','.pdf');
            modificarUltimoEnvio($result[$i][2],$fechaAS);
          }
        }elseif (strcmp($result[$i][0],"Bimestral")==0) {
          if ($intervalo->format('%R%a días')>=61) {
            //Creación del objeto de la clase heredada
            $pdf=new PDF();
            $pdf->setValores($result[$i][2],$fechaES,$fechaAS);
            //Títulos de las columnas
            $header=array('Columna 1');
            $pdf->AliasNbPages();
            //Primera página
            $pdf->AddPage();
            $pdf->SetY(65);
            $pdf->Datos($header);
            $pdf->Historial($header);
            $pdf->Output('F',$result[$i][2].'.pdf','.pdf');
            modificarUltimoEnvio($result[$i][2],$fechaAS);
          }
        }
      }
    }
  }else{
    //si el statement da error
    echo "<script>console.log( 'Debug Objects: " . "falso". "' );</script>";
  }

  function modificarUltimoEnvio($COD_CLIENTE, $FECHA)
  {
    $con = new Conexion();
    $conexion = $con->get_Conexion();

    try{
      //setear los errores
      //$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      //se crea la sentencia SQL
      //$sql = "UPDATE GEN_CLIENTE SET CONTRASENIA='".$Ppassword."' WHERE COD_CLIENTE='".$Pusuario."';";
      $sql = "UPDATE GEN_CLIENTE SET ULTIMO_ENVIO = ? WHERE COD_CLIENTE = ?";
      //prepara el statement
      $stmt = $conexion->prepare($sql);
      // ejecuta el query
      $stmt->execute(array($FECHA, $COD_CLIENTE));
      //echo "<script>console.log( 'Debug Objects: " .$sql. "' );</script>";
      echo "<script>console.log( 'Debug Objects: " .$stmt->rowCount(). "' );</script>";
    }
    catch(PDOException $e){
        echo "<script>console.log( 'Debug Objects: " .$e->getMessage(). "' );</script>";
    }

    $conexion = null;
  }
?>
