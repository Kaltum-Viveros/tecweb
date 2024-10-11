<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">

<script>
    function show(event) {
        var row = event.target.parentNode.parentNode;

		var id = row.cells[0].innerHTML;
        var nombre = row.cells[1].innerHTML;
        var marca = row.cells[2].innerHTML;
        var modelo = row.cells[3].innerHTML;
        var precio = row.cells[4].innerHTML;
        var unidades = row.cells[5].innerHTML;
        var detalles = row.cells[6].innerHTML;
        var imagen = row.cells[7].querySelector('img').src;

        // alert("Nombre: " + nombre + "\nMarca: " + marca + "\nModelo: " + modelo + "\nPrecio: " + precio + "\nDetalles: " + detalles + "\nUnidades: " + unidades + "\nImagen: " + imagen);

		send2form(id, nombre, marca, modelo, precio, unidades, detalles, imagen);
    }
</script>

<?php
    //header("Content-Type: application/json; charset=utf-8"); 
    $data = array();


		/** SE CREA EL OBJETO DE CONEXION */
		@$link = new mysqli('localhost', 'root', 'k4l7u3ab', 'marketzone', 3307);
        /** NOTA: con @ se suprime el Warning para gestionar el error por medio de código */

		/** comprobar la conexión */
		if ($link->connect_errno) 
		{
			die('Falló la conexión: '.$link->connect_error.'<br/>');
			//exit();
		}

		/** Crear una tabla que no devuelve un conjunto de resultados */
		if ( $result = $link->query("SELECT * FROM productos WHERE eliminado = '0'") ) 
		{
            /** Se extraen las tuplas obtenidas de la consulta */
			$row = $result->fetch_all(MYSQLI_ASSOC);

            /** Se crea un arreglo con la estructura deseada */
            foreach($row as $num => $registro) {            // Se recorren tuplas
                foreach($registro as $key => $value) {      // Se recorren campos
                    $data[$num][$key] = utf8_encode($value);
                }
            }

			/** útil para liberar memoria asociada a un resultado con demasiada información */
			$result->free();
		}

		$link->close();

        /** Se devuelven los datos en formato JSON */
        //echo json_encode($data, JSON_PRETTY_PRINT);
	?>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Producto</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <style>
            .img-producto 
            {
                width: 100px;  
                height: 100px; 
                object-fit: cover; /* Asegura que la imagen se recorte adecuadamente */
            }
			.btn 
			{
				margin: 5px;
				background-color: #343A40; 
			}
        </style>
    </head>
	<body>
		<h3>PRODUCTO</h3>

		<br/>
		
		<?php if( isset($row) ) : ?>
			<table class="table">
				<thead class="thead-dark">
					<tr>
					<th scope="col">#</th>
					<th scope="col">Nombre</th>
					<th scope="col">Marca</th>
					<th scope="col">Modelo</th>
					<th scope="col">Precio</th>
					<th scope="col">Unidades</th>
					<th scope="col">Detalles</th>
					<th scope="col">Imagen</th>
					<th scope="col">Acciones</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($row as $value) : ?>
					<tr>
						<th scope="row"><?= $value['id'] ?></th>
						<td><?= $value['nombre'] ?></td>
						<td><?= $value['marca'] ?></td>
						<td><?= $value['modelo'] ?></td>
						<td><?= $value['precio'] ?></td>
						<td><?= $value['unidades'] ?></td>
						<td><?= $value['detalles'] ?></td>
						<td><img class="img-producto" src="<?= $value['imagen'] ?>" alt="Imagen del producto"></td>
						<td><button class="btn btn-primary" onclick="show(event)">Modificar</button></td>
				</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php elseif(!empty($id)) : ?>

			<script>
                alert('El ID del producto no existe');
            </script>

		<?php endif; ?>

		<script>
			function send2form(id, nombre, marca, modelo, precio, unidades, detalles, imagen) {
				var form = document.createElement("form");

				var idIn = document.createElement("input");
				idIn.type = 'hidden';
				idIn.name = 'id';
				idIn.value = id;
				form.appendChild(idIn);

				var nombreIn = document.createElement("input");
				nombreIn.type = 'hidden';
				nombreIn.name = 'nombre';
				nombreIn.value = nombre;
				form.appendChild(nombreIn);

				var marcaIn = document.createElement("input");
				marcaIn.type = 'hidden';
				marcaIn.name = 'marca';
				marcaIn.value = marca;
				form.appendChild(marcaIn);

				var modeloIn = document.createElement("input");
				modeloIn.type = 'hidden';
				modeloIn.name = 'modelo';
				modeloIn.value = modelo;
				form.appendChild(modeloIn);

				var precioIn = document.createElement("input");
				precioIn.type = 'hidden';
				precioIn.name = 'precio';
				precioIn.value = precio;
				form.appendChild(precioIn);

				var unidadesIn = document.createElement("input");
				unidadesIn.type = 'hidden';
				unidadesIn.name = 'unidades';
				unidadesIn.value = unidades;
				form.appendChild(unidadesIn);

				var detallesIn = document.createElement("input");
				detallesIn.type = 'hidden';
				detallesIn.name = 'detalles';
				detallesIn.value = detalles;
				form.appendChild(detallesIn);

				var imagenIn = document.createElement("input");
				imagenIn.type = 'hidden';
				imagenIn.name = 'imagen';
				imagenIn.value = imagen;
				form.appendChild(imagenIn);

				form.method = 'POST';
				form.action = 'http://localhost/tecweb/practicas/p09/formulario_productos_v2.php';

				// Añadir el formulario al cuerpo del documento y enviarlo
				document.body.appendChild(form);
				form.submit();
			}
	</script>

	</body>
</html>