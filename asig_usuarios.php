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
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

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
                        <span>Mantenimiento
                        </span>
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
                        <h3 class="fw-bold fs-4 mb-3">Asignacion De Usuarios</h3>
                        <div class="row">

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <form class="d-flex" role="search" method="get" action="asig_usuarios.php">
                                    <input class="form-control me-2" type="search"
                                        placeholder="Buscar Nombre, Departamento O Consecutivo" aria-label="Search" name="search"
                                        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                    <button class="btn btn-outline-primary" type="submit">Buscar</button>
                                </form>
                                <a href="asig_usuarios.php" class="btn btn-outline-success me-md-2">
                                    ⟳
                                </a>
                                <a href="agregar_asignacion.php" class="btn btn-success me-md-2">Agregar</a>
                            </div>
                        </div>

                        </h3>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr class="highlight">
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Apellido</th>
                                            <th scope="col">Cargo</th>
                                            <th scope="col">Area</th>
                                            <th scope="col">Equipo</th>
                                            <th scope="col">N° Carta</th>
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
                            
                                        // Verificar la conexión
                                        if ($conn->connect_error) {
                                            die("Conexión fallida: " . $conn->connect_error);
                                        }

                                        $results_per_page = 7;

                                        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
                                            $page = $_GET['page'];
                                        } else {
                                            $page = 1;
                                        }

                                        $start_from = ($page - 1) * $results_per_page;

                                        $search = isset($_GET['search']) ? $_GET['search'] : '';

                                        $sql = "SELECT 
                                            u.ID_usuario, u.nombre, u.apellido, u.cargo, u.departamento, 
                                            e.serial, e.nombre_equipo, a.numero_consecutivo, e.estado AS estado_equipo
                                            FROM usuarios u
                                            LEFT JOIN asignacion a ON u.ID_usuario = a.FK_id
                                            LEFT JOIN equipos e ON a.FK_serial = e.serial
                                             WHERE (u.nombre LIKE ? OR u.departamento LIKE ?) 
                                            AND (e.nombre_equipo = 'PC' OR e.nombre_equipo = 'PORTATIL')
                                            AND a.estado_asig = 'ACTIVO' 
                                            LIMIT $start_from, $results_per_page";
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
                                                echo "<td>" . htmlspecialchars($row['nombre_equipo']) . "</td>";
                                                echo "<td> A-" . htmlspecialchars($row['numero_consecutivo']) . "</td>";
                                                echo "<td>
                                                 <a href='#' class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#exampleModal' data-id='" . $row['ID_usuario'] . "'>
                                                 <i class='lni lni-pencil'></i>
                                                 </a>
                                                 
                                                 <a href='pdf.php?id=" . $row['ID_usuario'] . "' class='btn btn-warning btn-sm edit-btn'>
                                                 <i class='lni lni-download'></i>
                                                 </a>

                                                 <a href='#' class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#detallesModal' data-serial='" . $row['serial'] . "'>
                                                <i class='lni lni-eye'></i>
                                                </a>
                                                 </td>";
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
                                        <div class="modal fade" id="detallesModal" tabindex="-1"
                                        aria-labelledby="detallesModal" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="detallesModal">Detalles</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" id="detallesModal" aria-hidden="true" inert>
                                                    <div><strong>Activo Fijo:</strong> <span id="activo_fijo"></span>
                                                    </div>
                                                    <div><strong>Estado:</strong> <span id="estado"></span></div>
                                                    <div><strong>IP LAN:</strong> <span id="ip_lan"></span></div>
                                                    <div><strong>IP WLAN:</strong> <span id="ip_wlan"></span></div>
                                                    <div><strong>Usuario Dominio:</strong> <span
                                                            id="usuario_dominio"></span></div>
                                                    <div><strong>Hoja De Vida:</strong> <span id="hv"></span></div>
                                                    <div><strong>Correo:</strong> <span id="correo"></span></div>
                                                    <div><strong>Sistema Operativo:</strong> <span
                                                            id="sistema_operativo"></span></div>
                                                    <div><strong>Ram:</strong> <span id="ram"></span> GB</div>
                                                    <div><strong>Disco Duro:</strong> <span id="disco"></span></div>
                                                    <div><strong>Procesador:</strong> <span id="procesador"></span>
                                                    </div>
                                                    <div><strong>Fecha De Compra:</strong> <span
                                                            id="fecha_compra"></span></div>
                                                    <div><strong>Costo:</strong> <span id="costo"></span></div>
                                                    <div><strong>Host:</strong> <span id="host_name"></span></div>
                                                    <div><strong>MAC LAN:</strong> <span id="mac_lan"></span></div>
                                                    <div><strong>MAC WLAN:</strong> <span id="mac_wlan"></span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </tbody>
                                </table>
                                <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <!-- Botón para ir a la primera página -->
        <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
            <a class="page-link" href="?page=1&search=<?php echo urlencode($search); ?>" aria-label="First">
                <span aria-hidden="true">&laquo;&laquo;</span>
            </a>
        </li>

        <!-- Botón para ir a la página anterior -->
        <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
            <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>"
                aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>

        <?php
        // Mostrar un rango limitado de páginas, por ejemplo, 5 páginas alrededor de la actual
        $range = 2; // Número de páginas a mostrar antes y después de la página actual
        $start = max(1, $page - $range); // Asegurarse de que la página de inicio no sea menor que 1
        $end = min($total_pages, $page + $range); // Asegurarse de que la página final no sea mayor que el total de páginas
        
        for ($i = $start; $i <= $end; $i++) {
            echo "<li class='page-item " . ($i == $page ? 'active' : '') . "'>
                <a class='page-link' href='?page=$i&search=" . urlencode($search) . "'>$i</a>
            </li>";
        }
        ?>

        <!-- Botón para ir a la página siguiente -->
        <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
            <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>"
                aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>

        <!-- Botón para ir a la última página -->
        <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
            <a class="page-link" href="?page=<?php echo $total_pages; ?>&search=<?php echo urlencode($search); ?>"
                aria-label="Last">
                <span aria-hidden="true">&raquo;&raquo;</span>
            </a>
        </li>
    </ul>
