<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jp";

// Crear conexión
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Corregir la consulta SQL
    $stmt = $mysqli->prepare("SELECT hash_cont FROM credenciales WHERE usuario = ?");
    $stmt->bind_param("s", $usuario); // Vinculamos el parámetro para evitar inyección SQL

    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($hash_cont);
        $stmt->fetch();

        // Verificar la contraseña
        if (password_verify($password, $hash_cont)) {
            $_SESSION['usuario'] = $usuario; 
            header("Location: index.php");  // Redirige a la página de inicio
            exit();
        } else {
            // Contraseña incorrecta
            header("Location: contraseña_incorrecta.php");
            exit();
        }
    } else {
        // Usuario no encontrado
        header("Location: usu_equi.php");
        exit();
    }

    // Cerrar la consulta y la conexión
    $stmt->close();
    $mysqli->close();
}
?>
