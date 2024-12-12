<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

// Conectar a la base de datos
require_once 'config.php';

// Obtener el correo del usuario actual
$correo = $_SESSION['usuario'];

// Obtener el ID_Empresa y ID_Rol del usuario actual
$stmt = $conn->prepare("SELECT ID_Empresa, ID_Rol FROM Usuarios WHERE Correo = :correo");
$stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    // Si no se encuentra el usuario, cerrar sesión y redirigir a la página de inicio de sesión
    session_destroy();
    header("Location: index.php");
    exit();
}

$id_empresa = $usuario['ID_Empresa'];
$id_rol = $usuario['ID_Rol'];

// Obtener todos los usuarios de la misma empresa y sus roles usando el procedimiento almacenado
$stmt = $conn->prepare("EXEC sp_ObtenerUsuarios :id_empresa");
$stmt->bindParam(':id_empresa', $id_empresa, PDO::PARAM_INT);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Eliminar usuario
if (isset($_GET['eliminar'])) {
    $id_usuario = intval($_GET['eliminar']);
    $stmt = $conn->prepare("EXEC sp_EliminarUsuarios :id_usuario");
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->execute();
    header("Location: Gestion_Empleados.php");
    exit();
}

// Redirigir según el rol del usuario
function redirigirSegunRol($id_rol) {
    if ($id_rol == 1) {
        return 'Panel_Admin.php';
    } elseif ($id_rol == 2) {
        return 'Panel_Empleado.php';
    }
    return 'index.php';
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Empleados</title>
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/cyborg/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Gestión de Empleados</h2>
        <div class="d-flex justify-content-between mb-3">
            <a href="Crear_Empleados.php" class="btn btn-success">Crear Empleado</a>
            <a href="<?php echo redirigirSegunRol($id_rol); ?>" class="btn btn-secondary">Volver al Panel</a>
        </div>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo Electrónico</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario['Nombre']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['Correo']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['Rol']); ?></td>
                        <td>
                            <a href="Editar_Empleados.php?id=<?php echo $usuario['ID_Usuario']; ?>" class="btn btn-primary btn-sm">Editar</a>
                            <a href="Gestion_Empleados.php?eliminar=<?php echo $usuario['ID_Usuario']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>