<?php
    use TECWEB\MYAPI\Delete; //se usa la clase Products
    include_once __DIR__.'/vendor/autoload.php'; 
    $prod = new Delete ('marketzone'); //se crea un objeto de la clase Products
    $prod -> delete($_GET['id']); //se llama al metodo delete con el id como parametro 
    echo $prod -> getData(); //se imprime el resultado
?>