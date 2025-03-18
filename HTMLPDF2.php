<?php
require 'vendor/autoload.php';
require 'plantilla2.php';

$id = isset($_GET['id']) ? $_GET['id'] : 'N/A';

$mpdf= new \Mpdf\Mpdf();
$css=file_get_contents('styleP.css');

$plantilla = getPlantilla($id);
$mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($plantilla, \Mpdf\HTMLParserMode::HTML_BODY);
$mpdf->Output('archivo.pdf', 'I');
?>