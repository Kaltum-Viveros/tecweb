<?php
    libxml_use_internal_errors(true); 

    $xml= new DOMDocument(); // crea un nuevo objeto DOMDocument para el xml a validar 

    $documento = file_get_contents('catalogovod.xml'); // obtiene el contenido del archivo xml

    $xml->loadXML($documento, LIBXML_NOBLANKS); // carga el xml en el objeto DOMDocument, LIBXML_NOBLANKS elimina los nodos en blanco
    // o usa $xml->load si prefieres usar la ruta del archivo

    $xsd = 'serviciovod.xsd'; // ruta del archivo xsd

    if (!$xml->schemaValidate($xsd)) // valida el xml con el xsd
    // o usa $xml->schemaValidateSource si prefieres usar el xsd en format string
    {
        $errors = libxml_get_errors(); // obtiene los errores
        $noError = 1;
        $lista = ''; 

        foreach ($errors as $error)
        {
            $lista = $lista.'['.($noError++).']: '.$error->message. '<br />'; // crea una lista con los errores
        }

        echo $lista; 

        //acabar con la ejecución del script
        die();
    } 

    header('Content-Type: text/xml'); // establece el tipo de contenido como xml 
    echo $xml->saveXML(); // imprime el xml 
?>