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

// Consulta de datos del usuario
$query_usuario = "SELECT nombre, apellido, cargo, departamento, ciudad FROM usuarios WHERE ID_usuario = :id_usuario";
$stmt_usuario = $pdo->prepare($query_usuario);
$stmt_usuario->execute(['id_usuario' => $id_usuario]);

$user = $stmt_usuario->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    die('No se encontró el usuario.');
}

// Consulta de equipos asignados al usuario, ahora recuperamos el numero_consecutivo
$query_activos = "
    SELECT e.serial, e.nombre_equipo, e.marca, e.modelo, e.PLACA, e.sistema_operativo, 
           e.procesador, e.ram, e.disco, e.ip_lan, e.usuario_dominio, e.hv, 
           a.numero_consecutivo, a.estado_asig, a.fecha_asignacion
    FROM equipos e
    JOIN asignacion a ON a.FK_serial = e.serial
    WHERE a.FK_id = :id_usuario AND a.estado_asig = 'ACTIVO'";
$stmt_activos = $pdo->prepare($query_activos);
$stmt_activos->execute(['id_usuario' => $id_usuario]);

// Crear el PDF
$pdf = new FPDI();
$pdf->setSourceFile('base_m.pdf');
$template = $pdf->importPage(1);

$pdf->addPage();
$pdf->useTemplate($template);

// Fuente
$pdf->setFont('Arial', '', 9);

// Información del usuario
$pdf->setXY(55, 45);
$pdf->Cell(0, 10, htmlspecialchars($user['nombre']) . ' ' . htmlspecialchars($user['apellido']));

$pdf->setXY(165, 180);
$pdf->Cell(0, 10, htmlspecialchars($user['nombre']) . ' ' . htmlspecialchars($user['apellido']));

$pdf->setXY(60, 49);
$pdf->Cell(0, 10, htmlspecialchars($user['departamento']));

$y_position = 70.5; // Se empieza a imprimir después de la información del usuario

// Arreglos para almacenar los equipos según su tipo
$equipos = [
    'pc' => [],
    'monitor' => [],
    'teclado' => [],
    'mouse' => [],
    'impresora' => [],
    'portatil' => [],
 
];

// Almacenamos los equipos en sus respectivas categorías
while ($asignacion = $stmt_activos->fetch(PDO::FETCH_ASSOC)) {
    $nombre_equipo = strtolower($asignacion['nombre_equipo']);  // Convertir a minúsculas para comparación

    // Clasificación exacta para cada tipo de equipo
    if (strpos($nombre_equipo, 'pc') !== false) {
        $equipos['pc'][] = $asignacion;
    } elseif (strpos($nombre_equipo, 'monitor') !== false) {
        $equipos['monitor'][] = $asignacion;
    } elseif (strpos($nombre_equipo, 'teclado') !== false) {
        $equipos['teclado'][] = $asignacion;
    } elseif (strpos($nombre_equipo, 'mouse') !== false) {
        $equipos['mouse'][] = $asignacion;
    } elseif (strpos($nombre_equipo, 'impresora') !== false) {
        $equipos['impresora'][] = $asignacion;
    } elseif (strpos($nombre_equipo, 'portatil') !== false) {
        $equipos['portatil'][] = $asignacion;
    }

    // Consulta de mantenimiento para cada equipo usando el numero_consecutivo de la asignación
    $query_mantenimiento = "
        SELECT fecha_inicio, fecha_fin, observaciones 
        FROM mantenimiento m
        WHERE m.fk_numero_consecutivo = :numero_consecutivo
    ";
    $stmt_mantenimiento = $pdo->prepare($query_mantenimiento);
    $stmt_mantenimiento->execute(['numero_consecutivo' => $asignacion['numero_consecutivo']]);

    // Obtener los resultados de mantenimiento
    $mantenimiento = $stmt_mantenimiento->fetch(PDO::FETCH_ASSOC);

    // Si hay datos de mantenimiento, los mostramos
    if ($mantenimiento) {

        $pdf->setXY(158.3, 45);
        $pdf->Cell(0, 10, htmlspecialchars($mantenimiento['fecha_inicio']));

        $pdf->setXY(158.3, 49);
        $pdf->Cell(0, 10, htmlspecialchars($mantenimiento['fecha_fin']));

        $pdf->setXY(12, 125);
        $pdf->Cell(0, 10, htmlspecialchars($mantenimiento['observaciones']));
    }
}

$hv = false;
// Ordenar y mostrar los equipos en el orden deseado
$orden = ['pc', 'monitor', 'teclado', 'mouse', 'impresora', 'portatil'];

foreach ($orden as $categoria) {

    // Si hay equipos en esta categoría, los mostramos
    if (!empty($equipos[$categoria])) {
        foreach ($equipos[$categoria] as $asignacion) {
            // Verificamos si la posición Y es mayor a 250, si es así, agregamos una nueva página
            if ($y_position > 250) {
                $pdf->addPage();
                $pdf->useTemplate($template);
            }
            if (strpos($asignacion['nombre_equipo'], 'PC') !== false || strpos($asignacion['nombre_equipo'], 'PORTATIL') !== false) {
                if (!$hv) {
                    $pdf->setXY(65, 53);
                    $pdf->Cell(0, 10, htmlspecialchars($asignacion['hv']));
                    $hv = true;
                }
            }

            // Imprimir detalles de los equipos
            $pdf->setXY(31.5, $y_position);
            $pdf->Cell(0, 10, htmlspecialchars($asignacion['marca']));

            $pdf->setXY(54, $y_position);
            $pdf->Cell(0, 10, htmlspecialchars($asignacion['modelo']));

            // Serial: Si es demasiado largo, se corta
            $serial = htmlspecialchars($asignacion['serial']);
            $pdf->setXY(82, $y_position);
            $pdf->Cell(0, 10, $serial);

            // Ajuste la distancia entre las filas para la próxima asignación de equipo
            $y_position += 6.5;
        }
    } else {
        // Si no hay equipos para esta categoría, solo dejamos espacio vacío
        $pdf->setXY(31.5, $y_position);
        $pdf->Cell(0, 10, '');  // Deja la categoría vacía

        $pdf->setXY(54, $y_position);
        $pdf->Cell(0, 10, '');

        $pdf->setXY(82, $y_position);
        $pdf->Cell(0, 10, '');

        $y_position += 6;
    }
}

// Salida del PDF
$pdf->Output('I', 'usuario_' . $id_usuario . '_informacion.pdf');
?>
