<?php
require_once('vendor/autoload.php');

use setasign\Fpdi\Fpdi;

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID de usuario no especificado.');
}

$id_usuario = $_GET['id'];

$dsn = 'mysql:host=localhost;dbname=jp';
$username = 'root';
$password = '';
$pdo = new PDO($dsn, $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query_usuario = "SELECT nombre, apellido, cargo, departamento, ciudad FROM usuarios WHERE ID_usuario = :id_usuario";
$stmt_usuario = $pdo->prepare($query_usuario);
$stmt_usuario->execute(['id_usuario' => $id_usuario]);

$user = $stmt_usuario->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    die('No se encontró el usuario.');
}

$query_firma = "SELECT ruta_f FROM firmas WHERE fk_id = :id_usuario";
$stmt_firma = $pdo->prepare($query_firma);
$stmt_firma->execute(['id_usuario' => $id_usuario]);

$firma = $stmt_firma->fetch(PDO::FETCH_ASSOC);

$image_path = !empty($firma['ruta_f']) ? 'Firmas/' . $firma['ruta_f'] : '';  

if ($image_path && file_exists($image_path)) {
    $image_exists = true;
} else {
    $image_exists = false;
}

$query_firma_usuario_4 = "SELECT ruta_f FROM firmas WHERE fk_id = 4";
$stmt_firma_usuario_4 = $pdo->prepare($query_firma_usuario_4);
$stmt_firma_usuario_4->execute();

$firma_usuario_4 = $stmt_firma_usuario_4->fetch(PDO::FETCH_ASSOC);
$image_path_usuario_4 = !empty($firma_usuario_4['ruta_f']) ? 'Firmas/' . $firma_usuario_4['ruta_f'] : '';


$query_activos = "SELECT e.serial, e.nombre_equipo, e.marca, e.modelo, e.PLACA, e.sistema_operativo, 
                               e.procesador, e.ram, e.disco, e.ip_lan, e.usuario_dominio, 
                               a.numero_consecutivo, a.estado_asig, a.fecha_asignacion
                       FROM equipos e
                       JOIN asignacion a ON a.FK_serial = e.serial
                       WHERE a.FK_id = :id_usuario AND a.estado_asig = 'ACTIVO'
                       ORDER BY a.fecha_asignacion DESC";
$stmt_activos = $pdo->prepare($query_activos);
$stmt_activos->execute(['id_usuario' => $id_usuario]);

$query_inactivos = "SELECT e.serial, e.nombre_equipo, e.marca, e.modelo, e.PLACA, e.sistema_operativo, 
                                 e.procesador, e.ram, e.disco, e.ip_lan, e.usuario_dominio, 
                                 a.numero_consecutivo, a.estado_asig, a.fecha_asignacion
                         FROM equipos e
                         JOIN asignacion a ON a.FK_serial = e.serial
                         WHERE a.FK_id = :id_usuario AND a.estado_asig = 'INACTIVO'
                         ORDER BY a.fecha_asignacion DESC";
$stmt_inactivos = $pdo->prepare($query_inactivos);
$stmt_inactivos->execute(['id_usuario' => $id_usuario]);

$pdf = new FPDI();
$pdf->setSourceFile('base.pdf');
$template = $pdf->importPage(1);

$pdf->addPage();
$pdf->useTemplate($template);

$pdf->setFont('Arial', '', 9);

if ($image_exists) {
    $pdf->Image($image_path, 86, 234, 57, 11); 
} else {
    
}

if (!empty($image_path_usuario_4) && file_exists($image_path_usuario_4)) {
    $pdf->Image($image_path_usuario_4, 30, 235, 57,11); 
} else {
    $pdf->setXY(40, 235);
    $pdf->Cell(0, 10, "");
}


$pdf->setXY(67, 35);
$pdf->Cell(0, 10, htmlspecialchars($user['nombre']) . ' ' . htmlspecialchars($user['apellido']));

$pdf->setXY(94, 246);
$pdf->Cell(0, 10, htmlspecialchars($user['nombre']) . ' ' . htmlspecialchars($user['apellido']));

$pdf->setXY(33, 57);
$pdf->Cell(0, 10, htmlspecialchars($user['cargo']));

$pdf->setXY(164, 45);
$pdf->Cell(0, 10, htmlspecialchars($user['departamento']));

$pdf->setXY(73, 45);
$pdf->Cell(0, 10, htmlspecialchars($user['ciudad']));

$y_position = 73.8; 

$sistema_operativo_impreso = false;
$procesador_impreso = false;
$ram_impreso = false;
$disco_impreso = false;
$ip_lan_impreso = false;
$usuario_dominio_impreso = false;
$fecha_impresa = false;
$consecutivo_impreso = false; 

