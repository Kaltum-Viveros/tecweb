<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo 1: Definicion</title>
</head>
<body>
    <?php
        require_once __DIR__ . '/Persona.php'; //dir sirve para obtener la ruta del archivo actual y concatenarle el nombre del archivo que se quiere incluir
        
        $per1 = new Persona;
        $per1 -> inicializar('Kaltum');
        $per1 -> mostrar();
        
        $per2 = new Persona;
        $per2 -> inicializar('Abdala');
        $per2 -> mostrar();

    ?>
</body>
</html>