<?php
$conexion = new mysqli("localhost", "root", "", "prueba");

if ($conexion->connect_error) {
    die("Error de conexion pes " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];

    $claveHash = password_hash($clave, PASSWORD_DEFAULT);
    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, correo, clave) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $correo, $claveHash);

    if ($stmt->execute()) {
        echo "Esa clave mas hackeable hermano, na mentira.";
    } else {
        echo "No pude registrar al usuario pidoperdon: " . $stmt->error;
    }
}
?>

<h2>Registro</h2>
<form method="POST">
    <p>Inserta tu nombre</p>
    <input type="text" name="nombre" required><br><br>

    <p>Inserta tu correo</p>
    <input type="email" name="correo" required><br><br>

    <p>Inserta tu clave</p>
    <input type="password" name="clave" required><br><br>

    <input type="submit" value="Registrar">
    <input type="button" value="Volver al Login" onclick="location.href='login.php'">
</form>
