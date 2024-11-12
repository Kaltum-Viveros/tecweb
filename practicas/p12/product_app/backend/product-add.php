<?php
    use TECWEB\MYAPI\Create; //se usa la clase Products
    include_once __DIR__.'/vendor/autoload.php'; 
    $prod = new Create ('marketzone'); //se crea un objeto de la clase Products
    $prod -> add(file_get_contents('php://input')); //se llama al metodo add con el contenido del archivo como parametro 
    echo $prod -> getData(); //se imprime el resultado
?>