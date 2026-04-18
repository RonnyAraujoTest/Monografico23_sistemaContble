<?php
include "auth.php";
require "./fpdf186/fpdf.php";

include "conexion.php";

$query = mysqli_query(
    $conn,
    "
SELECT p.*, e.nombre, e.apellido
FROM prestaciones p
INNER JOIN empleados e ON p.id_empleado = e.id
",
);

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont("Arial", "B", 16);
$pdf->Cell(190, 10, "Reporte de Prestaciones", 0, 1, "C");

$pdf->Ln(5);

$pdf->SetFont("Arial", "B", 10);

$pdf->Cell(35, 8, "Empleado", 1);
$pdf->Cell(20, 8, "Salario", 1);
$pdf->Cell(20, 8, "Preaviso", 1);
$pdf->Cell(25, 8, "Cesantia", 1);
$pdf->Cell(25, 8, "Vacaciones", 1);
$pdf->Cell(20, 8, "Regalia", 1);
$pdf->Cell(20, 8, "Total", 1);

$pdf->Ln();

$pdf->SetFont("Arial", "", 9);

while ($row = mysqli_fetch_assoc($query)) {
    $pdf->Cell(35, 8, $row["nombre"] . " " . $row["apellido"], 1);
    $pdf->Cell(20, 8, '$' . $row["salario"], 1);
    $pdf->Cell(20, 8, '$' . $row["preaviso"], 1);
    $pdf->Cell(25, 8, '$' . $row["cesantia"], 1);
    $pdf->Cell(25, 8, '$' . $row["vacaciones"], 1);
    $pdf->Cell(20, 8, '$' . $row["regalia"], 1);
    $pdf->Cell(20, 8, '$' . $row["total"], 1);

    $pdf->Ln();
}

$pdf->Output();

session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}

?>
