<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'admin') {
    header("Location: index.php");
    exit();
}

$eliminado = false; 

if (isset($_GET['ID_usuario'])) {
    $ID_usuario = $_GET['ID_usuario'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "jp";

    $mysqli = new mysqli($servername, $username, $password, $dbname);

    if ($mysqli->connect_error) {
        die("Conexión fallida: " . $mysqli->connect_error);
    }

    $stmt = $mysqli->prepare("DELETE FROM equipos WHERE serial = ?");
    $stmt->bind_param("s", $serial);

    if ($stmt->execute()) {
        $eliminado = true; 
    } else {
        $eliminado = false; 
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
