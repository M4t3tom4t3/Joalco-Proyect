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
                        <h3 class="fw-bold fs-4 mb-3">Hojas de Vida</h3>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <form class="d-flex" role="search" method="get" action="list_pcpt.php">
                                <input class="form-control me-2" type="search" placeholder="Buscar por Placa o Serial"
                                    aria-label="Search" name="search"
                                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                <button class="btn btn-outline-primary" type="submit">Buscar</button>
                            </form>
                            <a href="list_pcpt.php" class="btn btn-outline-success me-md-2">
                                ⟳
                            </a>

                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr class="highlight">
                                            <th scope="col">Placa</th>
                                            <th scope="col">Serial</th>
                                            <th scope="col">Equipo</th>
                                            <th scope="col">Marca</th>
                                            <th scope="col">Modelo</th>
                                            <th scope="col">Acciones</th>
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
                                            die("La conexión falló: " . $conn->connect_error);
                                        }

                                        $results_per_page = 7;

                                        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
                                            $page = $_GET['page'];
                                        } else {
                                            $page = 1;
                                        }

                                        $start_from = ($page - 1) * $results_per_page;

                                        $search = isset($_GET['search']) ? $_GET['search'] : '';

                                        $sql = "SELECT PLACA, serial, nombre_equipo, marca, modelo 
                                                FROM equipos 
                                                WHERE (nombre_equipo LIKE ? OR marca LIKE ? OR serial LIKE ? OR PLACA LIKE ?) 
                                                AND (nombre_equipo = 'PC' OR nombre_equipo = 'PORTATIL') 
                                                LIMIT ?, ?";
                                        $stmt = $conn->prepare($sql);

                                        $search_term = "%" . $search . "%";

                                        $stmt->bind_param("ssssii", $search_term, $search_term, $search_term, $search_term, $start_from, $results_per_page);

                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($row['PLACA']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['serial']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['nombre_equipo']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['marca']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['modelo']) . "</td>";
                                                echo "<td>
                                                <a href='HTMLPDF.php?serial=" . $row['serial'] . "' class='btn btn-warning btn-sm edit-btn'>
                                                <i class='lni lni-download'></i>
                                                </a>

                                                <a href='#' class='btn btn-outline-success btn-sm' data-bs-toggle='modal' data-bs-target='#exampleModal' data-id='" . $row['serial'] . "'>
                                                <i class='lni lni-plus'></i>
                                                </a>

                                                <a href='#' class='btn btn-outline-warning btn-sm' data-bs-toggle='modal' data-bs-target='#BackupModal' data-id='" . $row['serial'] . "'>
                                                <i class='lni lni-plus'></i>
                                                </a>

                                                </td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='6' class='text-center'>No se encontraron resultados</td></tr>";
                                        }
                                        $sql = "SELECT COUNT(*) AS total 
                                        FROM equipos 
                                        WHERE (nombre_equipo LIKE ? OR PLACA LIKE ? OR serial LIKE ?)
                                        AND (nombre_equipo = 'PC' OR nombre_equipo = 'PORTATIL')";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bind_param("sss", $search_term, $search_term, $search_term);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $row = $result->fetch_assoc();
                                        $total_results = $row['total'];
                                        $total_pages = ceil($total_results / $results_per_page);
                                        ?>
                                    </tbody>
                                </table>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item <?php if ($page <= 1)
                                            echo 'disabled'; ?>">
                                            <a class="page-link" href="?page=1&search=<?php echo urlencode($search); ?>"
                                                aria-label="First">
                                                <span aria-hidden="true">&laquo;&laquo;</span>
                                            </a>
                                        </li>

                                        <li class="page-item <?php if ($page <= 1)
                                            echo 'disabled'; ?>">
                                            <a class="page-link"
                                                href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>"
                                                aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>

                                        <?php
                                        $range = 2;
                                        $start = max(1, $page - $range);
                                        $end = min($total_pages, $page + $range);

                                        for ($i = $start; $i <= $end; $i++) {
                                            echo "<li class='page-item " . ($i == $page ? 'active' : '') . "'>
                                            <a class='page-link' href='?page=$i&search=" . urlencode($search) . "'>$i</a>
                                            </li>";
                                        }
                                        ?>

                                        <li class="page-item <?php if ($page >= $total_pages)
                                            echo 'disabled'; ?>">
                                            <a class="page-link"
                                                href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>"
                                                aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>

                                        <li class="page-item <?php if ($page >= $total_pages)
                                            echo 'disabled'; ?>">
                                            <a class="page-link"
                                                href="?page=<?php echo $total_pages; ?>&search=<?php echo urlencode($search); ?>"
                                                aria-label="Last">
                                                <span aria-hidden="true">&raquo;&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>

                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModal"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModal">Agregar Cambios</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="cambioForm">
                                                    <input type="hidden" id="serial" name="serial" value="" />
                                                    <div class="mb-3">
                                                        <label for="cambio" class="form-label">Cambio</label>
                                                        <input type="text" class="form-control" id="cambio"
                                                            name="cambio" required />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="fecha_cambio" class="form-label">Fecha del
                                                            Cambio</label>
                                                        <input type="date" class="form-control" id="fecha_cambio"
                                                            name="fecha_cambio" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-success">Guardar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="BackupModal" tabindex="-1" aria-labelledby="BackupModal"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="BackupModal">Registrar Backup</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="BackupForm">
                                                    <input type="hidden" id="serial" name="serial" value="" />
                                                    <div class="mb-3">
                                                        <label for="cambio" class="form-label">Fecha</label>
                                                        <input type="date" class="form-control" id="fecha_b"
                                                            name="fecha_b" required />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="cambio" class="form-label">Tecnico</label>
                                                        <input type="text" class="form-control" id="tecnico_b"
                                                            name="tecnico_b" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="cambio" class="form-label">Disco</label>
                                                        <input type="text" class="form-control" id="disco"
                                                            name="disco" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-success">Guardar</button>
                                                </form>
                                            </div>
                                        </div>
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
        $('#cambioForm').on('submit', function (event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: 'agregar_cambio.php',
                type: 'POST',
                data: formData,
                success: function (response) {
                    alert('Cambios guardados correctamente');
                    $('#exampleModal').modal('hide');
                    location.reload();
                },
                error: function () {
                    alert('Hubo un error al guardar los cambios.');
                }
            });
        });
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); 
            var serial = button.data('id'); 

            var modal = $(this);
            modal.find('#serial').val(serial); 
        });

    </script>
    <script>
       $('#BackupForm').on('submit', function (event) {
    event.preventDefault();
    var formData = $(this).serialize();

    $.ajax({
        url: 'agregar_backup.php',
        type: 'POST',
        data: formData,
        success: function (response) {
            alert('Backup registrado correctamente');
            $('#BackupModal').modal('hide');
            location.reload();
        },
        error: function () {
            alert('Hubo un error al guardar el cambio.');
        }
    });
});

        $('#BackupModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); 
            var serial = button.data('id'); 

            var modal = $(this);
            modal.find('#serial').val(serial); 
        });

    </script>
</body>

</html>