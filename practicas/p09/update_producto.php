<?php
// Obtener los datos del formulario (se asume que provienen de un método POST)
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$precio = $_POST['precio'];
$detalles = $_POST['detalles'];
$unidades = $_POST['unidades'];
$imagen = $_POST['imagen'];

/* MySQL Conexion */
$link = mysqli_connect("localhost", "root", "k4l7u3ab", "marketzone", 3307);

// Chequea conexión
if ($link === false) {
    die("ERROR: No pudo conectarse con la DB. " . mysqli_connect_error());
}

// Preparamos la consulta para actualizar el producto
$sql = "UPDATE productos SET nombre = '{$nombre}', marca = '{$marca}', modelo = '{$modelo}', precio = {$precio}, detalles = '{$detalles}', unidades = {$unidades}, imagen = '{$imagen}' WHERE id = {$id}";

if (mysqli_query($link, $sql)) { // Ejecuta la consulta
    echo '<h1>Registro actualizado.</h1>';
    echo '<p><strong>ID del Producto:</strong> ' . $id . '</p>';
    echo '<p><strong>Nombre:</strong> ' . $nombre . '</p>';
    echo '<p><strong>Marca:</strong> ' . $marca . '</p>';
    echo '<p><strong>Modelo:</strong> ' . $modelo . '</p>';
    echo '<p><strong>Precio:</strong> ' . $precio . '</p>';
    echo '<p><strong>Detalles:</strong> ' . $detalles . '</p>';
    echo '<p><strong>Unidades:</strong> ' . $unidades . '</p>';
} else {
    echo "ERROR: No se ejecutó $sql. " . mysqli_error($link);
}

// Cierra la conexión
mysqli_close($link);

echo '<br><p>
        <a href="get_productos_xhtml_v2.php">Ver Productos XHTML</a> |
        <a href="get_productos_vigentes_v2.php">Ver Productos Vigentes</a>
        </p>';
?>