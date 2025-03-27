<?php
require 'conexion.php';

header('Content-Type: application/json');

try {
    if (isset($_POST['id_usuario']) && isset($_POST['equipos'])) {
        $id_usuario = $_POST['id_usuario'];
        $equipos = json_decode($_POST['equipos'], true);
        $estado_asig = $_POST['estado_asig'];
        $fecha_asignacion = $_POST['fecha_asignacion'];

        $conexion = new Conexion;

        $conexion->Query = "SELECT MAX(numero_consecutivo) as max_consec FROM asignacion";
        $conexion->Pps = $conexion->getBaseDeDatosConection()->prepare($conexion->Query);
        $conexion->Pps->execute();
        $resultado = $conexion->Pps->fetch(PDO::FETCH_ASSOC);
        $nuevo_consecutivo = ($resultado['max_consec'] ?? 0) + 1;

        $pdo = $conexion->getBaseDeDatosConection(); 

        $pdo->beginTransaction(); 

        foreach ($equipos as $placa_equipo) {
            $conexion->Query = "INSERT INTO asignacion (numero_consecutivo, FK_id, FK_serial, estado_asig, fecha_asignacion) 
                                 VALUES (:consec, :id_usuario, :placa_equipo, :estado_asig, :fecha_asignacion)";

            $conexion->Pps = $pdo->prepare($conexion->Query);
            $conexion->Pps->execute([
                ":consec" => $nuevo_consecutivo,
                ":id_usuario" => $id_usuario,
                ":placa_equipo" => $placa_equipo,
                ":estado_asig" => $estado_asig,
                ":fecha_asignacion" => $fecha_asignacion
            ]);
        }

        $pdo->commit(); 
        echo json_encode(['status' => 'success', 'message' => 'Equipo agregado exitosamente.']);
    } else {
        throw new Exception('Datos incompletos.');
    }
} catch (\Throwable $th) {
    if (isset($pdo) && $pdo->inTransaction()) { 
        $pdo->rollBack(); 
    }
    echo json_encode(['status' => 'error', 'message' => 'Hubo un error al guardar la asignación: ' . $th->getMessage()]);
}
exit;
?>