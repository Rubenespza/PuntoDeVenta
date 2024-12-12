<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

// Conectar a la base de datos
require_once 'config.php';

// Obtener el ID de la venta desde la URL
$id_venta = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_venta <= 0) {
    echo "ID de venta inválido.";
    exit();
}

// Obtener los detalles de la venta
$stmt = $conn->prepare("EXEC sp_ObtenerDatosVenta :id_venta");
$stmt->bindParam(':id_venta', $id_venta, PDO::PARAM_INT);
$stmt->execute();
$detalles_venta = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$detalles_venta) {
    echo "No se encontraron detalles para esta venta.";
    exit();
}

// Obtener el rol del usuario actual para redirigir
$usuario_rol = $_SESSION['id_rol'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Venta</title>
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/cyborg/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Detalles de la Venta</h2>
        <?php if (!empty($detalles_venta)): ?>
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Producto</th>
                        <th>Precio por Unidad</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detalles_venta as $detalle): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($detalle['Fecha']); ?></td>
                            <td><?php echo htmlspecialchars($detalle['Cliente']); ?></td>
                            <td><?php echo htmlspecialchars($detalle['Producto']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($detalle['Precio'], 2)); ?></td>
                            <td><?php echo htmlspecialchars($detalle['Cantidad']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($detalle['Total'], 2)); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center">No se encontraron detalles para esta venta.</p>
        <?php endif; ?>
        <div class="text-center mt-4">
            <a href="<?php echo $usuario_rol == 1 ? 'Panel_Admin.php' : 'Panel_Empleado.php'; ?>" class="btn btn-secondary">Volver al Panel</a>
        </div>
    </div>
</body>
</html>