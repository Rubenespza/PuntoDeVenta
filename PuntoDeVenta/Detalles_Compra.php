<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

require_once 'config.php';

// Verificar si se proporcionó un ID de compra
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de compra inválido.");
}

$id_compra = $_GET['id'];

// Obtener los detalles de la compra
$stmt = $conn->prepare("EXEC sp_ObtenerDatosCompra :id_compra");
$stmt->bindParam(':id_compra', $id_compra, PDO::PARAM_INT);
$stmt->execute();
$compra = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($compra)) {
    die("No se encontraron detalles para esta compra.");
}

// Obtener el rol del usuario
$usuario_rol = $_SESSION['id_rol'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Compra</title>
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/cyborg/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Detalles de la Compra</h2>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Proveedor</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($compra as $detalle): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($detalle['Fecha']); ?></td>
                        <td><?php echo htmlspecialchars($detalle['Proveedor']); ?></td>
                        <td><?php echo htmlspecialchars($detalle['Producto']); ?></td>
                        <td><?php echo htmlspecialchars($detalle['Cantidad']); ?></td>
                        <td><?php echo htmlspecialchars(number_format($detalle['Precio'], 2)); ?></td>
                        <td><?php echo htmlspecialchars(number_format($detalle['Cantidad'] * $detalle['Precio'], 2)); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="<?php echo $usuario_rol == 1 ? 'Panel_Admin.php' : 'Panel_Empleado.php'; ?>" class="btn btn-secondary">Volver al Panel</a>
    </div>
</body>
</html>
