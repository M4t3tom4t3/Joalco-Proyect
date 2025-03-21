<?php 
function getPlantilla($numero_consecutivo){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "jp";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "SELECT u.nombre, u.apellido, u.cargo, u.departamento, u.ciudad, a.numero_consecutivo, 
    DATE_FORMAT(a.fecha_asignacion, '%d/%m/%Y') AS fecha_asignacion 
    FROM usuarios u
    JOIN asignacion a ON a.FK_id = u.ID_usuario
    WHERE a.numero_consecutivo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $numero_consecutivo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
    } else {
        return "<p>No se encontró el usuario.</p>";
    }

    $query_activos = "SELECT e.serial, e.nombre_equipo, e.marca, e.modelo, e.PLACA, e.sistema_operativo, 
                               e.procesador, e.ram, e.disco, e.ip_wlan, e.usuario_dominio, 
                               a.numero_consecutivo 
                       FROM equipos e
                       JOIN asignacion a ON a.FK_serial = e.serial
                       WHERE a.numero_consecutivo = ?";
    $stmt = $conn->prepare($query_activos);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $stmt->bind_param("i", $numero_consecutivo);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $stmt->execute();
$result = $stmt->get_result();

$PC = $Portatil = [
    "fecha_asignacion" => "N/A",
    "disco" => "N/A",
    "ram" => "N/A",
    "sistema_operativo" => "N/A",
    "procesador" => "N/A",
    "ip_wlan" => "N/A",
    "usuario_dominio" => "N/A",
    "numero_consecutivo" => "N/A" 
];

while ($row = $result->fetch_assoc()) {
    if ($row["nombre_equipo"] === "PC") {
        $PC = [
            "fecha_asignacion" => htmlspecialchars($row["fecha_asignacion"]),
            "disco" => htmlspecialchars($row["disco"]),
            "ram" => htmlspecialchars($row["ram"]),
            "sistema_operativo" => htmlspecialchars($row["sistema_operativo"]),
            "procesador" => htmlspecialchars($row["procesador"]),
            "ip_wlan" => htmlspecialchars($row["ip_wlan"]),
            "usuario_dominio" => htmlspecialchars($row["usuario_dominio"]),
            "numero_consecutivo" => htmlspecialchars($row["numero_consecutivo"])
        ];
    } elseif ($row["nombre_equipo"] === "PORTATIL") {
        $Portatil = [
            "fecha_asignacion" => htmlspecialchars($row["fecha_asignacion"]),
            "disco" => htmlspecialchars($row["disco"]),
            "ram" => htmlspecialchars($row["ram"]),
            "sistema_operativo" => htmlspecialchars($row["sistema_operativo"]),
            "procesador" => htmlspecialchars($row["procesador"]),
            "ip_wlan" => htmlspecialchars($row["ip_wlan"]),
            "usuario_dominio" => htmlspecialchars($row["usuario_dominio"]),
            "numero_consecutivo" => htmlspecialchars($row["numero_consecutivo"])
        ];
    }
}

$query_fecha_actual = "SELECT fecha_asignacion, FK_id FROM asignacion WHERE numero_consecutivo = ?";
$stmt_fecha = $conn->prepare($query_fecha_actual);
$stmt_fecha->bind_param("i", $numero_consecutivo);
$stmt_fecha->execute();
$result_fecha = $stmt_fecha->get_result();

if ($row = $result_fecha->fetch_assoc()) {
    $fecha_asignacion_actual = $row['fecha_asignacion'];
    $id_usuario = $row['FK_id'];
} else {
    die("Error: No se encontró la carta de asignación.");
}

$query_previos = "SELECT e.serial, e.nombre_equipo, e.marca, e.modelo, e.PLACA, 
                         e.sistema_operativo, e.procesador, e.ram, e.disco, e.ip_lan, 
                         e.usuario_dominio, a.numero_consecutivo, a.estado_asig, a.fecha_asignacion
                  FROM equipos e
                  JOIN asignacion a ON a.FK_serial = e.serial 
                  WHERE a.FK_id = ? 
                  AND a.fecha_asignacion < ?  
                  ORDER BY a.fecha_asignacion DESC";

