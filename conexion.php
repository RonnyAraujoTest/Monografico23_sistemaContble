<?php
// Configuración dinámica para Docker o entorno Local
$host = getenv("DB_HOST") ?: "localhost";
$user = getenv("DB_USER") ?: "root";
$pass = getenv("DB_PASS") ?: "0101";
$db = getenv("DB_NAME") ?: "sistemacontable";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

?>
