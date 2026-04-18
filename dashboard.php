<?php
include "auth.php";
include "conexion.php";

function obtenerTotal($conn, $query)
{
    $res = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($res);
    return $data["total"] ?? 0;
}

$total_estudiantes = obtenerTotal(
    $conn,
    "SELECT COUNT(*) total FROM estudiantes WHERE estado='activo'",
);
$total_empleados = obtenerTotal($conn, "SELECT COUNT(*) total FROM empleados");
$total_pagos = obtenerTotal($conn, "SELECT SUM(monto) total FROM pagos");
$total_nomina = obtenerTotal(
    $conn,
    "SELECT SUM(total_pagado) total FROM nomina",
);

$grafico = mysqli_query(
    $conn,
    "
SELECT MONTH(fecha_pago) mes, SUM(monto) total
FROM pagos GROUP BY mes ORDER BY mes
",
);

$meses = [];
$totales = [];

$nombres = [
    1 => "Ene",
    2 => "Feb",
    3 => "Mar",
    4 => "Abr",
    5 => "May",
    6 => "Jun",
    7 => "Jul",
    8 => "Ago",
    9 => "Sep",
    10 => "Oct",
    11 => "Nov",
    12 => "Dic",
];

while ($g = mysqli_fetch_assoc($grafico)) {
    $meses[] = $nombres[$g["mes"]];
    $totales[] = $g["total"];
}

$graficoNomina = mysqli_query(
    $conn,
    "
SELECT MONTH(fecha_pago) mes, SUM(total_pagado) total
FROM nomina GROUP BY mes ORDER BY mes
",
);

$totalesNomina = [];
while ($n = mysqli_fetch_assoc($graficoNomina)) {
    $totalesNomina[] = $n["total"];
}

while (count($totalesNomina) < count($meses)) {
    $totalesNomina[] = 0;
}

$historial = mysqli_query(
    $conn,
    "
SELECT * FROM historial_movimientos ORDER BY fecha DESC LIMIT 5
",
);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/dashboard.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <div class="layout">


        <?php include "menu.php"; ?>

        <main class="main">


            <div class="topbar">
                <h1>Panel de Control</h1>
                <p class="sub">Resumen general del sistema</p>
            </div>


            <div class="cards">

                <div class="card">
                    <h4>Estudiantes</h4>
                    <p><?= number_format($total_estudiantes) ?></p>
                </div>

                <div class="card">
                    <h4>Pagos</h4>
                    <p>$<?= number_format($total_pagos) ?></p>
                </div>

                <div class="card">
                    <h4>Empleados</h4>
                    <p><?= number_format($total_empleados) ?></p>
                </div>

                <div class="card">
                    <h4>Nómina</h4>
                    <p>$<?= number_format($total_nomina) ?></p>
                </div>

            </div>


            <div class="graficos">

                <div class="grafico-card">
                    <h3>Total Pagado</h3>
                    <p class="total">$<?= number_format($total_pagos) ?></p>
                    <canvas id="graficoPagos"></canvas>
                </div>

                <div class="grafico-card">
                    <h3>Distribución</h3>
                    <canvas id="graficoGeneral"></canvas>
                </div>

                <div class="grafico-card full">
                    <h3>Pagos vs Nómina</h3>
                    <canvas id="graficoComparativo"></canvas>
                </div>

            </div>


            <div class="tabla-box">

                <h3>Últimos Movimientos</h3>

                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Monto</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($historial)) { ?>
                            <tr>
                                <td><?= $row["fecha"] ?></td>
                                <td><?= $row["tipo_movimiento"] ?></td>
                                <td><?= $row["descripcion"] ?></td>
                                <td>$<?= number_format($row["monto"]) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>

        </main>

    </div>


    <script>

        const meses = <?= json_encode($meses) ?>;
        const pagos = <?= json_encode($totales) ?>;
        const nomina = <?= json_encode($totalesNomina) ?>;


        const ctxBar = document.getElementById("graficoPagos").getContext("2d");
        const ctxLine = document.getElementById("graficoComparativo").getContext("2d");
        const ctxDonut = document.getElementById("graficoGeneral");

        const gradBar = ctxBar.createLinearGradient(0, 0, 0, 300);
        gradBar.addColorStop(0, "#6B4F3B");
        gradBar.addColorStop(1, "#C8B6A6");

        const gradPagos = ctxLine.createLinearGradient(0, 0, 0, 300);
        gradPagos.addColorStop(0, "rgba(107,79,59,0.35)");
        gradPagos.addColorStop(1, "rgba(107,79,59,0)");

        const gradNomina = ctxLine.createLinearGradient(0, 0, 0, 300);
        gradNomina.addColorStop(0, "rgba(244,166,181,0.35)");
        gradNomina.addColorStop(1, "rgba(244,166,181,0)");


        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: meses,
                datasets: [{
                    label: 'Pagos',
                    data: pagos,
                    backgroundColor: gradBar,
                    borderRadius: 10,
                    barThickness: 28
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        callbacks: {
                            label: (ctx) => '$' + ctx.raw.toLocaleString()
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        },
                        ticks: {
                            callback: v => '$' + v
                        }
                    }
                }
            }
        });


        new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                labels: ['Estudiantes', 'Empleados'],
                datasets: [{
                    data: [<?= $total_estudiantes ?>, <?= $total_empleados ?>],
                    backgroundColor: ['#6B4F3B', '#F4A6B5'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,

                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });


        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: meses,
                datasets: [{
                        label: 'Pagos',
                        data: pagos,
                        borderColor: '#6B4F3B',
                        backgroundColor: gradPagos,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4
                    },
                    {
                        label: 'Nómina',
                        data: nomina,
                        borderColor: '#F4A6B5',
                        backgroundColor: gradNomina,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        },
                        ticks: {
                            callback: v => '$' + v
                        }
                    }
                }
            }
        });
    </script>

</body>

</html>
