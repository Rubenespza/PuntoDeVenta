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
$stmt = $conn->prepare("SELECT ID_Empresa FROM Usuarios WHERE Correo = :correo");
$stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    session_destroy();
    header("Location: index.php");
    exit();
}

$id_empresa = $usuario['ID_Empresa'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $empresa = $_POST['empresa'];

    try {
        // Llamar al procedimiento almacenado para agregar el nuevo proveedor
        $stmt = $conn->prepare("{CALL sp_CrearProveedor(?, ?, ?)}");
        $stmt->bindParam(1, $nombre, PDO::PARAM_STR);
        $stmt->bindParam(2, $empresa, PDO::PARAM_STR);
        $stmt->bindParam(3, $id_empresa, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: Gestion_Proveedores.php");
        exit();
    } catch (PDOException $e) {
        echo "<p>Error al crear el proveedor: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Proveedor</title>
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/cyborg/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Crear Proveedor</h2>
                <form method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="empresa">Empresa:</label>
                        <input type="text" class="form-control" id="empresa" name="empresa" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Crear Proveedor</button>
                    <a href="Gestion_Proveedores.php" class="btn btn-secondary btn-block">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>