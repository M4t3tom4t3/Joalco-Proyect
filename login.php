<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jp";

$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $stmt = $mysqli->prepare("SELECT hash_cont, rol, nombre_a, apellido_a FROM credenciales WHERE usuario = ?");
    $stmt->bind_param("s", $usuario); 

    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($hash_cont, $rol,$nombre_a, $apellido_a); 
        $stmt->fetch();

        if (password_verify($password, $hash_cont)) {
            $_SESSION['usuario'] = $usuario; 
            $_SESSION['rol'] = $rol;
            $_SESSION['nombre_a'] = $nombre_a;
            $_SESSION['apellido_a'] = $apellido_a;
            header("Location: index.php");  
            exit();
        } else {
            header("Location: contraseña_incorrecta.php");
            exit();
        }
    } else {
        header("Location: usu_equi.php");
        exit();
    }

    $stmt->close();
    $mysqli->close();
}
?>
