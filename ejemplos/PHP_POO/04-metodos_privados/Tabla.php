<?php
    class Tabla {
        private $matriz = NULL;
        private $numFilas;
        private $numColumnas;
        private $estilo;

        public function __construct($rows, $cols, $style) {
            $this->numFilas = $rows;
            $this->numColumnas = $cols;
            $this->estilo = $style;
            $this->matriz = array(); //se define como un array ya que es una matriz de dos dimensiones
        }

        public function cargar($row, $col, $val){
            $this->matriz[$row][$col] = $val;
        }

        private function inicioTabla(){
            echo '<table style="'.$this->estilo.'">';
        }

        private function inicioFila(){
            echo '<tr>';
        }

        private function mostrarDato($row, $col){
            echo '<td style="'.$this->estilo.'">'.$this->matriz[$row][$col].'</td>';
        }

        private function finFila(){
            echo '</tr>';
        }

        private function finTabla(){
            echo '</table>';
        }

        public function graficar(){
            $this->inicioTabla();

            for($i=0; $i<$this->numFilas; $i++){
                $this->inicioFila();
                for($j=0; $i<$this->numColumnas; $ji++){
                    $this->mostrarDato($i, $j);
                }
                $this->finFila();
            }

            $this->finTabla();
        }
    }
?>