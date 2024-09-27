<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Producto</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .text-center {
            text-align: center; 
        }
        .img-producto {
        width: 100px; 
        height: 100px; 
        object-fit: cover; 
    }
    </style>
</head>
<body>
	<h3>PRODUCTOS</h3>
	<br/>

	<?php
	
	if(isset($_GET['tope'])) {
        $tope = $_GET['tope'];
        $tope = (int)$tope; 
    } else {
        die('Parámetro "tope" no detectado...');
    }

	if (!empty($tope)) {
		
		@$link = new mysqli('localhost', 'root', 'k4l7u3ab', 'marketzone', 3307);

		if ($link->connect_errno) {
			die('Falló la conexión: '.$link->connect_error.'<br/>');
		}

		$data = [];
		if ($result = $link->query("SELECT * FROM productos WHERE unidades <= $tope")) {
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$data[] = $row;  
			}
			$result->free(); 
		}

		$link->close(); 
	}

	if (!empty($data)) : 
	?>
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
				</tr>
			</thead>
			<tbody>
				<?php foreach ($data as $row): ?>
                
				<tr>
					<th scope="row"><?= $row['id'] ?></th> 
					<td><?= $row['nombre'] ?></td>
					<td><?= $row['marca'] ?></td>
					<td><?= $row['modelo'] ?></td>
					<td><?= $row['precio'] ?></td>
					<td><?= $row['unidades'] ?></td>
					<td><?= utf8_encode($row['detalles']) ?></td>
					<td><img class="img-producto" src="<?= $row['imagen'] ?>" alt="Imagen del producto"></td>
				</tr>
				<?php endforeach; ?>
                
			</tbody>
		</table>
	<?php else : ?>
		<p>No hay coincidencias en la busqueda.</p>
	<?php endif; ?>
</body>
</html>
