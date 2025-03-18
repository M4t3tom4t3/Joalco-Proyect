<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Si no tienes Composer, incluye las librerías de PHPMailer manualmente
require 'vendor/autoload.php';  // Si estás usando Composer
// require 'path/to/PHPMailer/src/Exception.php';
// require 'path/to/PHPMailer/src/PHPMailer.php';
// require 'path/to/PHPMailer/src/SMTP.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jp";

$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

// Correo electrónico fijo al que se enviará el enlace
$correo_fijo = 'sistemas.transjoalco@gmail.com';  // Cambia este correo por el que deseas usar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];

    // Verificar si el usuario existe en la base de datos
    $stmt = $mysqli->prepare("SELECT id_u FROM credenciales WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id_u);
        $stmt->fetch();

        // Generar un token único para la recuperación
        $token = bin2hex(random_bytes(50));  // Genera un token aleatorio de 50 bytes

        // Almacenar el token en la base de datos
        $stmt = $mysqli->prepare("UPDATE credenciales SET reset_token = ? WHERE id_u = ?");
        $stmt->bind_param("si", $token, $id_u);
        $stmt->execute();

        // Enviar correo con el enlace de recuperación
        $mail = new PHPMailer(true);
        try {
            // Configuración del servidor de correo
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Cambia esto según el servicio de correo que uses
            $mail->SMTPAuth = true;
            $mail->Username = 'sistemas.transjoalco@gmail.com';
            $mail->Password = 'bpps wrqx chry npji'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Receptor del correo (correo fijo)
            $mail->setFrom('sistemas.transjoalco@gmail.com', 'Recuperación de Contraseña');
            $mail->addAddress($correo_fijo);  // Siempre al mismo correo

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de Contraseña';
            $mail->Body = 'El usuario "' . $usuario . '" ha solicitado restablecer su contraseña. Haz clic en el siguiente enlace para restablecerla: <a href="192.168.80.10/reestablecer.php?token=' . $token . '">Restablecer Contraseña</a>';
            $mail->AltBody = 'El usuario "' . $usuario . '" ha solicitado restablecer su contraseña. Visita el siguiente enlace para restablecerla: 192.168.80.10/reestablecer.php?token=' . $token;

            $mail->send();

            echo 'Correo enviado. El administrador recibirá el enlace de recuperación.';
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    } else {
        echo "<div class='alert alert-danger'>El nombre de usuario no está registrado.</div>";
    }

    $stmt->close();
    $mysqli->close();
}
?>
