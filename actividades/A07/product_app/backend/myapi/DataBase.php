<?php
    namespace myapi\db;

    abstract class DataBase { //es una clase abstracta ya que no se puede instanciar
        protected $conection;

        public function __construct($db, $user, $password) {



            $this -> conection = new mysqli('localhost', 'root', 'k4l7u3ab', 'marketzone', 3307);
        }
    }
?>