<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: inicio.html");
    exit();
}

include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cargo = $_POST['cargo'];
    $departamento = $_POST['departamento'];
    $ciudad = $_POST['ciudad'];

    $sql = "INSERT INTO usuarios (nombre, apellido, cargo, departamento, ciudad)
            VALUES ('$nombre','$apellido', '$cargo', '$departamento','$ciudad')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Usuario agregado exitosamente.'); window.location.href = 'list.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Equipo</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        <h3 class="fw-bold fs-4 mb-3">Agregar Usuarios</h3>
                        <div class="row">
                            <div class="container mt-4">
                                <form action="agregar_usuario.php" method="POST" id="formUsuario">
                                    <div class="mb-3">
                                        <label for="marca" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="PRIMER NOMBRE" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="marca" class="form-label">Apellido</label>
                                        <input type="text" class="form-control" id="apellido" name="apellido" placeholder="PRIMER APELLIDO" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="modelo" class="form-label">Cargo</label>
                                        <input type="text" class="form-control" id="cargo" name="cargo" required>
                                    </div>
                                    <div class="mb-3">
    <label for="departamento" class="form-label">Área</label>
    <select class="form-control" id="departamento" name="departamento" required>
        <option value="" disabled selected>Selecciona un área</option>
        <option value="sistemas">Sistemas</option>
        <option value="operaciones_carga_liquida">Operaciones Carga Líquida</option>
        <option value="operaciones_carga_seca">Operaciones Carga Seca</option>
        <option value="combustibles">Combustibles</option>
        <option value="costos">Costos</option>
        <option value="flota_propia">Flota Propia</option>
        <option value="recursos_humanos">Recursos Humanos</option>
        <option value="administrativo">Administrativo</option>
        <option value="gerencia">Gerencia</option>
        <option value="juridico">Jurídico</option>
        <option value="comercial">Comercial</option>
        <option value="contabilidad">Contabilidad</option>
        <option value="compras">Compras</option>
        <option value="almacen">Almacén</option>
        <option value="mantenimiento">Mantenimiento</option>
        <option value="cumplidos">Cumplidos</option>
        <option value="obra">Obra</option>
    </select>
</div>

<div class="mb-3">
    <label for="ciudad" class="form-label">Ciudad</label>
    <select class="form-control" id="ciudad" name="ciudad" required>
        <option value="" disabled selected>Selecciona una ciudad</option>
        <option value="bogota">Bogotá</option>
        <option value="cartagena">Cartagena</option>
        <option value="yumbo">Yumbo</option>
        <option value="buenaventura">Buenaventura</option>
        <option value="barranquilla">Barranquilla</option>
        <option value="itagui">Itagüí</option>
    </select>
</div>


                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                    <a href="list.php" class="btn btn-success me-md-2">Regresar</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script>
    
    function validarCaracteres(event) {
        const input = event.target;
        
        const regex = /^[a-zA-Z0-9-_\.@ ]*$/;

        
        if (!regex.test(input.value)) {
            input.value = input.value.replace(/[^a-zA-Z0-9-_\.@]/g, '');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        let inputs = document.querySelectorAll('#formUsuario input[type="text"]');
        inputs.forEach(input => {
            input.addEventListener('input', validarCaracteres); 
        });
    });
</script>
</body>

</html>