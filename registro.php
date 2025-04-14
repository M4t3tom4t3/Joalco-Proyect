<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jp";

$mysqli = new mysqli($servername, $username, $password, $dbname);
if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_a = $_POST['nombre_a'];
    $apellido_a = $_POST['apellido_a'];
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['password'];
    $confirmar_contraseña = $_POST['confirm_password'];

    if ($contraseña !== $confirmar_contraseña) {
        echo "<div class='alert alert-danger'>Las contraseñas no coinciden.</div>";
    } else {
        $hash_contr = password_hash($contraseña, PASSWORD_DEFAULT);

        $stmt = $mysqli->prepare("INSERT INTO credenciales (nombre_a, apellido_a, usuario, hash_cont) VALUES (?, ?,?, ?)");
        $stmt->bind_param("ssss",$nombre_a,$apellido_a, $usuario, $hash_contr);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Usuario registrado con éxito. <a href='login.php'>Iniciar sesión</a></div>";
        } else {
            echo "<div class='alert alert-danger'>Error al registrar el usuario. Intenta nuevamente.</div>";
        }

        $stmt->close();
    }
}

$mysqli->close();
?>
