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

// Obtener proveedores, clientes y años
try {
    $conn = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener proveedores
    $stmt = $conn->prepare("EXEC sp_ObtenerProveedores :id_empresa");
    $stmt->bindParam(':id_empresa', $id_empresa, PDO::PARAM_INT);
    $stmt->execute();
    $proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Obtener clientes
    $stmt = $conn->query("EXEC sp_ObtenerClientes");
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Obtener años de compras
    $stmt = $conn->query("EXEC sp_ObtenerAniosCompras");
    $anios_compras = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Obtener años de ventas
    $stmt = $conn->query("EXEC sp_ObtenerAniosVentas");
    $anios_ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error al obtener los datos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Historial</title>
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/cyborg/bootstrap.min.css" rel="stylesheet">
    <script>
        function actualizarOpciones() {
            var tipoHistorial = document.getElementById('tipo_historial').value;
            var selectProveedorCliente = document.getElementById('proveedor_cliente');
            var selectAno = document.getElementById('ano');
            var labelProveedorCliente = document.getElementById('label_proveedor_cliente');
            selectProveedorCliente.innerHTML = ''; // Limpiar opciones
            selectAno.innerHTML = ''; // Limpiar opciones

            var opcionTodos = document.createElement('option');
            opcionTodos.value = 'todos';
            opcionTodos.text = 'Todos';
            selectProveedorCliente.appendChild(opcionTodos);

            if (tipoHistorial === 'compras') {
                labelProveedorCliente.textContent = 'Proveedor:';
                <?php foreach ($proveedores as $proveedor): ?>
                var opcion = document.createElement('option');
                opcion.value = '<?php echo $proveedor["ID_Proveedor"]; ?>';
                opcion.text = '<?php echo $proveedor["Nombre"] . " - " . $proveedor["Empresa"]; ?>';
                selectProveedorCliente.appendChild(opcion);
                <?php endforeach; ?>

                <?php foreach ($anios_compras as $anio): ?>
                var opcionAno = document.createElement('option');
                opcionAno.value = '<?php echo $anio["Anio"]; ?>';
                opcionAno.text = '<?php echo $anio["Anio"]; ?>';
                selectAno.appendChild(opcionAno);
                <?php endforeach; ?>
            } else if (tipoHistorial === 'ventas') {
                labelProveedorCliente.textContent = 'Cliente:';
                <?php foreach ($clientes as $cliente): ?>
                var opcion = document.createElement('option');
                opcion.value = '<?php echo $cliente["ID_Cliente"]; ?>';
                opcion.text = '<?php echo $cliente["Nombre"]; ?>';
                selectProveedorCliente.appendChild(opcion);
                <?php endforeach; ?>

                <?php foreach ($anios_ventas as $anio): ?>
                var opcionAno = document.createElement('option');
                opcionAno.value = '<?php echo $anio["Anio"]; ?>';
                opcionAno.text = '<?php echo $anio["Anio"]; ?>';
                selectAno.appendChild(opcionAno);
                <?php endforeach; ?>
            }
        }
    </script>
</head>
<body onload="actualizarOpciones()">
<div class="container mt-5">
    <h2>Gestión de Historial</h2>
    <form method="post" action="Gestion_Historial.php">
        <div class="form-row">
            <?php if ($id_rol == 1): // Solo mostrar la opción de tipo de historial si el usuario es administrador ?>
            <div class="form-group col-md-3">
                <label for="tipo_historial">Tipo de Historial:</label>
                <select class="form-control" id="tipo_historial" name="tipo_historial" onchange="actualizarOpciones()">
                    <option value="compras">Compras</option>
                    <option value="ventas">Ventas</option>
                </select>
            </div>
            <?php else: // Si es empleado, establecer tipo de historial en ventas ?>
            <input type="hidden" id="tipo_historial" name="tipo_historial" value="ventas">
            <?php endif; ?>
            <div class="form-group col-md-3">
                <label for="proveedor_cliente" id="label_proveedor_cliente"><?php echo $id_rol == 1 ? 'Proveedor/Cliente' : 'Cliente'; ?>:</label>
                <select class="form-control" id="proveedor_cliente" name="proveedor_cliente">
                    <!-- Opciones dinámicas -->
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="mes">Mes:</label>
                <select class="form-control" id="mes" name="mes">
                    <option value="todos">Todos</option>
                    <option value="1">Enero</option>
                    <option value="2">Febrero</option>
                    <option value="3">Marzo</option>
                    <option value="4">Abril</option>
                    <option value="5">Mayo</option>
                    <option value="6">Junio</option>
                    <option value="7">Julio</option>
                    <option value="8">Agosto</option>
                    <option value="9">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="ano">Año:</label>
                <select class="form-control" id="ano" name="ano">
                    <!-- Opciones dinámicas -->
                </select>
            </div>
            <div class="form-group col-md-2 align-self-end">
                <button type="submit" class="btn btn-primary">Mostrar Historial</button>
            </div>
            <div class="form-group col-md-2 align-self-end">
                <a href="<?php echo $id_rol == 1 ? 'Panel_Admin.php' : 'Panel_Empleado.php'; ?>" class="btn btn-secondary">Volver al Panel</a>
            </div>
        </div>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tipo_historial = $_POST['tipo_historial'];
        $proveedor_cliente = $_POST['proveedor_cliente'];
        $mes = $_POST['mes'];
        $ano = $_POST['ano'];

        try {
            if ($tipo_historial === 'compras' && $id_rol == 1) {
                $query = "
                    SELECT c.Fecha, p.Nombre AS Proveedor, 
                           pr.Nombre AS Producto, dc.Cantidad, pr.Precio, SUM(dc.Cantidad * pr.Precio) AS Total
                    FROM Compras c
                    JOIN Detalles_Compra dc ON c.ID_Compra = dc.ID_Compra
                    JOIN Proveedores p ON c.ID_Proveedor = p.ID_Proveedor
                    JOIN Productos pr ON dc.ID_Producto = pr.ID_Producto
                    WHERE p.ID_Empresa = :id_empresa
                    AND YEAR(c.Fecha) = :ano
                ";
                if ($proveedor_cliente !== 'todos') {
                    $query .= " AND c.ID_Proveedor = :id_proveedor";
                }
                if ($mes !== 'todos') {
                    $query .= " AND MONTH(c.Fecha) = :mes";
                }
                $query .= " GROUP BY c.Fecha, p.Nombre, pr.Nombre, dc.Cantidad, pr.Precio";

                $stmt = $conn->prepare($query);
                $stmt->bindParam(':id_empresa', $id_empresa, PDO::PARAM_INT);
                $stmt->bindParam(':ano', $ano, PDO::PARAM_INT);
                if ($proveedor_cliente !== 'todos') {
                    $stmt->bindParam(':id_proveedor', $proveedor_cliente, PDO::PARAM_INT);
                }
                if ($mes !== 'todos') {
                    $stmt->bindParam(':mes', $mes, PDO::PARAM_INT);
                }
            } else if ($tipo_historial === 'ventas') {
                $query = "
                    SELECT v.Fecha, c.Nombre AS Cliente, 
                           pr.Nombre AS Producto, dv.Cantidad, pr.Precio, SUM(dv.Cantidad * pr.Precio) AS Total
                    FROM Ventas v
                    JOIN Detalles_Venta dv ON v.ID_Venta = dv.ID_Venta
                    JOIN Clientes c ON v.ID_Cliente = c.ID_Cliente
                    JOIN Productos pr ON dv.ID_Producto = pr.ID_Producto
                    WHERE YEAR(v.Fecha) = :ano
                ";
                if ($proveedor_cliente !== 'todos') {
                    $query .= " AND v.ID_Cliente = :id_cliente";
                }
                if ($mes !== 'todos') {
                    $query .= " AND MONTH(v.Fecha) = :mes";
                }
                $query .= " GROUP BY v.Fecha, c.Nombre, pr.Nombre, dv.Cantidad, pr.Precio";

                $stmt = $conn->prepare($query);
                $stmt->bindParam(':ano', $ano, PDO::PARAM_INT);
                if ($proveedor_cliente !== 'todos') {
                    $stmt->bindParam(':id_cliente', $proveedor_cliente, PDO::PARAM_INT);
                }
                if ($mes !== 'todos') {
                    $stmt->bindParam(':mes', $mes, PDO::PARAM_INT);
                }
            }

            $stmt->execute();
            $historial = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($historial)) {
                echo '<table class="table table-bordered mt-4">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Fecha</th>';
                echo '<th>' . ($tipo_historial === 'compras' ? 'Proveedor' : 'Cliente') . '</th>';
                echo '<th>Producto</th>';
                echo '<th>Cantidad</th>';
                echo '<th>Precio por Unidad</th>';
                echo '<th>Total</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                foreach ($historial as $registro) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($registro['Fecha']) . '</td>';
                    echo '<td>' . htmlspecialchars($registro['Proveedor'] ?? $registro['Cliente']) . '</td>';
                    echo '<td>' . htmlspecialchars($registro['Producto']) . '</td>';
                    echo '<td>' . htmlspecialchars($registro['Cantidad']) . '</td>';
                    echo '<td>' . htmlspecialchars(number_format($registro['Precio'], 2)) . '</td>';
                    echo '<td>' . htmlspecialchars(number_format($registro['Total'], 2)) . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<p class="text-center mt-4">No se encontraron registros.</p>';
            }
        } catch (PDOException $e) {
            echo '<p class="text-danger mt-4">Error al obtener el historial: ' . $e->getMessage() . '</p>';
        }
    }
    ?>
</div>
</body>
</html>