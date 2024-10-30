<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo 3: Cabecera</title>
</head>
<body>
    <?php
        /*use EJEMPLOS\POO\Cabecera as Cabecera; // Alias para la clase Cabecera
        require_once __DIR__ . '/Cabecera.php';

        $cab = new Cabecera('El Rincón de la Programación', 'center');
        $cab->graficar();	*/

        use EJEMPLOS\POO\Cabecera2 as Cabecera; // Alias para la clase Cabecera
        require_once __DIR__ . '/Cabecera.php';

        $cab = new Cabecera('El Rincón de la Programación', 'center', 'https://www.cs.buap.mx');
        $cab->graficar();	
    ?>
</body>
</html>