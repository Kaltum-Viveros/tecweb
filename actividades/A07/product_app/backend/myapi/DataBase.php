<?php
    namespace TECWEB\MYAPI;
    
    abstract class DataBase { //es una clase abstracta ya que no se puede instanciar
        protected $conexion;

        public function __construct($db, $user, $password) {
            $this -> conexion = new \mysqli('localhost', $user, $password, $db, 3307); // el simbolo \ es para que busque la clase mysqli en el namespace global
        }
    }
?>