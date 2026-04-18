<?php
include "auth.php";
include "conexion.php";

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    die("Error: ID no proporcionado");
}

$id = intval($_GET["id"]);

$query = mysqli_query(
    $conn,
    "SELECT nombre, apellido FROM estudiantes WHERE id='$id'",
);

if (!$query) {
    die("Error: " . mysqli_error($conn));
}

$est = mysqli_fetch_assoc($query);

if (!$est) {
    die("Estudiante no encontrado");
}

$nombre = $est["nombre"] . " " . $est["apellido"];

$update = mysqli_query(
    $conn,
    "UPDATE estudiantes SET estado='inactivo' WHERE id='$id'",
);

if (!$update) {
    die("Error al desactivar: " . mysqli_error($conn));
}

mysqli_query(
    $conn,
    "
INSERT INTO historial_movimientos(tipo_movimiento, descripcion, monto)
VALUES('Eliminación','Estudiante desactivado: $nombre',0)
",
);

header("Location: estudiantes.php?delete=ok");
exit();
?>
