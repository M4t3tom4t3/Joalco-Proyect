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

        #data3 {
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
                        <img src="Joalco2.jpeg" alt="Logo" class="img-fluid mb-4 redondeada"
                            style="max-width: 160px; margin-top: 20px; margin-right: 30px;">
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
                        <h3 class="fw-bold fs-4 mb-3">Crear asignacion</h3>
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
                                            <input type="text" class="form-control" id="data3" readonly>
                                            <input type="hidden" class="form-control" id="data" readonly>

                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                        <h4>Equipo</h4>
                                        <div class="card-body">
                                            <input type="text" name="filtro2" class="form-control" autocomplete="off"
                                                placeholder="Buscar Equipo">
                                            <ul class="list-group mt-2" id="lista2" style="display:none;"></ul>
                                            <br>
                                            <input type="text" class="form-control" id="data2" readonly>
                                           
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-12 col-12">
                                        <h4>Acciones</h4>
                                        <button id="agregarEquipo" class="btn btn-secondary mt-1 w-100">Agregar
                                                Equipo</button>
                                        <button id="guardar" class="btn btn-primary mt-1 w-100 mb-2">Guardar
                                            Asignación</button>
                                        <a href="index.php" class="btn btn-success w-100">Regresar</a>
                                    </div>
                                    <div class="col-xl-12">
                                        <h4>Equipos Agregados</h4>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>SERIAL</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody id="equiposSeleccionados"></tbody>
                                        </table>
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
    let equipos = []; 

    $('#lista').on('click', 'li', function () {
        let Data = $(this).text().split(" - ");
        $('#data').val(Data[2]); 
        $('#data3').val(Data[0]); 
    });

    $('input[name=filtro]').keyup(function () {
        if ($(this).val().trim().length > 0) {
            $.ajax({
                url: "proceso.php",
                method: "GET",
                data: { filtro: $(this).val() },
                success: function (response) {
                    response = JSON.parse(response);
                    let li = response.response.map(usu =>
                        `<li class='list-group-item'>${usu.nombre} ${usu.apellido} - ${usu.departamento} <span class='d-none'> - ${usu.ID_usuario}</span></li>`
                    ).join('');
                    $('#lista').html(li).show(150);
                }
            });
        } else {
            $('#lista').hide(150);
        }
    });

    $('#lista2').on('click', 'li', function () {
        let Data2 = $(this).text().split(" - ");
        $('#data2').val(Data2[1]); 
    });

    $('input[name=filtro2]').keyup(function () {
        if ($(this).val().trim().length > 0) {
            $.ajax({
                url: "proceso.php",
                method: "GET",
                data: { filtro2: $(this).val() },
                success: function (response) {
                    response = JSON.parse(response);
                    let li = response.response.length > 0 ?
                        response.response.map(equ => `<li class='list-group-item'>${equ.PLACA} - ${equ.serial}</li>`).join('') :
                        "<li class='list-group-item'>No hay resultados</li>";
                    $('#lista2').html(li).show(150);
                }
            });
        } else {
            $('#lista2').hide(150);
        }
    });

    $('#agregarEquipo').click(function () {
        let placa_equipo = $('#data2').val();
        if (placa_equipo && !equipos.includes(placa_equipo)) {
            equipos.push(placa_equipo);
            actualizarTabla();
            $('#data2').val('');
        } else {
            alert("Seleccione un equipo válido o que no esté repetido.");
        }
    });

    $(document).on('click', '.eliminarEquipo', function () {
        let placa = $(this).data('placa');
        equipos = equipos.filter(equipo => equipo !== placa);
        actualizarTabla();
    });

    function actualizarTabla() {
        let tablaHTML = equipos.map(placa =>
            `<tr>
                <td>${placa}</td>
                <td><button class="btn btn-danger eliminarEquipo" data-placa="${placa}">Eliminar</button></td>
            </tr>`
        ).join('');
        $('#equiposSeleccionados').html(tablaHTML);
    }

    $('#guardar').click(function () {
    let id_usuario = $('#data').val();
    let estado_asig = 'ACTIVO';
    let fecha_asignacion = new Date().toISOString().split('T')[0];

    if (id_usuario && equipos.length > 0) {
        $.ajax({
            url: 'guardar_asignacion.php',
            method: 'POST',
            data: {
                id_usuario: id_usuario,
                equipos: JSON.stringify(equipos),
                estado_asig: estado_asig,
                fecha_asignacion: fecha_asignacion
            },
            success: function (response) {
                try {
                    let res = typeof response === "string" ? JSON.parse(response) : response;
                    alert(res.message);
                    if (res.status === 'success') {
                        equipos = [];
                        actualizarTabla();
                    }
                } catch (e) {
                    console.error('Error al procesar la respuesta del servidor:', e);
                    alert('Error al procesar la respuesta del servidor. Consulta la consola para más detalles.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error AJAX:', textStatus, errorThrown, jqXHR.responseText);
                alert('Hubo un error al guardar la asignación. Consulta la consola para más detalles.');
            }
        });
    } else {
        alert('Seleccione un usuario y al menos un equipo.');
    }
});
});

    </script>
</body>

</html>