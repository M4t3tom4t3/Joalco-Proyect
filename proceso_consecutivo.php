<?php
require 'conexion.php';

if(isset($_GET['filtro_consecutivo'])){
    $numero_consecutivo = $_GET['filtro_consecutivo'];
    $conexion = new Conexion;
    $conexion->Query = "SELECT * FROM asignacion WHERE numero_consecutivo LIKE :numero_consecutivo";

    try{
        $conexion->Pps = $conexion->getBaseDeDatosConection()->prepare($conexion->Query);
        $conexion->Pps->execute([":numero_consecutivo"=>"%".$numero_consecutivo."%"]);

        // Verifica si la consulta devuelve datos
        $result = $conexion->Pps->fetchAll(PDO::FETCH_OBJ);
        
        if ($result) {
            echo json_encode(['response'=>$result]);
        } else {
            echo json_encode(['response'=>[]]);
        }
    }catch(\Throwable $th){
        echo $th->getMessage();
    }finally{
        $conexion->closeDataBase();
    }
}
?>

