<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: inicio.html");
    exit();
}

include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $serial = $_POST['serial'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $nombre_equipo = $_POST['nombre_equipo'];
    $placa = $_POST['placa'];
    $activo_fijo = $_POST['activo_fijo'];
    $estado = $_POST['estado'];
    $ip_lan = $_POST['ip_lan'];
    $ip_wlan = $_POST['ip_wlan'];
    $usuario_dominio = $_POST['usuario_dominio'];
    $hv = $_POST['hv'];
    $sistema_operativo = $_POST['sistema_operativo'];
    $ram = $_POST['ram'];
    $disco = $_POST['disco'];
    $procesador = $_POST['procesador'];
    $fecha_compra = $_POST['fecha_compra'];
    $costo = $_POST['costo'];
    $num_factura = $_POST['num_factura'];
    $num_pedido = $_POST['num_pedido'];
    $host_name = $_POST['host_name'];
    $mac_lan = $_POST['mac_lan'];
    $mac_wlan = $_POST['mac_wlan'];
    $licencia_w = $_POST['licencia_w'];
    $paquete_of = $_POST['paquete_of'];
    $correo = $_POST['correo'];

    // Manejo del archivo de imagen
    if (isset($_FILES['ruta_img']) && $_FILES['ruta_img']['error'] == 0) {
        $target_dir = "Equipos/";
        $target_file = $target_dir . basename($_FILES["ruta_img"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Verificar si el archivo es una imagen (opcional)
        $check = getimagesize($_FILES["ruta_img"]["tmp_name"]);
        if ($check !== false) {
            // Intentar mover el archivo a la carpeta Equipos
            if (move_uploaded_file($_FILES["ruta_img"]["tmp_name"], $target_file)) {
                // Si el archivo se subió correctamente, almacenamos la ruta en la base de datos
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
        $ruta_img = null; // Si no se subió una imagen
    }

    // Comprobamos si ruta_img es NULL o una cadena vacía
    if ($ruta_img === null) {
        $ruta_img = "NULL"; // Si no se subió imagen, asignamos NULL
    } else {
        // Si se subió imagen, lo dejamos como está
        $ruta_img = "'$ruta_img'"; // Aseguramos que esté entre comillas
    }

    // Preparar la consulta SQL
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
                                <form action="agregar_equipo.php" method="POST" enctype="multipart/form-data" id="formEquipo">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="serial" class="form-label">Serial</label>
                                            <input type="text" class="form-control" id="serial" name="serial" required>
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

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="nombre_equipo" class="form-label">Nombre del Equipo</label>
                                            <input type="text" class="form-control" id="nombre_equipo"
                                                name="nombre_equipo" placeholder="PORTATIL-PC-MOUSE" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="placa" class="form-label">Placa</label>
                                            <input type="text" class="form-control" id="placa" name="placa" placeholder="XXX-0000" required>
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
                                            <input type="number" class="form-control" id="hv" name="hv">
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
                                            <input type="number" class="form-control" id="num_factura" name="num_factura">
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
    // Función para permitir solo letras, números y algunos caracteres válidos
    function validarCaracteres(event) {
        const input = event.target;
        // Expresión regular que permite letras, números y los caracteres especiales permitidos: - . _
        const regex = /^[a-zA-Z0-9-_\.@]*$/;

        // Si el valor no coincide con la expresión regular, borramos el último carácter ingresado
        if (!regex.test(input.value)) {
            input.value = input.value.replace(/[^a-zA-Z0-9-_\.@]/g, ''); // Elimina cualquier caracter no permitido
        }
    }

    // Aplicar la validación a todos los campos que necesiten restricción
    document.addEventListener('DOMContentLoaded', function () {
        let inputs = document.querySelectorAll('#formEquipo input[type="text"]');  // Selecciona todos los campos de texto
        inputs.forEach(input => {
            input.addEventListener('input', validarCaracteres);  // Escucha el evento "input" para cada campo
        });
    });
</script>

</body>

</html>