<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['usuario']) && isset($_POST['contraseña'])) {
        $usuario = $_POST['usuario'];
        $contraseña = $_POST['contraseña'];

        try {
            $stmt = $conn->prepare("SELECT ID_Usuario, Nombre, Correo, Contraseña, ID_Rol FROM Usuarios WHERE Correo = :correo");
            $stmt->bindParam(':correo', $usuario, PDO::PARAM_STR);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($contraseña, $usuario['Contraseña'])) {
                $_SESSION['usuario'] = $usuario['Correo'];
                $_SESSION['id_rol'] = $usuario['ID_Rol'];
                $_SESSION['nombre'] = $usuario['Nombre'];

                if ($usuario['ID_Rol'] == 1) {
                    header("Location: Panel_Admin.php");
                } else {
                    header("Location: Panel_Empleado.php");
                }
                exit();
            } else {
                $error = "Usuario o contraseña incorrectos";
            }
        } catch (PDOException $e) {
            $error = "Error en la conexión: " . $e->getMessage();
        }
    } else {
        $error = "Por favor, complete todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/cyborg/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Inicio de Sesión</h2>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="post">
                    <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <input type="email" class="form-control" id="usuario" name="usuario" required>
                    </div>
                    <div class="form-group">
                        <label for="contraseña">Contraseña</label>
                        <input type="password" class="form-control" id="contraseña" name="contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
