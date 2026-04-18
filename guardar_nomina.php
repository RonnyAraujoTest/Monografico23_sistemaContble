<?php
include "auth.php";
include "conexion.php";
include "procesar_nomina.php";

$id = $_GET["id"];

$emp = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "
SELECT * FROM empleados WHERE id=$id
",
    ),
);

$calc = calcularNomina($emp["salario"]);

mysqli_query(
    $conn,
    "
INSERT INTO nomina(
id_empleado,
salario,
afp,
sfs,
isr,
deduccion,
total_pagado,
fecha_pago
)
VALUES(
$id,
{$emp["salario"]},
{$calc["afp"]},
{$calc["sfs"]},
{$calc["isr"]},
{$calc["total"]},
{$calc["neto"]},
NOW()
)
",
);

header("Location: nomina.php");
