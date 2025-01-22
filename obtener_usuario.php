<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

if (isset($_GET['ID_usuario'])) {
    $userId = $_GET['ID_usuario'];

    $sql = "SELECT ID_usuario, nombre, apellido, cargo, departamento, ciudad FROM usuarios WHERE ID_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode($user);  // Devolver los datos del usuario en formato JSON
    } else {
        echo json_encode(["error" => "Usuario no encontrado"]);
    }
} else {
    echo json_encode(["error" => "ID_usuario no proporcionado"]);
}

$conn->close();
?>
