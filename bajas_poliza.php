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
                            <?php if ($_SESSION['rol'] == 'admin') : ?>
                                <a href="reg.php" class="dropdown-item">Registrar Administrador</a>
                                <a href="carg_usuarios.php" class="dropdown-item">Insertar Usuarios CSV</a>
                                <?php endif; ?>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="content px-3 py-4">
                <div class="container-fluid">
                    <div class="mb-3">
                        <h3 class="fw-bold fs-4 mb-3"></h3>
                        <div class="row">
                            <div class="container mt-4">

                                <!-- Selector para elegir la tabla -->
                                <div class="mb-3">
                                    <label for="tablaSelector" class="form-label">Selecciona una tabla:</label>
                                    <select class="form-select" id="tablaSelector">
                                        <option value="tablaX">Equipos de Baja</option>
                                        <option value="tablaY">Equipos en Poliza</option>
                                    </select>
                                </div>

                                <!-- Tabla X -->
                                <div id="tablaX" class="table-responsive" style="display: none;">
                                    <h4>Equipos de Baja</h4>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a href="generar_reporte.php?tabla=tablaX"
                                            class="btn btn-outline-danger me-md-2"><i
                                                class="bi bi-filetype-pdf"></i></a>
                                        <a href="generar_reporteE.php?tabla=tablaX"
                                            class="btn btn-outline-success me-md-2"><i
                                                class="bi bi-file-earmark-spreadsheet"></i></a>
                                    </div>

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Serial</th>
                                                <th>Equipo</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Fecha de Compra</th>
                                                <th>Hoja de Vida</th>
                                                <th>Costo</th>
                                                <th>Usuario</th>
                                                <th>Departamento</th>
                                                <th>Años</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "
    SELECT e.serial, e.nombre_equipo, e.marca, e.modelo, e.fecha_compra, e.hv, e.costo,
           u.nombre AS usuario_nombre, u.departamento, 
           MAX(a.fecha_asignacion) AS fecha_ultima_asignacion
    FROM equipos e
    LEFT JOIN asignacion a ON e.serial = a.FK_serial
    LEFT JOIN usuarios u ON a.FK_id = u.ID_usuario
    WHERE e.estado = 'DE BAJA'
    GROUP BY e.serial, e.nombre_equipo, e.marca, e.modelo, e.fecha_compra, e.hv, e.costo, u.nombre, u.departamento
";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fechaCompra = new DateTime($row["fecha_compra"]);
        $fechaActual = new DateTime(); 
        $diferencia = $fechaActual->diff($fechaCompra); 
        $años = $diferencia->y;
        
        echo "<tr>";
        echo "<td>" . $row["serial"] . "</td>";
        echo "<td>" . $row["nombre_equipo"] . "</td>";
        echo "<td>" . $row["marca"] . "</td>";
        echo "<td>" . $row["modelo"] . "</td>";
        echo "<td>" . $row["fecha_compra"] . "</td>";
        echo "<td>" . $row["hv"] . "</td>";
        echo "<td>" . $row["costo"] . "</td>";
        echo "<td>" . $row["usuario_nombre"] . "</td>"; 
        echo "<td>" . $row["departamento"] . "</td>"; 

        if ($años > 3) {
            echo "<td><span class='badge text-bg-danger'>" . $años . " años</span></td>"; 
        } else {
            echo "<td><span class='badge text-bg-primary'>" . $años . " años</span></td>"; 
        }
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='9'>No hay equipos en poliza.</td></tr>";
}
?>

                                        </tbody>
                                    </table>
                                </div>

                                <div id="tablaY" class="table-responsive" style="display: none;">
                                    <h4>Equipos en Poliza</h4>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a href="generar_reporte.php?tabla=tablaY"
                                            class="btn btn-outline-danger me-md-2"><i
                                                class="bi bi-filetype-pdf"></i></a>
                                        <a href="generar_reporteE.php?tabla=tablaY"
                                            class="btn btn-outline-success me-md-2"><i
                                                class="bi bi-file-earmark-spreadsheet"></i></a>
                                    </div>

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Serial</th>
                                                <th>Equipo</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Fecha de Compra</th>
                                                <th>Años</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $servername = "localhost";
                                            $username = "root";
                                            $password = "";
                                            $dbname = "jp";

                                            $conn = new mysqli($servername, $username, $password, $dbname);

                                            if ($conn->connect_error) {
                                                die("Conexión fallida: " . $conn->connect_error);
                                            }

                                            $sql = "SELECT * FROM equipos WHERE poliza = 'SI'";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    $fechaCompra = new DateTime($row["fecha_compra"]);
                                                    $fechaActual = new DateTime(); 
                                                    $diferencia = $fechaActual->diff($fechaCompra); // Calcula la diferencia
                                                    $años = $diferencia->y;
                                                    echo "<td>" . $row["serial"] . "</td>";
                                                    echo "<td>" . $row["nombre_equipo"] . "</td>";
                                                    echo "<td>" . $row["marca"] . "</td>";
                                                    echo "<td>" . $row["modelo"] . "</td>";
                                                    echo "<td>" . $row["fecha_compra"] . "</td>";
                                                    if ($años > 3) {
                                                        echo "<td><span class='badge text-bg-danger'>" . $años . " años</span></td>"; // Badge rojo para > 3 años
                                                    } else {
                                                        echo "<td><span class='badge text-bg-primary'>" . $años . " años</span></td>"; // Badge azul para <= 3 años
                                                    }
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='7'>No hay equipos en poliza.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    
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
        $(document).ready(function () {
            $('#tablaSelector').change(function () {
                var selectedTable = $(this).val();

                if (selectedTable === "tablaX") {
                    $('#tablaX').show();
                    $('#tablaY').hide();
                } else if (selectedTable === "tablaY") {
                    $('#tablaY').show();
                    $('#tablaX').hide();
                }
            });

            $('#tablaX').show(); 
            $('#tablaY').hide(); 
        });
    </script>
</body>

</html>