<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: inicio.html");
    exit();
}

include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $serial = $_POST['serial'];
    $placa = $_POST['placa'];
    $hv = $_POST['hv'];

    $sql_check = "SELECT * FROM equipos WHERE serial = ? OR placa = ? OR hv = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ssi", $serial, $placa, $hv); 
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "<script>alert('El Serial, la Placa o la Hoja de Vida ya están registrados en la base de datos. Por favor, verifique los datos.'); window.location.href = 'agregar_equipo.php';</script>";
        exit;
    }
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $nombre_equipo = $_POST['nombre_equipo'];
    $estado = $_POST['estado'];
    $fecha_compra = $_POST['fecha_compra'];
    $costo = $_POST['costo'];
    $activo_fijo = isset($_POST['activo_fijo']) && $_POST['activo_fijo'] ? $_POST['activo_fijo'] : null;
    $ip_lan = isset($_POST['ip_lan']) && $_POST['ip_lan'] ? $_POST['ip_lan'] : null;
    $ip_wlan = isset($_POST['ip_wlan']) && $_POST['ip_wlan'] ? $_POST['ip_wlan'] : null;
    $usuario_dominio = isset($_POST['usuario_dominio']) && $_POST['usuario_dominio'] ? $_POST['usuario_dominio'] : null;
    $hv = isset($_POST['hv']) && $_POST['hv'] ? $_POST['hv'] : null;
    $sistema_operativo = isset($_POST['sistema_operativo']) && $_POST['sistema_operativo'] ? $_POST['sistema_operativo'] : null;
    $ram = isset($_POST['ram']) && $_POST['ram'] ? $_POST['ram'] : null;
    $disco = isset($_POST['disco']) && $_POST['disco'] ? $_POST['disco'] : null;
    $procesador = isset($_POST['procesador']) && $_POST['procesador'] ? $_POST['procesador'] : null;
    $num_factura = isset($_POST['num_factura']) && $_POST['num_factura'] ? $_POST['num_factura'] : null;
    $num_pedido = isset($_POST['num_pedido']) && $_POST['num_pedido'] ? $_POST['num_pedido'] : null;
    $host_name = isset($_POST['host_name']) && $_POST['host_name'] ? $_POST['host_name'] : null;
    $mac_lan = isset($_POST['mac_lan']) && $_POST['mac_lan'] ? $_POST['mac_lan'] : null;
    $mac_wlan = isset($_POST['mac_wlan']) && $_POST['mac_wlan'] ? $_POST['mac_wlan'] : null;
    $licencia_w = isset($_POST['licencia_w']) && $_POST['licencia_w'] ? $_POST['licencia_w'] : null;
    $paquete_of = isset($_POST['paquete_of']) && $_POST['paquete_of'] ? $_POST['paquete_of'] : null;
    $correo = isset($_POST['correo']) && $_POST['correo'] ? $_POST['correo'] : null;


    if (isset($_FILES['ruta_img']) && $_FILES['ruta_img']['error'] == 0) {
        $target_dir = "Equipos/";
        $target_file = $target_dir . basename($_FILES["ruta_img"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["ruta_img"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["ruta_img"]["tmp_name"], $target_file)) {
                $ruta_img = $target_file;
            } else {
                echo "Lo siento, hubo un error al subir el archivo.";
                exit;
            }
        } else {
            echo "El archivo no es una imagen válida.";
            exit;
        }
    } else {
        $ruta_img = null; 
    }

    if ($ruta_img === null) {
        $ruta_img = "NULL"; 
    } else {
        $ruta_img = "'$ruta_img'"; 
    }

    $sql = "INSERT INTO equipos (
            serial, marca, modelo, nombre_equipo, placa, activo_fijo, estado, 
            ip_lan, ip_wlan, usuario_dominio, hv, sistema_operativo, ram, disco, 
            procesador, fecha_compra, costo, ruta_img, num_factura, num_pedido, 
            host_name, mac_lan, mac_wlan, licencia_w, paquete_of, correo
        ) VALUES (
            '$serial', '$marca', '$modelo', '$nombre_equipo', '$placa', '$activo_fijo', 
            '$estado', '$ip_lan', '$ip_wlan', '$usuario_dominio', '$hv', 
            '$sistema_operativo', '$ram', '$disco', '$procesador', '$fecha_compra', 
            '$costo', $ruta_img, '$num_factura', '$num_pedido', '$host_name', 
            '$mac_lan', '$mac_wlan', '$licencia_w', '$paquete_of', '$correo'
        )";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Equipo agregado exitosamente.'); window.location.href = 'list_eq.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $serial = $_POST['serial'];
    $placa = $_POST['placa'];
    $hv = $_POST['hv'];

    $sql = "SELECT * FROM equipos WHERE serial = ? OR placa = ? OR hv = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $serial, $placa, $hv);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error_message = "El Serial, la Placa o la Hoja de Vida ya están registrados en la base de datos. Por favor, verifique los datos.";
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
                        <h3 class="fw-bold fs-4 mb-3">Agregar Equipo</h3>
                        <div class="row">
                            <div class="container mt-4">
                                <form action="agregar_equipo.php" class="needs-validation" method="POST" enctype="multipart/form-data" id="formEquipo">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="serial" class="form-label">Serial</label>
                                            <input type="text" class="form-control" id="serial" name="serial" required onblur="validarSerial()">
                                            <div class="invalid-feedback">Este número de serie ya está registrado.</div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="marca" class="form-label">Marca</label>
                                            <input type="text" class="form-control" id="marca" name="marca" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="modelo" class="form-label">Modelo</label>
                                            <input type="text" class="form-control" id="modelo" name="modelo" required>
                                        </div>
                                    </div>
                                    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="nombre_equipo" class="form-label">Nombre del Equipo</label>
                                            <input type="text" class="form-control" id="nombre_equipo"
                                                name="nombre_equipo" placeholder="PORTATIL-PC-MOUSE" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="placa" class="form-label">Placa</label>
                                            <input type="text" class="form-control" id="placa" name="placa" placeholder="XXX-0000" required onblur="validarPlaca()">
                                            <div class="invalid-feedback">Esta placa ya está registrada.</div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="activo_fijo" class="form-label">Activo Fijo</label>
                                            <input type="number" class="form-control" id="activo_fijo" name="activo_fijo">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="estado" class="form-label">Estado</label>
                                            <select class="form-control" id="estado" name="estado" required>
                                                <option value="" disabled selected>Seleccione un estado</option>
                                                <option value="DE BAJA">DE BAJA</option>
                                                <option value="ACTIVO">ACTIVO</option>
                                                <option value="BODEGA">BODEGA</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="ip_lan" class="form-label">IP LAN</label>
                                            <input type="text" class="form-control" id="ip_lan" name="ip_lan" placeholder="XXX.XXX.XX.XXX">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="ip_wlan" class="form-label">IP WLAN</label>
                                            <input type="text" class="form-control" id="ip_wlan" name="ip_wlan" placeholder="XXX.XXX.XX.XXX">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="usuario_dominio" class="form-label">Usuario Dominio</label>
                                            <input type="text" class="form-control" id="usuario_dominio"
                                                name="usuario_dominio">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="hv" class="form-label">Hoja de Vida</label>
                                            <input type="number" class="form-control" id="hv" name="hv" onblur="validarHv()">
                                            <div class="invalid-feedback">Esta hoja de vida ya está registrada.</div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="sistema_operativo" class="form-label">Sistema Operativo</label>
                                            <input type="text" class="form-control" id="sistema_operativo"
                                                name="sistema_operativo" placeholder="WINDOWS">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="ram" class="form-label">RAM</label>
                                            <input type="number" class="form-control" id="ram" name="ram">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="disco" class="form-label">Disco Duro</label>
                                            <input type="text" class="form-control" id="disco" name="disco" placeholder="X TB *TIPO DISCO*">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="procesador" class="form-label">Procesador</label>
                                            <input type="text" class="form-control" id="procesador" name="procesador">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="fecha_compra" class="form-label">Fecha de Compra</label>
                                            <input type="date" class="form-control" id="fecha_compra"
                                                name="fecha_compra">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="costo" class="form-label">Costo</label>
                                            <input type="number" class="form-control" id="costo" name="costo">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for=" num_factura" class="form-label">Numero de Factura</label>
                                            <input type="text" class="form-control" id="num_factura" name="num_factura">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="num_pedido" class="form-label">Numero de Pedido</label>
                                            <input type="number" class="form-control" id="num_pedido" name="num_pedido">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="host_name" class="form-label">Host Name</label>
                                            <input type="text" class="form-control" id="host_name" name="host_name">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for=" mac_lan" class="form-label">MAC LAN</label>
                                            <input type="text" class="form-control" id="mac_lan" name="mac_lan" placeholder="XX-XX-XX-XX-XX-XX">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="mac_wlan" class="form-label">MAC WLAN</label>
                                            <input type="text" class="form-control" id="mac_wlan" name="mac_wlan" placeholder="XX-XX-XX-XX-XX-XX">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="licencia_w" class="form-label">Licencia Windows</label>
                                            <input type="text" class="form-control" id="licencia_w" name="licencia_w">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for=" paquete_of" class="form-label">Paquete Oficce</label>
                                            <input type="text" class="form-control" id="paquete_of" name="paquete_of">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="correo" class="form-label">Correo: </label>
                                            <input type="text" class="form-control" id="correo" name="correo" placeholder="xxxxxxx@transjoal.com.co">
                                        </div>
                                        
                                    </div>

                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Imagen del Equipo</label>
                                        <input class="form-control" type="file" id="formFile" name="ruta_img">
                                    </div>

                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                    <a href="list_eq.php" class="btn btn-success me-md-2">Regresar</a>
                                </form>
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
    function validarCaracteres(event) {
        const input = event.target;
        const regex = /^[a-zA-Z0-9-_\.@ ]*$/;

        
        if (!regex.test(input.value)) {
            input.value = input.value.replace(/[^a-zA-Z0-9-_\.@]/g, ''); 
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        let inputs = document.querySelectorAll('#formEquipo input[type="text"]'); 
        inputs.forEach(input => {
            input.addEventListener('input', validarCaracteres); 
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nombreEquipoInput = document.getElementById('nombre_equipo');
        
        const camposAHabilitar = [
            'ram',
            'hv',
            'usuario_dominio',
            'ip_lan',
            'ip_wlan',
            'sistema_operativo',
            'disco',
            'procesador',
            'num_factura',
            'num_pedido',
            'host_name',
            'mac_lan',
            'mac_wlan',
            'licencia_w',
            'paquete_of',
            'correo'
        ];

        function toggleFields() {
            const nombreEquipo = nombreEquipoInput.value.toUpperCase();

            if (nombreEquipo !== "PORTATIL" && nombreEquipo !== "PC") {
                camposAHabilitar.forEach(field => {
                    const campo = document.getElementById(field);
                    if (campo) {
                        campo.disabled = true;
                    }
                });
            } else {
                camposAHabilitar.forEach(field => {
                    const campo = document.getElementById(field);
                    if (campo) {
                        campo.disabled = false;
                    }
                });
            }
        }

        nombreEquipoInput.addEventListener('input', toggleFields);

        toggleFields();
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const costoInput = document.getElementById('costo');
        const activoFijoInput = document.getElementById('activo_fijo');

        function toggleActivoFijo() {
            const costoValue = parseFloat(costoInput.value);

            if (costoValue > 2847000) {
                activoFijoInput.disabled = false; 
            } else {
                activoFijoInput.disabled = true; 
            }
        }

        costoInput.addEventListener('input', toggleActivoFijo);

        toggleActivoFijo();
    });
</script>
<script>
function validarSerial() {
    let serialInput = document.getElementById("serial");
    let serial = serialInput.value;

    if (serial.trim() === "") return;

    fetch("validar_serial.php?serial=" + serial)
        .then(response => response.json())
        .then(data => {
            if (data.existe) {
                serialInput.classList.add("is-invalid");
                serialInput.classList.remove("is-valid");
            } else {
                serialInput.classList.add("is-valid");
                serialInput.classList.remove("is-invalid");
            }
        })
        .catch(error => console.error("Error en la validación:", error));
}
</script>
<script>
function validarPlaca() {
    let placaInput = document.getElementById("placa");
    let placa = placaInput.value;

    if (placa.trim() === "") return;

    fetch("validar_placa.php?placa=" + placa)
        .then(response => response.json())
        .then(data => {
            if (data.existe) {
                placaInput.classList.add("is-invalid");
                placaInput.classList.remove("is-valid");
            } else {
                placaInput.classList.add("is-valid");
                placaInput.classList.remove("is-invalid");
            }
        })
        .catch(error => console.error("Error en la validación:", error));
}
</script>
<script>
function validarHv() {
    let hvInput = document.getElementById("hv");
    let hv = hvInput.value;

    if (hv.trim() === "") return;

    fetch("validar_hv.php?hv=" + hv)
        .then(response => response.json())
        .then(data => {
            if (data.existe) {
                hvInput.classList.add("is-invalid");
                hvInput.classList.remove("is-valid");
            } else {
                hvInput.classList.add("is-valid");
                hvInput.classList.remove("is-invalid");
            }
        })
        .catch(error => console.error("Error en la validación:", error));
}
</script>

</body>

</html>