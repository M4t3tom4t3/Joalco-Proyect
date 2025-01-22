<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

if (isset($_GET['serial'])) {
    $serial = $_GET['serial'];

    $sql = "SELECT serial, marca, modelo, nombre_equipo, placa, activo_fijo, estado, ip_lan, ip_wlan, usuario_dominio, hv, sistema_operativo, ram, disco, procesador, fecha_compra, costo FROM equipos WHERE serial = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $serial);  // Asegúrate de usar "s" para los valores de texto como serial
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "Equipo no encontrado"]);
    }
    
} else {
    echo json_encode(["error" => "Serial no proporcionado"]);
}

?>
