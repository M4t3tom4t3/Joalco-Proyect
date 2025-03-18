<?php
require 'conexion.php';

if (isset($_POST['id_usuario']) && isset($_POST['placa_equipo'])) {
    $id_usuario = $_POST['id_usuario'];
    $placa_equipo = $_POST['placa_equipo'];
    $estado_asig = $_POST['estado_asig'];  
    $fecha_asignacion = $_POST['fecha_asignacion'];  

    $conexion = new Conexion;

    $conexion->Query = "INSERT INTO asignacion (FK_id, FK_serial, estado_asig, fecha_asignacion) 
                        VALUES (:id_usuario, :placa_equipo, :estado_asig, :fecha_asignacion)";

    try {
        $conexion->Pps = $conexion->getBaseDeDatosConection()->prepare($conexion->Query);
        $conexion->Pps->execute([
            ":id_usuario" => $id_usuario,
            ":placa_equipo" => $placa_equipo,
            ":estado_asig" => $estado_asig,
            ":fecha_asignacion" => $fecha_asignacion
        ]);

        echo json_encode(['status' => 'success', 'message' => 'Asignación guardada']);
    } catch (\Throwable $th) {
        echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
    } finally {
        $conexion->closeDataBase();
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Datos faltantes']);
}
?>
