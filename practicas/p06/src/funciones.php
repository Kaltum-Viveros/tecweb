<?php
/* Ejercicio  1 multiplo de 5 y 7 
 */    function multiplo($num) {
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

        /*print_r($matriz);*/        
        // Mostrar la matriz

        echo "Matriz generada:<br>";
        foreach ($matriz as $fila) {
            echo implode(", ", $fila) . "<br>";
        }

        // Mostrar resultados
        echo "$totalNumerosGenerados numeros obtenidos en $iteraciones iteraciones";
    }

    function multiploazar($numero) {
        $contador = 0;
        do {
            $contador++;
            $num = rand(1, 999);
        } while ($num % $numero != 0);
        echo '<h3>R= El número '.$num.' es múltiplo de '.$numero.'</h3>';
        echo '<h3>Se encontró en '.$contador.' intentos</h3>';
    }

    function generarArregloLetras() {
        $letras = array();
        for ($i = 97; $i <= 122; $i++) {
            $letras[$i] = chr($i); #chr — Devuelve un caracter específico por su código ASCII 
        }
        #Lee el arreglo y crea una tabla en XHTML con echo y un ciclo foreach
        echo "<table border='1' width=100px style='text-align: center;'>";
        foreach ($letras as $key => $value) {
            echo "<tr><td>$key</td><td>$value</td></tr>";
        }
        echo "</table>";
    }

    function bienvenida($edad, $sexo) {
        if(isset($_POST["edad"]) && isset($_POST["sexo"]))
        {
            $edad = $_POST["edad"];
            $sexo = $_POST["sexo"];
            if($sexo == "femenino" && $edad >= 18 && $edad <= 35)
            {
                echo '<h3>Bienvenida, usted está en el rango de edad permitido.</h3>';
            }
            else
            {
                echo '<h3>Usted no cumple los requisitos.</h3>';
            }
        }
    }

    $vehiculos = [
        'ABC1234' => [
            'Auto' => [
                'marca' => 'HONDA',
                'modelo' => 2005,
                'tipo' => 'sedan'
            ],
            'Propietario' => [
                'nombre' => 'Kaltum Abdala',
                'ciudad' => 'Veracruz, Cordaba.',
                'direccion' => 'calle 7 av 11 y 13'
            ]
        ],
        'DEF5678' => [
            'Auto' => [
                'marca' => 'MAZDA',
                'modelo' => 2019,
                'tipo' => 'sedan'
            ],
            'Propietario' => [
                'nombre' => 'Ma. del Consuelo Molina',
                'ciudad' => 'Puebla, Pue.',
                'direccion' => '97 oriente'
            ]
        ],
        'GHI9012' => [
            'Auto' => [
                'marca' => 'TOYOTA',
                'modelo' => 2018,
                'tipo' => 'hachback'
            ],
            'Propietario' => [
                'nombre' => 'Juan Perez',
                'ciudad' => 'Puebla, Pue.',
                'direccion' => 'Av. Reforma 123'
            ]
        ],
        'JKL3456' => [
            'Auto' => [
                'marca' => 'FORD',
                'modelo' => 2017,
                'tipo' => 'camioneta'
            ],
            'Propietario' => [
                'nombre' => 'Ana Lopez',
                'ciudad' => 'Guadalajara, Jal.',
                'direccion' => 'Calle Falsa 123'
            ]
        ],
        'MNO7890' => [
            'Auto' => [
                'marca' => 'CHEVROLET',
                'modelo' => 2016,
                'tipo' => 'sedan'
            ],
            'Propietario' => [
                'nombre' => 'Carlos Martinez',
                'ciudad' => 'Monterrey, NL.',
                'direccion' => 'Av. Siempre Viva 742'
            ]
        ],
        'PQR1234' => [
            'Auto' => [
                'marca' => 'NISSAN',
                'modelo' => 2015,
                'tipo' => 'hachback'
            ],
            'Propietario' => [
                'nombre' => 'Laura Sanchez',
                'ciudad' => 'Tijuana, BC.',
                'direccion' => 'Calle 8 No. 45'
            ]
        ],
        'STU5678' => [
            'Auto' => [
                'marca' => 'BMW',
                'modelo' => 2020,
                'tipo' => 'sedan'
            ],
            'Propietario' => [
                'nombre' => 'Miguel Angel',
                'ciudad' => 'Cancún, QR.',
                'direccion' => 'Blvd. Kukulcan Km 12'
            ]
        ],
        'VWX9012' => [
            'Auto' => [
                'marca' => 'AUDI',
                'modelo' => 2019,
                'tipo' => 'camioneta'
            ],
            'Propietario' => [
                'nombre' => 'Sofia Hernandez',
                'ciudad' => 'Mérida, Yuc.',
                'direccion' => 'Calle 60 No. 123'
            ]
        ],
        'YZA3456' => [
            'Auto' => [
                'marca' => 'MERCEDES',
                'modelo' => 2018,
                'tipo' => 'sedan'
            ],
            'Propietario' => [
                'nombre' => 'Luis Gomez',
                'ciudad' => 'Querétaro, Qro.',
                'direccion' => 'Av. Universidad 456'
            ]
        ],
        'BCD7890' => [
            'Auto' => [
                'marca' => 'VOLKSWAGEN',
                'modelo' => 2017,
                'tipo' => 'hachback'
            ],
            'Propietario' => [
                'nombre' => 'Mariana Torres',
                'ciudad' => 'Toluca, Edo. Mex.',
                'direccion' => 'Calle de la Amargura 789'
            ]
        ],
        'EFG1234' => [
            'Auto' => [
                'marca' => 'KIA',
                'modelo' => 2016,
                'tipo' => 'camioneta'
            ],
            'Propietario' => [
                'nombre' => 'Pedro Ramirez',
                'ciudad' => 'León, Gto.',
                'direccion' => 'Blvd. Adolfo López Mateos 321'
            ]
        ],
        'HIJ5678' => [
            'Auto' => [
                'marca' => 'HYUNDAI',
                'modelo' => 2015,
                'tipo' => 'sedan'
            ],
            'Propietario' => [
                'nombre' => 'Gabriela Fernandez',
                'ciudad' => 'Aguascalientes, Ags.',
                'direccion' => 'Calle de la Paz 654'
            ]
        ],
        'KLM9012' => [
            'Auto' => [
                'marca' => 'TESLA',
                'modelo' => 2021,
                'tipo' => 'sedan'
            ],
            'Propietario' => [
                'nombre' => 'Ricardo Lopez',
                'ciudad' => 'Ciudad de México, CDMX.',
                'direccion' => 'Av. Insurgentes Sur 1234'
            ]
        ],
        'NOP3456' => [
            'Auto' => [
                'marca' => 'FIAT',
                'modelo' => 2014,
                'tipo' => 'hachback'
            ],
            'Propietario' => [
                'nombre' => 'Sandra Morales',
                'ciudad' => 'Morelia, Mich.',
                'direccion' => 'Calle del Sol 987'
            ]
        ],
        'QRS7890' => [
            'Auto' => [
                'marca' => 'PEUGEOT',
                'modelo' => 2013,
                'tipo' => 'camioneta'
            ],
            'Propietario' => [
                'nombre' => 'Jorge Gutierrez',
                'ciudad' => 'San Luis Potosí, SLP.',
                'direccion' => 'Av. Carranza 456'
            ]
        ]
    ];

    function mostrarVehiculos($matricula, $todos) {
        global $vehiculos;
        if (isset($matricula)) {
            if (isset($vehiculos[$matricula])) {
                echo '<pre>';
                print_r($vehiculos[$matricula]);
                echo '</pre>';
            } else {
                echo '<p>No se encontró el vehículo con matrícula ' . htmlspecialchars($matricula) . '.</p>';
            }
        }

        if (isset($todos)) {
            echo '<pre>';
            print_r($vehiculos);
            echo '</pre>';
        }
    }

    

?>