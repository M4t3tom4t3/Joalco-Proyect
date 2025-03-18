<?php
// contraseña_incorrecta.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contraseña Incorrecta</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">¡Error!</h4>
            <p>La contraseña ingresada es incorrecta. Por favor, intenta nuevamente.</p>
            <hr>
            <p class="mb-0">¿Olvidaste tu contraseña? <a href="recuperar.php">Recupérala aquí</a></p>
        </div>
        <div class="text-center">
            <a href="inicio.html" class="btn btn-primary">Regresar</a>
        </div>
    </div>
</body>
</html>
