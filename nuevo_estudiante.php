

<?php include "auth.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Nuevo Estudiante</title>
    <link rel="stylesheet" href="css/nestudiante.css">
</head>

<body>

    <div class="contenedor">

        <div class="card-estudiante">

            <h2>Registrar Estudiante</h2>

            <form action="guardar_estudiante.php" method="POST">




                <div class="input-box">
                    <input type="text" name="nombre" required>
                    <label>Nombre</label>
                </div>


                <div class="input-box">
                    <input type="text" name="apellido" required>
                    <label>Apellido</label>
                </div>


                <div class="input-box">
                    <input type="text" name="cedula" required pattern="[0-9]+" title="Solo números">
                    <label>Cédula</label>
                </div>


                <div class="input-box">
                    <input type="date" name="fecha_nacimiento" required>
                    <label>Fecha de nacimiento</label>
                </div>


                <div class="input-box">
                    <input type="text" name="curso" required>
                    <label>Curso</label>
                </div>


                <div class="input-box">
                    <input type="text" name="telefono" pattern="[0-9]+">
                    <label>Teléfono</label>
                </div>


                <div class="input-box">
                    <input type="email" name="correo">
                    <label>Correo</label>
                </div>

                <button type="submit" class="btn-guardar">
                    Guardar Estudiante
                </button>

            </form>

        </div>

    </div>

</body>

</html>
