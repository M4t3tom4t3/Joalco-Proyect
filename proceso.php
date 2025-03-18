<?php
require 'conexion.php';

if(isset($_GET['filtro'])){
    $NombreUser = $_GET['filtro'];
    $conexion = new Conexion;
    $conexion->Query = "SELECT * FROM usuarios WHERE nombre LIKE :nombre";

    try{
        $conexion->Pps = $conexion->getBaseDeDatosConection()->prepare($conexion->Query);
        $conexion->Pps->execute([":nombre"=>"%".$NombreUser."%"]);

        echo json_encode(['response'=>$conexion->Pps->fetchAll(PDO::FETCH_OBJ)]);
    }catch(\Throwable $th){
        echo $th->getMessage();
    }finally{
        $conexion->closeDataBase();
    }
}

if(isset($_GET['filtro2'])){
    $PLACA = $_GET['filtro2'];
    $conexion2 = new Conexion;
    $conexion2->Query = "SELECT * FROM equipos WHERE PLACA LIKE :PLACA";

    try{
        $conexion2->Pps = $conexion2->getBaseDeDatosConection()->prepare($conexion2->Query);
        $conexion2->Pps->execute([":PLACA"=>"%".$PLACA."%"]);

        echo json_encode(['response'=>$conexion2->Pps->fetchAll(PDO::FETCH_OBJ)]);
    }catch(\Throwable $th2){
        echo $th2->getMessage();
    }finally{
        $conexion2->closeDataBase();
    }
}
?>