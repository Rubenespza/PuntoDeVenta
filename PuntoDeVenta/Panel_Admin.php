<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

// Conectar a la base de datos
require_once 'config.php';

// Obtener el nombre del usuario
$correo = $_SESSION['usuario'];
$stmt = $conn->prepare("SELECT Nombre FROM Usuarios WHERE Correo = :correo");
$stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    // Si no se encuentra el usuario, cerrar sesión y redirigir a la página de inicio de sesión
    session_destroy();
    header("Location: index.php");
    exit();
}

$nombre = $usuario['Nombre'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/cyborg/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <h2>Bienvenido, <?php echo htmlspecialchars($nombre); ?></h2>
                <div class="list-group mt-4">
                    <a href="Gestion_Empleados.php" class="list-group-item list-group-item-action">Empleados</a>
                    <a href="Agregar_Compras.php" class="list-group-item list-group-item-action">Compras</a>
                    <a href="Agregar_Ventas.php" class="list-group-item list-group-item-action">Ventas</a>
                    <a href="Gestion_Proveedores.php" class="list-group-item list-group-item-action">Proveedores</a>
                    <a href="Gestion_Clientes.php" class="list-group-item list-group-item-action">Clientes</a>
                    <a href="Gestion_Historial.php" class="list-group-item list-group-item-action">Historial</a>
                    <a href="Cerrar_Sesion.php" class="list-group-item list-group-item-action text-danger">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>