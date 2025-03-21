<?php
require 'vendor/autoload.php';
require 'plantilla2.php';

$numero_consecutivo = isset($_GET['numero_consecutivo']) ? $_GET['numero_consecutivo'] : 'N/A';

$mpdf= new \Mpdf\Mpdf();
$css=file_get_contents('styleP.css');

$plantilla = getPlantilla($numero_consecutivo);
$mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($plantilla, \Mpdf\HTMLParserMode::HTML_BODY);
$mpdf->Output('archivo.pdf', 'I');
?>