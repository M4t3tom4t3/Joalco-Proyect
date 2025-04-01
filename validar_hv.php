<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "jp";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die(json_encode(["error" => "Error de conexión: " . $conn->connect_error]));
}

if (isset($_GET['hv'])) {
    $hv = $conn->real_escape_string($_GET['hv']);
    $sql = "SELECT COUNT(*) as count FROM equipos WHERE hv = '$hv'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    echo json_encode(["existe" => $row['count'] > 0]);
}

$conn->close();
?>
