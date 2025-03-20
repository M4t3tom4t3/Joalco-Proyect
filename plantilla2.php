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

    $numero_consecutivo = intval($numero_consecutivo);

    $sql = "SELECT * FROM asignacion WHERE numero_consecutivo = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    
    $stmt->bind_param("i", $numero_consecutivo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        var_dump($usuario);
    } else {
        return "<p>No se encontró el usuario.</p>";
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
            <td colspan="8" class="cell-custom1" style="text-align: center;"></td>
            <td colspan="2" style="text-align: center;">A-</td>
        </tr>
        <tr class="blue-header">
            <th colspan="7" class="blue-header">CIUDAD</th>
            <th colspan="3" class="blue-header">AREA</th>
        </tr>
        <tr>
            <td colspan="7" class="cell-custom1" style="text-align: center;"></td>
            <td colspan="3" style="text-align: center;"></td>
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
            <td colspan="5" class="cell-custom1" style="text-align: center;"></td>
            <td colspan="3" style="text-align: center;" ></td>
            <td colspan="2" style="text-align: center;"></td>
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
            <th colspan="2" ></th>
            <th colspan="1" ></th>
            <th colspan="4" ></th>
            <th colspan="2" ></th>
            <th colspan="2" ></th>
        </tr>
        <tr >
            <th colspan="2" ></th>
            <th colspan="1" ></th>
            <th colspan="4" ></th>
            <th colspan="2" ></th>
            <th colspan="2" ></th>
        </tr>
        <tr >
            <th colspan="2" ></th>
            <th colspan="1" ></th>
            <th colspan="4" ></th>
            <th colspan="2" ></th>
            <th colspan="2" ></th>
        </tr>
        <tr >
            <th colspan="2" ></th>
            <th colspan="1" ></th>
            <th colspan="4" ></th>
            <th colspan="2" ></th>
            <th colspan="2" ></th>
        </tr>
        <tr >
            <th colspan="2" ></th>
            <th colspan="1" ></th>
            <th colspan="4" ></th>
            <th colspan="2" ></th>
            <th colspan="2" ></th>
        </tr>
        <tr >
            <th colspan="2" ></th>
            <th colspan="1" ></th>
            <th colspan="4" ></th>
            <th colspan="2" ></th>
            <th colspan="2" ></th>
        </tr>
        <tr >
            <th colspan="2" ></th>
            <th colspan="1" ></th>
            <th colspan="4" ></th>
            <th colspan="2" ></th>
            <th colspan="2" ></th>
        </tr>
        <tr >
            <th colspan="2" ></th>
            <th colspan="1" ></th>
            <th colspan="4" ></th>
            <th colspan="2" ></th>
            <th colspan="2" ></th>
        </tr>
        <tr >
            <th colspan="2" ></th>
            <th colspan="1" ></th>
            <th colspan="4" ></th>
            <th colspan="2" ></th>
            <th colspan="2" ></th>
        </tr>
        <tr >
            <th colspan="2" ></th>
            <th colspan="1" ></th>
            <th colspan="4" ></th>
            <th colspan="2" ></th>
            <th colspan="2" ></th>
        </tr>
    </table>

    <table>
        <tr >
            <th colspan="1" class="cell-custom2" style="font-weight: bold; text-align: center;" >DISCO:</th>
            <th colspan="2" ></th>
            <th colspan="1" style="font-weight: bold; text-align: center;" >Sistema Operativo:</th>
            <th colspan="2" ></th>
        </tr>
        <tr >
            <th colspan="1" style="font-weight: bold; text-align: center;" >MEMORIA:</th>
            <th colspan="2" > RAM</th>
            <th colspan="1" style="font-weight: bold; text-align: center;" >IP:</th>
            <th colspan="2" ></th>
        </tr>
        <tr >
            <th colspan="1" style="font-weight: bold; text-align: center;" >PROCESADOR:</th>
            <th colspan="2" ></th>
            <th colspan="1" style="font-weight: bold; text-align: center;" >USUARIO DOMINIO:</th>
            <th colspan="2" ></th>
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
            <th colspan="2" ></th>
            <th colspan="1" ></th>
            <th colspan="4" ></th>
            <th colspan="2" ></th>
            <th colspan="2" ></th>
        </tr>
        <tr >
            <th colspan="2" ></th>
            <th colspan="1" ></th>
            <th colspan="4" ></th>
            <th colspan="2" ></th>
            <th colspan="2" ></th>
        </tr>
        <tr >
            <th colspan="2" </th>
            <th colspan="1" ></th>
            <th colspan="4" ></th>
            <th colspan="2" ></th>
            <th colspan="2" ></th>
        </tr>
        <tr >
            <th colspan="2" ></th>
            <th colspan="1" ></th>
            <th colspan="4" ></th>
            <th colspan="2" ></th>
            <th colspan="2" ></th>
        </tr>
        <tr >
            <th colspan="2" ></th>
            <th colspan="1" ></th>
            <th colspan="4" ></th>
            <th colspan="2" ></th>
            <th colspan="2" ></th>
        </tr>
        <tr >
            <th colspan="2" ></th>
            <th colspan="1" ></th>
            <th colspan="4" ></th>
            <th colspan="2" ></th>
            <th colspan="2" ></th>
        </tr>
        <tr >
            <th colspan="2" ></th>
            <th colspan="1" ></th>
            <th colspan="4" ></th>
            <th colspan="2" ></th>
            <th colspan="2" ></th>
        </tr>
        <tr >
            <th colspan="2" ></th>
            <th colspan="1" ></th>
            <th colspan="4" ></th>
            <th colspan="2" ></th>
            <th colspan="2" ></th>
        </tr>
        <tr >
            <th colspan="2" ></th>
            <th colspan="1" ></th>
            <th colspan="4" ></th>
            <th colspan="2" ></th>
            <th colspan="2" ></th>
        </tr>
        <tr >
            <th colspan="2" ></th>
            <th colspan="1" ></th>
            <th colspan="4" ></th>
            <th colspan="2" ></th>
            <th colspan="2" ></tr>
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