<?php
    use TECWEB\MYAPI\Products as Products; //se usa la clase Products
    include_once __DIR__.'/myapi/Products.php'; //se incluye el archivo Products.php
    $prod = new Products ('marketzone'); //se crea un objeto de la clase Products
    $prod -> single($_POST['id']); //se llama al metodo single
    echo $prod -> getData(); //se imprime el resultado
?>

