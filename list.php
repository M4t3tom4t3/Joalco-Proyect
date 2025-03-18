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
    <meta name="viewport" content="width=device-width, initial-scale=0.8, maximum-scale=1, user-scalable=no">
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
                    <a href="mantenimiento.php" class="sidebar-link">
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
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="content px-3 py-4">
                <div class="container-fluid">
                    <div class="mb-3">
                        <h3 class="fw-bold fs-4 mb-3">Usuarios</h3>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <form class="d-flex" role="search" method="get" action="list.php">
                                <input class="form-control me-2" type="search"
                                    placeholder="Buscar por Nombre o Departamento" aria-label="Search" name="search"
                                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                <button class="btn btn-outline-primary" type="submit">Buscar</button>
                            </form>
                            <a href="list.php" class="btn btn-outline-success me-md-2">
                                ⟳
                            </a>
                            <a href="agregar_usuario.php" class="btn btn-success me-md-2">Agregar</a>
                            <a href="agregar_firma.php" class="btn btn-warning me-md-2">Firma</a>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr class="highlight">
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Apellido</th>
                                            <th scope="col">Cargo</th>
                                            <th scope="col">Area</th>
                                            <th scope="col">Ciudad</th>
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

                                        $sql = "SELECT ID_usuario, nombre, apellido, cargo, departamento, ciudad FROM usuarios WHERE nombre LIKE ? OR departamento LIKE ? LIMIT $start_from, $results_per_page";
                                        $stmt = $conn->prepare($sql);
                                        $search_term = "%" . $search . "%";
                                        $stmt->bind_param("ss", $search_term, $search_term);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['apellido']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['cargo']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['departamento']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['ciudad']) . "</td>";
                                                echo "<td>
                                                <button class='btn btn-warning btn-sm edit-btn' data-id='" . $row['ID_usuario'] . "' data-bs-toggle='modal' data-bs-target='#editModal'>
                                                <i class='lni lni-pencil'></i> Editar
                                                </button>
                                                </td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='5' class='text-center'>No hay usuarios registrados</td></tr>";
                                        }

                                        $sql = "SELECT COUNT(*) AS total FROM usuarios WHERE nombre LIKE ? OR departamento LIKE ?";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bind_param("ss", $search_term, $search_term);
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


                                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Editar Usuario</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editUserForm">
                                                    <input type="hidden" id="userId" name="ID_usuario" />
                                                    <div class="mb-3">
                                                        <label for="nombre" class="form-label">Nombre</label>
                                                        <input type="text" class="form-control" id="nombre"
                                                            name="nombre" required />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="apellido" class="form-label">Apellido</label>
                                                        <input type="text" class="form-control" id="apellido"
                                                            name="apellido" required />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="cargo" class="form-label">Cargo</label>
                                                        <input type="text" class="form-control" id="cargo"
                                                            name="cargo" />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="departamento"
                                                            class="form-label">Departamento</label>
                                                        <input type="text" class="form-control" id="departamento"
                                                            name="departamento" />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="ciudad" class="form-label">Ciudad</label>
                                                        <input type="text" class="form-control" id="ciudad"
                                                            name="ciudad" />
                                                    </div>
                                                    <button type="submit" class="btn btn-success">Guardar
                                                        Cambios</button>
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
        $(document).on('click', '.edit-btn', function () {
            var userId = $(this).data('id');

            $.ajax({
                url: 'obtener_usuario.php',
                type: 'GET',
                data: { ID_usuario: userId },
                success: function (response) {
                    var data = JSON.parse(response);

                    $('#userId').val(data.ID_usuario);
                    $('#nombre').val(data.nombre);
                    $('#apellido').val(data.apellido);
                    $('#cargo').val(data.cargo);
                    $('#departamento').val(data.departamento);
                    $('#ciudad').val(data.ciudad);

                },
                error: function () {
                    alert('Hubo un error al obtener los datos del usuario.');
                }
            });
        });

        $('#editUserForm').on('submit', function (event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: 'actualizar_usuario.php',
                type: 'POST',
                data: formData,
                success: function (response) {
                    alert('Datos actualizados correctamente');
                    $('#editModal').modal('hide');
                    location.reload();
                },
                error: function () {
                    alert('Hubo un error al actualizar los datos.');
                }
            });
        });

    </script>

</body>

</html>