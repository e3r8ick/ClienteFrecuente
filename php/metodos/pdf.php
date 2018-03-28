<?php
require('../../fpdf/fpdf.php');
include '../conexion/conexion.php';

class pdf extends FPDF
{
  //Cabecera de página

  function Header()
  {
    //imagen
     $this->Image('../../images/lanco.png',75,8,60);

     $this->SetFont('Arial','B',9);

     //hay que cambiar el formato de las fechas prque se guardan de manera diferente a como se usan en Sql
     //se quitan los -
     $fecha1 = str_replace("-","",$_COOKIE["FECHA1"]);
     $fecha2 = str_replace("-","",$_COOKIE["FECHA2"]);
     //se separan los números
     $fecha1 = str_split($fecha1,2);
     $fecha2 = str_split($fecha2,2);
     //formamos la fecha con el formato correto
     $fecha1 = $fecha1[3]."/".$fecha1[2]."/".$fecha1[1];
     $fecha2 = $fecha2[3]."/".$fecha2[2]."/".$fecha2[1];

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
      $stmt->execute(array($_COOKIE["COD_CLIENTE"]));
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

       //se crea la sentencia SQL para admin con nombre
       $sqlAdminN = "SELECT FREPUNTOS.FECHA,
               FREPUNTOS.DOCUMENTO,
               FREPUNTOS.CLIENTE,
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

       //se crea la sentencia SQL para admin solo con fechas
       $sqlAdmin = "SELECT FREPUNTOS.FECHA,
               FREPUNTOS.DOCUMENTO,
               FREPUNTOS.CLIENTE,
               FRECOMPANIA.DES_CIA,
               FRESUCURSAL.DESCRIPCION,
               FREPUNTOS.ARTICULO,
               FREPUNTOS.MONTO,
               FREPUNTOSV.PUNTOSOBT,
               FREPUNTOSV.PUNTOSTRA
               FROM FREPUNTOS INNER JOIN FREPUNTOSV ON FREPUNTOS.CLIENTE = FREPUNTOSV.CLIENTE
               INNER JOIN FRECOMPANIA ON FREPUNTOS.CIA = FRECOMPANIA.COD_CIA
               INNER JOIN FRESUCURSAL ON FREPUNTOS.SUCURSAL = FRESUCURSAL.SUCURSAL
               WHERE (FREPUNTOS.FECHA BETWEEN ? AND ?)";

      //caso de admin
       if((isset($_COOKIE["ADMIN"])) and ((strcmp($_COOKIE["ADMIN"],"1"))==0)){
         //caso de admin con busqueda de cliente
         if(((strcmp($_COOKIE["COD_CLIENTE"],"001"))!=0)){
           $stmt = $conexion->prepare($sqlAdminN);

           //hay que cambiar el formato de las fechas prque se guardan de manera diferente a como se usan en Sql
           //se quitan los -
           $fecha1 = str_replace("-","",$_COOKIE["FECHA1"]);
           $fecha2 = str_replace("-","",$_COOKIE["FECHA2"]);
           //se separan los números
           $fecha1 = str_split($fecha1,2);
           $fecha2 = str_split($fecha2,2);
           //formamos la fecha con el formato correto
           $fecha1 = $fecha1[3]."/".$fecha1[2]."/".$fecha1[1];
           $fecha2 = $fecha2[3]."/".$fecha2[2]."/".$fecha2[1];

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

             //for($y=0;$y<30;$y++){
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
           }else{
             //si el statement da error
             echo "<script>console.log( 'Debug Objects: " . "falso". "' );</script>";
           }
           //se setea de nuevo el codigo del admin
           setCookie("COD_CLIENTE","001", time() + 86400,"/");
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
           $fecha1 = $fecha1[3]."/".$fecha1[2]."/".$fecha1[1];
           $fecha2 = $fecha2[3]."/".$fecha2[2]."/".$fecha2[1];

           if ($stmt) {
             //se realiza un execute y un fetch donde se obtienen los datos de la primera fila
             //que coincida con el usuario y la clave ademas del cia.
             //en el execute se agregan las variables por medio de un array.
             $stmt->execute(array($fecha1, $fecha2));
             //echo "<script>console.log( 'Debug Objects: " . json_encode($fecha1). json_encode($fecha2). "' );</script>";
             while($fila = $stmt->fetch()){
               $row[] = $fila;
             }

             $this->Cell(50,5,"Puntos Obtenidos = P.O",1);
             $this->Cell(50,5,"Puntos Gastados = P.G",1);
             $this->Ln();

             //header de la tabla
            $this->SetFont('Arial','B',7);
            $this->Cell(15,5,"Fecha",1);
            $this->Cell(20,5,"Documento",1);
            $this->Cell(20,5,"Cliente",1);
            $this->Cell(30,5,"Compania",1);
            $this->Cell(20,5,"Sucursal",1);
            $this->Cell(35,5,"Descripcion",1);
            $this->Cell(15,5,"Monto",1);
            $this->Cell(15,5,"P.O",1);
            $this->Cell(15,5,"P.G",1);
            $this->Ln();

             //for($y=0;$y<30;$y++){
             for($i=0, $size=count($row); $i<$size; $i++){
               for($j=0; $j<9; $j++){
                 if($j==0 or $j==6 or $j==7 or $j==8){
                   $this->Cell(15,5,$row[$i][$j],1);
                 }elseif($j==3){
                   $this->Cell(30,5,$row[$i][$j],1);
                 }elseif ($j==1 or $j==4 or $j==2) {
                   $this->Cell(20,5,$row[$i][$j],1);
                 }else{
                   $this->Cell(35,5,$row[$i][$j],1);
                 }
               }
               $this->Ln();
             }
             //se cierra la conexion
             $conexion = null;
           //  header('location: ../mostrarhistorial.php');

           }else{
             //si el statement da error
             echo "<script>console.log( 'Debug Objects: " . "falso". "' );</script>";
           }
         }
       }else{

       $stmt = $conexion->prepare($sql);

       //hay que cambiar el formato de las fechas prque se guardan de manera diferente a como se usan en Sql
       //se quitan los -
       $fecha1 = str_replace("-","",$_COOKIE["FECHA1"]);
       $fecha2 = str_replace("-","",$_COOKIE["FECHA2"]);
       //se separan los números
       $fecha1 = str_split($fecha1,2);
       $fecha2 = str_split($fecha2,2);
       //formamos la fecha con el formato correto
       $fecha1 = $fecha1[3]."/".$fecha1[2]."/".$fecha1[1];
       $fecha2 = $fecha2[3]."/".$fecha2[2]."/".$fecha2[1];
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

      //for($y=0;$y<30;$y++){
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
      //}
     }
    }
  }

  //Creación del objeto de la clase heredada
  $pdf=new PDF();
  //Títulos de las columnas
  $header=array('Columna 1');
  $pdf->AliasNbPages();
  //Primera página
  $pdf->AddPage();
  $pdf->SetY(65);
  $pdf->Datos($header);
  $pdf->Historial($header);
  $pdf->Output();
?>
