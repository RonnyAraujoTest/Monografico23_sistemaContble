<?php
include "auth.php";

function calcularPrestaciones($salario, $fecha_ingreso)
{
    $hoy = new DateTime();
    $ingreso = new DateTime($fecha_ingreso);

    $antiguedad = $hoy->diff($ingreso)->y;

    if ($antiguedad < 1) {
        $preaviso = 7 * ($salario / 23.83);
    } elseif ($antiguedad < 5) {
        $preaviso = 14 * ($salario / 23.83);
    } else {
        $preaviso = 28 * ($salario / 23.83);
    }

    if ($antiguedad < 1) {
        $cesantia = 0;
    } elseif ($antiguedad < 5) {
        $cesantia = 21 * ($salario / 23.83) * $antiguedad;
    } else {
        $cesantia = 23 * ($salario / 23.83) * $antiguedad;
    }

    $vacaciones = 14 * ($salario / 23.83);

    $regalia = $salario / 12;

    $total = $preaviso + $cesantia + $vacaciones + $regalia;

    return [
        "preaviso" => $preaviso,
        "cesantia" => $cesantia,
        "vacaciones" => $vacaciones,
        "regalia" => $regalia,
        "total" => $total,
    ];
}
?>
