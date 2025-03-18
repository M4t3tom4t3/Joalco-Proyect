<?php

// Verifica si las variables correctas están en el POST
if (isset($_POST['fecha_b']) && isset($_POST['tecnico_b']) && isset($_POST['disco']) && isset($_POST['serial'])) {
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "jp";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Recibe los valores del formulario
    $fecha_b = $_POST['fecha_b'];
    $tecnico_b = $_POST['tecnico_b'];
    $disco = $_POST['disco'];
    $serial = $_POST['serial'];  

    // Prepara la consulta para insertar en la base de datos
    $sql = "INSERT INTO backups (fk_serial, fecha_b, tecnico_b, disco) VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    // Vincula los parámetros
    $stmt->bind_param("ssss", $serial, $fecha_b, $tecnico_b, $disco);

    // Ejecuta la consulta
    if ($stmt->execute()) {
        echo "Backup registrado correctamente";
    } else {
        echo "Error al guardar los cambios: " . $stmt->error;
    }

    // Cierra la declaración y la conexión
    $stmt->close();
    $conn->close();
} else {
    echo "Faltan datos requeridos";
}
?>