while ($asignacion = $stmt_activos->fetch(PDO::FETCH_ASSOC)) {
    if ($y_position > 250) {
        $pdf->addPage();
        $pdf->useTemplate($template);
        $y_position = 35;  
    }

    $pdf->setXY(17, $y_position);
    $pdf->Cell(0, 10, htmlspecialchars($asignacion['nombre_equipo']));

    $pdf->setXY(53, $y_position);
    $pdf->Cell(0, 10, htmlspecialchars($asignacion['marca']));

    $pdf->setXY(75, $y_position);
    $pdf->Cell(0, 10, htmlspecialchars($asignacion['modelo']));

    $serial = htmlspecialchars($asignacion['serial']);
    $max_serial_length = 13; 
    if (strlen($serial) > $max_serial_length) {
        $serial = substr($serial, 0, $max_serial_length) . '...';
    }

    $pdf->setXY(141, $y_position);
    $pdf->Cell(0, 10, $serial);

    $pdf->setXY(172, $y_position);
    $pdf->Cell(0, 10, htmlspecialchars($asignacion['PLACA']));

    if (($asignacion['nombre_equipo'] == 'PC' || $asignacion['nombre_equipo'] == 'PORTATIL') && !$consecutivo_impreso) {
        $pdf->setXY(177, 35);  
        $pdf->Cell(0, 10, 'A-' . htmlspecialchars($asignacion['numero_consecutivo']));
        $consecutivo_impreso = true; 
    }

    
    if (!empty($asignacion['sistema_operativo']) && !$sistema_operativo_impreso) {
        $pdf->setXY(141, 113);
        $pdf->Cell(0, 10, htmlspecialchars($asignacion['sistema_operativo']));
        $sistema_operativo_impreso = true;
    }

    if (!empty($asignacion['procesador']) && !$procesador_impreso) {
        $pdf->setXY(38, 120.5);
        $pdf->Cell(0, 10, htmlspecialchars($asignacion['procesador']));
        $procesador_impreso = true;
    }

    if (!empty($asignacion['ram']) && !$ram_impreso) {
        $pdf->setXY(38, 117);
        $pdf->Cell(0, 10, htmlspecialchars($asignacion['ram']) . ' GB');
        $ram_impreso = true;
    }

    if (!empty($asignacion['disco']) && !$disco_impreso) {
        $pdf->setXY(38, 113);
        $pdf->Cell(0, 10, htmlspecialchars($asignacion['disco']));
        $disco_impreso = true;
    }

    if (!empty($asignacion['ip_lan']) && !$ip_lan_impreso) {
        $pdf->setXY(141, 117);
        $pdf->Cell(0, 10, htmlspecialchars($asignacion['ip_lan']));
        $ip_lan_impreso = true;
    }

    if (!empty($asignacion['usuario_dominio']) && !$usuario_dominio_impreso) {
        $pdf->setXY(141, 120.5);
        $pdf->Cell(0, 10, htmlspecialchars($asignacion['usuario_dominio']));
        $usuario_dominio_impreso = true;
    }

    if (in_array(strtoupper($asignacion['nombre_equipo']), ['PORTATIL', 'PC']) && !$fecha_impresa) {
        $pdf->setXY(100, 57.5);
        $pdf->Cell(0, 10, htmlspecialchars($asignacion['fecha_asignacion']));
        $pdf->setXY(170, 57.5);
        $pdf->Cell(0, 10, htmlspecialchars($asignacion['fecha_asignacion']));
        $fecha_impresa = true;
    }

    $y_position += 4.4;  
}

while ($asignacion = $stmt_inactivos->fetch(PDO::FETCH_ASSOC)) {
    if ($y_position > 250) {
        $pdf->addPage();
        $pdf->useTemplate($template);
        $y_position = 35;  
    }

    $pdf->setXY(17, 137.7);
    $pdf->Cell(0, 10, htmlspecialchars($asignacion['nombre_equipo']));

    $pdf->setXY(53, 137.7);
    $pdf->Cell(0, 10, htmlspecialchars($asignacion['marca']));

    $pdf->setXY(75, 137.7);
    $pdf->Cell(0, 10, htmlspecialchars($asignacion['modelo']));

    $serial = htmlspecialchars($asignacion['serial']);
    $max_serial_length = 13; 
    if (strlen($serial) > $max_serial_length) {
        $serial = substr($serial, 0, $max_serial_length) . '...';
    }

    $pdf->setXY(141, 137.7);
    $pdf->Cell(0, 10, $serial);

    $pdf->setXY(172, 137.7);
    $pdf->Cell(0, 10, htmlspecialchars($asignacion['PLACA']));

    if (($asignacion['nombre_equipo'] == 'PC' || $asignacion['nombre_equipo'] == 'PORTATIL') && !$consecutivo_impreso) {
        $pdf->setXY(100, $y_position);  
        $pdf->Cell(0, 10, 'Nº Consecutivo: ' . htmlspecialchars($asignacion['numero_consecutivo']));
        $consecutivo_impreso = true;  
    }

    $y_position += 4.4;  
}

// Salida del PDF
$pdf->Output('I', 'usuario_' . $id_usuario . '_informacion.pdf');
?>
