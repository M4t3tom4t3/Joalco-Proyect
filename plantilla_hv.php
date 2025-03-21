<?php
function getPlantilla($serial){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "jp";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM equipos WHERE serial = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $serial);
    $stmt->execute();
    $result = $stmt->get_result();

    $sql = "SELECT cambio, DATE_FORMAT(fecha_cambio, '%d/%m/%Y') AS fecha_cambio FROM cambios WHERE fk_serial = ? LIMIT 10";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $serial);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $cambios = [];
    while ($fila = $resultado->fetch_assoc()) {
    $cambios[] = $fila;
    }

    for ($i = count($cambios); $i < 10; $i++) {
    $cambios[] = ['cambio' => '', 'fecha_cambio' => ''];
    }

    if ($result->num_rows > 0) {
        $equipo = $result->fetch_assoc();
    } else {
        return "<h3>No se encontraron datos para el serial: $serial</h3>";
    }
    $serial = $_GET['serial'];

    $sql_backups = "SELECT DATE_FORMAT(fecha_b, '%d/%m/%Y') AS  fecha_b, tecnico_b, disco FROM backups WHERE fk_serial = ? LIMIT 10";
    $stmt = $conn->prepare($sql_backups);
    $stmt->bind_param("s", $serial);
    $stmt->execute();
    $resultado_backups = $stmt->get_result();

    $backups = [];
    while ($fila = $resultado_backups->fetch_assoc()) {
    $backups[] = $fila;
    }

    for ($i = count($backups); $i < 10; $i++) {
    $backups[] = ['tecnico_b' => '', 'fecha_b' => '', 'disco' => ''];
    }

    $sql_asignacion = "SELECT
    u.nombre, u.departamento, u.cargo,
    DATE_FORMAT(e.fecha_asignacion, '%d/%m/%Y') AS fecha_asignacion, e.numero_consecutivo
    FROM asignacion e
    INNER JOIN usuarios u ON e.fk_id = u.id_usuario
    WHERE e.fk_serial = ?
    ORDER BY fecha_asignacion desc";
    $stmt = $conn->prepare($sql_asignacion);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $stmt->bind_param("s", $serial);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    
    $stmt->close();
    $conn->close();
    
