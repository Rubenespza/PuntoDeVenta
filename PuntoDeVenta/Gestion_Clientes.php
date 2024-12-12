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

// Obtener el ID_Rol del usuario actual
$stmt = $conn->prepare("SELECT ID_Rol FROM Usuarios WHERE Correo = :correo");
$stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    // Si no se encuentra el usuario, cerrar sesión y redirigir a la página de inicio de sesión
    session_destroy();
    header("Location: index.php");
    exit();
}

$id_rol = $usuario['ID_Rol'];

// Obtener todos los clientes
$stmt = $conn->prepare("EXEC sp_ObtenerClientes");
$stmt->execute();
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Eliminar cliente
if (isset($_GET['eliminar'])) {
    $id_cliente = intval($_GET['eliminar']);
    $stmt = $conn->prepare("EXEC sp_EliminarClientes :id_cliente");
    $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
    $stmt->execute();
    header("Location: Gestion_Clientes.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/cyborg/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Gestión de Clientes</h2>
        <div class="d-flex justify-content-between mb-3">
            <a href="Crear_Clientes.php" class="btn btn-success">Añadir Cliente</a>
            <a href="<?php echo $id_rol == 1 ? 'Panel_Admin.php' : 'Panel_Empleado.php'; ?>" class="btn btn-secondary">Volver al Panel</a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($cliente['Nombre']); ?></td>
                        <td>
                            <a href="Editar_Clientes.php?id=<?php echo $cliente['ID_Cliente']; ?>" class="btn btn-primary btn-sm">Editar</a>
                            <a href="Gestion_Clientes.php?eliminar=<?php echo $cliente['ID_Cliente']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este cliente?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>