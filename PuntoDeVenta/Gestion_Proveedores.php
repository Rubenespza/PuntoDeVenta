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

// Obtener el ID_Empresa del usuario actual
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

// Obtener todos los proveedores de la misma empresa
$stmt = $conn->prepare("
    EXEC sp_ObtenerProveedores :id_empresa
");
$stmt->bindParam(':id_empresa', $id_empresa, PDO::PARAM_INT);
$stmt->execute();
$proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Eliminar proveedor
if (isset($_GET['eliminar'])) {
    $id_proveedor = intval($_GET['eliminar']);
    $stmt = $conn->prepare("EXEC sp_EliminarProveedores :id_proveedor");
    $stmt->bindParam(':id_proveedor', $id_proveedor, PDO::PARAM_INT);
    $stmt->execute();
    header("Location: Gestion_Proveedores.php");
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
    <title>Gestión de Proveedores</title>
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/cyborg/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Gestión de Proveedores</h2>
        <div class="d-flex justify-content-between mb-3">
            <a href="Crear_Proveedores.php" class="btn btn-success">Añadir Proveedor</a>
            <a href="<?php echo redirigirSegunRol($id_rol); ?>" class="btn btn-secondary">Volver al Panel</a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Empresa</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($proveedores as $proveedor): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($proveedor['Nombre']); ?></td>
                        <td><?php echo htmlspecialchars($proveedor['Empresa']); ?></td>
                        <td>
                            <a href="Editar_Proveedores.php?id=<?php echo $proveedor['ID_Proveedor']; ?>" class="btn btn-primary btn-sm">Editar</a>
                            <a href="Gestion_Proveedores.php?eliminar=<?php echo $proveedor['ID_Proveedor']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este proveedor?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>