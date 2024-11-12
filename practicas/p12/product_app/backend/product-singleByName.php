<?php
    use TECWEB\MYAPI\Read;
    include_once __DIR__.'/myapi/Products.php';
    $prod = new Read ('marketzone');
    $prod->singleByName($_GET['name']);
    echo $prod->getData();
?>