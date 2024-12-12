<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

// Conectar a la base de datos
require_once 'config.php';

// Obtener el correo y la empresa del usuario actual
$correo = $_SESSION['usuario'];
$stmt = $conn->prepare("SELECT ID_Empresa, ID_Rol FROM Usuarios WHERE Correo = :correo");
$stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    session_destroy();
    header("Location: index.php");
    exit();
}

$id_empresa = $usuario['ID_Empresa'];
$id_rol = $usuario['ID_Rol'];

// Obtener los productos por empresa
$stmt = $conn->prepare("SELECT ID_Producto, Nombre FROM Productos WHERE ID_Empresa = :id_empresa");
$stmt->bindParam(':id_empresa', $id_empresa, PDO::PARAM_INT);
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener los clientes
$stmt = $conn->prepare("EXEC sp_ObtenerClientes");
$stmt->execute();
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Procesar el formulario de venta
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cantidad = $_POST['cantidad'];
    $id_producto = $_POST['producto'];
    $id_cliente = $_POST['cliente'];
    $fecha = date('Y-m-d');

    try {
        // Llamar al procedimiento almacenado para agregar la venta
        $stmt = $conn->prepare("{CALL sp_AñadirVenta(?, ?, ?, ?, ?)}");
        $stmt->bindParam(1, $id_cliente, PDO::PARAM_INT);
        $stmt->bindParam(2, $fecha, PDO::PARAM_STR);
        $stmt->bindParam(3, $id_producto, PDO::PARAM_INT);
        $stmt->bindParam(4, $cantidad, PDO::PARAM_INT);
        
        // Inicializar el parámetro de salida
        $id_venta = 0;
        $stmt->bindParam(5, $id_venta, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT, 10);
        
        // Ejecutar el procedimiento almacenado
        $stmt->execute();

        // Redirigir a la página de detalles de la venta
        header("Location: Detalles_Venta.php?id=" . $id_venta);
        exit();
    } catch (PDOException $e) {
        die("Error al registrar la venta: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Venta</title>
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/cyborg/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Agregar Venta</h2>
                <form method="post">
                    <div class="form-group">
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                    </div>
                    <div class="form-group">
                        <label for="producto">Producto:</label>
                        <select class="form-control" id="producto" name="producto" required>
                            <?php foreach ($productos as $producto): ?>
                                <option value="<?= $producto['ID_Producto'] ?>"><?= $producto['Nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cliente">Cliente:</label>
                        <select class="form-control" id="cliente" name="cliente" required>
                            <?php foreach ($clientes as $cliente): ?>
                                <option value="<?= $cliente['ID_Cliente'] ?>"><?= $cliente['Nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Proceder con la venta</button>
                    <a href="Panel_Admin.php" class="btn btn-secondary btn-block">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>