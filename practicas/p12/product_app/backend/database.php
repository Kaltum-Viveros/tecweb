<?php
    $conexion = @mysqli_connect(
        'localhost',
        'root',
        'k4l7u3ab',
        'marketzone',
        3307
    );

    /**
     * NOTA: si la conexión falló $conexion contendrá false
     **/
    if(!$conexion) {
        die('¡Base de datos NO conectada!');
    }
?>