<?php
include "auth.php";

function calcularNomina($salario)
{
    if ($salario <= 0) {
        return [
            "afp" => 0,
            "sfs" => 0,
            "isr" => 0,
            "total" => 0,
            "neto" => 0,
        ];
    }

    $afp = $salario * 0.0304;
    $sfs = $salario * 0.0287;

    $salario_anual = $salario * 12;

    if ($salario_anual <= 416220) {
        $isr_anual = 0;
    } elseif ($salario_anual <= 624329) {
        $isr_anual = ($salario_anual - 416220) * 0.15;
    } elseif ($salario_anual <= 867123) {
        $isr_anual = 31216 + ($salario_anual - 624329) * 0.2;
    } else {
        $isr_anual = 79776 + ($salario_anual - 867123) * 0.25;
    }

    $isr = $isr_anual / 12;

    $total_deducciones = $afp + $sfs + $isr;
    $neto = $salario - $total_deducciones;

    $afp = round($afp, 2);
    $sfs = round($sfs, 2);
    $isr = round($isr, 2);
    $total_deducciones = round($total_deducciones, 2);
    $neto = round($neto, 2);

    return [
        "afp" => $afp,
        "sfs" => $sfs,
        "isr" => $isr,
        "total" => $total_deducciones,
        "neto" => $neto,
    ];
}
?>
