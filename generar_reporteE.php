<?php
// Incluir las clases necesarias para trabajar con Excel (PhpSpreadsheet)
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require_once 'vendor/autoload.php';

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jp";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para generar el reporte Excel
function generarExcel($conn, $estado = '', $poliza = '') {
    // Crear un nuevo objeto Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Encabezado de la tabla
    $sheet->setCellValue('A1', 'Serial');
    $sheet->setCellValue('B1', 'Equipo');
    $sheet->setCellValue('C1', 'Marca');
    $sheet->setCellValue('D1', 'Modelo');
    $sheet->setCellValue('E1', 'Fecha de Compra');
    $sheet->setCellValue('F1', 'Nombre Completo');
    $sheet->setCellValue('G1', 'Departamento');

    // Determinar la consulta según el tipo de reporte
    if ($estado) {
        // Equipos de baja
        $sql = "SELECT * FROM equipos WHERE estado = '$estado'";
    } else if ($poliza) {
        // Equipos en póliza
        $sql = "SELECT * FROM equipos WHERE poliza = '$poliza'";
    } else {
        // En caso de no recibir parámetros válidos
        die("No se ha especificado un parámetro válido");
    }

    $result = $conn->query($sql);
    $rowNum = 2;

    // Llenar las filas de datos
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Obtener el ID del usuario asignado a este equipo
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

            // Llenar los datos en las celdas
            $sheet->setCellValue('A' . $rowNum, $row['serial']);
            $sheet->setCellValue('B' . $rowNum, $row['nombre_equipo']);
            $sheet->setCellValue('C' . $rowNum, $row['marca']);
            $sheet->setCellValue('D' . $rowNum, $row['modelo']);
            $sheet->setCellValue('E' . $rowNum, $row['fecha_compra']);
            $sheet->setCellValue('F' . $rowNum, $nombreCompleto);
            $sheet->setCellValue('G' . $rowNum, $departamento);

            // Incrementar la fila
            $rowNum++;
        }
    }

    // Crear el archivo Excel
    $writer = new Xlsx($spreadsheet);
    
    // Establecer el nombre del archivo
    $fileName = 'reporte_' . date('Y-m-d') . '.xlsx';
    
    // Forzar la descarga del archivo
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');
    
    // Guardar el archivo
    $writer->save('php://output');
    exit();
}

// Si el parámetro 'tabla' está presente en la URL, generar el reporte correspondiente
if (isset($_GET['tabla'])) {
    if ($_GET['tabla'] == 'tablaX') {
        // Generar reporte Excel para equipos de baja
        generarExcel($conn, 'DE BAJA');
    } else if ($_GET['tabla'] == 'tablaY') {
        // Generar reporte Excel para equipos en póliza
        generarExcel($conn, '', 'SI');
    }
}
?>
