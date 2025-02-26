<?php
include('conexion.php');

if (isset($_POST['serial'])) {
    $serial = $_POST['serial'];

    // Consulta actualizada con la fecha de asignación y ordenada por la fecha más reciente
    $sql = "SELECT 
                u.nombre, 
                u.apellido,
                u.cargo,
                u.departamento,
                a.fecha_asignacion
            FROM asignacion a
            JOIN usuarios u ON a.FK_id = u.id_usuario
            JOIN equipos e ON a.FK_serial = e.serial
            WHERE e.serial = ?
            ORDER BY a.fecha_asignacion DESC"; // Ordenar por fecha de asignación más reciente

    if ($stmt = $conn->prepare($sql)) {
        // Vinculamos el parámetro serial
        $stmt->bind_param("s", $serial); 
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<table class='table table-bordered'>";
            echo "<thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Cargo</th>
                        <th>Departamento</th>
                        <th>Fecha de Asignación</th>
                    </tr>
                  </thead><tbody>";

            while ($row = $result->fetch_assoc()) {
                $fechaAsignacion = new DateTime($row['fecha_asignacion']);
                $fechaFormateada = $fechaAsignacion->format('d/m/Y');
                // Mostrar los datos de la asignación en la tabla
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                echo "<td>" . htmlspecialchars($row['apellido']) . "</td>";
                echo "<td>" . htmlspecialchars($row['cargo']) . "</td>";
                echo "<td>" . htmlspecialchars($row['departamento']) . "</td>";
                echo "<td>" . $fechaFormateada . "</td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<p>No hay asignaciones para este equipo.</p>";
        }
    } else {
        echo "<p>Error al preparar la consulta.</p>";
    }

    $conn->close();
} else {
    echo "<p>No se recibió el Serial del equipo.</p>";
}
?>
