<?php
    namespace TECWEB\MYAPI;
    include_once __DIR__.'/DataBase.php';
    class Update extends DataBase {

        public function __construct($db, $user='root', $pass='k4l7u3ab') {
            $this->data = array();
            parent::__construct($db, $user, $pass);
        }

        public function edit($object) {
            $producto = $object;
            $this->data = array(
                'status'  => 'error',
                'message' => 'No se encontró el producto o ocurrió un error'
            );

            if (!empty($producto)) {
                // SE TRANSFORMA EL STRING DEL JSON A OBJETO
                $jsonOBJ = json_decode($producto);

                // Verificar que el id del producto existe en el JSON
                if (isset($jsonOBJ->id)) {
                    // SE ASUME QUE LOS DATOS YA FUERON VALIDADOS ANTES DE ENVIARSE
                    $id = $jsonOBJ->id;
                    $sql = "SELECT * FROM productos WHERE id = '{$id}' AND eliminado = 0";
                    $result = $this->conexion->query($sql);

                    // Verificar si existe el producto con el id proporcionado
                    if ($result->num_rows > 0) {
                        // SE PREPARA EL UPDATE
                        $this->conexion->set_charset("utf8");
                        $sql = "UPDATE productos SET
                                    nombre = '{$jsonOBJ->nombre}',
                                    marca = '{$jsonOBJ->marca}',
                                    modelo = '{$jsonOBJ->modelo}',
                                    precio = {$jsonOBJ->precio},
                                    detalles = '{$jsonOBJ->detalles}',
                                    unidades = {$jsonOBJ->unidades},
                                    imagen = '{$jsonOBJ->imagen}'
                                WHERE id = '{$id}' AND eliminado = 0";

                        // Ejecutar la consulta de actualización
                        if ($this->conexion->query($sql)) {
                            $this->data['status'] = "success";
                            $this->data['message'] = "Producto actualizado correctamente";
                        } else {
                            $this->data['message'] = "ERROR: No se pudo ejecutar $sql. " . mysqli_error($this->conexion);
                        }
                    } else {
                        // Producto no encontrado
                        $this->data['message'] = "No se encontró el producto con el id especificado.";
                    }

                    $result->free();
                } else {
                    // Error si no se envió el id
                    $this->data['message'] = "El id del producto no fue proporcionado en el JSON.";
                }

                // Cerrar la conexión
                $this->conexion->close();
            }
        }

    }
?>