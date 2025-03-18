<?php
// Incluir archivo de configuración
require_once 'config.php';

// Variables para mensajes de error y éxito
$msg = '';
$error = '';

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
        // Insertar el producto en la base de datos
        $sql = "INSERT INTO productos (nombre, descripcion, precio, categoria, stock) 
                VALUES ('$nombre', '$descripcion', $precio, '$categoria', $stock)";
        
        if ($conn->query($sql) === TRUE) {
            $msg = "Producto registrado correctamente.";
            // Limpiar el formulario
            $nombre = $descripcion = $categoria = '';
            $precio = $stock = 0;
        } else {
            $error = "Error al registrar el producto: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Producto - TechStore</title>
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
            <h2>Registrar Nuevo Producto</h2>
            
            <?php if (!empty($msg)): ?>
                <div class="alert success"><?php echo $msg; ?></div>
            <?php endif; ?>
            
            <?php if (!empty($error)): ?>
                <div class="alert error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="nombre">Nombre del Producto:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="precio">Precio:</label>
                    <input type="number" id="precio" name="precio" step="0.01" min="0" required>
                </div>
                
                <div class="form-group">
                    <label for="categoria">Categoría:</label>
                    <select id="categoria" name="categoria" required>
                        <option value="">Seleccionar categoría</option>
                        <option value="Smartphones">Smartphones</option>
                        <option value="Laptops">Laptops</option>
                        <option value="Accesorios">Accesorios</option>
                        <option value="Smart TVs">Smart TVs</option