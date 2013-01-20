<?php

// Helper para classe de excel
//* @author Felipe <felipe@wadtecnologia.com.br>

require_once 'plugins/fpdf17/fpdf.php';
function  read_pdf($inputFileName = ''){
   
    $content = ob_get_clean();
	try
    {
        $html2pdf = new HTML2PDF();
//      $html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
		 $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content);
		//$html2pdf->writeHTML($input2FileName);
        $html2pdf->Output('exemple00.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
		
}
function  read_pdf2($inputFileName = ''){

$pdf = new FPDF();
 define('FPDF_FONTPATH','plugins/fpdf17/fpdf_fonts/');  
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Write(5,$inputFileName);
$pdf->Output();
}

	  




?>