<?php
include('conexion.php');  

if (isset($_GET['serial'])) {
    $serial = $_GET['serial'];
} else {
    die('Error: El serial no está definido.');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['ruta_img']) && $_FILES['ruta_img']['error'] == 0) {
        $target_dir = "Equipos/";
        $target_file = $target_dir . basename($_FILES["ruta_img"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["ruta_img"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["ruta_img"]["tmp_name"], $target_file)) {
                $ruta_img = $target_file;

                $sql = "UPDATE equipos SET ruta_img = ? WHERE serial = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $ruta_img, $serial); 

                if ($stmt->execute()) {
                    echo "<script>alert('Imagen subida correctamente.'); window.location.href = 'list_eq.php';</script>";
                } else {
                    echo "Error al actualizar la base de datos: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error al mover el archivo.";
            }
        } else {
            echo "El archivo no es una imagen válida.";
        }
    } else {
        echo "Error: No se ha subido ninguna imagen o hubo un problema al subirla.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="index.php">Joalco</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="list.php" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Usuarios</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="list_eq.php" class="sidebar-link">
                        <i class="lni lni-agenda"></i>
                        <span>Equipos</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                        <i class="lni lni-protection"></i>
                        <span>Asignaciones</span>
                    </a>
                    <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="asig_usuarios.php" class="sidebar-link"><i class="lni lni-user"></i>Personas</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="asig_equipos.php" class="sidebar-link"><i class="lni lni-folder"></i> Equipos</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="mantenimiento.php " class="sidebar-link">
                        <i class="lni lni-cog"></i>
                        <span>Mantenimiento</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="list_pcpt.php" class="sidebar-link">
                        <i class="lni lni-book"></i>
                        <span>Hoja de Vida</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#impresoras" aria-expanded="false" aria-controls="impresoras">
                        <i class="lni lni-printer"></i>
                        <span>Impresoras</span>
                    </a>
                    <ul id="impresoras" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="imp_bogota.php" class="sidebar-link"><i class="lni lni-home"></i>Bogota</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="imp_sucursales.php" class="sidebar-link"><i class="lni lni-map"></i> Sucursales</a>
                        </li>
                    </ul>
                </li>

            </ul>
        </aside>
        <div class="main">
            <?php

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "jp";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verificar la conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Consultar el número de usuarios
            $query_usuarios = "SELECT COUNT(*) AS total_usuarios FROM usuarios";
            $result_usuarios = $conn->query($query_usuarios);
            $usuarios = $result_usuarios->fetch_assoc();

            // Consultar el número de equipos
            $query_equipos = "SELECT COUNT(*) AS total_equipos FROM equipos";
            $result_equipos = $conn->query($query_equipos);
            $equipos = $result_equipos->fetch_assoc();


            $conn->close();
            ?>
            <nav class="navbar navbar-expand px-4 py-3">
                <form action="#" class="d-none d-sm-inline-block">

                </form>
                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                <img src="account.png" class="avatar img-fluid" alt="">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end rounded">
                            <a href="logout.php" class="dropdown-item">Cerrar sesión</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="content px-3 py-4">
                <div class="container-fluid">
                    <div class="mb-3">
                        <h3 class="fw-bold fs-4 mb-3">Subir Imagenes</h3>
                        <div class="row">
                            <form action="subir_imagen.php?serial=<?php echo htmlspecialchars($serial); ?>"
                                method="POST" enctype="multipart/form-data">
                                <div>
                                    <label for="ruta_img">Selecciona una imagen:</label>
                                    <input  class="form-control" type="file" name="ruta_img" id="ruta_img" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                    <a href="list_eq.php" class="btn btn-success me-md-2">Regresar</a>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>

</body>

</html>