<?php
require('../../fpdf/fpdf.php');
class pdf extends FPDF
{
   //Cabecera de página
   function Header()
   {

      $this->Image('../../images/lanco.png',75,8,60);

      $this->SetFont('Arial','B',10);

      $this->Cell(30,7,'Fecha Inicio',1,0,'C');
      $this->Ln();
      $this->Cell(30,7,'01/01/2018',1,0,'C');
      $this->Ln();
      $this->Cell(30,7,'Fecha Final',1,0,'C');
      $this->Ln();
      $this->Cell(30,7,'02/03/2018',1,0,'C');

   }

   function TablaBasica($header)
   {
    //Cabecera
    foreach($header as $col)
    $this->Cell(40,7,$col,1);
    $this->Ln();

      $this->Cell(40,5,"hola",1);
      $this->Cell(40,5,"hola2",1);
      $this->Cell(40,5,"hola3",1);
      $this->Cell(40,5,"hola4",1);
      $this->Ln();
      $this->Cell(40,5,"linea ",1);
      $this->Cell(40,5,"linea 2",1);
      $this->Cell(40,5,"linea 3",1);
      $this->Cell(40,5,"linea 4",1);
   }
}
   //Creación del objeto de la clase heredada
    $pdf=new PDF();
    //Títulos de las columnas
    $header=array('Columna 1','Columna 2','Columna 3','Columna 4');
    $pdf->AliasNbPages();
    //Primera página
    $pdf->AddPage();
    $pdf->SetY(65);
    //$pdf->AddPage();
    $pdf->TablaBasica($header);

$pdf->Output();
?>
