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
                        <h3 class="fw-bold fs-4 mb-3">Equipos</h3>
                        <div class="row">
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <form class="d-flex" role="search" method="get" action="list_eq.php">
                                <input class="form-control me-2" type="search" placeholder="Placa, Serial o Equipo"
                                    aria-label="Search" name="search"
                                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                <button class="btn btn-outline-primary" type="submit">Buscar</button>
                            </form>
                            <a href="list_eq.php" class="btn btn-outline-success me-md-2">
                                ⟳
                            </a>
                            <a href="agregar_equipo.php" class="btn btn-success me-md-2">Agregar</a>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr class="highlight">

                                            <th scope="col">Serial</th>
                                            <th scope="col">Marca</th>
                                            <th scope="col">Modelo</th>
                                            <th scope="col">Equipo</th>
                                            <th scope="col">Placa</th>
                                            <th scope="col">Imagen</th>
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

                                        $sql = "SELECT serial, marca, modelo, nombre_equipo, placa, activo_fijo, ruta_img FROM equipos WHERE placa LIKE ? OR serial LIKE ? OR nombre_equipo LIKE ? LIMIT $start_from, $results_per_page";
                                        $stmt = $conn->prepare($sql);
                                        $search_term = "%" . $search . "%";
                                        $stmt->bind_param("sss", $search_term, $search_term, $search_term);
                                        $stmt->execute();

                                        $result = $stmt->get_result();

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $ruta_img = htmlspecialchars($row['ruta_img']);
                                                $serial = htmlspecialchars($row['serial']);
                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($row['serial']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['marca']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['modelo']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['nombre_equipo']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['placa']) . "</td>";
                                                echo "<td>";
                                                if (!empty($ruta_img)) {
                                                    echo "<a href='$ruta_img' target='_blank'>";
                                                    echo "<img src='$ruta_img' alt='Imagen del equipo' style='width: 100px; height: 75px;'>";
                                                    echo "</a>";
                                                } else {
                                                    echo "No imagen disponible";
                                                }

                                                echo "<td>
                                                <button class='btn btn-warning btn-sm edit-btn' data-serial='" . $serial . "' data-bs-toggle='modal' data-bs-target='#editModal'>
                                                <i class='lni lni-pencil'></i> 
                                                </button>
                                                <a href='#' class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#exampleModal' data-serial='" . $serial . "'><i class='lni lni-eye'></i></a>
                                                
                                                <button class='btn btn-success btn-sm edit-btn' onclick=\"window.location.href='subir_imagen.php?serial=" . $serial . "'\">
                                                <i class='lni lni-folder'></i> 
                                                </button>";
                                                if ($_SESSION['rol'] == 'admin') {
                                                    echo "<button class='btn btn-danger btn-sm delete-btn' data-serial='" . $serial . "'>
                                                            <i class='bi bi-trash'></i>
                                                          </button>";
                                                }
                                    
                                                echo "</td>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='5' class='text-center'>No hay equipos registrados</td></tr>";
                                        }
                                        $sql = "SELECT COUNT(*) AS total FROM equipos WHERE placa LIKE ? OR nombre_equipo LIKE ?";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bind_param("ss", $search_term, $search_term);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $row = $result->fetch_assoc();
                                        $total_results = $row['total'];

                                        $total_pages = ceil($total_results / $results_per_page);

                                        ?>
                                    </tbody>

                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detalles</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" id="exampleModal" aria-hidden="true" inert>
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
                                    <div class="modal fade" id="editModal" tabindex="-1"
                                        aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="editModalLabel">Editar Equipo</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editEquipoForm" enctype="multipart/form-data" id="formEditar">
                                                        <input type="hidden" id="serial" name="serial">

                                                        <div class="mb-3">
                                                            <label for="poliza" class="form-label">Poliza</label>
                                                            <input type="text" class="form-control" id="polizax"
                                                                name="polizax">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="marca" class="form-label">Marca</label>
                                                            <input type="text" class="form-control" id="marca"
                                                                name="marca">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="modelo" class="form-label">Modelo</label>
                                                            <input type="text" class="form-control" id="modelo"
                                                                name="modelo">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="nombre_equipo" class="form-label">Equipo</label>
                                                            <input type="text" class="form-control" id="nombre_equipo"
                                                                name="nombre_equipo">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="placa" class="form-label">Placa</label>
                                                            <input type="text" class="form-control" id="placa"
                                                                name="placa">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="activo_fijo" class="form-label">Activo
                                                                Fijo</label>
                                                            <input type="text" class="form-control" id="activo_fijox"
                                                                name="activo_fijox">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="estado" class="form-label">Estado</label>
                                                            <input type="text" class="form-control" id="estadox"
                                                                name="estadox">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="ip_lan" class="form-label">IP LAN</label>
                                                            <input type="text" class="form-control" id="ip_lanx"
                                                                name="ip_lanx">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="ip_lan" class="form-label">IP WLAN</label>
                                                            <input type="text" class="form-control" id="ip_wlanx"
                                                                name="ip_wlanx">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="ip_lan" class="form-label">Usuario
                                                                Dominio</label>
                                                            <input type="text" class="form-control"
                                                                id="usuario_dominiox" name="usuario_dominiox">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="ip_lan" class="form-label">HOJA DE VIDA</label>
                                                            <input type="text" class="form-control" id="hvx" name="hvx">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="ip_lan" class="form-label">SISTEMA
                                                                OPERATIVO</label>
                                                            <input type="text" class="form-control"
                                                                id="sistema_operativox" name="sistema_operativox">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="ip_lan" class="form-label">RAM</label>
                                                            <input type="text" class="form-control" id="ramx"
                                                                name="ramx">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="ip_lan" class="form-label">DISCO DURO</label>
                                                            <input type="text" class="form-control" id="discox"
                                                                name="discox">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="ip_lan" class="form-label">PROCESADOR</label>
                                                            <input type="text" class="form-control" id="procesadorx"
                                                                name="procesadorx">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="ip_lan" class="form-label">FECHA DE
                                                                COMPRA</label>
                                                            <input type="date" class="form-control" id="fecha_comprax"
                                                                name="fecha_comprax">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="ip_lan" class="form-label">COSTO</label>
                                                            <input type="text" class="form-control" id="costox"
                                                                name="costox">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="ip_lan" class="form-label">NUMERO DE
                                                                FACTURA</label>
                                                            <input type="text" class="form-control" id="num_facturax"
                                                                name="num_facturax">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="ip_lan" class="form-label">NUMERO DE
                                                                PEDIDO</label>
                                                            <input type="text" class="form-control" id="num_pedidox"
                                                                name="num_pedidox">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="ip_lan" class="form-label">HOST NAME</label>
                                                            <input type="text" class="form-control" id="host_namex"
                                                                name="host_namex">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="ip_lan" class="form-label">MAC LAN</label>
                                                            <input type="text" class="form-control" id="mac_lanx"
                                                                name="mac_lanx">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="ip_lan" class="form-label">MAC WLAN</label>
                                                            <input type="text" class="form-control" id="mac_wlanx"
                                                                name="mac_wlanx">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="ip_lan" class="form-label">LICENCIA
                                                                WINDOWS</label>
                                                            <input type="text" class="form-control" id="licencia_wx"
                                                                name="licencia_wx">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="ip_lan" class="form-label">PAQUETE
                                                                OFFICE</label>
                                                            <input type="text" class="form-control" id="paquete_ofx"
                                                                name="paquete_ofx">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="ip_lan" class="form-label">CORREO</label>
                                                            <input type="text" class="form-control" id="correox"
                                                                name="correox">
                                                        </div>
                                                        <button type="submit" class="btn btn-success">Guardar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var serial = button.data('serial');

            $.ajax({
                url: 'obtener_equipo.php',
                type: 'GET',
                data: { serial: serial },
                success: function (response) {
                    console.log("Respuesta de PHP:", response);
                    try {
                        var data = JSON.parse(response);

                        if (data.error) {
                            alert(data.error);
                        } else {
                            console.log("Datos a llenar en el formulario:", data);
                            $('#serial').val(data.serial);
                            $('#marca').val(data.marca);
                            $('#modelo').val(data.modelo);
                            $('#nombre_equipo').val(data.nombre_equipo);
                            $('#placa').val(data.placa);
                            $('#activo_fijox').val(data.activo_fijo);
                            $('#estadox').val(data.estado);
                            $('#ip_lanx').val(data.ip_lan);
                            $('#ip_wlanx').val(data.ip_wlan);
                            $('#usuario_dominiox').val(data.usuario_dominio);
                            $('#hvx').val(data.hv);
                            $('#sistema_operativox').val(data.sistema_operativo);
                            $('#ramx').val(data.ram);
                            $('#discox').val(data.disco);
                            $('#procesadorx').val(data.procesador);
                            $('#fecha_comprax').val(data.fecha_compra);
                            $('#costox').val(data.costo);
                            $('#num_facturax').val(data.num_factura);
                            $('#num_pedidox').val(data.num_pedido);
                            $('#host_namex').val(data.host_name);
                            $('#mac_lanx').val(data.mac_lan);
                            $('#mac_wlanx').val(data.mac_wlan);
                            $('#licencia_wx').val(data.licencia_w);
                            $('#paquete_ofx').val(data.paquete_of);
                            $('#polizax').val(data.poliza);
                            $('#correox').val(data.correo);
                        }
                    } catch (e) {
                        console.log("Error al procesar la respuesta:", e);
                        alert('Error al procesar los detalles del equipo.');
                    }
                },
                error: function (xhr, status, error) {
                    console.log("Error AJAX:", error);
                    alert('Error al realizar la solicitud AJAX.');
                }
            });
        });

        $('#editEquipoForm').submit(function (e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: 'actualizar_equipo.php',
                type: 'POST',
                data: formData,
                success: function (response) {
                    console.log(response);


                    try {
                        var data = JSON.parse(response);

                        if (data.success) {
                            alert(data.success);
                            $('#editModal').modal('hide');
                            location.reload();
                        } else if (data.error) {
                            alert(data.error);
                        } else {
                            alert('Solicitud no válida');
                        }
                    } catch (e) {
                        console.log("Error al procesar la respuesta:", e);
                        alert('Error al procesar la respuesta del servidor.');
                    }
                },
                error: function (xhr, status, error) {
                    alert('Error al enviar los datos');
                }
            });
        });
    </script>
    <script>
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var serial = button.data('serial');
            console.log("Serial:", serial);

            $.ajax({
                url: 'obtener_detalles.php',
                type: 'POST',
                data: { serial: serial },
                success: function (response) {
                    console.log("Respuesta de PHP:", response);
                    try {
                        var data = JSON.parse(response);

                        if (data.error) {
                            alert(data.error);
                        } else {

                            $('#activo_fijo').text(data.activo_fijo);
                            $('#estado').text(data.estado);
                            $('#ip_lan').text(data.ip_lan);
                            $('#ip_wlan').text(data.ip_wlan);
                            $('#usuario_dominio').text(data.usuario_dominio);
                            $('#hv').text(data.hv);
                            $('#sistema_operativo').text(data.sistema_operativo);
                            $('#ram').text(data.ram);
                            $('#disco').text(data.disco);
                            $('#procesador').text(data.procesador);
                            $('#fecha_compra').text(data.fecha_compra);
                            $('#costo').text(data.costo);
                            $('#host_name').text(data.host_name);
                            $('#mac_lan').text(data.mac_lan);
                            $('#mac_wlan').text(data.mac_wlan);
                            $('#correo').text(data.correo);
                        }
                    } catch (e) {
                        console.log("Error al procesar la respuesta:", e);
                        alert('Error al procesar los detalles del equipo.');
                    }
                },
                error: function (xhr, status, error) {
                    console.log("Error AJAX:", error);
                    alert('Error al realizar la solicitud AJAX.');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.btn-upload-image').on('click', function () {
                var serial = $(this).data('serial'); 
                window.location.href = 'subir_imagen.php?serial=' + serial;
            });
        });
    </script>
    <script>

    function validarCaracteres(event) {
        const input = event.target;
        const regex = /^[a-zA-Z0-9-_\.@]*$/;

        if (!regex.test(input.value)) {
            input.value = input.value.replace(/[^a-zA-Z0-9-_\.@]/g, ''); 
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        let inputs = document.querySelectorAll('#formEditar input[type="text"]'); 
        inputs.forEach(input => {
            input.addEventListener('input', validarCaracteres);  
        });
    });
</script>
<script>

    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const serial = button.getAttribute('data-serial'); 

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esta acción!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminarlo',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'eliminar_equipo.php?serial=' + serial;
                    }
                });
            });
        });
    });
</script>

</body>
</html>