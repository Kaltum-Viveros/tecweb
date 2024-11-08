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
    }
?>