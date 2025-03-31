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

if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] == 0) {
    $file = $_FILES['csvFile']['tmp_name'];
    $handle = fopen($file, "r");

    if ($handle !== FALSE) {
        fgetcsv($handle); 

        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            $nombre = $conn->real_escape_string($data[0]);
            $apellido = $conn->real_escape_string($data[1]);
            $cargo = $conn->real_escape_string($data[2]);
            $departamento = isset($data[3]) ? $conn->real_escape_string($data[3]) : 'Sin Departamento';
            $ciudad = isset($data[4]) ? $conn->real_escape_string($data[4]) : 'Sin Ciudad';

            $sql = "INSERT INTO usuarios (nombre, apellido, cargo, departamento, ciudad) 
                    VALUES ('$nombre', '$apellido', '$cargo', '$departamento', '$ciudad')";

            if (!$conn->query($sql)) {
                echo "Error al insertar usuario: " . $conn->error . "<br>";
            }
        }

        fclose($handle);
        echo "<script>alert('Usuarios cargados exitosamente.'); window.location.href = 'list.php';</script>";
    } else {
        echo "Error al abrir el archivo.";
    }
} else {
    echo "Error al subir el archivo.";
}

$conn->close();
?>
