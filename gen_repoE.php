<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require_once 'vendor/autoload.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

function generarExcelEquipos($conn) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Reporte Equipos');

    $headers = ['Serial', 'Nombre Equipo', 'Marca', 'Modelo', 'PLACA', 'Activo Fijo', 'Estado', 'IP WLAN', 'HV', 'IP LAN', 'Sistema Operativo', 'RAM', 'Disco', 'Procesador', 'Fecha Compra', 'Costo', 'Usuario Dominio', 'Num Factura', 'Num Pedido', 'Host Name', 'MAC LAN', 'MAC WLAN', 'Licencia Windows', 'Paquete Office', 'Póliza', 'Correo', 'Ciudad'];
    $sheet->fromArray($headers, NULL, 'A1');

    $sql = "SELECT serial, nombre_equipo, marca, modelo, PLACA, activo_fijo, estado, ip_wlan, hv, ip_lan, sistema_operativo, ram, disco, procesador, fecha_compra, costo, usuario_dominio, num_factura, num_pedido, host_name, mac_lan, mac_wlan, licencia_w, paquete_of, poliza, correo, ciudad FROM equipos";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $rowIndex = 2;
        while ($row = $result->fetch_assoc()) {
            $sheet->fromArray(array_values($row), NULL, 'A' . $rowIndex);
            $rowIndex++;
        }
    }
    $writer = new Xlsx($spreadsheet);
    
    $fileName = 'reporte_' . date('Y-m-d') . '.xlsx';
    
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');
    
    $writer->save('php://output');
    exit();
}

generarExcelEquipos($conn);
?>
