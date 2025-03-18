<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jp";

$mysqli = new mysqli($servername, $username, $password, $dbname);
// Verificar si hubo error en la conexión
if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

// Verificar si los datos del formulario están presentes
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['password'];
    $confirmar_contraseña = $_POST['confirm_password'];

    // Verificar que las contraseñas coincidan
    if ($contraseña !== $confirmar_contraseña) {
        echo "<div class='alert alert-danger'>Las contraseñas no coinciden.</div>";
    } else {
        // Hashear la contraseña antes de guardarla
        $hash_contr = password_hash($contraseña, PASSWORD_DEFAULT);

        // Preparar la consulta SQL para insertar el nuevo usuario
        $stmt = $mysqli->prepare("INSERT INTO credenciales (usuario, hash_cont) VALUES (?, ?)");
        $stmt->bind_param("ss", $usuario, $hash_contr);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Usuario registrado con éxito. <a href='login.php'>Iniciar sesión</a></div>";
        } else {
            echo "<div class='alert alert-danger'>Error al registrar el usuario. Intenta nuevamente.</div>";
        }

        // Cerrar la declaración
        $stmt->close();
    }
}

// Cerrar la conexión a la base de datos
$mysqli->close();
?>
