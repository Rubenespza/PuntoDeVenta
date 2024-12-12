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

// Obtener los proveedores por empresa
$stmt = $conn->prepare("EXEC sp_ObtenerProveedores :id_empresa");
$stmt->bindParam(':id_empresa', $id_empresa, PDO::PARAM_INT);
$stmt->execute();
$proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Procesar el formulario de compra
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cantidad = $_POST['cantidad'];
    $id_producto = $_POST['producto'];
    $id_proveedor = $_POST['proveedor'];
    $fecha = date('Y-m-d');

    try {
        // Llamar al procedimiento almacenado para agregar la compra
        $stmt = $conn->prepare("{CALL sp_AñadirCompra(?, ?, ?, ?, ?)}");
        $stmt->bindParam(1, $id_proveedor, PDO::PARAM_INT);
        $stmt->bindParam(2, $fecha, PDO::PARAM_STR);
        $stmt->bindParam(3, $id_producto, PDO::PARAM_INT);
        $stmt->bindParam(4, $cantidad, PDO::PARAM_INT);

        // Inicializar el parámetro de salida
        $id_compra = 0;
        $stmt->bindParam(5, $id_compra, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT, 10);

        // Ejecutar el procedimiento almacenado
        $stmt->execute();

        // Redirigir a la página de detalles de la compra
        header("Location: Detalles_Compra.php?id=" . $id_compra);
        exit();
    } catch (PDOException $e) {
        die("Error al registrar la compra: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Compra</title>
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/cyborg/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Agregar Compra</h2>
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
                        <label for="proveedor">Proveedor:</label>
                        <select class="form-control" id="proveedor" name="proveedor" required>
                            <?php foreach ($proveedores as $proveedor): ?>
                                <option value="<?= $proveedor['ID_Proveedor'] ?>"><?= $proveedor['Nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Proceder con la compra</button>
                    <a href="Panel_Admin.php" class="btn btn-secondary btn-block">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
