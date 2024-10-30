<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo 2: Menu</title>
</head>
<body>
    <?php
        require_once __DIR__ . '/Menu.php'; //dir sirve para obtener la ruta del archivo actual y concatenarle el nombre del archivo que se quiere incluir
    
        $menu = new Menu;
        $menu -> cargar_opcion('http://www.facebook.com', 'Facebook');
        $menu -> cargar_opcion('http://www.instagram.com', 'Instagram');
        $menu -> cargar_opcion('http://www.outlook.com', 'Outlook');

        $menu -> mostrar();
    ?>
</body>
</html>