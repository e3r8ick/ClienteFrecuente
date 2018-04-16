<?php
  require('../../fpdf/fpdf.php');
  include '../conexion/conexion.php';

  class pdf extends FPDF
  {
    public $COD_CLIENTE;
    public $FECHA;
    //Cabecera de página

    function setValores($COD_CLIENTE, $FECHA)
    {
      $this->COD_CLIENTE = $COD_CLIENTE;
      $this->FECHA = $FECHA;
    }

    function Header()
    {
      //imagen
       $this->Image('../../images/lanco.png',75,8,60);

       $this->SetFont('Arial','B',9);

       //hay que cambiar el formato de las fechas prque se guardan de manera diferente a como se usan en Sql
       //se quitan los -
       $fecha = str_replace("-","/",$this->FECHA);

       $this->Cell(30,7,'Fecha',1,0,'C');
       $this->Ln();
       $this->Cell(30,7,$fecha,1,0,'C');
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

    function Mensaje($header, $mensaje)
    {
      $this->SetFont('Arial','B',9);
      $this->MultiCell(185,5,$mensaje,0);
    }
  }
      //Creación del objeto de la clase heredada
      $pdf=new PDF();

      //fecha actual
      $fecha = getdate();
      $fechaA = array($fecha['mday'], $fecha['mon'], $fecha['year']);
      $fechaAS = $fechaA[0]."-".$fechaA[1]."-".$fechaA[2];

      $pdf->setValores($_COOKIE["COD_CLIENTE"],$fechaAS);
      //Títulos de las columnas
      $header=array('Columna 1');
      $pdf->AliasNbPages();
      //Primera página
      $pdf->AddPage();
      $pdf->SetY(65);
      $pdf->Datos($header);
      $pdf->Mensaje($header, $_POST["MENSAJE"]);
      $pdf->Output('F',$_COOKIE["COD_CLIENTE"].'_'.$fechaAS.'.pdf','.pdf');
      header('location: ../ayuda.php?msg=CorreoEnviado');


?>
