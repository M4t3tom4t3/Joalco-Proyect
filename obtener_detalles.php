<?php
// Depuración
error_log("POST data: " . print_r($_POST, true)); // Ver los datos recibidos

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

if (isset($_POST['serial'])) {
    $serial = $_POST['serial'];
    
    // Verificar que el serial está siendo recibido
    error_log("Serial recibido: " . $serial);

    $sql = "SELECT activo_fijo, estado, ip_lan, ip_wlan, usuario_dominio, hv, sistema_operativo, ram, disco, procesador, fecha_compra, costo, host_name, mac_lan, mac_wlan, correo FROM equipos WHERE serial = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $serial); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row); // Regresar la respuesta en formato JSON
    } else {
        echo json_encode(["error" => "No se encontró el equipo"]);
    }
} else {
    echo json_encode(["error" => "No se envió el serial"]);
}

$conn->close();
?>
