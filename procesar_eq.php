<?php
session_start();
if ($_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "jp";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (isset($_FILES['csvFileEquipos']) && $_FILES['csvFileEquipos']['error'] == 0) {
    $file = $_FILES['csvFileEquipos']['tmp_name'];
    $handle = fopen($file, "r");

    if ($handle !== FALSE) {
        fgetcsv($handle); 

        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            $serial = $conn->real_escape_string($data[0]);
            $nombre_equipo = $conn->real_escape_string($data[1]);
            $marca = $conn->real_escape_string($data[2]);
            $modelo = $conn->real_escape_string($data[3]);
            $placa = $conn->real_escape_string($data[4]);
            $fecha_compra = $conn->real_escape_string($data[5]);
            $costo = $conn->real_escape_string($data[6]);
            $ciudad = $conn->real_escape_string($data[7]);

            $sql = "INSERT INTO equipos (serial, nombre_equipo, marca, modelo, placa, fecha_compra, costo, ciudad) 
                    VALUES ('$serial', '$nombre_equipo', '$marca', '$modelo', '$placa', '$fecha_compra', '$costo', '$ciudad')";

            if (!$conn->query($sql)) {
                echo "Error al insertar equipo: " . $conn->error . "<br>";
            }
        }

        fclose($handle);
        echo "<script>alert('Equipos cargados exitosamente.'); window.location.href = 'list_eq.php';</script>";
    } else {
        echo "Error al abrir el archivo.";
    }
} else {
    echo "Error al subir el archivo.";
}

$conn->close();
?>
