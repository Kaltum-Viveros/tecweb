<?php
    namespace TECWEB\MYAPI;

    include_once __DIR__.'/DataBase.php';

    class Products extends DataBase {
        private  $data;

        public function __construct($db, $user='root', $password='k4l7u3ab') { //se ponen en ese orden los parametros para que no de error
            $this -> data = array();
            parent::__construct($db, $user, $password); //llamamos al constructor de la clase padre DataBase para que se conecte a la base de datos
        }

        public function list () {
            if ( $result = $this -> conexion->query("SELECT * FROM productos WHERE eliminado = 0") ) {
                // SE OBTIENEN LOS RESULTADOS
                $rows = $result->fetch_all(MYSQLI_ASSOC);
        
                if(!is_null($rows)) {
                    // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
                    foreach($rows as $num => $row) {
                        foreach($row as $key => $value) {
                            $this -> data[$num][$key] = $value;
                        }
                    }
                }
                $result->free();
            } else {
                die('Query Error: '.mysqli_error($this -> conexion));
            }
            $this -> conexion->close();
        }

        public function getData() {
            return json_encode($this -> data, JSON_PRETTY_PRINT);
        }

        public function search($parametro) {
            if( $parametro ) {
                $search = $parametro;
                // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
                $sql = "SELECT * FROM productos WHERE (id = '{$search}' OR nombre LIKE '%{$search}%' OR marca LIKE '%{$search}%' OR detalles LIKE '%{$search}%') AND eliminado = 0";
                if ( $result = $this -> conexion->query($sql) ) {
                    // SE OBTIENEN LOS RESULTADOS
                    $rows = $result->fetch_all(MYSQLI_ASSOC);
        
                    if(!is_null($rows)) {
                        // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
                        foreach($rows as $num => $row) {
                            foreach($row as $key => $value) {
                                $this -> data[$num][$key] = $value;
                            }
                        }
                    }
                    $result->free();
                } else {
                    die('Query Error: '.mysqli_error($this -> conexion));
                }
                $this -> conexion->close();
            } 
        }

        public function single($id){
            if( $id ) {
        
                $sql = "SELECT * FROM productos WHERE id = '{$id}'";
        
                if ( $result = $this -> conexion->query($sql) ) {
                    $rows = $result->fetch_all(MYSQLI_ASSOC); // OBTIENE TODOS LOS REGISTROS Y LOS GUARDA EN UN ARRAY
        
                    if(!is_null($rows)) {
                        foreach($rows as $num => $row) {
                            foreach($row as $key => $value) {
                                $this -> data[$num][$key] = $value;  // CODIFICA CADA CAMPO EN UTF-8
                            }
                        }
                    } //este if se encarga de verificar si hay datos en la consulta y si los hay los guarda en un array 
                    $result->free();
                } else {
                    die('Query Error: '.mysqli_error($this -> conexion));
                }
                $this -> conexion->close();
            }
        }

        public function add($object){
            $producto = $object; // se obtiene el contenido del archivo

            $msj = array(
                'status'  => 'error',
                'message' => 'Ya existe un producto con ese nombre'
            ); //se crea un array con un mensaje de error

            if(!empty($producto)) {
                // SE TRANSFORMA EL STRING DEL JASON A OBJETO
                $jsonOBJ = json_decode($producto);
                // SE ASUME QUE LOS DATOS YA FUERON VALIDADOS ANTES DE ENVIARSE
                $sql = "SELECT * FROM productos WHERE nombre = '{$jsonOBJ->nombre}' AND eliminado = 0";
                $result = $this -> conexion->query($sql);
                
                if ($result->num_rows == 0) {
                    $this -> conexion->set_charset("utf8");
                    $sql = "INSERT INTO productos VALUES (null, '{$jsonOBJ->nombre}', '{$jsonOBJ->marca}', '{$jsonOBJ->modelo}', {$jsonOBJ->precio}, '{$jsonOBJ->detalles}', {$jsonOBJ->unidades}, '{$jsonOBJ->imagen}', 0)";
                    if($this -> conexion->query($sql)){
                        $this -> data['status'] =  "success";
                        $this -> data['message'] =  "Producto agregado";
                    } else {
                        $this -> data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this -> conexion);
                    }
                }

                $result->free();
                // Cierra la conexion
                $this -> conexion->close();
            }
        }

        public function delete($id){
            $msj = array(
                'status'  => 'error',
                'message' => 'La consulta falló'
            );
            // SE VERIFICA HABER RECIBIDO EL ID
            if( $id ) {
                // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
                $sql = "UPDATE productos SET eliminado=1 WHERE id = {$id}";
                if ( $this -> conexion->query($sql) ) {
                    $this -> data['status'] =  "success";
                    $this -> data['message'] =  "Producto eliminado";
                } else {
                    $this -> data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this -> conexion);
                }
                $this -> conexion->close();
            } 
        }

        public function edit($object){
            $producto = $object;
            $msj = array(
                'status'  => 'error',
                'message' => 'No se encontró el producto o ocurrió un error'
            );

            if (!empty($producto)) { // SE VERIFICA QUE EL JSON NO ESTÉ VACÍO 
                // SE TRANSFORMA EL STRING DEL JSON A OBJETO
                $jsonOBJ = json_decode($producto);

                if (isset($jsonOBJ->id)) {
                    // SE ASUME QUE LOS DATOS YA FUERON VALIDADOS ANTES DE ENVIARSE
                    $id = $jsonOBJ->id; // SE OBTIENE EL ID DEL PRODUCTO
                    $sql = "SELECT * FROM productos WHERE id = '{$id}' AND eliminado = 0";
                    $result = $this -> conexion->query($sql);

                    // Verificar si existe el producto con el nombre proporcionado
                    if ($result->num_rows > 0) {
                        // SE PREPARA EL UPDATE
                        $this -> conexion->set_charset("utf8"); // SE CAMBIA EL CHARSET A UTF-8
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
                        if ($this -> conexion->query($sql)) {
                            $this -> data['status'] = "success";
                            $this -> data['message'] = "Producto actualizado correctamente";
                        } else {
                            $this -> data['message'] = "ERROR: No se pudo ejecutar $sql. " . mysqli_error($this -> conexion);
                        }
                    } else {
                        // Producto no encontrado
                        $this -> data['message'] = "No se encontró el producto con el nombre especificado.";
                    }

                    $result->free();
                } else {
                    // Error si no se envió el nombre
                    $this -> data['message'] = "El ID del producto no fue proporcionado en el JSON.";
                }

                // Cerrar la conexión
                $this -> conexion->close();
            }
        }
    }
?>