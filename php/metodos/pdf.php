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
}

//Creación del objeto de la clase heredada
$pdf=new pdf();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
//Aquí escribimos lo que deseamos mostrar...
$pdf->Output();
?>
