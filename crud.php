<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "prueba");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"]) && isset($_POST["correo"]) && isset($_POST["clave"])) {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $clave = password_hash($_POST["clave"], PASSWORD_DEFAULT);

    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, correo, clave) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $correo, $clave);
    $stmt->execute();
}

if (isset($_POST["editar_id"])) {
    $id = $_POST["editar_id"];
    $nombre = $_POST["editar_nombre"];
    $correo = $_POST["editar_correo"];
    $stmt = $conexion->prepare("UPDATE usuarios SET nombre = ?, correo = ? WHERE id = ?");
    $stmt->bind_param("ssi", $nombre, $correo, $id);
    $stmt->execute();

    header("Location: crud.php");
    exit();
}


if (isset($_GET["eliminar"])) {
    $idEliminar = $_GET["eliminar"];
    $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $idEliminar);
    $stmt->execute();

    
    header("Location: crud.php");
    exit();
}


$resultado = $conexion->query("SELECT id, nombre, correo FROM usuarios");
?>

<h2>Bienvenido, <?php echo $_SESSION["usuario"]; ?></h2>
<a href="logout.php">Cerrar sesión</a>

<h2>Registro de Usuarios</h2>
<form method="POST" action="">
    Nombre: <input type="text" name="nombre" required><br><br>
    Correo: <input type="email" name="correo" required><br><br>
    Clave: <input type="password" name="clave" required><br><br>
    <input type="submit" value="Agregar">
</form>

<h2>Usuarios Registrados</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Correo</th>
        <th>Acciones</th>
    </tr>
    <?php while ($usuario = $resultado->fetch_assoc()): ?>
        <tr>
            <td><?php echo $usuario["id"]; ?></td>
            <td><?php echo $usuario["nombre"]; ?></td>
            <td><?php echo $usuario["correo"]; ?></td>
            <td>
                <a href="?eliminar=<?php echo $usuario["id"]; ?>">Eliminar</a> |
                <a href="?editar=<?php echo $usuario["id"]; ?>">Editar</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<?php
// Mostrar formulario de edición
if (isset($_GET["editar"])) {
    $idEditar = $_GET["editar"];
    $stmt = $conexion->prepare("SELECT id, nombre, correo FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $idEditar);
    $stmt->execute();
    $resultadoEditar = $stmt->get_result();
    if ($usuarioEditar = $resultadoEditar->fetch_assoc()):
?>
    <h3>Editar usuario</h3>
    <form method="POST">
        <input type="hidden" name="editar_id" value="<?= $usuarioEditar['id'] ?>">
        Nombre: <input type="text" name="editar_nombre" value="<?= $usuarioEditar['nombre'] ?>" required><br><br>
        Correo: <input type="email" name="editar_correo" value="<?= $usuarioEditar['correo'] ?>" required><br><br>
        <input type="submit" value="Guardar cambios">
    </form>
<?php
    endif;
}
?>
