<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: inicio.html");
    exit();
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
                <a href="index.php">
                <img src="Joalco2.jpeg" alt="Logo" class="img-fluid mb-4 redondeada" style="max-width: 160px; margin-top: 20px; margin-right: 30px;">
                </a>
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
                    <a href="bajas_poliza.php" class="sidebar-link">
                    <i class="bi bi-bank2"></i>
                        <span>Bajas y Polizas</span>
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
                        <h3 class="fw-bold fs-4 mb-3">Centro de Comando Impresoras Bogota</h3>
                        <div class="row">

                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card" style="width: 100%;">
                                    <div class="card-body">
                                        <h5 class="card-title"><strong>Administrativa</strong></h5>
                                        <p class="card-text">Usuario: Admin</p>
                                        <p class="card-text">Contraseña: **********
                                            <input type="text" value="WDS3706281" class="password-input"
                                                style="opacity: 0; position: absolute;">
                                        </p>
                                        <button class="copy-btn btn btn-outline-secondary btn-sm"
                                            data-password="WDS3706281"><i class="bi bi-copy"></i></button>
                                        <a href="https://192.168.80.17/" target="_blank" class="btn btn-link">Link</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card" style="width: 100%;">
                                    <div class="card-body">
                                        <h5 class="card-title"><strong>Financiera</strong></h5>
                                        <p class="card-text">Usuario: Admin</p>
                                        <p class="card-text">Contraseña: **********
                                            <input type="text" value="WDS3706120" class="password-input"
                                                style="opacity: 0; position: absolute;">
                                        </p>
                                        <button class="copy-btn btn btn-outline-secondary btn-sm"
                                            data-password="WDS3706120"><i class="bi bi-copy"></i></button>
                                        <a href="https://192.168.80.25/" target="_blank" class="btn btn-link">Link</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card" style="width: 100%;">
                                    <div class="card-body">
                                        <h5 class="card-title"><strong>Operaciones</strong></h5>
                                        <p class="card-text">Usuario: Admin</p>
                                        <p class="card-text">Contraseña: **********
                                            <input type="text" value="WDS3706280" class="password-input"
                                                style="opacity: 0; position: absolute;">
                                        </p>
                                        <button class="copy-btn btn btn-outline-secondary btn-sm"
                                            data-password="WDS3706280"><i class="bi bi-copy"></i></button>
                                        <a href="https://192.168.80.26/" target="_blank" class="btn btn-link">Link</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card" style="width: 100%;">
                                    <div class="card-body">
                                        <h5 class="card-title"><strong>Mantenimiento</strong></h5>
                                        <p class="card-text">Usuario: Admin</p>
                                        <p class="card-text">Contraseña: *****
                                            <input type="text" value="Admin" class="password-input"
                                                style="opacity: 0; position: absolute;">
                                        </p>
                                        <button class="copy-btn btn btn-outline-secondary btn-sm"
                                            data-password="Admin"><i class="bi bi-copy"></i></button>
                                        <a href="https://192.168.80.23/" target="_blank" class="btn btn-link">Link</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card" style="width: 100%;">
                                    <div class="card-body">
                                        <h5 class="card-title"><strong>Almacen</strong></h5>
                                        <p class="card-text">Usuario: Admin</p>
                                        <p class="card-text">Contraseña: *****
                                            <input type="text" value="Admin" class="password-input"
                                                style="opacity: 0; position: absolute;">
                                        </p>
                                        <button class="copy-btn btn btn-outline-secondary btn-sm"
                                            data-password="Admin"><i class="bi bi-copy"></i></button>
                                        <a href="https://192.168.80.122/" target="_blank" class="btn btn-link">Link</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card" style="width: 100%;">
                                    <div class="card-body">
                                        <h5 class="card-title"><strong>Archivo</strong></h5>
                                        <p class="card-text">Usuario: Admin</p>
                                        <p class="card-text">Contraseña: **********
                                            <input type="text" value="WDS3706245" class="password-input"
                                                style="opacity: 0; position: absolute;">
                                        </p>
                                        <button class="copy-btn btn btn-outline-secondary btn-sm"
                                            data-password="WDS3706245"><i class="bi bi-copy"></i></button>
                                        <a href="https://192.168.80.21/" target="_blank" class="btn btn-link">Link</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card" style="width: 100%;">
                                    <div class="card-body">
                                        <h5 class="card-title"><strong>Contabilidad</strong></h5>
                                        <p class="card-text">Usuario: Admin</p>
                                        <p class="card-text">Contraseña: **********
                                            <input type="text" value="WDS3706288" class="password-input"
                                                style="opacity: 0; position: absolute;">
                                        </p>
                                        <button class="copy-btn btn btn-outline-secondary btn-sm"
                                            data-password="WDS3706288"><i class="bi bi-copy"></i></button>
                                        <a href="https://192.168.80.16/" target="_blank" class="btn btn-link">Link</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card" style="width: 100%;">
                                    <div class="card-body">
                                        <h5 class="card-title"><strong>Tesoreria</strong></h5>
                                        <p class="card-text">Usuario: Admin</p>
                                        <p class="card-text">Contraseña: **********
                                            <input type="text" value="WDS3706291" class="password-input"
                                                style="opacity: 0; position: absolute;">
                                        </p>
                                        <button class="copy-btn btn btn-outline-secondary btn-sm"
                                            data-password="WDS3706291"><i class="bi bi-copy"></i></button>
                                        <a href="https://192.168.15.11/" target="_blank" class="btn btn-link">Link</a>
                                    </div>
                                </div>
                            </div>
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
    <script>
        document.querySelectorAll('.copy-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                // Usamos el valor del atributo `data-password` para obtener la contraseña
                const password = btn.getAttribute('data-password');

                // Crear un campo de texto temporal para copiar el valor
                const tempInput = document.createElement('input');
                document.body.appendChild(tempInput);
                tempInput.value = password;
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);

                // Opcional: Puedes agregar una notificación visual para indicar que se copió correctamente
                alert("Contraseña copiada ");
            });
        });

    </script>
</body>

</html>