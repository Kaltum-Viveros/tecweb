<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html" encoding="UTF-8" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN" doctype-system="http://www.w3.org/TR/xhtml1/DTD/strict.dtd"/>

    <xsl:template match="/">
        <html>
            <head>
                <title>Catálogo VOD</title>
                <!-- Bootstrap CDN -->
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
                <!-- Font Awesome CDN for Icons -->
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
                <style type="text/css">
                    /* Estilos Generales */
                    body {
                        background: linear-gradient(to right, #2b5876, #4e4376); /* Degradado de azul y morado */
                        color: #e5e5e5; /* Gris claro */
                        font-family: 'Roboto', Arial, sans-serif;
                        margin: 0;
                        padding: 0;
                    }

                    h1 {
                        text-align: center;
                        color: #00bcd4; /* Turquesa */
                        font-size: 3.5em;
                        font-weight: bold;
                        margin-bottom: 40px;
                    }

                    h2 {
                        text-align: center;
                        color: #ffffff; /* Blanco */
                        text-transform: uppercase;
                        font-weight: bold;
                        margin: 20px 0;
                        border-bottom: 3px solid #00bcd4; /* Turquesa */
                        display: inline-block;
                        padding-bottom: 5px;
                    }

                    h2 i {
                        margin-right: 10px; /* Espacio entre icono y texto */
                    }

                    .container {
                        padding: 40px;
                        max-width: 1200px;
                        margin: auto;
                    }

                     /* Tablas */
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin: 20px 0;
                        overflow: hidden;
                        border-radius: 8px;
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
                        border: 2px solid #ffffff; /* Borde blanco alrededor de la tabla */
                        background-color: rgba(63, 81, 181, 0.1) !important; /* Fondo azul translúcido */
                    }

                    table thead {
                        background-color: #1a237e !important; /* Fondo más oscuro para encabezado */
                        color: #ffffff !important; /* Blanco */
                    }

                    table th, table td {
                        padding: 15px;
                        text-align: center;
                        border: 1px solid #555; /* Borde gris claro para celdas internas */
                    }

                    table tbody tr:nth-child(even) {
                        background-color: rgba(255, 255, 255, 0.05) !important; /* Fondo más oscuro para filas pares */
                    }

                    table tbody tr:hover {
                        background-color: rgba(0, 188, 212, 0.3) !important; /* Fondo translúcido más oscuro para hover */
                        transition: 0.3s ease-in-out;
                    }

                </style>
            </head>
            <body>
                <div class="container">
                    <img src="logo_StreamBox.png" style="display: block; margin: 20px auto 20px; width: 400px;" />

                    <h2><i class="fa-solid fa-ticket"></i>Películas</h2> <!-- Icono de video para Películas -->
                    <xsl:for-each select="CatalogoVOD/contenido/peliculas">
                        <table class="table table-dark table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Duración</th>
                                    <th>Género</th>
                                </tr>
                            </thead>
                            <tbody>
                                <xsl:for-each select="genero">
                                    <xsl:variable name="generoNombre" select="@nombre"/>
                                    <xsl:for-each select="titulo">
                                        <tr>
                                            <td><xsl:value-of select="@nombre"/></td>
                                            <td><xsl:value-of select="@duracion"/></td>
                                            <td><xsl:value-of select="$generoNombre"/></td>
                                        </tr>
                                    </xsl:for-each>
                                </xsl:for-each>
                            </tbody>
                        </table>
                    </xsl:for-each>

                    <h2><i class="fa-solid fa-ticket"></i>Series</h2> <!-- Icono de película para Series -->
                    <xsl:for-each select="CatalogoVOD/contenido/series">
                        <table class="table table-dark table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Duración</th>
                                    <th>Género</th>
                                </tr>
                            </thead>
                            <tbody>
                                <xsl:for-each select="genero">
                                    <xsl:variable name="generoNombre" select="@nombre"/> 
                                    <xsl:for-each select="titulo">
                                        <tr>
                                            <td><xsl:value-of select="@nombre"/></td>
                                            <td><xsl:value-of select="@duracion"/></td>
                                            <td><xsl:value-of select="$generoNombre"/></td>
                                        </tr>
                                    </xsl:for-each>
                                </xsl:for-each>
                            </tbody>
                        </table>
                    </xsl:for-each>
                </div>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
