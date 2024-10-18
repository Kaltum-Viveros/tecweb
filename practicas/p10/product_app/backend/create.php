<?php
    include_once __DIR__.'/database.php';

    // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
    $producto = file_get_contents('php://input');
    
    if (!empty($producto)) {
        // SE TRANSFORMA EL STRING DEL JSON A OBJETO
        $jsonOBJ = json_decode($producto);

        // VALIDAR QUE TODOS LOS CAMPOS OBLIGATORIOS ESTÉN PRESENTES
        if (isset($jsonOBJ->nombre) && isset($jsonOBJ->marca) && isset($jsonOBJ->modelo) && isset($jsonOBJ->precio) && isset($jsonOBJ->unidades)) {
            $nombre = $jsonOBJ->nombre;
            $marca = $jsonOBJ->marca;
            $modelo = $jsonOBJ->modelo;
            $precio = $jsonOBJ->precio;
            $detalles = isset($jsonOBJ->detalles) ? $jsonOBJ->detalles : ''; // Detalles es opcional
            $unidades = $jsonOBJ->unidades;
            $imagen = isset($jsonOBJ->imagen) ? $jsonOBJ->imagen : 'default.png'; // Imagen es opcional

            // CONSULTA PARA VERIFICAR SI EL PRODUCTO YA EXISTE
            $queryCheck = "SELECT * FROM productos WHERE nombre = ? AND eliminado = 0";
            $stmtCheck = $conexion->prepare($queryCheck);
            $stmtCheck->bind_param("s", $nombre);
            $stmtCheck->execute();
            $result = $stmtCheck->get_result();

            // SI EL PRODUCTO YA EXISTE Y NO ESTÁ ELIMINADO
            if ($result->num_rows > 0) {
                echo json_encode(["success" => false, "message" => "El producto ya existe y no ha sido eliminado."]);
            } else {
                // SI NO EXISTE, SE REALIZA LA INSERCIÓN
                $queryInsert = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmtInsert = $conexion->prepare($queryInsert);
                $stmtInsert->bind_param("sssdsis", $nombre, $marca, $modelo, $precio, $detalles, $unidades, $imagen);

                // EJECUTAR INSERCIÓN
                if ($stmtInsert->execute()) {
                    // RESPUESTA EXITOSA
                    echo json_encode(["success" => true, "message" => "Producto insertado exitosamente."]);
                } else {
                    // ERROR EN LA INSERCIÓN
                    echo json_encode(["success" => false, "message" => "Error al insertar el producto."]);
                }

                $stmtInsert->close();
            }

            $stmtCheck->close();
        } else {
            // FALTAN CAMPOS OBLIGATORIOS
            echo json_encode(["success" => false, "message" => "Faltan campos obligatorios."]);
        }
    } else {
        // NO SE RECIBIÓ INFORMACIÓN DEL CLIENTE
        echo json_encode(["success" => false, "message" => "No se recibió ningún dato."]);
    }

    // CERRAR CONEXIÓN A LA BASE DE DATOS
    $conexion->close();
?>