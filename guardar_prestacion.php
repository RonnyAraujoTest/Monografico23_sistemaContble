<?php
include "auth.php";
include "conexion.php";

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    die("Error: ID no recibido");
}

$id = intval($_GET["id"]);

$empleado = mysqli_query(
    $conn,
    "
SELECT * FROM empleados WHERE id = '$id'
",
);

if (mysqli_num_rows($empleado) == 0) {
    die("Empleado no encontrado");
}

$emp = mysqli_fetch_assoc($empleado);

$salario = $emp["salario"];

$preaviso = ($salario / 30) * 28;

$cesantia = $salario * 2;

$vacaciones = ($salario / 30) * 14;

$regalia = $salario / 12;

$total = $preaviso + $cesantia + $vacaciones + $regalia;

$fecha = date("Y-m-d");

$insert = mysqli_query(
    $conn,
    "
INSERT INTO prestaciones
(id_empleado, salario, preaviso, cesantia, vacaciones, regalia, total, fecha)
VALUES
('$id','$salario','$preaviso','$cesantia','$vacaciones','$regalia','$total','$fecha')
",
);

if (!$insert) {
    die("Error al guardar: " . mysqli_error($conn));
}

header("Location: prestaciones.php?ok=1");
exit();
?>
