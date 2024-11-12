<?php
    use TECWEB\MYAPI\Update; //se usa la clase Products
    include_once __DIR__.'/vendor/autoload.php'; 
    $prod = new Update ('marketzone'); //se crea un objeto de la clase Products
    $prod -> edit(file_get_contents('php://input')); //se llama al metodo edit con el contenido del archivo como parametro
    echo $prod -> getData(); //se imprime el resultado
?>