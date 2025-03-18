<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: inicio.html");
    exit();
}
$link = mysqli_connect("localhost", "root", "", "jp");
$consulta = mysqli_query($link, "SELECT nombre_equipo, COUNT(*) as cantidad FROM equipos WHERE nombre_equipo='PC' OR nombre_equipo='PORTATIL' GROUP BY nombre_equipo");

$dataPoints1 = array();

while ($equipos = mysqli_fetch_assoc($consulta)) {
    $dataPoints1[] = array("label" => $equipos['nombre_equipo'], "y" => (int)$equipos['cantidad']);
}

$consulta2 = mysqli_query($link, "SELECT estado, COUNT(*) as cantidad FROM equipos WHERE estado IN ('ACTIVO', 'DE BAJA', 'BODEGA') GROUP BY estado");

$dataPoints2 = array();

while ($equipos = mysqli_fetch_assoc($consulta2)) {
    $dataPoints2[] = array("label" => $equipos['estado'], "y" => (int)$equipos['cantidad']);
}

$ciudades_order = ['Bogota', 'Buenaventura', 'Itagui'];

$query_mantenimiento_mayor_a_un_ano = "
SELECT 
    m.ciudad, 
    COUNT(*) as cantidad_mayor_a_un_ano
FROM mantenimiento m
WHERE m.ciudad IN ('Bogota', 'Buenaventura', 'Itagui') 
AND DATEDIFF(CURDATE(), m.fecha_fin) > 365
GROUP BY m.ciudad;
";
$result_mantenimiento_mayor_a_un_ano = mysqli_query($link, $query_mantenimiento_mayor_a_un_ano);

$mayor_a_un_ano = [];
while ($row = mysqli_fetch_assoc($result_mantenimiento_mayor_a_un_ano)) {
    $mayor_a_un_ano[$row['ciudad']] = (int)$row['cantidad_mayor_a_un_ano'];
}

$query_mantenimiento_menor_a_un_ano = "
SELECT 
    m.ciudad, 
    COUNT(*) as cantidad_menor_a_un_ano
FROM mantenimiento m
WHERE m.ciudad IN ('Buenaventura', 'Itagui', 'Bogota') 
AND DATEDIFF(CURDATE(), m.fecha_fin) <= 365
GROUP BY m.ciudad;
";
$result_mantenimiento_menor_a_un_ano = mysqli_query($link, $query_mantenimiento_menor_a_un_ano);

$menor_a_un_ano = [];
while ($row = mysqli_fetch_assoc($result_mantenimiento_menor_a_un_ano)) {
    $menor_a_un_ano[$row['ciudad']] = (int)$row['cantidad_menor_a_un_ano'];
}

$dataPoints3 = [];
$dataPoints4 = [];

foreach ($ciudades_order as $ciudad) {
    $dataPoints3[] = array(
        "label" => $ciudad,
        "y" => isset($mayor_a_un_ano[$ciudad]) ? $mayor_a_un_ano[$ciudad] : 0 
    );

    $dataPoints4[] = array(
        "label" => $ciudad,
        "y" => isset($menor_a_un_ano[$ciudad]) ? $menor_a_un_ano[$ciudad] : 0 
    );
}

mysqli_close($link);
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
    <link rel="icon" href="INVENTARIO.ico">
    <script>
        window.onload = function () {
 
 var chart1 = new CanvasJS.Chart("chartContainer1", {
     animationEnabled: true,
     exportEnabled: true,
     title:{
         text: "PC y Portatiles Joalco"
     },
     subtitles: [{
         text: "2025"
     }],
     data: [{
         type: "pie",
         showInLegend: "true",
         legendText: "{label}",
         indexLabelFontSize: 16,
         indexLabel: "{label} - #percent%",
         yValueFormatString: "N°#,##0",
         dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
     }]
 });
 var chart2 = new CanvasJS.Chart("chartContainer2", {
        animationEnabled: true,
        exportEnabled: true,
        title: {
            text: "Estado de los Equipos Joalco"
        },
        subtitles: [{
            text: "2025"
        }],
        data: [{
            type: "pie",
            showInLegend: true,
            legendText: "{label}",
            indexLabelFontSize: 16,
            indexLabel: "{label} - #percent%",
            yValueFormatString: "N°#,##0",
            dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
        }]
    });
    var chart3 = new CanvasJS.Chart("chartContainer3", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: "Mantenimientos Regionales"
	},
	axisY:{
		includeZero: true
	},
	legend:{
		cursor: "pointer",
		verticalAlign: "center",
		horizontalAlign: "right",
		itemclick: toggleDataSeries
	},
	data: [{
		type: "column",
		name: "Pedinetes",
		indexLabel: "{y}",
		yValueFormatString: "N°#0.##",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
	},{
		type: "column",
		name: "Realizados",
		indexLabel: "{y}",
		yValueFormatString: "N°#0.##",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
	}]
});

    chart1.render();
    chart2.render();
    chart3.render();
    function toggleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else{
		e.dataSeries.visible = true;
	}
	chart3.render();
}
}
    </script>
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
            <?php

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "jp";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            $query_usuarios = "SELECT COUNT(*) AS total_usuarios FROM usuarios";
            $result_usuarios = $conn->query($query_usuarios);
            $usuarios = $result_usuarios->fetch_assoc();

            $query_equipos = "SELECT COUNT(*) AS total_equipos FROM equipos";
            $result_equipos = $conn->query($query_equipos);
            $equipos = $result_equipos->fetch_assoc();


            $conn->close();
            ?>
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
                        <h3 class="fw-bold fs-4 mb-3">Admin Dashboard</h3>
                        <div class="row">
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card" style="width: 100%;">
                                    <div class="card-body">
                                        <h5 class="card-title"><strong>Usuarios</strong></h5>
                                        <p class="card-text">Usuarios registrados:
                                            <strong><?php echo $usuarios['total_usuarios']; ?></strong>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card" style="width: 100%;">
                                    <div class="card-body">
                                        <h5 class="card-title"><strong>Equipos Totales</strong></h5>
                                        <p class="card-text">Equipos registrados:
                                            <strong><?php echo $equipos['total_equipos']; ?></strong>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card" style="width: 100%;">
                                    <div class="card-body">
                                        <h5 class="card-title"><strong>Generador de Firmas</strong></h5>
                                        <a href="http://10.238.18.163/" target="_blank">Link</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card" style="width: 100%;">
                                    <div class="card-body">
                                    <div id="chartContainer1" style="height: 370px; width: 100%;"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card" style="width: 100%;">
                                    <div class="card-body">
                                    <div id="chartContainer2" style="height: 370px; width: 100%;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card" style="width: 100%;">
                                    <div class="card-body">
                                    <div id="chartContainer3" style="height: 370px; width: 100%;"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>