</nav>

                                <div class="modal fade" id="exampleModal" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Detalles de Asignación
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="modalContent">
                                                </div>
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
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var userId = button.data('id');
            $.ajax({
                url: 'obtener_asignacion.php',
                type: 'POST',
                data: { id_usuario: userId },
                success: function (response) {
                    $('#modalContent').html(response);
                },
                error: function () {
                    $('#modalContent').html('<p>Error al cargar los datos.</p>');
                }
            });
        });
        function cambiarEstado(serial_equipo, id_usuario) {
            // Realizamos la solicitud AJAX para cambiar el estado a INACTIVO
            $.ajax({
                url: 'obtener_asignacion.php', // Mismo archivo
                method: 'POST',
                data: {
                    serial_equipo: serial_equipo,
                    id_usuario: id_usuario,
                    estado: 'INACTIVO' // Agregar el estado
                },
                success: function (response) {
                    try {
                        var data = JSON.parse(response);
                        if (data.success) {
                            $("#estado_" + serial_equipo).text("INACTIVO");
                            alert(data.message);
                        } else {
                            alert(data.message);
                        }
                    } catch (e) {
                        console.error("Error al parsear la respuesta JSON:", e);
                        alert("Hubo un problema con la respuesta del servidor.");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", error);
                    alert("Hubo un problema al cambiar el estado.");
                }
            });
        }

        function cambiarEstadoActivo(serial_equipo, id_usuario) {
            // Realizamos la solicitud AJAX para cambiar el estado a ACTIVO
            $.ajax({
                url: 'obtener_asignacion.php', // Mismo archivo
                method: 'POST',
                data: {
                    serial_equipo: serial_equipo,
                    id_usuario: id_usuario,
                    estado: 'ACTIVO' // Agregar el estado
                },
                success: function (response) {
                    try {
                        var data = JSON.parse(response);
                        if (data.success) {
                            $("#estado_" + serial_equipo).text("ACTIVO");
                            alert(data.message);
                        } else {
                            alert(data.message);
                        }
                    } catch (e) {
                        console.error("Error al parsear la respuesta JSON:", e);
                        alert("Hubo un problema con la respuesta del servidor.");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", error);
                    alert("Hubo un problema al cambiar el estado.");
                }
            });
        }
        function eliminarAsignacion(serial_equipo, id_usuario) {
            if (confirm("¿Estás seguro de que deseas eliminar esta asignación?")) {
                var data = new FormData();
                data.append('serial_equipo', serial_equipo);
                data.append('id_usuario', id_usuario);
                data.append('accion', 'eliminar');

                fetch('obtener_asignacion.php', {
                    method: 'POST',
                    body: data
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            location.reload(); // Recarga la página para mostrar los cambios
                        } else {
                            alert("Error: " + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Hubo un problema con la solicitud.');
                    });
            }
        }


    </script>
    <script>
        $(document).ready(function() {
    // Mostrar detalles del equipo cuando se hace clic en el icono de ojo
    $('#detallesModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var serial = button.data('serial'); // Obtener el serial del equipo
        var modal = $(this);

        // Verificar si el serial está presente
        if (serial) {
            // Llamar al servidor para obtener detalles del equipo por serial
            $.ajax({
                url: 'obtener_detalles.php',  // Archivo PHP que devolverá los detalles
                method: 'POST',
                data: { serial: serial },  // Enviar el serial en el POST
                success: function(data) {
                    var response = JSON.parse(data);  // Parsear la respuesta JSON

                    if (response.error) {
                        alert(response.error);  // Si hay un error, mostrarlo
                    } else {
                        // Rellenar los campos del modal con los datos del equipo
                        modal.find('#activo_fijo').text(response.activo_fijo);
                        modal.find('#estado').text(response.estado);
                        modal.find('#ip_lan').text(response.ip_lan);
                        modal.find('#ip_wlan').text(response.ip_wlan);
                        modal.find('#usuario_dominio').text(response.usuario_dominio);
                        modal.find('#hv').text(response.hv);
                        modal.find('#correo').text(response.correo);
                        modal.find('#sistema_operativo').text(response.sistema_operativo);
                        modal.find('#ram').text(response.ram);
                        modal.find('#disco').text(response.disco);
                        modal.find('#procesador').text(response.procesador);
                        modal.find('#fecha_compra').text(response.fecha_compra);
                        modal.find('#costo').text(response.costo);
                        modal.find('#host_name').text(response.host_name);
                        modal.find('#mac_lan').text(response.mac_lan);
                        modal.find('#mac_wlan').text(response.mac_wlan);
                    }
                },
                error: function() {
                    alert('Error al cargar los detalles del equipo.');
                }
            });
        } else {
            alert('No se pudo obtener el serial del equipo.');
        }
    });
});

    </script>
</body>

</html>