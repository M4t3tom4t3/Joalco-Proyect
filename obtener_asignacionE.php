<?php
include('conexion.php');

if (isset($_POST['serial'])) {
    $serial = $_POST['serial'];

    $sql = "SELECT 
                u.nombre, 
                u.apellido,
                u.cargo,
                u.departamento
            FROM asignacion a
            JOIN usuarios u ON a.FK_ID = u.id_usuario
            JOIN equipos e ON a.FK_serial = e.serial
            WHERE e.serial = ?";

    if ($stmt = $conn->prepare($sql)) {
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
                    </tr>
                  </thead><tbody>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                echo "<td>" . htmlspecialchars($row['apellido']) . "</td>";
                echo "<td>" . htmlspecialchars($row['cargo']) . "</td>";
                echo "<td>" . htmlspecialchars($row['departamento']) . "</td>";
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
