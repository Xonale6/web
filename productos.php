<?php
// Incluir archivo de configuración
require_once 'config.php';

// Mensaje de operación exitosa o error
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
$error = isset($_GET['error']) ? $_GET['error'] : '';

// Obtener todos los productos
$sql = "SELECT * FROM productos ORDER BY fecha_registro DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - TechStore</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>TechStore</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="bienvenida.php">Bienvenida</a></li>
                    <li><a href="nuevo_producto.php">Nuevo Producto</a></li>
                    <li><a href="productos.php">Productos</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="empresa-info">
            <h2>Listado de Productos</h2>
            
            <?php if (!empty($msg)): ?>
                <div class="alert success"><?php echo $msg; ?></div>
            <?php endif; ?>
            
            <?php if (!empty($error)): ?>
                <div class="alert error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <a href="nuevo_producto.php" class="btn">Agregar Nuevo Producto</a>
            
            <?php if ($result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Categoría</th>
                            <th>Stock</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['nombre']; ?></td>
                                <td>$<?php echo number_format($row['precio'], 2); ?></td>
                                <td><?php echo $row['categoria']; ?></td>
                                <td><?php echo $row['stock']; ?></td>
                                <td class="actions">
                                    <a href="editar_producto.php?id=<?php echo $row['id']; ?>" class="btn">Editar</a>
                                    <a href="eliminar_producto.php?id=<?php echo $row['id']; ?>" class="btn" onclick="return confirm('¿Está seguro de que desea eliminar este producto?');">Eliminar</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No hay productos registrados.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 TechStore - Todos los derechos reservados</p>
        </div>
    </footer>
</body>
</html>