<?php
libxml_use_internal_errors(true);

// Verificar si se enviaron datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Cargar el XML existente
    $xml = new DOMDocument();
    $documento = file_get_contents('catalogovod.xml');

    if (!$documento) {
        die("No se pudo cargar el archivo XML.");
    }

    $xml->loadXML($documento, LIBXML_NOBLANKS);

    // Acceder al elemento raíz
    $raiz = $xml->documentElement;

    // 1. Agregar nodo perfil
    $perfil = $xml->createElement('perfil');
    $nombreUsuario = $xml->createElement('nombre', htmlspecialchars($_POST['usuario']));
    $idioma = $xml->createElement('idioma', htmlspecialchars($_POST['size']));
    $perfil->appendChild($nombreUsuario);
    $perfil->appendChild($idioma);

    // Verificar si existe la sección de perfiles en el XML, si no, se crea.
    $perfiles = $raiz->getElementsByTagName('perfiles')->item(0);
    if (!$perfiles) {
        $perfiles = $xml->createElement('perfiles');
        $raiz->appendChild($perfiles);
    }
    $perfiles->appendChild($perfil);

    // 2. Verificar y agregar géneros y títulos de películas
    $peliculas = $raiz->getElementsByTagName('peliculas')->item(0);
    if (!$peliculas) {
        $peliculas = $xml->createElement('peliculas');
        $peliculas->setAttribute('region', 'MEX'); // Asumiendo la región por defecto
        $raiz->appendChild($peliculas);
    }

    $generoPeliculas = $xml->createElement('genero');
    $generoPeliculas->setAttribute('nombre', htmlspecialchars($_POST['pel-genero']));

    $titulo1 = $xml->createElement('titulo');
    $titulo1->setAttribute('nombre', htmlspecialchars($_POST['pel-titulo1']));
    $titulo1->setAttribute('duracion', htmlspecialchars($_POST['pel-duracion1']));

    $titulo2 = $xml->createElement('titulo');
    $titulo2->setAttribute('nombre', htmlspecialchars($_POST['pel-titulo2']));
    $titulo2->setAttribute('duracion', htmlspecialchars($_POST['pel-duracion2']));

    $generoPeliculas->appendChild($titulo1);
    $generoPeliculas->appendChild($titulo2);
    $peliculas->appendChild($generoPeliculas);

    // 3. Verificar y agregar géneros y títulos de series
    $series = $raiz->getElementsByTagName('series')->item(0);
    if (!$series) {
        $series = $xml->createElement('series');
        $series->setAttribute('region', 'USA'); // Asumiendo la región por defecto
        $raiz->appendChild($series);
    }

    $generoSeries = $xml->createElement('genero');
    $generoSeries->setAttribute('nombre', htmlspecialchars($_POST['ser-genero']));

    $titulo1 = $xml->createElement('titulo');
    $titulo1->setAttribute('nombre', htmlspecialchars($_POST['ser-titulo1']));
    $titulo1->setAttribute('duracion', htmlspecialchars($_POST['ser-duracion1']));

    $titulo2 = $xml->createElement('titulo');
    $titulo2->setAttribute('nombre', htmlspecialchars($_POST['ser-titulo2']));
    $titulo2->setAttribute('duracion', htmlspecialchars($_POST['ser-duracion2']));

    $generoSeries->appendChild($titulo1);
    $generoSeries->appendChild($titulo2);
    $series->appendChild($generoSeries);

    // Guardar el XML modificado en un nuevo archivo
    $nuevoArchivo = 'catalogovod_modificado.xml';
    if ($xml->save($nuevoArchivo)) {
        echo "El archivo modificado ha sido creado exitosamente: <a href='$nuevoArchivo' target='_blank'>Descargar archivo modificado</a>";
    } else {
        echo "Error al guardar el archivo modificado.";
    }
} else {
    echo "No se enviaron datos.";
}
?>