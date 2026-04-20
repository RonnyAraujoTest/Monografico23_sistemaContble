<?php include "auth.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Crear Usuario - SICOLAR</title>

<link rel="stylesheet" href="css/crear.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

</head>

<body>

<div class="container">


<div class="left">
<img src="img/image.png">

<div class="overlay"></div>

<div class="branding">
<h1>SICOLAR</h1>
<p>Administración segura del sistema</p>
</div>
</div>


<div class="right">

<div class="box">

<h2>Crear Administrador</h2>

<?php if ($error) { ?>
<div class="alert error"><?= $error ?></div>
<?php } ?>

<?php if ($success) { ?>
<div class="alert success"><?= $success ?></div>
<?php } ?>

<form method="POST">

<div class="input-group">
<span>📧</span>
<input type="email" name="correo" placeholder="Correo" required>
</div>

<div class="input-group">
<span>🔒</span>
<input type="password" id="pass1" name="password" placeholder="Contraseña" required>
<span class="toggle" onclick="verPass('pass1')">👁</span>
</div>

<div class="input-group">
<span>🔐</span>
<input type="password" id="pass2" name="confirmar" placeholder="Confirmar contraseña" required>
<span class="toggle" onclick="verPass('pass2')">👁</span>
</div>

<button class="btn">Crear Usuario</button>

<p class="volver">
<a href="login.php">← Volver al login</a>
</p>

</form>

</div>

</div>

</div>

<script>
function verPass(id){
let p = document.getElementById(id);
p.type = p.type === "password" ? "text" : "password";
}
</script>

</body>
</html>
