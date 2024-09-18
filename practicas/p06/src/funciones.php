<!-- Ejercicio  1 multiplo de 5 y 7 -->
<?php
    function multiplo($num) {
        $num = $_GET['numero'];
        if ($num%5==0 && $num%7==0)
        {
            echo '<h3>R= El número '.$num.' SÍ es múltiplo de 5 y 7.</h3>';
        }
        else
        {
            echo '<h3>R= El número '.$num.' NO es múltiplo de 5 y 7.</h3>';
        }
    }

    function generarMatriz() {
        $matriz = array();
        $secuenciaEncontrada = false;
        $iteraciones = 0;
        $totalNumerosGenerados = 0;

        while (!$secuenciaEncontrada) {
            $fila = array();
            $fila[] = rand(1, 999); // Primer número (impar)
            $fila[] = rand(1, 999); // Segundo número (par)
            $fila[] = rand(1, 999); // Tercer número (impar)

            // Incrementamos la cuenta de números generados
            $totalNumerosGenerados += 3;
            $iteraciones++;

            // Comprobar si la secuencia es impar, par, impar
            if ($fila[0]% 2 !== 0 && $fila[1]%2 ===0 && $fila[2]% 2 !== 0) {
                $secuenciaEncontrada = true;
            }

            // Agregar la fila a la matriz
            $matriz[] = $fila;
        }

        // Mostrar resultados
        echo "Secuencia impar, par, impar encontrada tras $iteraciones iteraciones. <br>";
        echo "Total de números generados: $totalNumerosGenerados <br>";

        // Mostrar la matriz
        echo "Matriz generada:<br>";
        foreach ($matriz as $fila) {
            echo implode(", ", $fila) . "<br>";
        }
    }
?>