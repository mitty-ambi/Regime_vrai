<?php 
namespace App\Models;
require_once APPPATH . 'ThirdParty/fpdf/fpdf.php';

use FPDF;

class RegimeSuggestionPdf extends FPDF {
    public function Header()
    {
        $this->SetFont('Arial','B',15);
        $this->Cell(0,10,'Suggestion de Regime',0,1,'C');
    }
}
?>