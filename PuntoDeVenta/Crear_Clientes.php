<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

// Conectar a la base de datos
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];

    try {
        // Llamar al procedimiento almacenado para agregar el nuevo cliente
        $stmt = $conn->prepare("{CALL sp_CrearCliente(?)}");
        $stmt->bindParam(1, $nombre, PDO::PARAM_STR);
        $stmt->execute();

        header("Location: Gestion_Clientes.php");
        exit();
    } catch (PDOException $e) {
        echo "<p>Error al crear el cliente: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cliente</title>
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/cyborg/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Crear Cliente</h2>
                <form method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Crear Cliente</button>
                    <a href="Gestion_Clientes.php" class="btn btn-secondary btn-block">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>