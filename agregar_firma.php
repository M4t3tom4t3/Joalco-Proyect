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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Asignaciones</title>
    <style>
        #lista>li {
            background-color: #F8F8FF;
            cursor: pointer;
        }

        #lista2>li {
            background-color: #F8F8FF;
            cursor: pointer;
        }

        #data2 {
            background-color: rgb(198, 200, 202);
        }

        #data {
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
                        <h3 class="fw-bold fs-4 mb-3">Subir Firma</h3>
                        <div class="row">
                            <div class="container">
                                <div class="row mt-4">
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                        <h4>Usuario</h4>
                                        <div class="card-body">
                                            <input type="text" name="filtro" class="form-control" autocomplete="off"
                                                placeholder="Buscar Usuario">
                                            <ul class="list-group mt-2" id="lista" style="display:none;"></ul>
                                            <br>
                                            <input type="text" class="form-control" id="data" readonly>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-12 col-12">
                                        <h4>Seleccionar Archivo</h4>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="firma_usuario" class="form-label">Seleccionar Firma</label>
                                                <input type="file" id="firma_usuario" name="firma"
                                                    class="firma_usuario">
                                            </div>
                                        </div>
                                        <button id="guardar" class="btn btn-primary mt-1 w-100 mb-3">Guardar
                                        </button>
                                        <a href="index.php" class="btn btn-success w-100">Regresar</a>
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
        $(document).ready(function () {

            $('#lista').on('click', 'li', function () {
                let fila = $(this);

                let Data = fila.text().split(" - ");

                $('#data').val(Data[2]);
            });

            $('input[name=filtro]').keyup(function () {
                if ($(this).val().trim().length > 0) {
                    let li = "";
                    $('#lista').show(150);

                    $.ajax({
                        url: "proceso.php",
                        method: "GET",
                        data: { filtro: $(this).val() },
                        success: function (response) {
                            response = JSON.parse(response);
                            response.response.forEach(usu => {
                                li += "<li class='list-group-item'>" + usu.nombre + " " + usu.apellido + " - " + usu.departamento + "<span class='d-none'>" + " - " + usu.ID_usuario + "</span></li>";
                            });

                            $('#lista').html(li)
                        }
                    });
                } else {
                    $('#lista').hide(150);
                }
            })
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#guardar').click(function () {
                let id_usuario = $('#data').val();  // Obtener el id del usuario
                let firma_file = $('#firma_usuario')[0].files[0];  // Obtener el archivo de la firma

                if (id_usuario && firma_file) {
                    let formData = new FormData();
                    formData.append('id_usuario', id_usuario);  // Añadir el id del usuario
                    formData.append('firma', firma_file);  // Añadir el archivo

                    $.ajax({
                        url: 'guardar_firma.php',
                        method: 'POST',
                        data: formData,
                        contentType: false,  // No modificar el tipo de contenido
                        processData: false,  // No procesar los datos
                        success: function (response) {
                            alert('Firma guardada correctamente!');
                            console.log(response);  // Verificar la respuesta
                        },
                        error: function () {
                            alert('Hubo un error al guardar la firma.');
                        }
                    });
                } else {
                    alert('Por favor, selecciona un usuario y una firma.');
                }
            });
        });

    </script>
</body>

</html>