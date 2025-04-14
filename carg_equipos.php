<?php
session_start();
if ($_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Equipos CSV</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Carga Masiva de Equipos</h2>
        <form action="procesar_eq.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="csvFile" class="form-label">Selecciona un archivo CSV</label>
                <input type="file" class="form-control" name="csvFileEquipos" id="csvFileEquipos" accept=".csv" required>
            </div>
            <button type="submit" class="btn btn-primary">Subir y Procesar</button>
        </form>
    </div>
</body>
</html>
