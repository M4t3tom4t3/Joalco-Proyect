<?php

if (isset($_POST['cambio']) && isset($_POST['fecha_cambio'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "jp";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $cambio = $_POST['cambio'];
    $fecha_cambio = $_POST['fecha_cambio'];
    $serial = $_POST['serial']; 

    
    $sql = "INSERT INTO cambios (fk_serial, cambio, fecha_cambio) VALUES (?, ?, ?)";

    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("sss", $serial, $cambio, $fecha_cambio);

    if ($stmt->execute()) {
        echo "Cambios guardados correctamente";
    } else {
        echo "Error al guardar los cambios: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Faltan datos requeridos";
}
?>