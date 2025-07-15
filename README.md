¿Qué aprendí?
1. CRUD completo con PHP y MySQL
Crear, Leer, Actualizar y Eliminar usuarios desde una interfaz.
Manejo de formularios HTML con POST y GET.
Usar mysqli y prepare() para consultas seguras (evita SQL Injection).

2. Autenticación de usuarios
Registro con password_hash().
Login con password_verify().
Uso de $_SESSION para mantener al usuario conectado.
Redirección segura con header("Location:...").

3. Estructura de páginas funcionales
registro.php: para registrar usuarios nuevos.
login.php: para iniciar sesión.
crud.php: gestión de usuarios (solo si estás logueado).
logout.php: para cerrar sesión limpiamente.
panel.php: página de bienvenida tras el login (si la usaste)