$stmt_previos = $conn->prepare($query_previos);
$stmt_previos->bind_param("is", $id_usuario, $fecha_asignacion_actual);
$stmt_previos->execute();
$result_previos = $stmt_previos->get_result();
    
    $data2 = [];
    while ($row = $result_previos ->fetch_assoc()) {
        $data2[] = $row;
    }



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
                <h2>ASIGNACIÓN Y/O REPOSICIÓN DE EQUIPOS</h2>
            </td>
            <td class="cell-custom10">
                <table>
                    
                    <tr>
                        <th class="cell-custom11" style="font-weight: bold; text-align: center;" >GTI-FOR-03</th>
                    </tr>
                    <tr>
                        <th style="font-weight: bold; text-align: center;">Version: 5</th>
                    </tr>
                    <tr>
                        <th style="font-weight: bold; text-align: center;">Fecha:31/03/2022</th>
                    </tr>
                    <tr>
                        <th style="font-weight: bold; text-align: center;">Pagina 1 de 1</th>
                    </tr>
                </table>
            </td>
            
        </tr>
    </table>

    <table>
        <tr class="white-header">
            <th colspan="10" class="white-header"></th>
        </tr>
        <tr class="blue-header">
            <th colspan="8" class="blue-header">NOMBRE DEL USUARIO</th>
            <th colspan="2" class="blue-header">N°.CONSECUTIVO</th>
        </tr>
        <tr>
            <td colspan="8" class="cell-custom1" style="text-align: center;">' . htmlspecialchars($usuario['nombre']) . ' ' . htmlspecialchars($usuario['apellido']) . '</td>
            <td colspan="2" style="text-align: center;">A-' . htmlspecialchars($usuario['numero_consecutivo']) . '</td>
        </tr>
        <tr class="blue-header">
            <th colspan="7" class="blue-header">CIUDAD</th>
            <th colspan="3" class="blue-header">AREA</th>
        </tr>
        <tr>
            <td colspan="7" class="cell-custom1" style="text-align: center;">' . htmlspecialchars($usuario['ciudad']) . '</td>
            <td colspan="3" style="text-align: center;">' . htmlspecialchars($usuario['departamento']) . '</td>
        </tr>
        <tr class="white-header">
            <th colspan="10" class="white-header"></th>
        </tr>
        <tr class="blue-header">
            <th colspan="5" class="blue-header">CARGO</th>
            <th colspan="3" class="blue-header">FECHA DE LA SOLICITUD</th>
            <th colspan="2" class="blue-header">FECHA DE ENTREGA</th>
        </tr>
        <tr>
            <td colspan="5" class="cell-custom1" style="text-align: center;">' . htmlspecialchars($usuario['cargo']) . '</td>
            <td colspan="3" style="text-align: center;" >' . htmlspecialchars($usuario['fecha_asignacion']) . '</td>
            <td colspan="2" style="text-align: center;">' . htmlspecialchars($usuario['fecha_asignacion']) . '</td>
        </tr>
        <tr class="white-header">
            <th colspan="10" class="white-header"></th>
        </tr>
    </table>
    
    <table>
        <tr class="blue-header">
            <th colspan="11" class="blue-header">DESCRIPCION DEL NUEVO ELEMENTO</th>
        </tr>
        <tr class="blue-header">
            <th colspan="2" class="blue-header">ELEMENTO</th>
            <th colspan="1" class="blue-header">MARCA</th>
            <th colspan="4" class="blue-header">MODELO</th>
            <th colspan="2" class="blue-header">SERIAL</th>
            <th colspan="2" class="blue-header">COD.CONTROL</th>
        </tr>
        <tr >
            <th colspan="2" >' . htmlspecialchars($data[0]['nombre_equipo'] ?? '') . '</th>
            <th colspan="1" >' . htmlspecialchars($data[0]['marca'] ?? '') . '</th>
            <th colspan="4" >' . htmlspecialchars($data[0]['modelo'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data[0]['serial'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data[0]['PLACA'] ?? '') . '</th>
        </tr>
        <tr >
            <th colspan="2" >' . htmlspecialchars($data[1]['nombre_equipo'] ?? '') . '</th>
            <th colspan="1" >' . htmlspecialchars($data[1]['marca'] ?? '') . '</th>
            <th colspan="4" >' . htmlspecialchars($data[1]['modelo'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data[1]['serial'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data[1]['PLACA'] ?? '') . '</th>
        </tr>
        <tr >
            <th colspan="2" >' . htmlspecialchars($data[2]['nombre_equipo'] ?? '') . '</th>
            <th colspan="1" >' . htmlspecialchars($data[2]['marca'] ?? '') . '</th>
            <th colspan="4" >' . htmlspecialchars($data[2]['modelo'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data[2]['serial'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data[2]['PLACA'] ?? '') . '</th>
        </tr>
        <tr >
            <th colspan="2" >' . htmlspecialchars($data[3]['nombre_equipo'] ?? '') . '</th>
            <th colspan="1" >' . htmlspecialchars($data[3]['marca'] ?? '') . '</th>
            <th colspan="4" >' . htmlspecialchars($data[3]['modelo'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data[3]['serial'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data[3]['PLACA'] ?? '') . '</th>
        </tr>
        <tr >
            <th colspan="2" >' . htmlspecialchars($data[4]['nombre_equipo'] ?? '') . '</th>
            <th colspan="1" >' . htmlspecialchars($data[4]['marca'] ?? '') . '</th>
            <th colspan="4" >' . htmlspecialchars($data[4]['modelo'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data[4]['serial'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data[4]['PLACA'] ?? '') . '</th>
        </tr>
        <tr >
            <th colspan="2" >' . htmlspecialchars($data[5]['nombre_equipo'] ?? '') . '</th>
            <th colspan="1" >' . htmlspecialchars($data[5]['marca'] ?? '') . '</th>
            <th colspan="4" >' . htmlspecialchars($data[5]['modelo'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data[5]['serial'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data[5]['PLACA'] ?? '') . '</th>
        </tr>
        <tr >
            <th colspan="2" >' . htmlspecialchars($data[6]['nombre_equipo'] ?? '') . '</th>
            <th colspan="1" >' . htmlspecialchars($data[6]['marca'] ?? '') . '</th>
            <th colspan="4" >' . htmlspecialchars($data[6]['modelo'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data[6]['serial'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data[6]['PLACA'] ?? '') . '</th>
        </tr>
        <tr >
            <th colspan="2" >' . htmlspecialchars($data[7]['nombre_equipo'] ?? '') . '</th>
            <th colspan="1" >' . htmlspecialchars($data[7]['marca'] ?? '') . '</th>
            <th colspan="4" >' . htmlspecialchars($data[7]['modelo'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data[7]['serial'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data[7]['PLACA'] ?? '') . '</th>
        </tr>
        <tr >
            <th colspan="2" >' . htmlspecialchars($data[8]['modeloe_equipo'] ?? '') . '</th>
            <th colspan="1" >' . htmlspecialchars($data[8]['marca'] ?? '') . '</th>
            <th colspan="4" >' . htmlspecialchars($data[8]['modelo'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data[8]['serial'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data[8]['PLACA'] ?? '') . '</th>
        </tr>
        <tr >
            <th colspan="2" >' . htmlspecialchars($data[9]['nombre_equipo'] ?? '') . '</th>
            <th colspan="1" >' . htmlspecialchars($data[9]['marca'] ?? '') . '</th>
            <th colspan="4" >' . htmlspecialchars($data[9]['modelo'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data[9]['serial'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data[9]['PLACA'] ?? '') . '</th>
        </tr>
    </table>

    <table>
        <tr >
            <th colspan="1" class="cell-custom2" style="font-weight: bold; text-align: center;" >DISCO:</th>
            <th colspan="2" >' . ($PC["disco"] !== "N/A" ? $PC["disco"] : $Portatil["disco"]) . '</th>
            <th colspan="1" style="font-weight: bold; text-align: center;" >Sistema Operativo:</th>
            <th colspan="2" >' . ($PC["sistema_operativo"] !== "N/A" ? $PC["sistema_operativo"] : $Portatil["sistema_operativo"]) . '</th>
        </tr>
        <tr >
            <th colspan="1" style="font-weight: bold; text-align: center;" >MEMORIA:</th>
            <th colspan="2" >' . ($PC["ram"] !== "N/A" ? $PC["ram"] : $Portatil["ram"]) . ' RAM</th>
            <th colspan="1" style="font-weight: bold; text-align: center;" >IP:</th>
            <th colspan="2" >' . ($PC["ip_wlan"] !== "N/A" ? $PC["ip_wlan"] : $Portatil["ip_wlan"]) . '</th>
        </tr>
        <tr >
            <th colspan="1" style="font-weight: bold; text-align: center;" >PROCESADOR:</th>
            <th colspan="2" >' . ($PC["procesador"] !== "N/A" ? $PC["procesador"] : $Portatil["procesador"]) . '</th>
            <th colspan="1" style="font-weight: bold; text-align: center;" >USUARIO DOMINIO:</th>
            <th colspan="2" >' . ($PC["usuario_dominio"] !== "N/A" ? $PC["usuario_dominio"] : $Portatil["usuario_dominio"]) . '</th>
        </tr>
    </table>
    <table>
        <tr class="blue-header">
            <th colspan="11" class="blue-header">DESCRIPCION DEL ANTERIOR ELEMENTO</th>
        </tr>
        <tr class="blue-header">
            <th colspan="2" class="blue-header">ELEMENTO</th>
            <th colspan="1" class="blue-header">MARCA</th>
            <th colspan="4" class="blue-header">MODELO</th>
            <th colspan="2" class="blue-header">SERIAL</th>
            <th colspan="2" class="blue-header">COD.CONTROL</th>
        </tr>
        <tr >
            <th colspan="2" >' . htmlspecialchars($data2[0]['nombre_equipo'] ?? '') . '</th>
            <th colspan="1" >' . htmlspecialchars($data2[0]['marca'] ?? '') . '</th>
            <th colspan="4" >' . htmlspecialchars($data2[0]['modelo'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data2[0]['serial'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data2[0]['PLACA'] ?? '') . '</th>
        </tr>
        <tr >
            <th colspan="2" >' . htmlspecialchars($data2[1]['nombre_equipo'] ?? '') . '</th>
            <th colspan="1" >' . htmlspecialchars($data2[1]['marca'] ?? '') . '</th>
            <th colspan="4" >' . htmlspecialchars($data2[1]['modelo'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data2[1]['serial'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data2[1]['PLACA'] ?? '') . '</th>
        </tr>
        <tr >
            <th colspan="2" >' . htmlspecialchars($data2[2]['nombre_equipo'] ?? '') . '</th>
            <th colspan="1" >' . htmlspecialchars($data2[2]['marca'] ?? '') . '</th>
            <th colspan="4" >' . htmlspecialchars($data2[2]['modelo'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data2[2]['serial'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data2[2]['PLACA'] ?? '') . '</th>
        </tr>
        <tr >
            <th colspan="2" >' . htmlspecialchars($data2[3]['nombre_equipo'] ?? '') . '</th>
            <th colspan="1" >' . htmlspecialchars($data2[3]['marca'] ?? '') . '</th>
            <th colspan="4" >' . htmlspecialchars($data2[3]['modelo'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data2[3]['serial'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data2[3]['PLACA'] ?? '') . '</th>
        </tr>
        <tr >
            <th colspan="2" >' . htmlspecialchars($data2[4]['nombre_equipo'] ?? '') . '</th>
            <th colspan="1" >' . htmlspecialchars($data2[4]['marca'] ?? '') . '</th>
            <th colspan="4" >' . htmlspecialchars($data2[4]['modelo'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data2[4]['serial'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data2[4]['PLACA'] ?? '') . '</th>
        </tr>
        <tr >
            <th colspan="2" >' . htmlspecialchars($data2[5]['nombre_equipo'] ?? '') . '</th>
            <th colspan="1" >' . htmlspecialchars($data2[5]['marca'] ?? '') . '</th>
            <th colspan="4" >' . htmlspecialchars($data2[5]['modelo'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data2[5]['serial'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data2[5]['PLACA'] ?? '') . '</th>
        </tr>
        <tr >
            <th colspan="2" >' . htmlspecialchars($data2[6]['nombre_equipo'] ?? '') . '</th>
            <th colspan="1" >' . htmlspecialchars($data2[6]['marca'] ?? '') . '</th>
            <th colspan="4" >' . htmlspecialchars($data2[6]['modelo'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data2[6]['serial'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data2[6]['PLACA'] ?? '') . '</th>
        </tr>
        <tr >
            <th colspan="2" >' . htmlspecialchars($data2[7]['nombre_equipo'] ?? '') . '</th>
            <th colspan="1" >' . htmlspecialchars($data2[7]['marca'] ?? '') . '</th>
            <th colspan="4" >' . htmlspecialchars($data2[7]['modelo'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data2[7]['serial'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data2[7]['PLACA'] ?? '') . '</th>
        </tr>
        <tr >
            <th colspan="2" >' . htmlspecialchars($data2[8]['nombre_equipo'] ?? '') . '</th>
            <th colspan="1" >' . htmlspecialchars($data2[8]['marca'] ?? '') . '</th>
            <th colspan="4" >' . htmlspecialchars($data2[8]['modelo'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data2[8]['serial'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data2[8]['PLACA'] ?? '') . '</th>
        </tr>
        <tr >
            <th colspan="2" >' . htmlspecialchars($data2[9]['nombre_equipo'] ?? '') . '</th>
            <th colspan="1" >' . htmlspecialchars($data2[9]['marca'] ?? '') . '</th>
            <th colspan="4" >' . htmlspecialchars($data2[9]['modelo'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data2[9]['serial'] ?? '') . '</th>
            <th colspan="2" >' . htmlspecialchars($data2[9]['PLACA'] ?? '') . ' </tr>
    </table>
    <table>
        <tr class="blue-header">modelo<th colspan="11" class="blue-header">USUARIO</th>
        </tr>
        <tr>
            <th class="blue-header">SAP</th>
            <th class="cell-custom13">DEJ</th>
            <th class="cell-custom13">PRD</th>
            <th colspan="2"></th>
            <th colspan="2"></th>
            <th class="cell-custom12" colspan="3">OFFFICE</th>
            <th >0</th>
        </tr>
        <tr>
            <th class="blue-header">CORREO</th>
            <th colspan="6" class="cell-custom13" style="text-align: center;">0</th>
            <th class="cell-custom12" colspan="3">OPEN OFFFICE</th>
            <th >X</th>
        </tr>
        <tr>
            <th class="blue-header">OTROS</th>
            <th colspan="10" class="cell-custom13" style="text-align: center;"></th>
        </tr>
        <tr>
            <th colspan="11" class="blue-header">SOPORTE DE ENTREGA</th>
        </tr>
        <tr class="white-header">
            <th colspan="11" class="white-header" style="text-align: center; font-weight: bold; font-size: 10px;" >Esperamos que aproveche la utilidad de este equipo y le brinde el manejo apropiado, el cual es para uso exclusivo de la empresa; el 
                                                                                                                    uso y cuidado del equipo es de su responsabilidad y cualquier daño ocasionado por el mal uso e incluso su pérdida es por cuenta 
                                                                                                                    suya. </th>
        </tr>
    </table> 
    <table>   
        <tr>
            <td style="border-bottom: none; border-right: none; font-weight: bold;">Entregado por:</td>
            <td style="border-left: none; border-right: none; border-bottom: none;" class="cell-custom14"></td>
            <td style="border-left: none; border-right: none; border-bottom: none; font-weight: bold;">Recibido por:</td>
            <td style="border-left: none; border-right: none; border-bottom: none;" class="cell-custom14"></td>
            <td style="border-left: none; border-right: none;border-bottom: none; font-weight: bold;" >Autorizado por:</td>
            <td style="border-left: none; border-bottom: none;" class="cell-custom14"></td>
        </tr>
        <tr>
            <td style="border-right: none; border-bottom: none; border-top: none;" ></td>
            <td style="border-left: none; border-right: none; border-bottom: none; border-top: none;" ></td>
            <td style="border-left: none; border-right: none; border-bottom: none; border-top: none;" ></td>
            <td style="border-left: none; border-right: none; border-bottom: none; border-top: none;" ></td>
            <td style="border-left: none; border-right: none; border-bottom: none; border-top: none;" ></td>
            <td style="border-left: none; border-bottom: none; border-top: none;" ></td>
        </tr>
        <tr>
            <td style="border-right: none; border-bottom: none; border-top: none; text-align: right; font-weight: bold;" >Firma:</td>
            <td style="border-left: none; border-right: none; border-top: none; " ></td>
            <td style="border-left: none; border-right: none; border-bottom: none; border-top: none; text-align: right; font-weight: bold;" >Firma:</td>
            <td style="border-left: none; border-right: none; border-top: none;" ></td>
            <td style="border-left: none; border-right: none;border-bottom: none; border-top: none; text-align: right; font-weight: bold;" >Firma:</td>
            <td style="border-left: none; border-top: none;"></td>
        </tr>
        <tr>
            <td style="border-right: none; border-bottom: none; border-top: none; text-align: right; font-weight: bold;" >Nombre:</td>
            <td style="border-left: none; border-right: none; border-bottom: none; border-top: none; font-weight: bold; text-align: center;" >MIGUEL INFANTE</td>
            <td style="border-left: none; border-right: none; border-bottom: none; border-top: none; text-align: right; font-weight: bold;" >Nombre:</td>
            <td style="border-left: none; border-right: none; border-top: none;" ></td>
            <td style="border-left: none; border-right: none; border-bottom: none; border-top: none; text-align: right; font-weight: bold;" >Nombre:</td>
            <td style="border-left: none; border-bottom: none; border-top: none; font-weight: bold; text-align: center;" >NIDIA PAEZ</td>
        </tr>
        <tr>
            <td style="border-right: none; border-bottom: none; border-top: none; text-align: right; font-weight: bold;" >C.C:</td>
            <td style="border-left: none; border-right: none; border-bottom: none; border-top: none; font-weight: bold; text-align: center;" >1024557337</td>
            <td style="border-left: none; border-right: none; border-bottom: none; border-top: none; text-align: right; font-weight: bold;" >C.C:</td>
            <td style="border-left: none; border-right: none; border-top: none;" ></td>
            <td style="border-left: none; border-right: none; border-bottom: none; border-top: none; text-align: right; font-weight: bold;" >C.C:</td>
            <td style="border-left: none; border-bottom: none; border-top: none; font-weight: bold; text-align: center;" >52447402</td>
        </tr>
        <tr>
            <td style="border-right: none; border-top: none;" ></td>
            <td style="border-left: none; border-right: none; border-top: none;" ></td>
            <td style="border-left: none; border-right: none; border-top: none;" ></td>
            <td style="border-left: none; border-right: none; border-top: none;" ></td>
            <td style="border-left: none; border-right: none; border-top: none;" ></td>
            <td style="border-left: none; border-top: none;" ></td>
        </tr>
    </table>
    
</body>';

return $contenido;
}
?>