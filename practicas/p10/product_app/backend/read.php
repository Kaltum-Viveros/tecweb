<?php
include_once __DIR__.'/database.php';

// SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
$data = array();

// SE VERIFICA HABER RECIBIDO EL TÉRMINO DE BÚSQUEDA
if (isset($_POST['searchProduct'])) {
    $searchProduct = $_POST['searchProduct'];

    // SE REALIZA LA QUERY DE BÚSQUEDA CON LIKE PARA BUSCAR EN NOMBRE, MARCA, DETALLES Y ID
    if ($result = $conexion->query("SELECT * FROM productos WHERE nombre LIKE '%{$searchProduct}%' OR marca LIKE '%{$searchProduct}%' OR detalles LIKE '%{$searchProduct}%' OR id = '{$searchProduct}'")) {
        // SE OBTIENEN LOS RESULTADOS
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $data[] = $row; // Agregar cada fila a $data
        }
        $result->free();
    } else {
        die('Query Error: '.mysqli_error($conexion));
    }
    $conexion->close();
}

// SE HACE LA CONVERSIÓN DE ARRAY A JSON
echo json_encode($data, JSON_PRETTY_PRINT);
?>