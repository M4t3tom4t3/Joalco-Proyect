<?php
// usuario_no_existe.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario no existe</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">¡Error!</h4>
            <p>El nombre de usuario no existe. Por favor, verifique los datos e intente nuevamente.</p>
            <hr>
            <p class="mb-0">¿Ya tienes una cuenta? <a href="inicio.html">Inicia sesión</a></p>
        </div>
        <div class="text-center">
            <a href="inicio.html" class="btn btn-primary">Volver al login</a>
        </div>
    </div>
</body>
</html>
