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

function generarExcel($conn, $estado = '', $poliza = '') {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'Serial');
    $sheet->setCellValue('B1', 'Equipo');
    $sheet->setCellValue('C1', 'Marca');
    $sheet->setCellValue('D1', 'Modelo');
    $sheet->setCellValue('E1', 'Fecha de Compra');
    $sheet->setCellValue('F1', 'Nombre Completo');
    $sheet->setCellValue('G1', 'Departamento');
    $sheet->setCellValue('H1', 'Años');

    if ($estado) {
        $sql = "SELECT * FROM equipos WHERE estado = '$estado'";
    } else if ($poliza) {
        $sql = "SELECT * FROM equipos WHERE poliza = '$poliza'";
    } else {
        die("No se ha especificado un parámetro válido");
    }

    $result = $conn->query($sql);
    $rowNum = 2;

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $serial = $row['serial'];
            $sqlAsignacion = "SELECT u.nombre, u.apellido, u.departamento 
                              FROM asignacion a 
                              JOIN usuarios u ON a.FK_id = u.ID_usuario 
                              WHERE a.FK_serial = '$serial' LIMIT 1";
            $resultAsignacion = $conn->query($sqlAsignacion);
            if ($resultAsignacion->num_rows > 0) {
                $userData = $resultAsignacion->fetch_assoc();
                $nombreCompleto = $userData['nombre'] . ' ' . $userData['apellido'];
                $departamento = $userData['departamento'];
            } else {
                $nombreCompleto = 'No asignado';
                $departamento = 'No asignado';
            }
            $fechaCompra = new DateTime($row["fecha_compra"]);
            $fechaActual = new DateTime(); 
            $diferencia = $fechaActual->diff($fechaCompra); 
            $años = $diferencia->y;

            $sheet->setCellValue('A' . $rowNum, $row['serial']);
            $sheet->setCellValue('B' . $rowNum, $row['nombre_equipo']);
            $sheet->setCellValue('C' . $rowNum, $row['marca']);
            $sheet->setCellValue('D' . $rowNum, $row['modelo']);
            $sheet->setCellValue('E' . $rowNum, $row['fecha_compra']);
            $sheet->setCellValue('F' . $rowNum, $nombreCompleto);
            $sheet->setCellValue('G' . $rowNum, $departamento);
            $sheet->setCellValue('h' . $rowNum, $años);
            $rowNum++;
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

if (isset($_GET['tabla'])) {
    if ($_GET['tabla'] == 'tablaX') {
        generarExcel($conn, 'DE BAJA');
    } else if ($_GET['tabla'] == 'tablaY') {
        generarExcel($conn, '', 'SI');
    }
}
?>
