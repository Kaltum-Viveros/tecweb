<?php
    use TECWEB\MYAPI\Products as Products; //se usa la clase Products
    include_once __DIR__.'/myapi/Products.php'; //se incluye el archivo Products.php
    $prod = new Products ('marketzone'); //se crea un objeto de la clase Products
    $prod -> delete($_GET['id']); //se llama al metodo delete con el id como parametro 
    echo $prod -> getData(); //se imprime el resultado
?>