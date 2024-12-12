<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

// Conectar a la base de datos
require_once 'config.php';

// Obtener el ID del cliente a editar desde la URL
$id_cliente = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Guardar los cambios del formulario
    $nombre = $_POST['nombre'];

    $stmt = $conn->prepare("EXEC sp_EditarCliente :id_cliente, :nombre");
    $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmt->execute();

    header("Location: Gestion_Clientes.php");
    exit();
}

// Obtener los datos actuales del cliente
$stmt = $conn->prepare("SELECT Nombre FROM Clientes WHERE ID_Cliente = :id_cliente");
$stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
$stmt->execute();
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cliente) {
    header("Location: Gestion_Clientes.php");
    exit();
}

$nombre = $cliente['Nombre'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/cyborg/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Editar Cliente</h2>
                <form method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Editar Cliente</button>
                    <a href="Gestion_Clientes.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>