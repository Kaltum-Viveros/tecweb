<?php
    /*include_once __DIR__.'/database.php';

    // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
    $producto = file_get_contents('php://input'); //se obtiene el contenido del archivo
    $data = array(
        'status'  => 'error',
        'message' => 'Ya existe un producto con ese nombre'
    ); //se crea un array con un mensaje de error
    if(!empty($producto)) {
        // SE TRANSFORMA EL STRING DEL JASON A OBJETO
        $jsonOBJ = json_decode($producto);
        // SE ASUME QUE LOS DATOS YA FUERON VALIDADOS ANTES DE ENVIARSE
        $sql = "SELECT * FROM productos WHERE nombre = '{$jsonOBJ->nombre}' AND eliminado = 0";
        $result = $conexion->query($sql);
        
        if ($result->num_rows == 0) {
            $conexion->set_charset("utf8");
            $sql = "INSERT INTO productos VALUES (null, '{$jsonOBJ->nombre}', '{$jsonOBJ->marca}', '{$jsonOBJ->modelo}', {$jsonOBJ->precio}, '{$jsonOBJ->detalles}', {$jsonOBJ->unidades}, '{$jsonOBJ->imagen}', 0)";
            if($conexion->query($sql)){
                $data['status'] =  "success";
                $data['message'] =  "Producto agregado";
            } else {
                $data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($conexion);
            }
        }

        $result->free();
        // Cierra la conexion
        $conexion->close();
    }

    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
    */

    use TECWEB\MYAPI\Products as Products; //se usa la clase Products
    include_once __DIR__.'/myapi/Products.php'; //se incluye el archivo Products.php
    $prod = new Products ('marketzone'); //se crea un objeto de la clase Products
    $prod -> add(file_get_contents('php://input')); //se llama al metodo add con el contenido del archivo como parametro 
    echo $prod -> getData(); //se imprime el resultado
?>