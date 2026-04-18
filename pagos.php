<?php
include "auth.php";
include "conexion.php";

$buscar = "";
$fecha = "";
$metodo = "";

if (isset($_GET["buscar"]) && $_GET["buscar"] != "") {
    $buscar = mysqli_real_escape_string($conn, $_GET["buscar"]);
}

if (isset($_GET["fecha"]) && $_GET["fecha"] != "") {
    $fecha = mysqli_real_escape_string($conn, $_GET["fecha"]);
}

if (isset($_GET["metodo"]) && $_GET["metodo"] != "") {
    $metodo = mysqli_real_escape_string($conn, $_GET["metodo"]);
}

$query = "
SELECT pagos.*, estudiantes.nombre, estudiantes.apellido
FROM pagos
INNER JOIN estudiantes
ON pagos.id_estudiante = estudiantes.id
WHERE 1=1
";

if ($buscar != "") {
    $query .= " AND (
        estudiantes.nombre LIKE '%$buscar%'
        OR estudiantes.apellido LIKE '%$buscar%'
    )";
}

if ($fecha != "") {
    $query .= " AND DATE(pagos.fecha_pago) = '$fecha'";
}

if ($metodo != "") {
    $query .= " AND pagos.metodo_pago = '$metodo'";
}

$query .= " ORDER BY pagos.fecha_pago DESC";

$resultado = mysqli_query($conn, $query);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Pagos</title>

    <link rel="stylesheet" href="css/pago.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>

    <div class="layout">

        <?php include "menu.php"; ?>

        <main class="contenido">

            <div class="topbar">

                <div>
                    <h1>Reporte de Pagos</h1>
                    <p class="sub">Control financiero de estudiantes</p>
                </div>

                <div class="acciones-top">
                    <a href="nuevo_estudiante.php" class="btn-top">+ Estudiante</a>
                    <a href="nuevo_pago.php" class="btn-top verde">+ Pago</a>
                </div>

            </div>


            <form method="GET" class="filtros">

                <input type="text" name="buscar"
                    placeholder="Buscar estudiante"
                    value="<?= htmlspecialchars($buscar) ?>">

                <input type="date" name="fecha"
                    value="<?= htmlspecialchars($fecha) ?>">

                <select name="metodo">
                    <option value="">Método de pago</option>

                    <option value="Efectivo" <?= $metodo == "Efectivo"
                        ? "selected"
                        : "" ?>>Efectivo</option>
                    <option value="Transferencia" <?= $metodo == "Transferencia"
                        ? "selected"
                        : "" ?>>Transferencia</option>
                    <option value="Tarjeta" <?= $metodo == "Tarjeta"
                        ? "selected"
                        : "" ?>>Tarjeta</option>

                </select>

                <button class="btn buscar">Buscar</button>
                <a href="pagos.php" class="btn limpiar">Limpiar</a>

            </form>


            <div class="tabla-box">

                <table>

                    <thead>
                        <tr>
                            <th>Estudiante</th>
                            <th>Concepto</th>
                            <th>Monto</th>
                            <th>Fecha</th>
                            <th>Método</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (mysqli_num_rows($resultado) > 0) { ?>

                            <?php while (
                                $fila = mysqli_fetch_assoc($resultado)
                            ) { ?>

                                <tr>

                                    <td><?= $fila["nombre"] .
                                        " " .
                                        $fila["apellido"] ?></td>

                                    <td><?= htmlspecialchars(
                                        $fila["concepto"],
                                    ) ?></td>

                                    <td class="monto">
                                        $<?= number_format($fila["monto"], 2) ?>
                                    </td>

                                    <td><?= date(
                                        "d/m/Y",
                                        strtotime($fila["fecha_pago"]),
                                    ) ?></td>

                                    <td>
                                        <span class="badge <?= strtolower(
                                            $fila["metodo_pago"],
                                        ) ?>">
                                            <?= $fila["metodo_pago"] ?>
                                        </span>
                                    </td>

                                </tr>

                            <?php } ?>

                        <?php } else { ?>

                            <tr>
                                <td colspan="5" class="no-data">
                                    No hay resultados
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
