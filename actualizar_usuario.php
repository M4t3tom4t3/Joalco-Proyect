<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

if (isset($_POST['ID_usuario'])) {
    $userId = $_POST['ID_usuario'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cargo = $_POST['cargo'];
    $departamento = $_POST['departamento'];
    $ciudad = $_POST['ciudad'];

    $sql = "UPDATE usuarios SET nombre = ?, apellido = ?, cargo = ?, departamento = ?, ciudad = ? WHERE ID_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $nombre, $apellido, $cargo, $departamento, $ciudad, $userId);

    if ($stmt->execute()) {
        echo "Usuario actualizado correctamente";
    } else {
        echo "Error al actualizar el usuario";
    }
} else {
    echo "Datos incompletos";
}

$conn->close();
?>
