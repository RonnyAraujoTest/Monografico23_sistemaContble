<?php
include "auth.php";
include "conexion.php";

$where = "WHERE 1=1";

$tipo = "";
$fecha = "";

if (!empty($_GET["tipo"])) {
    $tipo = mysqli_real_escape_string($conn, $_GET["tipo"]);
    $where .= " AND tipo_movimiento = '$tipo'";
}

if (!empty($_GET["fecha"])) {
    $fecha = mysqli_real_escape_string($conn, $_GET["fecha"]);
    $where .= " AND DATE(fecha) = '$fecha'";
}

$query = "SELECT * FROM historial_movimientos $where ORDER BY fecha DESC";
$resultado = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Historial</title>

    <link rel="stylesheet" href="css/historial.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>

    <div class="layout">

        <?php include "menu.php"; ?>

        <main class="contenido">


            <div class="topbar">

                <div>
                    <h1>Historial del Sistema</h1>
                    <p class="sub">Registro de movimientos del sistema</p>
                </div>

                <a href="exportar_historial.php?tipo=<?= $tipo ?>&fecha=<?= $fecha ?>"
                    class="btn-top verde">
                    📄 Descargar PDF
                </a>

            </div>


            <form method="GET" class="filtros">

                <select name="tipo">
                    <option value="">Tipo de movimiento</option>

                    <option value="Pago" <?= $tipo == "Pago"
                        ? "selected"
                        : "" ?>>Pago</option>
                    <option value="Registro" <?= $tipo == "Registro"
                        ? "selected"
                        : "" ?>>Registro</option>
                    <option value="Eliminación" <?= $tipo == "Eliminación"
                        ? "selected"
                        : "" ?>>Eliminación</option>

                </select>

                <input type="date" name="fecha" value="<?= $fecha ?>">

                <button class="btn buscar">Buscar</button>

                <a href="historial.php" class="btn limpiar">Limpiar</a>

            </form>


            <div class="tabla-box">

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

                        <?php if (mysqli_num_rows($resultado) > 0) { ?>

                            <?php while (
                                $row = mysqli_fetch_assoc($resultado)
                            ) { ?>

                                <tr>

                                    <td><?= $row["fecha"] ?></td>

                                    <td>
                                        <?php if (
                                            $row["tipo_movimiento"] == "Pago"
                                        ) { ?>
                                            <span class="badge pago">Pago</span>

                                        <?php } elseif (
                                            $row["tipo_movimiento"] ==
                                            "Registro"
                                        ) { ?>
                                            <span class="badge registro">Registro</span>

                                        <?php } else { ?>
                                            <span class="badge eliminacion">Eliminación</span>
                                        <?php } ?>
                                    </td>

                                    <td><?= $row["descripcion"] ?></td>

                                    <td class="monto">
                                        $<?= number_format($row["monto"]) ?>
                                    </td>

                                </tr>

                            <?php } ?>

                        <?php } else { ?>

                            <tr>
                                <td colspan="4" class="no-data">
                                    No hay movimientos registrados
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
