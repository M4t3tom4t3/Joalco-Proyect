<?php
require_once('vendor/autoload.php');
use setasign\Fpdi\Fpdi;


if (!isset($_GET['serial']) || empty($_GET['serial'])) {
    die('Serial del equipo no especificado.');
}

$serial = $_GET['serial'];

try {
    $pdo = new PDO('mysql:host=localhost;dbname=jp', 'root', ''); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("No se pudo conectar a la base de datos: " . $e->getMessage());
}


$query_usuario = "SELECT a.FK_id
                  FROM asignacion a
                  WHERE a.FK_serial = :serial"; 
$stmt_usuario = $pdo->prepare($query_usuario);
$stmt_usuario->execute(['serial' => $serial]);

$usuarios_ids = $stmt_usuario->fetchAll(PDO::FETCH_COLUMN);

$query_asignacion = "SELECT estado_asig, fecha_asignacion, numero_consecutivo
                     FROM asignacion WHERE FK_serial = :serial";
$stmt_asignacion = $pdo->prepare($query_asignacion);
$stmt_asignacion->execute(['serial' => $serial]);

$asignacion = $stmt_asignacion->fetch(PDO::FETCH_ASSOC);

$query_mantenimiento = "SELECT fecha_inicio, fecha_fin, observaciones, tecnico
                        FROM mantenimiento WHERE fk_numero_consecutivo = :numero_consecutivo";
$stmt_mantenimiento = $pdo->prepare($query_mantenimiento);
$stmt_mantenimiento->execute(['numero_consecutivo' => $asignacion['numero_consecutivo']]);

$mantenimiento = $stmt_mantenimiento->fetch(PDO::FETCH_ASSOC);

if (empty($usuarios_ids)) {
    die('No se encontró ningún usuario asignado a este serial.');
}

$query_equipo = "SELECT serial, nombre_equipo, marca, modelo, PLACA, ip_lan, ip_wlan, hv, sistema_operativo, usuario_dominio, ram, disco, procesador, fecha_compra, activo_fijo
                 FROM equipos WHERE serial = :serial";
$stmt_equipo = $pdo->prepare($query_equipo);
$stmt_equipo->execute(['serial' => $serial]);

$equipo = $stmt_equipo->fetch(PDO::FETCH_ASSOC);

$pdf = new FPDI();
$pdf->setSourceFile('base_hv.pdf');
$template = $pdf->importPage(1);

$pdf->addPage();
$pdf->useTemplate($template);


$pdf->setFont('Arial', '', 8);

$y_position = 48;

$pdf->setXY(82, 72);
$pdf->Cell(0, 10,htmlspecialchars($equipo['nombre_equipo']));


$pdf->setXY(16, 76);
$pdf->Cell(0, 10,htmlspecialchars($equipo['marca']));

$pdf->setXY(51, 72);
$max_length = 8;  
$modelo = htmlspecialchars($equipo['modelo']);
if (strlen($modelo) > $max_length) {
    $modelo = substr($modelo, 0, $max_length) . '...';  
}

$pdf->Cell(0, 10, $modelo);


$pdf->setXY(51, 76);
$pdf->Cell(0, 10,htmlspecialchars($equipo['serial']));


$pdf->setXY(97, 137);
$pdf->Cell(0, 10,htmlspecialchars($equipo['ip_lan']));


$pdf->setXY(97, 141);
$pdf->Cell(0, 10,htmlspecialchars($equipo['ip_wlan']));


$pdf->setXY(51, 102);
$pdf->Cell(0, 10,htmlspecialchars($equipo['sistema_operativo']));


$pdf->setXY(68, 91);
$pdf->Cell(0, 10, htmlspecialchars($equipo['ram']) . ' GB');


$pdf->setXY(29, 91);
$pdf->Cell(0, 10,htmlspecialchars($equipo['disco']));


$pdf->setXY(51, 96);
$pdf->Cell(0, 10,htmlspecialchars($equipo['procesador']));

$pdf->setXY(175, 25);
$pdf->Cell(0, 10,htmlspecialchars($equipo['hv']));

$pdf->setXY(170, 30);
$pdf->Cell(0, 10,htmlspecialchars($equipo['activo_fijo']));

$pdf->setXY(170, 34);
$pdf->Cell(0, 10,htmlspecialchars($equipo['fecha_compra']));


$pdf->setXY(158, 141);
$pdf->Cell(0, 10,htmlspecialchars($equipo['usuario_dominio']));


$y_position_mantenimiento = 76; 

$query_mantenimiento = "
    SELECT fecha_inicio, fecha_fin, observaciones, tecnico
    FROM mantenimiento
    WHERE fk_numero_consecutivo IN (SELECT numero_consecutivo FROM asignacion WHERE FK_serial = :serial)
";
$stmt_mantenimiento = $pdo->prepare($query_mantenimiento);
$stmt_mantenimiento->execute(['serial' => $serial]);

$mantenimientos = $stmt_mantenimiento->fetchAll(PDO::FETCH_ASSOC);

$y_position_mantenimiento = 76; // Aquí ajustas la posición inicial para los mantenimientos

// Iterar sobre todos los mantenimientos
foreach ($mantenimientos as $mantenimiento) {
    // Formatear la fecha
    $fecha_inicio = date('d/m/Y', strtotime($mantenimiento['fecha_inicio']));
    
    $pdf->setXY(98, $y_position_mantenimiento);
    $pdf->Cell(0, 10, 'PREVEN  ' . htmlspecialchars($fecha_inicio));   

    $pdf->setXY(130, $y_position_mantenimiento);
    $pdf->Cell(0, 10, htmlspecialchars($mantenimiento['tecnico']));

    $y_position_mantenimiento += 4; 
}


foreach ($usuarios_ids as $id_usuario) {
    $query_user = "SELECT nombre, apellido, cargo, departamento FROM usuarios WHERE ID_usuario = :id_usuario";
    $stmt_user = $pdo->prepare($query_user);
    $stmt_user->execute(['id_usuario' => $id_usuario]);

    $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        continue; 
    }

    // Información del usuario
    $pdf->setXY(16, $y_position);
    $pdf->Cell(0, 10, htmlspecialchars($user['nombre']) . ' ' . htmlspecialchars($user['apellido']));
    $pdf->setXY(51, $y_position);
    $pdf->Cell(0, 10, htmlspecialchars($user['departamento']));
    $pdf->setXY(98, $y_position);
    $pdf->Cell(0, 10, htmlspecialchars($user['cargo']));

    $query_asignacion_usuario = "SELECT estado_asig, fecha_asignacion, numero_consecutivo
                                 FROM asignacion 
                                 WHERE FK_id = :id_usuario AND FK_serial = :serial";
    $stmt_asignacion_usuario = $pdo->prepare($query_asignacion_usuario);
    $stmt_asignacion_usuario->execute(['id_usuario' => $id_usuario, 'serial' => $serial]);

    $asignacion_usuario = $stmt_asignacion_usuario->fetch(PDO::FETCH_ASSOC);

    if (!$asignacion_usuario) {
        continue; 
    }
    $fecha_asignacion = date('d/m/Y', strtotime($asignacion_usuario['fecha_asignacion']));
$pdf->setXY(158, $y_position);  
$pdf->Cell(0, 10, htmlspecialchars($fecha_asignacion));


    $pdf->setXY(130, $y_position);  
    $pdf->Cell(0, 10, 'A-' . htmlspecialchars($asignacion_usuario['numero_consecutivo']));
$y_position += 4;
}


$pdf->Output('I', 'usuario_' . $serial . '_informacion.pdf');
?>
