<?php
include "auth.php";
include "conexion.php";

$query = "SELECT * FROM estudiantes WHERE estado='activo' ORDER BY id DESC";
$resultado = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Estudiantes</title>

    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/estudiante.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="layout">

        <?php include "menu.php"; ?>

        <main class="main">


            <div class="topbar">
                <div>
                    <h1>Gestión de Estudiantes 👨‍🎓</h1>
                    <p class="sub">Administración del sistema</p>
                </div>

                <a href="nuevo_estudiante.php" class="btn-top verde">+ Nuevo</a>
            </div>


            <?php if (isset($_GET["edit"])) { ?>
                <div class="alert success">✔ Estudiante actualizado correctamente</div>
            <?php } ?>

            <?php if (isset($_GET["delete"])) { ?>
                <div class="alert danger">🗑 Estudiante eliminado correctamente</div>
            <?php } ?>


            <div class="filtros">
                <input type="text" id="buscar" placeholder="Buscar estudiante...">
            </div>


            <div class="tabla-box">

                <table id="tabla">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ID Inst.</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Cédula</th>
                            <th>Fecha</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Curso</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (mysqli_num_rows($resultado) > 0) { ?>
                            <?php while (
                                $fila = mysqli_fetch_assoc($resultado)
                            ) { ?>

                                <tr>

                                    <td><?= $fila["id"] ?></td>
                                    <td><?= $fila["id_institucional"] ?></td>
                                    <td><?= $fila["nombre"] ?></td>
                                    <td><?= $fila["apellido"] ?></td>
                                    <td><?= $fila["cedula"] ?></td>
                                    <td><?= $fila["fecha_nacimiento"] ?></td>
                                    <td><?= $fila["telefono"] ?></td>
                                    <td><?= $fila["correo"] ?></td>
                                    <td><?= $fila["curso"] ?></td>

                                    <td>
                                        <span class="badge <?= $fila[
                                            "estado"
                                        ] ?>">
                                            <?= ucfirst($fila["estado"]) ?>
                                        </span>
                                    </td>

                                    <td class="acciones">

                                        <a href="editar_estudiante.php?id=<?= $fila[
                                            "id"
                                        ] ?>" class="btn-editar">✏</a>

                                        <button class="btn-eliminar" onclick="confirmarEliminar(<?= $fila[
                                            "id"
                                        ] ?>)">
                                            🗑
                                        </button>

                                    </td>

                                </tr>

                            <?php } ?>
                        <?php } else { ?>

                            <tr>
                                <td colspan="11" class="no-data">No hay estudiantes registrados</td>
                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </main>

    </div>

    <script>

        document.getElementById("buscar").addEventListener("keyup", function() {
            let filtro = this.value.toLowerCase();
            let filas = document.querySelectorAll("#tabla tbody tr");

            filas.forEach(fila => {
                fila.style.display = fila.innerText.toLowerCase().includes(filtro) ? "" : "none";
            });
        });


        function confirmarEliminar(id) {
            Swal.fire({
                title: '¿Eliminar estudiante?',
                text: "Esta acción no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = "eliminar_estudiante.php?id=" + id;
                }
            });
        }
    </script>

</body>

</html>
