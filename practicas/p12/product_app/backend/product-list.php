<?php
    use TECWEB\MYAPI\Read; //se usa la clase Products
    include_once __DIR__.'/vendor/autoload.php'; 
    $prod = new Read ('marketzone'); //se crea un objeto de la clase Products
    $prod -> list(); //se llama al metodo list
    echo $prod -> getData(); //se imprime el resultado
?>