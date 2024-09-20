<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 4</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Escribir programa para comprobar si un número es un múltiplo de 5 y 7</p>
    <?php
        include_once 'src/funciones.php'; 
        // Incluir el archivo que contiene la función para comprobar si un número es múltiplo de 5 y 7
        if(isset($_GET['numero'])) // Verificar si se ha enviado el número a comprobar, el GET es un array asociativo que contiene las variables enviadas por el método GET
        {
            multiplo($_GET['numero']); // Llamar a la función multiplo con el número enviado por el método GET
        }
        else 
        {
            echo '<h3>Introduce un número para comprobar si es múltiplo de 5 y 7</h3>';
        } 
    ?>

    <h2>Ejercicio 2</h2>
    <p>Generar 3 números aleatorios hasta obtener una secuencia compuesta por 3 números con la estructura impar, par, impar</p>
    <?php
        include_once 'src/funciones.php'; 
        // Ejecutar el programa
        generarMatriz();
    ?>

    <h2>Ejercio 3</h2>
    <p> Utiliza un ciclo while para encontrar el primer número entero obtenido aleatoriamente, pero que además sea múltiplo de un número dado.</p>
    <!--  Crear una variante de este script utilizando el ciclo do-while.
    El número dado se debe obtener vía GET. -->
    <?php
        include_once 'src/funciones.php'; 
        multiploazar($_GET['numero']);
    ?>

    <h2>Ejercicio 4</h2>
    <p>Crear un arreglo cuyos índices van de 97 a 122 y cuyos valores son las letras de la ‘a’ a la ‘z’. Usa la función chr(n) que devuelve el caracter cuyo código ASCII es n para poner el valor en cada índice. Es decir: </p>
    <?php
        include_once 'src/funciones.php';
        generarArregloLetras();
    ?>

    <fieldset>
    <legend><h2>Ejercicio 5</h2> </legend>
    <!-- el ejercicio debe implementarse en formularios simples de HTML5 (solicitud) y como respuesta devolver un XHTML generado por PHP. -->
    <p>Usar las variables $edad y $sexo en una instrucción if para identificar una persona de sexo “femenino”, cuya edad oscile entre los 18 y 35 años y mostrar un mensaje debienvenida apropiado</p>
    <form method="post">
        Edad: <input type="text" name="edad" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required> 
        Sexo:<select name="sexo">
                <option value="masculino">Masculino</option>
                <option value="femenino">Femenino</option>
            </select>
            <input type="submit" style="margin-bottom: 20px">
    </form>
    </fieldset>

    <?php
        include_once 'src/funciones.php';
        bienvenida($_POST["edad"], $_POST["sexo"]);
    ?>
    
    <fieldset>
    <legend><h2>Ejercicio 6</h2></legend>
    <p> Crea en código duro un arreglo asociativo que sirva para registrar el parque vehicular de una ciudad.</p>
    
    <h2>Consulta de Vehículos</h2>
    <form method="post">
        Matrícula: <input type="text" name="matricula">
        <input type="submit" value="Consultar">
        <br><br>
    </form>

    <form method="post">
        <input type="submit" name="todos" value="Mostrar Todos los Autos" style="margin-bottom: 20px">
    </form>
    </fieldset>

    <?php
        include_once 'src/funciones.php';
        $matricula = isset($_POST["matricula"]) ? $_POST["matricula"] : null;
        $todos = isset($_POST["todos"]) ? $_POST["todos"] : null;
        mostrarVehiculos($matricula, $todos);
        
    ?>

</body>
</html>