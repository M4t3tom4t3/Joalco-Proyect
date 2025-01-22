<?php
include('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['serial'])) {
        $serial = $_POST['serial'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $nombre_equipo = $_POST['nombre_equipo'];
        $placa = $_POST['placa'];
        $activo_fijo = $_POST['activo_fijox'];
        $estado = $_POST['estadox'];
        $ip_lan = $_POST['ip_lanx'];
        $ip_wlan = $_POST['ip_wlanx'];
        $usuario_dominio = $_POST['usuario_dominiox'];
        $hv = $_POST['hvx'];
        $sistema_operativo = $_POST['sistema_operativox'];
        $ram = $_POST['ramx'];
        $disco = $_POST['discox'];
        $procesador = $_POST['procesadorx'];
        $fecha_compra = $_POST['fecha_comprax'];
        $costo = $_POST['costox'];

        // Escapar los valores para evitar inyecciones SQL
        $serial = $conn->real_escape_string($serial);
        $marca = $conn->real_escape_string($marca);
        $modelo = $conn->real_escape_string($modelo);
        $nombre_equipo = $conn->real_escape_string($nombre_equipo);
        $placa = $conn->real_escape_string($placa);
        $activo_fijo = $conn->real_escape_string($activo_fijo);
        $estado = $conn->real_escape_string($estado);
        $ip_lan = $conn->real_escape_string($ip_lan);
        $ip_wlan = $conn->real_escape_string($ip_wlan);
        $usuario_dominio = $conn->real_escape_string($usuario_dominio);
        $hv = $conn->real_escape_string($hv);
        $sistema_operativo = $conn->real_escape_string($sistema_operativo);
        $ram = $conn->real_escape_string($ram);
        $disco = $conn->real_escape_string($disco);
        $procesador = $conn->real_escape_string($procesador);
        $fecha_compra = $conn->real_escape_string($fecha_compra);
        $costo = $conn->real_escape_string($costo);

        // Ahora, realiza la consulta de actualización
        $sql = "UPDATE equipos SET marca = '$marca', modelo = '$modelo', nombre_equipo = '$nombre_equipo',
                placa = '$placa', activo_fijo = '$activo_fijo', estado = '$estado', ip_lan = '$ip_lan',
                ip_wlan = '$ip_wlan',usuario_dominio = '$usuario_dominio', hv = '$hv', sistema_operativo = '$sistema_operativo', ram = '$ram',
                disco = '$disco', procesador = '$procesador', fecha_compra = '$fecha_compra', costo = '$costo'
                WHERE serial = '$serial'";

        // Ejecutar la consulta
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => 'Equipo actualizado correctamente.']);
        } else {
            echo json_encode(['error' => 'Error al actualizar el equipo: ' . $conn->error]);
        }
    } else {
        echo json_encode(['error' => 'Faltan datos del formulario.']);
    }
}
?>
