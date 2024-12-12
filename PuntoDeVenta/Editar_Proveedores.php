<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

// Conectar a la base de datos
require_once 'config.php';

// Obtener el ID del proveedor a editar desde la URL
$id_proveedor = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Guardar los cambios del formulario
    $nombre = $_POST['nombre'];
    $empresa = $_POST['empresa'];

    $stmt = $conn->prepare("EXEC sp_EditarProveedor :id_proveedor, :nombre, :empresa");
    $stmt->bindParam(':id_proveedor', $id_proveedor, PDO::PARAM_INT);
    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmt->bindParam(':empresa', $empresa, PDO::PARAM_STR);
    $stmt->execute();

    header("Location: Gestion_Proveedores.php");
    exit();
}

// Obtener los datos actuales del proveedor
$stmt = $conn->prepare("SELECT Nombre, Empresa FROM Proveedores WHERE ID_Proveedor = :id_proveedor");
$stmt->bindParam(':id_proveedor', $id_proveedor, PDO::PARAM_INT);
$stmt->execute();
$proveedor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$proveedor) {
    header("Location: Gestion_Proveedores.php");
    exit();
}

$nombre = $proveedor['Nombre'];
$empresa = $proveedor['Empresa'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proveedor</title>
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/cyborg/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Editar Proveedor</h2>
                <form method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="empresa">Empresa</label>
                        <input type="text" class="form-control" id="empresa" name="empresa" value="<?php echo htmlspecialchars($empresa); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Editar Proveedor</button>
                    <a href="Gestion_Proveedores.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>