<?php
include "auth.php";
include "conexion.php";

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    die("Recibo no válido");
}

$id = intval($_GET["id"]);

$query = mysqli_query(
    $conn,
    "
SELECT n.*, e.nombre, e.apellido, e.cargo
FROM nomina n
JOIN empleados e ON n.id_empleado = e.id
WHERE n.id = $id
",
);

if (mysqli_num_rows($query) == 0) {
    die("No se encontró el pago");
}

$pago = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Recibo de Nómina</title>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #031926, #0b3c5d);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }


        .ticket {
            width: 420px;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }


        .header {
            background: linear-gradient(135deg, #468189, #77ACA2);
            color: white;
            text-align: center;
            padding: 20px;
        }

        .header h2 {
            margin: 0;
            font-weight: 600;
        }

        .header span {
            font-size: 13px;
            opacity: 0.8;
        }


        .content {
            padding: 25px;
        }


        .info p {
            margin: 6px 0;
            font-size: 14px;
        }


        .divider {
            margin: 15px 0;
            border-top: 1px dashed #ccc;
        }


        .detalle div {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
            font-size: 14px;
        }


        .total {
            margin-top: 15px;
            padding: 12px;
            background: #f4f6f9;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 16px;
            color: #031926;
        }


        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 15px;
        }


        .btn {
            margin: 20px;
            width: calc(100% - 40px);
            padding: 12px;
            border: none;
            border-radius: 25px;
            background: linear-gradient(45deg, #468189, #77ACA2);
            color: white;
            cursor: pointer;
            font-size: 14px;
            transition: 0.3s;
        }

        .btn:hover {
            transform: scale(1.05);
        }


        @media print {
            body {
                background: white;
            }

            .btn {
                display: none;
            }
        }
    </style>

</head>

<body>

    <div class="ticket">

        <div class="header">
            <h2>Recibo de Nómina</h2>
            <span>Centro Educativo</span>
        </div>

        <div class="content">

            <div class="info">
                <p><strong>Empleado:</strong> <?= $pago["nombre"] .
                    " " .
                    $pago["apellido"] ?></p>
                <p><strong>Cargo:</strong> <?= $pago["cargo"] ?></p>
                <p><strong>Fecha:</strong> <?= $pago["fecha_pago"] ?></p>
            </div>

            <div class="divider"></div>

            <div class="detalle">
                <div><span>Salario</span><span>$<?= number_format(
                    $pago["salario"],
                    2,
                ) ?></span></div>
                <div><span>AFP</span><span>$<?= number_format(
                    $pago["afp"],
                    2,
                ) ?></span></div>
                <div><span>SFS</span><span>$<?= number_format(
                    $pago["sfs"],
                    2,
                ) ?></span></div>
                <div><span>ISR</span><span>$<?= number_format(
                    $pago["isr"],
                    2,
                ) ?></span></div>
                <div><span>Bono</span><span>$<?= number_format(
                    $pago["bono"],
                    2,
                ) ?></span></div>
                <div><span>Deducción</span><span>$<?= number_format(
                    $pago["deduccion"],
                    2,
                ) ?></span></div>
            </div>

            <div class="divider"></div>

            <div class="total">
                <span>Total Pagado</span>
                <span>$<?= number_format($pago["total_pagado"], 2) ?></span>
            </div>

            <div class="footer">
                <p>✔ Pago procesado correctamente</p>
            </div>

        </div>

        <button class="btn" onclick="window.print()">🖨 Imprimir</button>

    </div>

</body>

</html>
