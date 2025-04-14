<?php
require_once('vendor/autoload.php');
use setasign\Fpdi\Fpdi;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$mensaje = '';
if (isset($_GET['tabla']) && $_GET['tabla'] == 'tablaX') {
    $estado = 'DE BAJA';
    $sql = "SELECT * FROM equipos WHERE estado = '$estado'";
    $mensaje = 'EQUIPOS DE BAJA';
} else if (isset($_GET['tabla']) && $_GET['tabla'] == 'tablaY') {
    $poliza = 'SI';
    $sql = "SELECT * FROM equipos WHERE poliza = '$poliza'";
    $mensaje = '  EQUIPOS EN POLIZA';
} else {
    die("Tabla no válida");
}

$result = $conn->query($sql);

$pdf = new FPDI('L', 'mm', array(215.9, 279.4));
$pdf->AddPage();
$pdf->setSourceFile('R_P.pdf');
$tplIdx = $pdf->importPage(1);
$pdf->useTemplate($tplIdx);
$pdf->SetFont('Arial', '', 8);

$pdf->SetY(10.5); 
$pdf->SetX(39); 
$pdf->Cell(0, 10, $mensaje, 0, 1, 'C'); 
$pdf->SetY(23.2); 
$pdf->SetX(15.5);




$pdf->Cell(36, 6, 'Serial', 1);
$pdf->Cell(21, 6, 'Equipo', 1);
$pdf->Cell(20, 6, 'Marca', 1);
$pdf->Cell(27, 6, 'Modelo', 1);
$pdf->Cell(23, 6, 'Fecha de Compra', 1);
$pdf->Cell(25, 6, 'Valor de Compra', 1);
$pdf->Cell(25, 6, 'Usuario', 1);
$pdf->Cell(20, 6, 'Departamento', 1);
$pdf->Cell(37, 6, 'Activo Fijo', 1);
$pdf->Cell(20, 6, 'Años', 1);
$pdf->Ln();

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

        $maxLength = 9; 


        $pdf->SetX(15.5);

    $marca = $row['marca'];
    if (strlen($marca) > $maxLength) {
    $marca = substr($marca, 0, $maxLength) . '...'; 
}
        
        $pdf->Cell(36, 10, $row['serial'], 1);
        $pdf->Cell(21, 10, $row['nombre_equipo'], 1);
        $pdf->Cell(20, 10, $marca, 1);
        $pdf->Cell(27, 10, $row['modelo'], 1);
        $pdf->Cell(23, 10, $row['fecha_compra'], 1);
        $pdf->Cell(25, 10, '$'.$row['costo'], 1);
        $pdf->Cell(25, 10, $nombreCompleto, 1);
        $pdf->Cell(20, 10, $departamento, 1);
        $pdf->Cell(37, 10, $row['activo_fijo'], 1);
        $pdf->Cell(20, 10, $años . ' años', 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, 'No hay registros', 0, 1);
}

$pdf->Output();

?>