$contenido='
<body>
    <table class="header-table">
        <tr>
            <td style="width: 25%; border: 1px solid black;">
                <div style="text-align: center;">
                    <img src="Joalco.png" alt="DALCO Logo" class="logo">
                </div>
            </td>
            <td style="width: 50%; border: 1px solid black; text-align: center; vertical-align: middle;">
                <h2>HOJA DE VIDA EQUIPOS DE COMPUTO</h2>
            </td>
            <td class="cell-custom10">
                <table>
                    <tr>
                        <th colspan="2" style="text-align: center; font-size: 10px;" >CODIGO<br>GTI-FOR-02-V_03<br>Fecha:30/08/2019</th>
                        
                    </tr>
                    <tr>
                        <th class="cell-custom3" style="background-color:rgb(194, 190, 190); text-align: center;">Hoja</th>
                        <td class="cell-custom3" style="text-align: center;">' . htmlspecialchars($equipo['hv']) . '</td>
                    </tr>
                    <tr>
                        <th style="background-color:rgb(194, 190, 190); text-align: center;">N° Activo Fija</th>
                        <td style="text-align: center;">' . htmlspecialchars($equipo['activo_fijo']) . '</td>
                    </tr>
                    <tr>
                        <th style="background-color:rgb(194, 190, 190); text-align: center;">Feacha de Compra</th>
                        <td style="text-align: center;">' . htmlspecialchars($equipo['fecha_compra']) . '</td>
                    </tr>
                </table>
            </td>
            
        </tr>
    </table>

    <table>
        <tr class="blue-header">
            <th colspan="6" class="blue-header">UBICACIÓN ACTUAL</th>
        </tr>
        <tr>
            <th class="cell-custom" style="background-color:rgb(194, 190, 190); text-align: center;">Usuario</th>
            <th class="cell-custom" style="background-color:rgb(194, 190, 190); text-align: center;">Área</th>
            <th class="cell-custom3" style="background-color:rgb(194, 190, 190); text-align: center;">Cargo</th>
            <th style="background-color:rgb(194, 190, 190); text-align: center;">Carta de Asignación</th>
            <th class="cell-custom2" style="background-color:rgb(194, 190, 190);">Fecha de Asignación</th>
            <th style="background-color:rgb(194, 190, 190);">Factura</th>
        </tr>
        <tr><td>' . htmlspecialchars($data[0]['nombre'] ?? '') . '</td><td>' . htmlspecialchars($data[0]['departamento'] ?? '') . '</td><td>' . htmlspecialchars($data[0]['cargo'] ?? '') . '</td><td>A-' . htmlspecialchars($data[0]['numero_consecutivo'] ?? '') . '</td><td>' . htmlspecialchars($data[0]['fecha_asignacion'] ?? '') . '</td><td>' . htmlspecialchars($equipo['num_factura'] ?? '') . '</td></tr>
        <tr><td>' . htmlspecialchars($data[1]['nombre'] ?? '') . '</td><td>' . htmlspecialchars($data[1]['departamento'] ?? '') . '</td><td>' . htmlspecialchars($data[1]['cargo'] ?? '') . '</td><td>A-' . htmlspecialchars($data[1]['numero_consecutivo'] ?? '') . '</td><td>' . htmlspecialchars($data[1]['fecha_asignacion'] ?? '') . '</td><td colspan="1" style="background-color:rgb(194, 190, 190); font-weight: bold;">Pedido</td></tr>
        <tr><td>' . htmlspecialchars($data[2]['nombre'] ?? '') . '</td><td>' . htmlspecialchars($data[2]['departamento'] ?? '') . '</td><td>' . htmlspecialchars($data[2]['cargo'] ?? '') . '</td><td>A-' . htmlspecialchars($data[2]['numero_consecutivo'] ?? '') . '</td><td>' . htmlspecialchars($data[2]['fecha_asignacion'] ?? '') . '</td><td>' . htmlspecialchars($equipo['num_pedido'] ?? '') . '</td></tr>
        <tr><td>' . htmlspecialchars($data[3]['nombre'] ?? '') . '</td><td>' . htmlspecialchars($data[3]['departamento'] ?? '') . '</td><td>' . htmlspecialchars($data[3]['cargo'] ?? '') . '</td><td>A-' . htmlspecialchars($data[3]['numero_consecutivo'] ?? '') . '</td><td>' . htmlspecialchars($data[3]['fecha_asignacion'] ?? '') . '</td><td colspan="1" style="background-color:rgb(194, 190, 190); font-weight: bold;">$ Costo</td></tr>
        <tr><td>' . htmlspecialchars($data[4]['nombre'] ?? '') . '</td><td>' . htmlspecialchars($data[4]['departamento'] ?? '') . '</td><td>' . htmlspecialchars($data[4]['cargo'] ?? '') . '</td><td>A-' . htmlspecialchars($data[4]['numero_consecutivo'] ?? '') . '</td><td>' . htmlspecialchars($data[4]['fecha_asignacion'] ?? '') . '</td><td>' . htmlspecialchars($equipo['costo'] ?? '') . '</td></tr>
    </table>

    <table>
        <tr>
            <th colspan="5" class="blue-header">CONFIGURACIÓN ACTUAL HARDWARE</th>
            <th colspan="6" class="blue-header">MANTENIMIENTOS REALIZADOS</th>
        </tr>
        <tr>
            <th class="cell-custom2" style="background-color:rgb(194, 190, 190);">Marca</th>
            <th class="cell-custom2" style="background-color:rgb(194, 190, 190);">Modelo</th>
            <td class="cell-custom6">' . htmlspecialchars($equipo['modelo']) . '</td>
            <th style="background-color:rgb(194, 190, 190);">Tipo</th>
            <td class="cell-custom6">' . htmlspecialchars($equipo['nombre_equipo']) . '</td>
            <th class="cell-custom7" style="background-color:rgb(194, 190, 190);">Tipo</th>
            <th class="cell-custom4" style="background-color:rgb(194, 190, 190);">Fecha</th>
            <th class="cell-custom5" style="background-color:rgb(194, 190, 190); text-align: center;">Realizo</th>
            <th colspan="3" style="background-color:rgb(194, 190, 190);">Costo $</th>
        </tr>
        <tr>
            <td>#N/D</td>
            <td style="background-color:rgb(194, 190, 190); font-weight: bold;">Pantalla</td>
            <td colspan="3">#N/D</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td>' . htmlspecialchars($equipo['marca']) . '</td>
            <td style="background-color:rgb(194, 190, 190); font-weight: bold;">Serial CPU</td>
            <td colspan="3">'.$serial.'</td>
            <td ></td>
            <td></td>
            <td></td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td>#N/D</td>
            <td style="background-color:rgb(194, 190, 190); font-weight: bold;">Serial Mouse</td>
            <td colspan="3">#N/D</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td style="background-color:rgb(194, 190, 190); font-weight: bold;">Disco Duro</td>
            <td>' . htmlspecialchars($equipo['disco']) . '</td>
            <td style="background-color:rgb(194, 190, 190); font-weight: bold;">Memoria RAM</td>
            <td colspan="2">' . htmlspecialchars($equipo['ram']) . ' RAM</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td colspan="2" style="background-color:rgb(194, 190, 190); font-weight: bold;">Procesador</td>
            <td colspan="3">' . htmlspecialchars($equipo['procesador']) . '</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td colspan="2" style="background-color:rgb(194, 190, 190); font-weight: bold;">Sistema Operativo</td>
            <td colspan="3">' . htmlspecialchars($equipo['sistema_operativo']) . '</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td colspan="2" style="background-color:rgb(194, 190, 190); font-weight: bold;">Licencia Windows</td>
            <td colspan="3">' . htmlspecialchars($equipo['licencia_w']) . '</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td colspan="2" style="background-color:rgb(194, 190, 190); font-weight: bold;">Tipo de Licencia Windows</td>
            <td colspan="3">#N/D</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td colspan="2" style="background-color:rgb(194, 190, 190); font-weight: bold;">Paquete Office</td>
            <td colspan="3">' . htmlspecialchars($equipo['paquete_of']) . '</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td colspan="2" style="background-color:rgb(194, 190, 190); font-weight: bold;">Licencia Office</td>
            <td colspan="3">#N/D</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td colspan="2" style="background-color:rgb(194, 190, 190); font-weight: bold;">Tipo de Licencia Office</td>
            <td colspan="3">#N/D</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="3"></td>
        </tr>
    </table>

    <table>
        <tr>
            <th colspan="5" class="blue-header">CONFIGURACIÓN DE LA RED</th>
        </tr>
        <tr>
            <th style="background-color:rgb(194, 190, 190);"></th>
            <th style="background-color:rgb(194, 190, 190);">MAC</th>
            <th style="background-color:rgb(194, 190, 190);">Dirección IP</th>
            <th colspan="2" style="background-color:rgb(194, 190, 190);"></th>
        </tr>
        <tr>
            <td style="background-color:rgb(194, 190, 190); font-weight: bold;">Ethernet</td>
            <td>' . htmlspecialchars($equipo['mac_lan']) . '</td>
            <td>' . htmlspecialchars($equipo['ip_lan']) . '</td>
            <td style="background-color:rgb(194, 190, 190); font-weight: bold;">Host Name</td>
            <td>' . htmlspecialchars($equipo['host_name']) . '</td>
        </tr>
        <tr>
            <td style="background-color:rgb(194, 190, 190); font-weight: bold;">Wireless</td>
            <td>' . htmlspecialchars($equipo['mac_wlan']) . '</td>
            <td>' . htmlspecialchars($equipo['ip_wlan']) . '</td>
            <td  class="cell-custom7" style="background-color:rgb(194, 190, 190); font-weight: bold;">Usu Dominio</td>
            <td>' . htmlspecialchars($equipo['usuario_dominio']) . '</td>
        </tr>
    </table>

    <table>
        <tr>
            <th colspan="3" class="blue-header">CONTROL DE BACKUPS</th>
            <th colspan="4" class="blue-header">CONTROL DE CAMBIOS</th>
        </tr>
        <tr>
            <th class="cell-custom2" style="background-color:rgb(194, 190, 190);">Fecha</th>
            <th class="cell-custom" style="background-color:rgb(194, 190, 190); text-align: center;">Usuario</th>
            <th class="cell-custom" style="background-color:rgb(194, 190, 190); text-align: center;">Storage</th>
            <th class="cell-custom" style="background-color:rgb(194, 190, 190); text-align: center;">Descripción del elemento</th>
            <th style="background-color:rgb(194, 190, 190);">Costo</th>
            <th colspan="2" style="background-color:rgb(194, 190, 190);">Fecha</th>
        </tr>
        <tr> <td>' . htmlspecialchars($backups[0]['fecha_b']) . '</td> <td>' . htmlspecialchars($backups[0]['tecnico_b']) . '</td> <td>' . htmlspecialchars($backups[0]['disco']) . '</td> <td>' . htmlspecialchars($cambios[0]['cambio']) . '</td> <td></td> <td colspan="2">'. htmlspecialchars($cambios[0]['fecha_cambio']) . '</td> </tr>
        <tr> <td>' . htmlspecialchars($backups[1]['fecha_b']) . '</td> <td>' . htmlspecialchars($backups[1]['tecnico_b']) . '</td> <td>' . htmlspecialchars($backups[1]['disco']) . '</td> <td>' . htmlspecialchars($cambios[1]['cambio']) . '</td> <td></td> <td colspan="2">'. htmlspecialchars($cambios[1]['fecha_cambio']) . '</td> </tr>
        <tr> <td>' . htmlspecialchars($backups[2]['fecha_b']) . '</td> <td>' . htmlspecialchars($backups[2]['tecnico_b']) . '</td> <td>' . htmlspecialchars($backups[2]['disco']) . '</td> <td>' . htmlspecialchars($cambios[2]['cambio']) . '</td> <td></td> <td colspan="2">'. htmlspecialchars($cambios[2]['fecha_cambio']) . '</td> </tr>
        <tr> <td>' . htmlspecialchars($backups[3]['fecha_b']) . '</td> <td>' . htmlspecialchars($backups[3]['tecnico_b']) . '</td> <td>' . htmlspecialchars($backups[3]['disco']) . '</td> <td>' . htmlspecialchars($cambios[3]['cambio']) . '</td> <td></td> <td colspan="2">'. htmlspecialchars($cambios[3]['fecha_cambio']) . '</td> </tr>
        <tr> <td>' . htmlspecialchars($backups[4]['fecha_b']) . '</td> <td>' . htmlspecialchars($backups[4]['tecnico_b']) . '</td> <td>' . htmlspecialchars($backups[4]['disco']) . '</td> <td>' . htmlspecialchars($cambios[4]['cambio']) . '</td> <td></td> <td colspan="2">'. htmlspecialchars($cambios[4]['fecha_cambio']) . '</td> </tr>
        <tr> <td>' . htmlspecialchars($backups[5]['fecha_b']) . '</td> <td>' . htmlspecialchars($backups[5]['tecnico_b']) . '</td> <td>' . htmlspecialchars($backups[5]['disco']) . '</td> <td>' . htmlspecialchars($cambios[5]['cambio']) . '</td> <td></td> <td colspan="2">'. htmlspecialchars($cambios[5]['fecha_cambio']) . '</td> </tr>
        <tr> <td>' . htmlspecialchars($backups[6]['fecha_b']) . '</td> <td>' . htmlspecialchars($backups[6]['tecnico_b']) . '</td> <td>' . htmlspecialchars($backups[6]['disco']) . '</td> <td>' . htmlspecialchars($cambios[6]['cambio']) . '</td> <td></td> <td colspan="2">'. htmlspecialchars($cambios[6]['fecha_cambio']) . '</td> </tr>
        <tr> <td>' . htmlspecialchars($backups[7]['fecha_b']) . '</td> <td>' . htmlspecialchars($backups[7]['tecnico_b']) . '</td> <td>' . htmlspecialchars($backups[7]['disco']) . '</td> <td>' . htmlspecialchars($cambios[7]['cambio']) . '</td> <td></td> <td colspan="2">'. htmlspecialchars($cambios[7]['fecha_cambio']) . '</td> </tr>
        <tr> <td>' . htmlspecialchars($backups[8]['fecha_b']) . '</td> <td>' . htmlspecialchars($backups[8]['tecnico_b']) . '</td> <td>' . htmlspecialchars($backups[8]['disco']) . '</td> <td>' . htmlspecialchars($cambios[8]['cambio']) . '</td> <td></td> <td colspan="2">'. htmlspecialchars($cambios[8]['fecha_cambio']) . '</td> </tr>
        <tr> <td>' . htmlspecialchars($backups[9]['fecha_b']) . '</td> <td>' . htmlspecialchars($backups[9]['tecnico_b']) . '</td> <td>' . htmlspecialchars($backups[9]['disco']) . '</td> <td>' . htmlspecialchars($cambios[9]['cambio']) . '</td> <td></td> <td colspan="2">'. htmlspecialchars($cambios[9]['fecha_cambio']) . '</td> </tr>
    </table>
</body>';

return $contenido;
}
?>