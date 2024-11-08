<?php
    /*
    include_once __DIR__.'/database.php';

    $data = array();

    if( isset($_POST['id']) ) {
        $id = $_POST['id'];

        $sql = "SELECT * FROM productos WHERE id = '{$id}'";

        if ( $result = $conexion->query($sql) ) {
            $rows = $result->fetch_all(MYSQLI_ASSOC); // OBTIENE TODOS LOS REGISTROS Y LOS GUARDA EN UN ARRAY

            if(!is_null($rows)) {
                foreach($rows as $num => $row) {
                    foreach($row as $key => $value) {
                        $data[$num][$key] = $value;  // CODIFICA CADA CAMPO EN UTF-8
                    }
                }
            } //este if se encarga de verificar si hay datos en la consulta y si los hay los guarda en un array 
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($conexion));
        }
        $conexion->close();
    }

    echo json_encode($data, JSON_PRETTY_PRINT);
    //este archivo se encarga de devolver los datos de un producto en formato JSON 
    */

    use TECWEB\MYAPI\Products as Products; //se usa la clase Products
    include_once __DIR__.'/myapi/Products.php'; //se incluye el archivo Products.php
    $prod = new Products ('marketzone'); //se crea un objeto de la clase Products
    $prod -> single($_POST['id']); //se llama al metodo single
    echo $prod -> getData(); //se imprime el resultado
?>

