<?php
include "auth.php";
include "conexion.php";

if (!isset($_POST["id"])) {
    die("ID no recibido");
}

$id = intval($_POST["id"]);
$curso = $_POST["curso"];
$telefono = $_POST["telefono"];
$correo = $_POST["correo"];

$sql = "UPDATE estudiantes
SET curso='$curso', telefono='$telefono', correo='$correo'
WHERE id=$id";

$update = mysqli_query($conn, $sql);

if (!$update) {
    die("Error al actualizar: " . mysqli_error($conn));
}

header("Location: estudiantes.php?edit=ok");
exit();
?>
