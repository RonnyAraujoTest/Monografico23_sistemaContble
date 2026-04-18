<?php
include "auth.php";
include "conexion.php";

if (
    empty($_POST["nombre"]) ||
    empty($_POST["apellido"]) ||
    empty($_POST["cedula"]) ||
    empty($_POST["fecha_nacimiento"]) ||
    empty($_POST["cargo"]) ||
    empty($_POST["fecha_ingreso"])
) {
    die("Faltan datos obligatorios");
}

$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$cedula = $_POST["cedula"];
$fecha_nacimiento = $_POST["fecha_nacimiento"];
$cargo = $_POST["cargo"];
$telefono = $_POST["telefono"];
$correo = $_POST["correo"];
$fecha_ingreso = $_POST["fecha_ingreso"];

if (!preg_match("/^[0-9]+$/", $cedula)) {
    die("La cédula solo debe contener números");
}

switch ($cargo) {
    case "Director":
        $salario = 80000;
        break;
    case "Coordinador":
        $salario = 45000;
        break;
    case "Profesor":
        $salario = 35000;
        break;
    case "Secretaria":
        $salario = 25000;
        break;
    case "Asistente":
        $salario = 20000;
        break;
    case "Conserje":
        $salario = 18000;
        break;
    default:
        $salario = 0;
}

$verificar = mysqli_query(
    $conn,
    "SELECT id FROM empleados WHERE cedula='$cedula'",
);
if (mysqli_num_rows($verificar) > 0) {
    die("Error: Esta cédula ya está registrada");
}

$sql = "INSERT INTO empleados(
nombre, apellido, cedula, fecha_nacimiento,
cargo, salario, telefono, correo, fecha_ingreso
) VALUES(
'$nombre', '$apellido', '$cedula', '$fecha_nacimiento',
'$cargo', '$salario', '$telefono', '$correo', '$fecha_ingreso'
)";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

mysqli_query(
    $conn,
    "
INSERT INTO historial_movimientos(tipo_movimiento, descripcion, monto)
VALUES('Empleado','Nuevo empleado: $nombre $apellido','$salario')
",
);

header("Location: empleados.php?success=1");
exit();
?>
