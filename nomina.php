<?php
include "auth.php";
include "conexion.php";
include "procesar_nomina.php";

$empleados = mysqli_query(
    $conn,
    "
SELECT * FROM empleados
WHERE estado='activo'
ORDER BY id DESC
",
);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Nómina</title>

    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/nomina.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        .btn-pagar {
            background: #22c55e;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            transition: 0.3s;
        }

        .btn-pagar:hover {
            background: #16a34a;
        }

        .btn-pagado {
            background: #9ca3af;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
        }
    </style>

</head>

<body>

    <div class="layout">

        <?php include "menu.php"; ?>

        <main class="main">

            <div class="topbar">
                <div>
                    <h1>Nómina 💰</h1>
                    <p class="sub">Procesamiento automático de pagos</p>
                </div>
            </div>

            <div class="tabla-box">

                <table>

                    <thead>
                        <tr>
                            <th>Empleado</th>
                            <th>Salario</th>
                            <th>AFP</th>
                            <th>SFS</th>
                            <th>ISR</th>
                            <th>Deducciones</th>
                            <th>Neto</th>
                            <th>Acción</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (mysqli_num_rows($empleados) > 0) { ?>

                            <?php while (
                                $emp = mysqli_fetch_assoc($empleados)
                            ) {

                                $calc = calcularNomina($emp["salario"]);

                                $pagado = mysqli_query(
                                    $conn,
                                    "
SELECT * FROM nomina
WHERE id_empleado = {$emp["id"]}
AND MONTH(fecha_pago) = MONTH(CURDATE())
",
                                );

                                $yaPago = mysqli_num_rows($pagado) > 0;
                                ?>

                                <tr>

                                    <td><?= $emp["nombre"] .
                                        " " .
                                        $emp["apellido"] ?></td>

                                    <td>$<?= number_format(
                                        $emp["salario"],
                                    ) ?></td>

                                    <td>$<?= number_format(
                                        $calc["afp"],
                                        2,
                                    ) ?></td>
                                    <td>$<?= number_format(
                                        $calc["sfs"],
                                        2,
                                    ) ?></td>
                                    <td>$<?= number_format(
                                        $calc["isr"],
                                        2,
                                    ) ?></td>

                                    <td>$<?= number_format(
                                        $calc["total"],
                                        2,
                                    ) ?></td>

                                    <td>$<?= number_format(
                                        $calc["neto"],
                                        2,
                                    ) ?></td>

                                    <td>

                                        <?php if ($yaPago) { ?>

                                            <span class="btn-pagado">✔ Pagado</span>

                                        <?php } else { ?>

                                            <a href="guardar_nomina.php?id=<?= $emp[
                                                "id"
                                            ] ?>"
                                                class="btn-pagar"
                                                onclick="return confirm('¿Procesar pago de nómina?')">
                                                💰 Pagar
                                            </a>

                                        <?php } ?>

                                    </td>

                                </tr>

                            <?php
                            } ?>

                        <?php } else { ?>

                            <tr>
                                <td colspan="8" class="no-data">
                                    No hay empleados activos
                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </main>
    </div>

</body>

</html>
