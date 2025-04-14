<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $cseleconn->connect_error);
}

$sql = "SELECT MAX(hv) AS ultima_hv FROM equipos";
$result = $conn->query($sql);

$ultimaHv = 1; 

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['ultima_hv'] !== null) {
        $ultimaHv = $row['ultima_hv'] + 1;
    }
}

echo json_encode(["siguiente_hv" => $ultimaHv]);
$conn->close();
?>
