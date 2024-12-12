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

// Obtener roles
try {
    $conn = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query("SELECT ID_Rol, Descripcion FROM Roles");
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener los datos: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_rol = $_POST['id_rol'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);

    try {
        // Llamar al procedimiento almacenado para agregar el nuevo empleado
        $stmt = $conn->prepare("{CALL sp_CrearUsuario(?, ?, ?, ?, ?)}");
        $stmt->bindParam(1, $id_empresa, PDO::PARAM_INT);
        $stmt->bindParam(2, $id_rol, PDO::PARAM_INT);
        $stmt->bindParam(3, $nombre, PDO::PARAM_STR);
        $stmt->bindParam(4, $correo, PDO::PARAM_STR);
        $stmt->bindParam(5, $contraseña, PDO::PARAM_STR);
        $stmt->execute();

        header("Location: Gestion_Empleados.php");
        exit();
    } catch (PDOException $e) {
        echo "<p>Error al crear el empleado: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Empleado</title>
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/cyborg/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Crear Empleado</h2>
                <form method="post">
                    <div class="form-group">
                        <label for="id_rol">Rol:</label>
                        <select class="form-control" id="id_rol" name="id_rol" required>
                            <?php foreach ($roles as $rol): ?>
                                <option value="<?= $rol['ID_Rol'] ?>"><?= $rol['Descripcion'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo:</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>
                    <div class="form-group">
                        <label for="contraseña">Contraseña:</label>
                        <input type="password" class="form-control" id="contraseña" name="contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Crear Empleado</button>
                    <a href="Gestion_Empleados.php" class="btn btn-secondary btn-block">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>