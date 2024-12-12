<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

// Conectar a la base de datos
require_once 'config.php';

// Obtener el ID del usuario a editar desde la URL
$id_usuario = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Guardar los cambios del formulario
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $id_rol = $_POST['id_rol'];

    $stmt = $conn->prepare("EXEC sp_EditarUsuario :id_usuario, :nombre, :correo, :id_rol");
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
    $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: Gestion_Empleados.php");
    exit();
}

// Obtener los datos actuales del usuario
$stmt = $conn->prepare("SELECT Nombre, Correo, ID_Rol FROM Usuarios WHERE ID_Usuario = :id_usuario");
$stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    header("Location: Gestion_Empleados.php");
    exit();
}

$nombre = $usuario['Nombre'];
$correo = $usuario['Correo'];
$id_rol = $usuario['ID_Rol'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empleado</title>
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/cyborg/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Editar Empleado</h2>
                <form method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($correo); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="id_rol">Rol</label>
                        <select class="form-control" id="id_rol" name="id_rol" required>
                            <option value="1" <?php echo $id_rol == 1 ? 'selected' : ''; ?>>Administrador</option>
                            <option value="2" <?php echo $id_rol == 2 ? 'selected' : ''; ?>>Empleado</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Editar Usuario</button>
                    <a href="Gestion_Empleados.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>