<?php
// Incluir archivo de configuración
require_once 'config.php';

// Verificar si se proporcionó un ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: productos.php?error=ID de producto no válido");
    exit();
}

$id = intval($_GET['id']);

// Verificar que el producto existe
$sql = "SELECT id FROM productos WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows != 1) {
    header("Location: productos.php?error=Producto no encontrado");
    exit();
}

// Eliminar el producto
$sql = "DELETE FROM productos WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: productos.php?msg=Producto eliminado correctamente");
} else {
    header("Location: productos.php?error=Error al eliminar el producto: " . $conn->error);
}

$conn->close();
?>