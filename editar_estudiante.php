<?php
include "auth.php";
include "conexion.php";

if (!isset($_GET["id"]) || $_GET["id"] == "") {
    die("ID no válido");
}

$id = intval($_GET["id"]);

if ($id <= 0) {
    die("ID incorrecto");
}

$query = mysqli_query($conn, "SELECT * FROM estudiantes WHERE id=$id LIMIT 1");

if (!$query) {
    die("Error en consulta: " . mysqli_error($conn));
}

if (mysqli_num_rows($query) == 0) {
    die("Estudiante no encontrado");
}

$est = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Estudiante</title>

    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/editEstudiante.css">

</head>

<body>

    <div class="layout">



        <main class="main">

            <div class="topbar">
                <h1>✏ Editar Estudiante</h1>
            </div>

            <div class="form-box">

                <form action="actualizar_estudiante.php" method="POST">

                    <input type="hidden" name="id" value="<?= $est["id"] ?>">


                    <div class="input-group">
                        <input type="text" value="<?= $est[
                            "id_institucional"
                        ] ?>" readonly>
                    </div>

                    <div class="input-group">
                        <input type="text" value="<?= $est[
                            "nombre"
                        ] ?>" readonly>
                    </div>

                    <div class="input-group">
                        <input type="text" value="<?= $est[
                            "apellido"
                        ] ?>" readonly>
                    </div>

                    <div class="input-group">
                        <input type="text" value="<?= $est[
                            "cedula"
                        ] ?>" readonly>
                    </div>

                    <div class="input-group">
                        <input type="date" value="<?= $est[
                            "fecha_nacimiento"
                        ] ?>" readonly>
                    </div>


                    <div class="input-group">
                        <input type="text" name="curso" value="<?= $est[
                            "curso"
                        ] ?>" required>
                    </div>

                    <div class="input-group">
                        <input type="text" name="telefono" value="<?= $est[
                            "telefono"
                        ] ?>" required>
                    </div>

                    <div class="input-group">
                        <input type="email" name="correo" value="<?= $est[
                            "correo"
                        ] ?>" required>
                    </div>

                    <div class="btn-group">
                        <button type="submit" class="btn-guardar">Actualizar</button>
                        <a href="estudiantes.php" class="btn-volver">Volver</a>
                    </div>

                </form>

            </div>

        </main>

    </div>

</body>

</html>
