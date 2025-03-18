<?php
include('conexion.php');

if (isset($_POST['serial_equipo']) && isset($_POST['id_usuario']) && isset($_POST['estado'])) {
    $serial_equipo = $_POST['serial_equipo'];
    $id_usuario = $_POST['id_usuario'];
    $estado = $_POST['estado']; 

    if (empty($serial_equipo)) {
        echo json_encode(["success" => false, "message" => "Error: El serial del equipo está vacío."]);
        exit();
    }

    $update_sql = "UPDATE asignacion SET estado_asig = ? WHERE FK_serial = ? AND FK_ID = ?";

    if ($stmt_update = $conn->prepare($update_sql)) {
        $stmt_update->bind_param("sii", $estado, $serial_equipo, $id_usuario);

        if ($stmt_update->execute()) {
            echo json_encode(["success" => true, "message" => "Estado actualizado a $estado."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al actualizar el estado del equipo: " . $stmt_update->error]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Error al preparar la consulta de actualización: " . $conn->error]);
    }

    $stmt_update->close();
    $conn->close();
    exit();
}
if (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
    if (isset($_POST['serial_equipo']) && isset($_POST['id_usuario'])) {
        $serial_equipo = $_POST['serial_equipo'];
        $id_usuario = $_POST['id_usuario'];

        // Consulta para eliminar la asignación
        $delete_sql = "DELETE FROM asignacion WHERE FK_serial = ? AND FK_ID = ?";

        if ($stmt_delete = $conn->prepare($delete_sql)) {
            $stmt_delete->bind_param("ii", $serial_equipo, $id_usuario);

            if ($stmt_delete->execute()) {
                echo json_encode(["success" => true, "message" => "Asignación eliminada con éxito."]);
            } else {
                echo json_encode(["success" => false, "message" => "Error al eliminar la asignación: " . $stmt_delete->error]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Error al preparar la consulta de eliminación: " . $conn->error]);
        }

        $stmt_delete->close();
        $conn->close();
        exit();
    } else {
        echo json_encode(["success" => false, "message" => "Faltan datos para eliminar la asignación."]);
        exit();
    }
}



if (isset($_POST['id_usuario'])) {
    $id_usuario = $_POST['id_usuario'];

    $sql = "SELECT asignacion.FK_serial, equipos.nombre_equipo, equipos.placa, asignacion.estado_asig, asignacion.fecha_asignacion
        FROM asignacion
        JOIN equipos ON asignacion.FK_serial = equipos.serial
        WHERE asignacion.FK_ID = ?
        ORDER BY FIELD(asignacion.estado_asig, 'INACTIVO', 'ACTIVO') DESC, asignacion.fecha_asignacion DESC"; 

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<h4>Asignaciones de Equipos</h4>";
            echo "<table class='table table-striped'>";
            echo "<thead><tr><th>Serial</th><th>Nombre del Equipo</th><th>Placa</th><th>Estado</th><th>Fecha Asignación</th><th>Acciones</th></tr></thead>";
            echo "<tbody>";

            while ($row = $result->fetch_assoc()) {
                $serial_equipo = $row['FK_serial'];
                $nombre_equipo = htmlspecialchars($row['nombre_equipo']);
                $placa = htmlspecialchars($row['placa']);
                $estado = htmlspecialchars($row['estado_asig']);
                $fecha_asignacion = htmlspecialchars($row['fecha_asignacion']);  

                $fecha_asignacion_formateada = date("d/m/Y", strtotime($fecha_asignacion));

                echo "<tr>";
                echo "<td>" . $serial_equipo . "</td>";
                echo "<td>" . $nombre_equipo . "</td>";
                echo "<td>" . $placa . "</td>";
                echo "<td id='estado_" . $serial_equipo . "'>" . $estado . "</td>";
                echo "<td>" . $fecha_asignacion_formateada . "</td>"; 
                echo "<td><button class='btn btn-outline-warning' style='font-size: 15px;' onclick='cambiarEstado(\"$serial_equipo\", \"$id_usuario\")'><i class='bi bi-arrow-90deg-down' ></i></button>
                <button class='btn btn-outline-success' style='font-size: 15px;' onclick='cambiarEstadoActivo(\"$serial_equipo\", \"$id_usuario\")'><i class='bi bi-arrow-90deg-up' ></i></button>
                <button class='btn btn-outline-danger' style='font-size: 15px;' onclick='eliminarAsignacion(\"$serial_equipo\", \"$id_usuario\")'><i class='bi bi-trash'></i></button>
                </td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>No hay asignaciones para este usuario.</p>";
        }

        $stmt->close();
    } else {
        echo "<p>Error al ejecutar la consulta: " . $conn->error . "</p>";
    }

    $conn->close();
    exit();
}

?>
