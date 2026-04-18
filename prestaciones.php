<?php
include "auth.php";
include "conexion.php";
include "calcular_prestaciones.php";

$empleados = mysqli_query(
    $conn,
    "SELECT * FROM empleados WHERE estado='activo'",
);
?>

<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<title>Prestaciones</title>

<link rel="stylesheet" href="css/menu.css">
<link rel="stylesheet" href="css/prestaciones.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>

<div class="layout">

<?php include "menu.php"; ?>


<main class="main">


<div class="topbar">
<div>
<h1>Prestaciones Laborales 💼</h1>
<p class="sub">Cálculo automático de beneficios laborales</p>
</div>

<a href="exportar_prestaciones.php" class="btn-pdf">
📄 Exportar PDF
</a>
</div>


<?php if (isset($_GET["ok"])) { ?>
<div class="alert success">✔ Prestación guardada correctamente</div>
<?php } ?>


<div class="tabla-box">

<table>

<thead>
<tr>
<th>Empleado</th>
<th>Salario</th>
<th>Preaviso</th>
<th>Cesantía</th>
<th>Vacaciones</th>
<th>Regalía</th>
<th>Total</th>
<th>Acción</th>
</tr>
</thead>

<tbody>

<?php if (mysqli_num_rows($empleados) > 0) { ?>

<?php while ($emp = mysqli_fetch_assoc($empleados)) {
    $calc = calcularPrestaciones($emp["salario"], $emp["fecha_ingreso"]); ?>

<tr>

<td><?= $emp["nombre"] . " " . $emp["apellido"] ?></td>

<td>$<?= number_format($emp["salario"]) ?></td>

<td>$<?= number_format($calc["preaviso"], 2) ?></td>
<td>$<?= number_format($calc["cesantia"], 2) ?></td>
<td>$<?= number_format($calc["vacaciones"], 2) ?></td>
<td>$<?= number_format($calc["regalia"], 2) ?></td>

<td class="total">
$<?= number_format($calc["total"], 2) ?>
</td>

<td>
<a href="guardar_prestacion.php?id=<?= $emp["id"] ?>" class="btn-guardar">
Guardar
</a>
</td>

</tr>

<?php
} ?>

<?php } else { ?>

<tr>
<td colspan="8" class="no-data">No hay empleados activos</td>
</tr>

<?php } ?>

</tbody>

</table>

</div>

</main>
</div>

</body>
</html>
