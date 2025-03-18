<?php
session_start();

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "jp";

    $mysqli = new mysqli($servername, $username, $password, $dbname);

    if ($mysqli->connect_error) {
        die("Conexión fallida: " . $mysqli->connect_error);
    }

    // Verificar si el token existe en la base de datos
    $stmt = $mysqli->prepare("SELECT id_u FROM credenciales WHERE reset_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id_u);
        $stmt->fetch();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $new_password = $_POST['new_password'];
            $new_password_hash = password_hash($new_password, PASSWORD_BCRYPT);

            // Actualizar la contraseña y limpiar el token
            $stmt = $mysqli->prepare("UPDATE credenciales SET hash_cont = ?, reset_token = NULL WHERE id_u = ?");
            $stmt->bind_param("si", $new_password_hash, $id_u);
            $stmt->execute();

            echo "<div class='alert alert-success'>Contraseña restablecida con éxito.</div>";
        }

        echo '<form action="reestablecer.php?token=' . $token . '" method="POST">
                <label for="new_password">Nueva Contraseña</label>
                <input type="password" id="new_password" name="new_password" required>
                <button type="submit">Restablecer Contraseña</button>
              </form>';
    } else {
        echo "<div class='alert alert-danger'>Token inválido o expirado.</div>";
    }

    $stmt->close();
    $mysqli->close();
} else {
    echo "<div class='alert alert-danger'>Token no proporcionado.</div>";
}
?>
