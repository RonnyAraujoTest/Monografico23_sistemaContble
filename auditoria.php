<?php
include "auth.php";

function registrarAuditoria($conn, $accion, $modulo)
{
    $usuario = $_SESSION["usuario"] ?? "sistema";
    $ip = $_SERVER["REMOTE_ADDR"];

    mysqli_query(
        $conn,
        "
        INSERT INTO auditoria(usuario, accion, modulo, ip)
        VALUES('$usuario', '$accion', '$modulo', '$ip')
    ",
    );
}
?>
