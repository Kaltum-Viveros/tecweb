<?php
    use TECWEB\MYAPI\Products as Products; //se usa la clase Products
    include_once __DIR__.'/myapi/Products.php'; //se incluye el archivo Products.php
    $prod = new Products ('marketzone'); //se crea un objeto de la clase Products
    $prod -> search($_GET['search']);  //se llama al metodo search con el parametro search
    echo $prod -> getData(); //se imprime el resultado
?>