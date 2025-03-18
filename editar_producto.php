<?php
// Incluir archivo de configuración
require_once 'config.php';

// Variables para mensajes de error y éxito
$msg = '';
$error = '';

// Verificar si se proporcionó un ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: productos.php?error=ID de producto no válido");
    exit();
}

$id = intval($_GET['id']);

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $precio = floatval($_POST['precio']);
    $categoria = $conn->real_escape_string($_POST['categoria']);
    $stock = intval($_POST['stock']);
    
    // Verificar que todos los campos estén completos
    if (empty($nombre) || empty($descripcion) || $precio <= 0 || empty($categoria) || $stock < 0) {
        $error = "Por favor, complete todos los campos correctamente.";
    } else {
        // Actualizar el producto en la base de datos
        $sql = "UPDATE productos SET 
                nombre = '$nombre', 
                descripcion = '$descripcion', 
                precio = $precio, 
                categoria = '$categoria', 
                stock = $stock 
                WHERE id = $id";
        
        if ($conn->query($sql) === TRUE) {
            header("Location: productos.php?msg=Producto actualizado correctamente");
            exit();
        } else {
            $error = "Error al actualizar el producto: " . $conn->error;
        }
    }
}

// Obtener la información del producto
$sql = "SELECT * FROM productos WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows != 1) {
    header("Location: productos.php?error=Producto no encontrado");
    exit();
}

$producto = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto - TechStore</title>
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
            <h2>Editar Producto</h2>
            
            <?php if (!empty($msg)): ?>
                <div class="alert success"><?php echo $msg; ?></div>
            <?php endif; ?>
            
            <?php if (!empty($error)): ?>
                <div class="alert error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id); ?>">
                <div class="form-group">
                    <label for="nombre">Nombre del Producto:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo $producto['nombre']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" rows="4" required><?php echo $producto['descripcion']; ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="precio">Precio:</label>
                    <input type="number" id="precio" name="precio" step="0.01" min="0" value="<?php echo $producto['precio']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="categoria">Categoría:</label>
                    <select id="categoria" name="categoria" required>
                        <option value="">Seleccionar categoría</option>
                        <option value="Smartphones" <?php echo ($producto['categoria'] == "Smartphones") ? 'selected' : ''; ?>>Smartphones</option>
                        <option value="Laptops" <?php echo ($producto['categoria'] == "Laptops") ? 'selected' : ''; ?>>Laptops</option>
                        <option value="Accesorios" <?php echo ($producto['categoria'] == "Accesorios") ? 'selected' : ''; ?>>Accesorios</option>
                        <option value="Smart TVs" <?php echo ($producto['categoria'] == "Smart TVs") ? 'selected' : ''; ?>>Smart TVs</option>
                        <option value="Audio" <?php echo ($producto['categoria'] == "Audio") ? 'selected' : ''; ?>>Audio</option>
                        <option value="Gaming" <?php echo ($producto['categoria'] == "Gaming") ? 'selected' : ''; ?>>Gaming</option>
                        <option value="Electrodomésticos" <?php echo ($producto['categoria'] == "Electrodomésticos") ? 'selected' : ''; ?>>Electrodomésticos</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="stock">Stock:</label>
                    <input type="number" id="stock" name="stock" min="0" value="<?php echo $producto['stock']; ?>" required>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn">Actualizar Producto</button>
                    <a href="productos.php" class="btn">Cancelar</a>
                </div>
            </form>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 TechStore - Todos los derechos reservados</p>
        </div>
    </footer>
</body>
</html>