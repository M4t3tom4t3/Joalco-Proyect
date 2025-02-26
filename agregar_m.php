<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: inicio.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jp";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $fk_numero_consecutivo = $_POST['data_consecutivo'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $observaciones = $_POST['observaciones'];
    $tecnico = $_POST['tecnico'];

    // Validar que los campos no estén vacíos
    if (!empty($fk_numero_consecutivo) && !empty($fecha_inicio) && !empty($fecha_fin) && !empty($observaciones)) {
        // Preparar la consulta SQL para insertar los datos
        $query = $conn->prepare("INSERT INTO mantenimiento (fk_numero_consecutivo, fecha_inicio, fecha_fin, tecnico, observaciones)
        VALUES (?, ?, ?, ?, ?)");

        // Enlaza los parámetros de manera segura
        $query->bind_param("sssss", $fk_numero_consecutivo, $fecha_inicio, $fecha_fin, $tecnico, $observaciones);

        // Ejecuta la consulta
        if ($query->execute()) {
            // Redirige al usuario si la consulta fue exitosa
            header("Location: mantenimiento.php");
            exit(); // Asegúrate de que después de header() haya un exit() para detener el script
        } else {
            // Manejo del error
            echo "Error al guardar los datos: " . $query->error;
        }
    } else {
        echo "Por favor, complete todos los campos del formulario.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        #lista_consecutivo>li {
            background-color: #F8F8FF;
            cursor: pointer;
        }

        #data_consecutivo {
            background-color: rgb(198, 200, 202);
        }
    </style>
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
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="content px-3 py-4">
                <div class="container-fluid">
                    <div class="mb-3">
                        <h3 class="fw-bold fs-4 mb-3">Mantenimiento</h3>
                        <div class="row">
                            <form action="agregar_m.php" method="POST">
                                <div class="mb-3">
                                    <label for="fk_numero_consecutivo" class="form-label">Número Consecutivo</label>
                                    <input type="text" name="filtro_consecutivo" class="form-control" autocomplete="off"
                                        placeholder="Buscar Número Consecutivo">
                                    <ul class="list-group mt-2" id="lista_consecutivo" style="display:none;"></ul>
                                    <br>
                                    <input type="text" class="form-control" id="data_consecutivo" name="data_consecutivo"readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="fecha_inicio" class="form-label">Fecha y Hora de Inicio</label>
                                    <input type="datetime-local" class="form-control" id="fecha_inicio"
                                        name="fecha_inicio">
                                </div>
                                <div class="mb-3">
                                    <label for="fecha_fin" class="form-label">Fecha y Hora de Finalización</label>
                                    <input type="datetime-local" class="form-control" id="fecha_fin" name="fecha_fin">
                                </div>
                                <div class="mb-3">
                                    <label for="tecnico" class="form-label">Tecnico</label>
                                    <input type="text" class="form-control" id="tecnico" name="tecnico">
                                </div>
                                <div class="mb-3">
                                    <label for="observaciones" class="form-label">Observaciones</label>
                                    <input type="text" class="form-control" id="observaciones" name="observaciones">
                                </div>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a href="mantenimiento.php" class="btn btn-success me-md-2">Regresar</a>
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
    <script>
        $(document).ready(function () {
            $('input[name=filtro_consecutivo]').keyup(function () {
                if ($(this).val().trim().length > 0) {
                    let li = "";
                    $('#lista_consecutivo').show(150);

                    $.ajax({
                        url: "proceso_consecutivo.php", // Asegúrate de que esta URL es correcta
                        method: "GET",
                        data: { filtro_consecutivo: $(this).val() },
                        success: function (response) {
                            // Asegúrate de que la respuesta es un objeto JSON
                            console.log(response);

                            response = JSON.parse(response); // Esto puede no ser necesario si el servidor ya devuelve JSON

                            li = ""; // Limpiamos la lista antes de agregar nuevos elementos

                            // Verifica si la respuesta tiene datos
                            if (response.response.length > 0) {
                                response.response.forEach(item => {
                                    // Accede a las propiedades correctas del objeto
                                    li += "<li class='list-group-item'>" + item.numero_consecutivo + " - " + item.FK_serial + "</li>";
                                });
                            } else {
                                li = "<li class='list-group-item'>No hay resultados</li>";
                            }
                            // Agrega los elementos de la lista al DOM
                            $('#lista_consecutivo').html(li);
                        },
                        error: function (xhr, status, error) {
                            console.error("Error al obtener los datos: ", error);
                            alert('Hubo un error al obtener los datos.');
                        }
                    });
                } else {
                    $('#lista_consecutivo').hide(150);
                }
            });

            // Acción al seleccionar un ítem de la lista
            $('#lista_consecutivo').on('click', 'li', function () {
                let fila = $(this);
                let Data = fila.text().split(" - ");
                console.log(Data);
                $('#data_consecutivo').val(Data[0]); // Esto asigna el número consecutivo al campo de texto
            });
        });
        $('form').submit(function(e) {
    let valido = true;

    // Validar campos
    if ($('#data_consecutivo').val() === '') {
        valido = false;
        alert('El número consecutivo es obligatorio');
    }
    if ($('#fecha_inicio').val() === '' || $('#fecha_fin').val() === '') {
        valido = false;
        alert('Las fechas son obligatorias');
    }
    if ($('#observaciones').val() === '') {
        valido = false;
        alert('Las observaciones son obligatorias');
    }

    // Si no es válido, evitar el envío del formulario
    if (!valido) {
        e.preventDefault();
    }
});

    </script>
</body>

</html>