<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'admin') {
    // Si no está logueado o no tiene rol de administrador, redirige a otra página
    header("Location: index.php");
    exit();
}

$eliminado = false; // Variable para saber si se eliminó correctamente

if (isset($_GET['serial'])) {
    $serial = $_GET['serial'];

    // Conectar a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "jp";

    $mysqli = new mysqli($servername, $username, $password, $dbname);

    if ($mysqli->connect_error) {
        die("Conexión fallida: " . $mysqli->connect_error);
    }

    // Eliminar el equipo de la base de datos
    $stmt = $mysqli->prepare("DELETE FROM equipos WHERE serial = ?");
    $stmt->bind_param("s", $serial);

    if ($stmt->execute()) {
        $eliminado = true; // Se eliminó correctamente
    } else {
        $eliminado = false; // Hubo un error
    }

    $stmt->close();
    $mysqli->close();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de Eliminación</title>
    <!-- Agregar el enlace a SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php if ($eliminado): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Equipo eliminado!',
            text: 'El equipo se ha eliminado correctamente.',
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'list_eq.php';
            }
        });
    </script>
<?php else: ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un problema al eliminar el equipo.',
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'list_eq.php'; 
            }
        });
    </script>
<?php endif; ?>

</body>
</html>
