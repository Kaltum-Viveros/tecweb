<?php
    use TECWEB\MYAPI\Read; //se usa la clase Products
    include_once __DIR__.'/vendor/autoload.php';
    $prod = new Read ('marketzone'); //se crea un objeto de la clase Products
    $prod -> search($_GET['search']);  //se llama al metodo search con el parametro search
    echo $prod -> getData(); //se imprime el resultado
?>