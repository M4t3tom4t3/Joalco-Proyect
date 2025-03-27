<?php
require 'conexion.php';

if(isset($_GET['filtro_serial'])){ 
    $serial = $_GET['filtro_serial'];
    $conexion = new Conexion;
    $conexion->Query = "SELECT serial FROM equipos WHERE serial LIKE :serial";

    try {
        $conexion->Pps = $conexion->getBaseDeDatosConection()->prepare($conexion->Query);
        $conexion->Pps->execute([":serial" => "%" . $serial . "%"]);

        $result = $conexion->Pps->fetchAll(PDO::FETCH_OBJ);

        echo json_encode(['response' => $result ?: []]); 
    } catch (\Throwable $th) {
        echo json_encode(['error' => $th->getMessage()]);
    } finally {
        $conexion->closeDataBase();
    }
}
?>
