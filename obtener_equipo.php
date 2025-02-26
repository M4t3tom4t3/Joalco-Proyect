<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jp";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión es exitosa
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

// Verificar si se ha enviado el parámetro 'serial'
if (isset($_GET['serial'])) {
    $serial = $_GET['serial'];

    // Consulta para obtener los detalles del equipo
    $sql = "SELECT serial, marca, modelo, nombre_equipo, placa, activo_fijo, estado, ip_lan, ip_wlan, usuario_dominio, hv, sistema_operativo, ram, disco, procesador, fecha_compra, costo, num_factura, num_pedido, host_name, mac_lan, mac_wlan, licencia_w, paquete_of, poliza, correo FROM equipos WHERE serial = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $serial);  // Asegúrate de usar "s" para los valores de texto como serial
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Obtener los datos del equipo
        $row = $result->fetch_assoc();

        // Asegurarse de que la clave 'poliza' esté definida
        if (!isset($row['poliza'])) {
            $row['poliza'] = '';  // Asignar un valor vacío si 'poliza' no está presente
        }

        // Asegurarse de que la fecha no sea "0000-00-00"
        if ($row['fecha_compra'] == '0000-00-00') {
            $row['fecha_compra'] = '';  // Asignar un valor vacío si la fecha es inválida
        }

        // Devolver los datos del equipo en formato JSON
        echo json_encode($row);
    } else {
        // Si no se encuentra el equipo, devolver un error
        echo json_encode(["error" => "Equipo no encontrado"]);
    }
} else {
    // Si no se proporciona el parámetro 'serial', devolver un error
    echo json_encode(["error" => "Serial no proporcionado"]);
}
?>
