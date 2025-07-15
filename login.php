<?php
session_start();

$conexion = new mysqli("localhost", "root", "", "prueba");
if ($conexion->connect_error) {
    die("❌ Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];

    $stmt = $conexion->prepare("SELECT id, nombre, clave FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($clave, $usuario["clave"])) {
            $_SESSION["usuario"] = $usuario["nombre"];
            header("Location: crud.php");
            exit();
        } else {
            echo "❌ Clave incorrecta.";
        }
    } else {
        echo "❌ Usuario no encontrado.";
    }
}
?>

<h2>Login</h2>
<form method="POST">
    Correo: <input type="email" name="correo" required><br><br>
    Clave: <input type="password" name="clave" required><br><br>
    <input type="submit" value="Ingresar">
    <input type="button" value="Registrar" onclick="location.href='registro.php'">
</form>

<br>

