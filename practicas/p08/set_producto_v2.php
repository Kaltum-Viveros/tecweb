<!-- Validar que el nombre, modelo y la marca no existan ya en la BD. Si los datos son
correctos, insertar a la BD. En caso de éxito, mostrar un resumen de los datos
insertados. En caso contrario, mostrar un mensaje sobre el documento XHTML de
respuesta que determine el error cometido. -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <title>Registro Completado</title>
    <style type="text/css">
        body {
            margin: 20px;
            background-color: #C4DF9B;
            font-family: Verdana, Helvetica, sans-serif;
            font-size: 90%;
        }

        h1 {
            color: #005825;
            border-bottom: 1px solid #005825;
        }

        h2 {
            font-size: 1.2em;
            color: #4A0048;
        }
    </style>

</head>

<body>
    <h1>REGISTRO PRODUCTO</h1>

    <?php

    $nombre = isset($_POST['name']) ? $_POST['name'] : 'nombre_producto'; // Si existe el valor, se asigna a la variable, si no, se asigna un valor por defecto
    $marca = isset($_POST['brand']) ? $_POST['brand'] : 'marca_producto';
    $modelo = isset($_POST['model']) ? $_POST['model'] : 'modelo_producto';
    $precio = isset($_POST['price']) ? $_POST['price'] : 0;
    $detalles = isset($_POST['details']) ? $_POST['details'] : 'detalles_producto';
    $unidades = isset($_POST['units']) ? $_POST['units'] : 0;
    $imagen = isset($_POST['img']) ? $_POST['img'] : 'imagen_producto';

    /** SE CREA EL OBJETO DE CONEXION */
    @$link = new mysqli('localhost', 'root', 'k4l7u3ab', 'marketzone', 3307);

    /** comprobar la conexión */
    if ($link->connect_errno) {
        die('Falló la conexión: ' . $link->connect_error . '<br/>');
        /** NOTA: con @ se suprime el Warning para gestionar el error por medio de código */
    }

    $sql = "SELECT * FROM productos WHERE nombre = '{$nombre}' AND marca = '{$marca}' AND modelo = '{$modelo}'";
    $result = $link->query($sql); // Ejecuta la consulta y guarda el resultado

    if ($result->num_rows > 0) { // Si hay al menos un registro
        echo '<p>El producto ya se encuentra registrado</p>';
    } else {
        $sql = "INSERT INTO productos VALUES (null, '{$nombre}', '{$marca}', '{$modelo}', {$precio}, '{$detalles}', {$unidades}, '{$imagen}', 0)";
        if ($link->query($sql)) { // Ejecuta la consulta y guarda el resultado
            echo '<p>Producto insertado con ID: ' . $link->insert_id . '</p>';
        } else {
            echo '<p>El Producto no pudo ser insertado </p>'; 
        }
    }

    $link->close(); // Cierra la conexión

    ?>
</body>

</html>
