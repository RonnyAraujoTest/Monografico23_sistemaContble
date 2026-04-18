<?php
include "auth.php";
include "conexion.php";
include "auditoria.php";

$id = intval($_GET["id"]);

$est = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "
SELECT nombre, apellido FROM estudiantes WHERE id=$id
",
    ),
);

$nombre = $est["nombre"] . " " . $est["apellido"];

mysqli_query(
    $conn,
    "
UPDATE estudiantes SET estado='activo' WHERE id=$id
",
);

mysqli_query(
    $conn,
    "
INSERT INTO historial_movimientos(tipo_movimiento, descripcion, monto)
VALUES('Reactivación','Estudiante reactivado: $nombre',0)
",
);

registrarAuditoria(
    $conn,
    "Reactivó estudiante: $nombre (ID $id)",
    "Estudiantes",
);

header("Location: estudiantes.php?reactivado=ok");
exit();
?>
