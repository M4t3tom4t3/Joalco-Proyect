<?php
function getPlantilla($id){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "jp";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "SELECT nombre, apellido, cargo, departamento, ciudad FROM usuarios WHERE ID_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
    } else {
        return "<p>No se encontró el usuario.</p>";
    }

    $sql_equipo = "SELECT e.serial, e.nombre_equipo, e.marca, e.modelo
    FROM equipos e
    JOIN asignacion a ON e.serial = a.FK_serial
    WHERE a.FK_id = ? AND a.estado_asig = 'ACTIVO'";

    $stmt = $conn->prepare($sql_equipo);
    if (!$stmt) {
    die("Error en la consulta de equipos: " . $conn->error);
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado_equipos = $stmt->get_result();

    $PC = $Monitor = $Teclado = $Mouse = $Portatil = $Otros = ["marca" => "", "modelo" => "", "serial" => ""];

    while ($equipo = $resultado_equipos->fetch_assoc()) {
    $datos = [
    "marca"  => htmlspecialchars($equipo["marca"]),
    "modelo" => htmlspecialchars($equipo["modelo"]),
    "serial" => htmlspecialchars($equipo["serial"]),
    "hv"     => ($equipo["nombre_equipo"] == "PC" || $equipo["nombre_equipo"] == "PORTATIL") 
                    ? htmlspecialchars($equipo["hv"]) 
                    : "N/A"
    ];

    switch ($equipo["nombre_equipo"]) {
    case "PC":
        $PC = $datos;
    break;
    case "MONITOR":
        $Monitor = $datos;
    break;
    case "TECLADO":
        $Teclado = $datos;
    break;
    case "MOUSE":
        $Mouse = $datos;
    break;
    case "PORTATIL":
        $Portatil = $datos;
    break;
    default:
        $Otros = $datos;
    break;
    }
    }

    $sql_mantenimiento = "SELECT 
    m.fk_numero_consecutivo, 
    DATE_FORMAT(m.fecha_inicio, '%Y-%m-%d') AS fecha_inicio,
    DATE_FORMAT(m.fecha_inicio, '%H:%i:%s') AS hora_inicio,
    DATE_FORMAT(m.fecha_fin, '%Y-%m-%d') AS fecha_fin,
    DATE_FORMAT(m.fecha_fin, '%H:%i:%s') AS hora_fin,
    m.observaciones, 
    m.tecnico, 
    m.ciudad, 
    m.tipo
    FROM mantenimiento m
    JOIN asignacion a ON m.fk_numero_consecutivo = a.numero_consecutivo
    WHERE a.FK_id = ?";
        $stmt = $conn->prepare($sql_mantenimiento);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado_mantenimiento = $stmt->get_result();
    
        if ($resultado_mantenimiento->num_rows > 0) {
            $mantenimiento = $resultado_mantenimiento->fetch_assoc();
        } else {
            $mantenimiento = [
                "fk_numero_consecutivo" => "N/A",
                "fecha_inicio" => "N/A",
                "fecha_fin" => "N/A",
                "observaciones" => "N/A",
                "tecnico" => "N/A",
                "ciudad" => "N/A",
                "tipo" => "N/A"
            ];
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
                <h2>Mantenimiento Preventivo</h2>
            </td>
            <td class="cell-custom10">
                <table>
                    
                    <tr>
                        <th class="cell-custom11" style="font-weight: bold; text-align: center;" >GTI-FOR-07</th>
                    </tr>
                    <tr>
                        <th style="font-weight: bold; text-align: center;">Version: 2</th>
                    </tr>
                    <tr>
                        <th style="font-weight: bold; text-align: center;">Fecha:17/08/2021</th>
                    </tr>
                    <tr>
                        <th style="font-weight: bold; text-align: center;">Pagina 1 de 1</th>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="white-header">
            <th colspan="3" class="white-header" style="border-bottom: none; text-align: center; font-weight: bold;">Datos de Usuario del Equipo</th>
        </tr>
    </table>
    <table>
        <tr>
            <th colspan="5" style="border-top: none; border-right: none; border-bottom: none;"></th>
            <td class="cell-custom6" style="border-left: none; border-right: none; border-top: none; text-align: center; font-weight: bold;">Fecha</td>
            <td style="border-left: none; border-top: none;  text-align: center; font-weight: bold;">Hora</td> 
        </tr>
        <tr>
            <th style="border-top: none; border-bottom: none">Nombre</th>
            <td colspan="2" class="cell-custom9" style="text-align: center;">' . htmlspecialchars($usuario['nombre']) . ' ' . htmlspecialchars($usuario['apellido']) . '</td>
            <td style="border-right: none; border-top: none; border-bottom: none;"></td>
            <td style="border-left: none; border-top: none; border-bottom: none; text-align: right; font-weight: bold;">Inicio</td>
            <td>'. htmlspecialchars($mantenimiento['fecha_inicio']) .'</td>
            <td>'. htmlspecialchars($mantenimiento['hora_inicio']) .'</td> 
        </tr>
        <tr>
            <th style="border-top: none; border-bottom: none;">Area</th>
            <td colspan="2" class="cell-custom9" style="text-align: center;">' . htmlspecialchars($usuario['departamento']) . '</td>
            <td style="border-top: none; border-bottom: none; border-right: none;"></td>
            <td style="border-left: none; border-top: none; border-bottom: none; text-align: right; font-weight: bold;">Fin</td>
            <td>'. htmlspecialchars($mantenimiento['fecha_fin']) .'</td>
            <td>'. htmlspecialchars($mantenimiento['hora_fin']) .'</td> 
        </tr>
        <tr>
            <th style="border-top: none; border-bottom: none;">HV Equipo</th>
            <td colspan="2" class="cell-custom9" style="background-color:rgb(255, 240, 24);"></td>
            <td style="border-right: none; border-top: none; border-bottom: none;"></td>
            <td style="border-left: none; border-top: none; border-bottom: none; border-right: none;"></td>
            <td style="border-right: none; border-left: none; border-bottom: none; border-top: none; text-align: center; font-weight: bold;">aaaa-mm-dd</td>
            <td style="border-left: none; border-bottom: none; border-top: none; text-align: center; font-weight: bold;" >hh-mm-ss</td> 
        </tr>
        <tr class="white-header">
            <th colspan="7" class="white-header" style="border-top: none; border-bottom: none; text-align: center; font-weight: bold;">Datos del Equipo </th>
        </tr>
    </table>
    <table>
        <tr>
            <td style="font-weight: bold;" class="cell-custom7" >Item</td>
            <td style="font-weight: bold;">Marca</td>
            <td style="font-weight: bold;">Modelo</td>
            <td style="font-weight: bold;">Serial</td>
            <td style="font-weight: bold;">Observaciones</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">CPU</td>
            <td >' . $PC["marca"] . '</td>
            <td>' . $PC["modelo"] . '</td>
            <td>' . $PC["serial"] . '</td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Monitor</td>
            <td>' . $Monitor["marca"] . '</td>
            <td>' . $Monitor["modelo"] . '</td>
            <td>' . $Monitor["serial"] . '</td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Teclado</td>
            <td>' . $Teclado["marca"] . '</td>
            <td>' . $Teclado["modelo"] . '</td>
            <td>' . $Teclado["serial"] . '</td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Mouse</td>
            <td>' . $Mouse["marca"] . '</td>
            <td>' . $Mouse["modelo"] . '</td>
            <td>' . $Mouse["serial"] . '</td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Impresora</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Portatil</td>
            <td>' . $Portatil["marca"] . '</td>
            <td>' . $Portatil["modelo"] . '</td>
            <td>' . $Portatil["serial"] . '</td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Otro</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center; font-weight: bold;">Observacion</td>
        </tr>
        <tr>
            <td colspan="5" style="height: 70px;">'. htmlspecialchars($mantenimiento['observaciones']) .'</td>
        </tr>
    </table>
    <table>   
        <tr>
            <td style="border-bottom: none; border-right: none; font-weight: bold;">Firmas</td>
            <td style="border-left: none; border-right: none; border-bottom: none;" class="cell-custom14"></td>
            <td style="border-left: none; border-right: none; border-bottom: none; font-weight: bold;"></td>
            <td style="border-left: none; border-right: none; border-bottom: none;" class="cell-custom14"></td>
            <td style="border-left: none; border-right: none;border-bottom: none; font-weight: bold;" ></td>
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
            <td style="border-right: none; border-bottom: none; border-top: none; text-align: right; font-weight: bold;" ></td>
            <td style="border-left: none; border-right: none; border-bottom: none; border-top: none; font-weight: bold; text-align: center;" >Quien Realiza</td>
            <td style="border-left: none; border-right: none; border-bottom: none; border-top: none; text-align: right; font-weight: bold;" ></td>
            <td style="border-left: none; border-right: none; border-top: none; border-bottom: none; text-align: center; font-weight: bold;" >Quien Autoriza</td>
            <td style="border-left: none; border-right: none; border-bottom: none; border-top: none; text-align: right; font-weight: bold;" ></td>
            <td style="border-left: none; border-bottom: none; border-top: none; font-weight: bold; text-align: center;" >Usuario</td>
        </tr>
        <tr>
            <td style="border-right: none; border-top: none; border-bottom: none;" ></td>
            <td style="border-left: none; border-right: none; border-top: none; border-bottom: none; text-align: center;" >'. htmlspecialchars($mantenimiento['tecnico']) .'</td>
            <td style="border-left: none; border-right: none; border-top: none; border-bottom: none;" ></td>
            <td style="border-left: none; border-right: none; border-top: none; border-bottom: none; text-align: center;" >NIDIA PAEZ</td>
            <td style="border-left: none; border-right: none; border-top: none; border-bottom: none;" ></td>
            <td style="border-left: none; border-top: none; border-bottom: none; text-align: center;" >' . htmlspecialchars($usuario['nombre']) . ' ' . htmlspecialchars($usuario['apellido']) . '</td>
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