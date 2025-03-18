<?php
// Conexión a la base de datos
$host = 'localhost';
$db = 'jp'; // Nombre de tu base de datos
$user = 'root';
$pass = ''; // Contraseña de tu base de datos

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Verificar si se recibió la firma y el ID de usuario
if (isset($_POST['firma']) && isset($_POST['fk_id'])) {
    $fk_id = $_POST['fk_id'];
    $firmaBase64 = $_POST['firma'];

    // Eliminar el prefijo "data:image/png;base64," de la cadena base64
    $firmaBase64 = str_replace('data:image/png;base64,', '', $firmaBase64);
    $firmaBase64 = str_replace(' ', '+', $firmaBase64); // Reemplazar los espacios con '+'

    // Decodificar la cadena base64 a datos binarios
    $firmaImagen = base64_decode($firmaBase64);

    // Generar un nombre único para la imagen (con timestamp)
    $nombreArchivo = 'firma_' . time() . '.png'; // Nombre único con timestamp

    // Definir la ruta donde se guardará la imagen
    $rutaImagen = 'firmas/' . $nombreArchivo;

    // Guardar la imagen en el servidor
    if (file_put_contents($rutaImagen, $firmaImagen)) {
        // Insertar la URL de la imagen y el ID del usuario en la base de datos
        $stmt = $pdo->prepare("INSERT INTO firmas (fk_id, ruta_f) VALUES (?, ?)");
        $stmt->execute([$fk_id, $rutaImagen]);

        echo "Firma guardada exitosamente!";
    } else {
        echo "Hubo un error al guardar la firma.";
    }
} else {
    echo "Error: No se recibió la firma o el ID de usuario.";
}
?>
