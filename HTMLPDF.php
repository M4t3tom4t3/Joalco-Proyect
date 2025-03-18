<?php
require 'vendor/autoload.php';
require 'plantilla_hv.php';

$serial = isset($_GET['serial']) ? $_GET['serial'] : 'N/A';

$mpdf= new \Mpdf\Mpdf();
$css=file_get_contents('styleP.css');

$plantilla = getPlantilla($serial);
$mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($plantilla, \Mpdf\HTMLParserMode::HTML_BODY);
$mpdf->Output('archivo.pdf', 'I');
?>