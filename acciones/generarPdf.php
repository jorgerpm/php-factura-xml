<?php
if (is_file('./Utils/configUtil.php')) {
    require_once './Utils/configUtil.php';
} else {
    require_once '../Utils/configUtil.php';
}
// include class
require('../Utils/fpdf185/fpdf.php');

// extend class
class generarPdf extends FPDF {

    protected $fontName = 'Arial';

    function renderTitle($text) {
        $this->SetTextColor(0, 0, 0);
        $this->SetFont($this->fontName, 'B', 20);
        $this->Cell(0, 11, utf8_decode($text), 0, 1, 'C');
        $this->Ln();
    }

    function renderSubTitle($text) {
        $this->SetTextColor(0, 0, 0);
        $this->SetFont($this->fontName, 'B', 16);
        $this->Cell(0, 10, utf8_decode($text), 0, 1);
        $this->Ln();
    }

    function renderText($text) {
        $this->SetTextColor(51, 51, 51);
        $this->SetFont($this->fontName, '', 12);
        $this->MultiCell(0, 7, utf8_decode($text), 0, 1);
        $this->Ln();
    }
}

if(isset($_SESSION['Usuario'])){

    if(isset($_POST["listaClavesAcceso"])){
        
        $arrayClaves = explode(",",$_POST["listaClavesAcceso"]);
        
        

//        // create document
        $pdf = new generarPdf();
        $pdf->AddPage();

        // config document
//        $pdf->SetTitle('Proyecto carga de xml');
//        $pdf->SetAuthor('IdebSystems Cia. Ltda.');
//        $pdf->SetCreator('FPDF Maker');

        // add content
        $pdf->renderTitle('LISTA DE DOCUMENTOS ELECTRONICOS A ENVIAR');
        foreach ($arrayClaves as $clave){
            $pdf->renderText('Clave de acceso: ' . $clave);
        }
        
//        $pdf->renderSubTitle('FPDF');        
//        $pdf->renderText('Antes de comenzar lo primero es descargar FPDF e incluir los archivos necesarios en nuestro proyecto.');
        //$pdf->Image('../Assets/imagenes/ajaxloadingbar.gif', null, null, 180);

        // output file
        $archpdf = $pdf->Output('S', 'fpdf-advanced.pdf');

        //$fileXml = file_get_contents($archpdf);
        $fileB64 = base64_encode($archpdf);

        echo $fileB64;
    }

}else{
    echo 'window.location.replace("index");';
}
