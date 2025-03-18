<?php
include('conexion.php');

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Ruta de destino para guardar las firmas
$ruta_destino = __DIR__ . '/Firmas/';
if (!is_dir($ruta_destino)) {
    mkdir($ruta_destino, 0775, true);  // Crear carpeta si no existe
}

// Obtener los datos del formulario
$usuario_id = $_POST['id_usuario'];  // Obtener el id_usuario desde la solicitud
$firma = $_FILES['firma'];  // Obtener el archivo de firma

if (isset($firma) && $firma['error'] === UPLOAD_ERR_OK) {
    // Generar nombre único para el archivo
    $nombre_archivo = uniqid() . '_' . $firma['name'];
    $ruta_completa = $ruta_destino . $nombre_archivo;

    // Mover el archivo al directorio de destino
    if (move_uploaded_file($firma['tmp_name'], $ruta_completa)) {
        // Insertar la información en la base de datos
        $sql = "INSERT INTO firmas (fk_id, ruta_f) VALUES ($usuario_id, '$nombre_archivo')";

        if ($conn->query($sql) === TRUE) {
            echo "Firma guardada exitosamente.";
        } else {
            echo "Error al guardar la firma: " . $conn->error;
        }
    } else {
        echo "Error al mover el archivo.";
    }
} else {
    echo "Error al subir el archivo. Código de error: " . $firma['error'];
}
?>
