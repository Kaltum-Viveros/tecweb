<?php
    require_once __DIR__ . '/Cabecera.php';
    require_once __DIR__ . '/Cuerpo.php';
    require_once __DIR__ . '/Pie.php';

    class Pagina {
        private $cabecera;
        private $cuerpo;
        private $pie;
        
        public function __construct($title, $location, $msj) {
            $this -> cabecera = new Cabecera($title, $location);
            $this -> cuerpo = new Cuerpo();
            $this -> pie = new Pie($msj);
        } //es una semantica de contenido fuerte ya que se le pasa el titulo, la ubicacion y el mensaje 
        
        public function insertar_cuerpo($text) {
            $this -> cuerpo -> insertar_parrafo($text);
        }

        public function graficar() {
            $this -> cabecera -> graficar();
            $this -> cuerpo -> graficar();
            $this -> pie -> graficar();
        }
    }
?>