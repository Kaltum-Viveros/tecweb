<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 4</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Determina cuál de las siguientes variables son válidas y explica por qué:</p>
    <p>$_myvar,  $_7var,  myvar,  $myvar,  $var7,  $_element1, $house*5</p>
    <?php
        //AQUI VA MI CÓDIGO PHP
        $_myvar;
        $_7var;
        //myvar;       // Inválida
        $myvar;
        $var7;
        $_element1;
        //$house*5;     // Invalida
        
        echo '<h4>Respuesta:</h4>';   
    
        echo '<ul>';
        echo '<li>$_myvar es válida porque inicia con guión bajo.</li>';
        echo '<li>$_7var es válida porque inicia con guión bajo.</li>';
        echo '<li>myvar es inválida porque no tiene el signo de dolar ($).</li>';
        echo '<li>$myvar es válida porque inicia con una letra.</li>';
        echo '<li>$var7 es válida porque inicia con una letra.</li>';
        echo '<li>$_element1 es válida porque inicia con guión bajo.</li>';
        echo '<li>$house*5 es inválida porque el símbolo * no está permitido.</li>';
        echo '</ul>';
    
        unset($_myvar, $_7var, $myvar, $var7, $_element1);  // Limpia las variables

        //ejercicio 2

        echo '<h2>Ejercicio 2</h2>';

        echo '<p> Proporcionar los valores de $a, $b, $c como sigue y muestra el contenido de cada variable:</p>';

        $a = "ManejadorSQL";
        $b = 'MySQL';
        $c = &$a;

        echo '<p> $a: '.$a.'<br />'.'$b: '.$b.'<br />'.'$c: '.$c.'</p>';

        echo '<p> Agrega al código actual las siguientes asignaciones y Vuelve a mostrar el contenido de cada una de las variables:</p>';

        $a = "PHP server";
        $b = &$a;

        echo '<p> $a: '.$a.'<br />'.'$b: '.$b.'<br />'.'$c: '.$c.'<br />'.'</p>';

        echo '<p> Describe y muestra en la página obtenida qué ocurrió en el segundo bloque de asignaciones.</p>';

        echo '<p><b>Explicación: </b> Se reescribió la variable $a, y la variable $b se asignó por referencia a la variable $a, por lo que al cambiar el valor de $a también cambia el valor de $b. 
        <br /> La variable $c se asignó por referencia a la variable $a, por lo que al cambiar el valor de $a también cambia el valor de $c.</p>';

        unset($a, $b, $c);  // Limpia las variables

        //ejercicio 3

        echo '<h2>Ejercicio 3</h2>';

        echo '<p> Muestra el contenido de cada variable inmediatamente después de cada asignación, 
        verificar la evolución del tipo de estas variables (imprime todos los componentes de los arreglo):</p>'; 

        //1
        $a = "PHP5 ";
        echo '<p>'.'$a: '.$a.'</p>';
        //2
        $z[] = &$a;    
        echo '<p> $z: '; 
        print_r($z); 
        echo '</p>';
        //3
        $b = "5a version de PHP";
        echo '<p> $b: '.$b.'</p>';
        //4
        $c = intval($b)*10; // la variable $b se multiplica por 10 y se asigna a la variable $c, la variable b es un string por lo que se convierte a 5
        echo '<p> $c: '.$c.'</p>';
        //5
        $a .= $b; // la variable $a se concatena con la variable $b y se asigna a la variable $a 
        echo '<p> $a: '.$a.'</p>';
        //6
        settype($b, 'int'); // la variable $b se convierte a int
        $b *= $c; // la variable $b se multiplica por la variable $c y se asigna a la variable $b donde b=5 y c=50
        echo '<p> $b: '.$b.'</p>';
        //7
        $z[0] ="MySQL";
        echo '<p> $z: '; 
        print_r($z); 
        echo '</p>';

        //unset($a, $b, $c, $z);  // Limpia las variables

        //ejercicio 4
        echo '<h2>Ejercicio 4</h2>';

        echo '<p> Lee y muestra los valores de las variables del ejercicio anterior, pero ahora con la ayuda de la matriz $GLOBALS o del modificador global de PHP. </p>';

        echo '<p>'. '$a: '.$GLOBALS['a'].'<br />'. '$b: '.$GLOBALS['b'].'<br />'. '$c: '.$GLOBALS['c'].'<br />'. '$z: '.$GLOBALS['z'][0].'</p>';

        unset($a, $b, $c, $z);  // Limpia las variables

        //ejercicio 5

        echo '<h2>Ejercicio 5</h2>';

        echo '<p> Dar el valor de las variables $a, $b, $c al final del siguiente script:</p>';

        $a = "7 personas";
        echo  '<p> $a: '.$a.'</p>';

        $b = (integer) $a;
        echo '<p> $b: '.$b.'</p>';

        $a = "9E3";
        echo '<p> $a: '.$a.'</p>';

        $c = (double) $a;
        echo '<p> $c: '.$c.'</p>';

        unset($a, $b, $c);  // Limpia las variables

        //ejercicio 6

        echo '<h2>Ejercicio 6</h2>';

        echo '<p> Dar y comprobar el valor booleano de las variables $a, $b, $c, $d, $e y $f y muéstralas usando la función vardump. </p>';

        $a = "0";
        $b = "TRUE";
        $c = FALSE;
        $d = ($a || $b);  // or es verdadero si uno de los dos es verdadero
        $e = ($a && $c); // and es verdadero si ambos son verdaderos
        $f = ($a XOR $b); // xor es verdadero si uno de los dos es verdadero pero no ambos

        echo '<p> $a: ';
        var_dump($a);
        echo '</p>';

        echo '<p> $b: ';
        var_dump($b);
        echo '</p>';

        echo '<p> $c: ';
        var_dump($c);
        echo '</p>';

        echo '<p> $d: ';
        var_dump($d);
        echo '</p>';

        echo '<p> $e: ';
        var_dump($e);
        echo '</p>';

        echo '<p> $f:';
        var_dump($f);
        echo '</p>';

        echo '<p> Después investiga una función de PHP que permita transformar el valor booleano de $c y $e en uno que se pueda mostrar con un echo: </p>';
        
        echo '<p> $c: '. var_export($c, true).'</p>';
        echo '<p> $e: '. var_export($e, true).'</p>';
        
        unset($a, $b, $c, $d, $e, $f);  // Limpia las variables

        //ejercicio 7

        echo '<h2>Ejercicio 7</h2>';
        
        echo '<p> Usando la variable predefinida $_SERVER, determina lo siguiente:</p>';    

        echo '<p> <b> a. </b> La versión de Apache y PHP <br />'.$_SERVER['SERVER_SOFTWARE'].'</p>';

        echo '<p> <b> b. </b> El nombre del sistema operativo (servidor) <br />'.$_SERVER['SERVER_NAME'].'</p>';

        echo '<p> <b> c. </b> El idioma del navegador (cliente): <br />'.$_SERVER['HTTP_ACCEPT_LANGUAGE'].'</p>';

    ?>
    <!-- Icono de documento comprobado con éxito como XHTML 1.1 por W3C-->
    <p>
        <a href="https://validator.w3.org/markup/check?uri=referer"><img
        src="https://www.w3.org/Icons/valid-xhtml11" alt="Valid XHTML 1.1" height="31" width="88" /></a>
    </p>

</body>
</html>