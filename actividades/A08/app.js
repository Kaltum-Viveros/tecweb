// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

var edit = false; // Inicialmente se asume que no se está editando ningún producto
var selectedProductId; // Declarar la variable al inicio

$(document).ready(function() {

    console.log("jQuery ready");
    $('#product-result').hide();

    listarProductos(); // SE LISTAN LOS PRODUCTOS AL CARGAR LA PAGINA 

    $('#search').keyup(function(e) {
        e.preventDefault(); // Prevenir el comportamiento por defecto del formulario

        // Obtener el valor de búsqueda usando jQuery
        var search = $('#search').val(); // Cambia 'searchInput' por el ID correcto del campo de entrada

        // Realizar la solicitud AJAX
        $.ajax({
            url: './backend/product-search.php',
            type: 'GET',
            data: { search: search },
            success: function(response) {
                let productos = JSON.parse(response);

                if (Object.keys(productos).length > 0) {
                    let template = '';
                    let template_bar = '';

                    productos.forEach(producto => {
                        let descripcion = `
                            <li>precio: ${producto.precio}</li>
                            <li>unidades: ${producto.unidades}</li>
                            <li>modelo: ${producto.modelo}</li>
                            <li>marca: ${producto.marca}</li>
                            <li>detalles: ${producto.detalles}</li>
                        `;

                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td>
                                    <a href="#" class="product-item">${producto.nombre}</a>
                                </td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger" data-id="${producto.id}">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;

                        template_bar += `<li>${producto.nombre}</li>`;
                    });

                    // Actualizar el DOM con los resultados
                    document.getElementById("product-result").className = "card my-4 d-block"; // SE MUESTRA LA BARRA DE BUSQUEDA 
                    document.getElementById("container").innerHTML = template_bar;
                    document.getElementById("products").innerHTML = template;
                } else {
                    if(Object.keys(products).length == 0) { // SI NO SE ENCUENTRAN PRODUCTOS SE MUESTRA UN MENSAJE
                        let template_bar = ''; // SE CREA UNA VARIABLE PARA ALMACENAR EL HTML DE LA BARRA DE BUSQUEDA
                        template_bar += `<li>No se encontraron productos</il>`; // SE AGREGA EL MENSAJE A LA VARIABLE
                        document.getElementById("product-result").className = "card my-4 d-block"; // SE MUESTRA LA BARRA DE BUSQUEDA 
                        document.getElementById("container").innerHTML = template_bar; // SE MUESTRA EL MENSAJE DE NO ENCONTRADO EN LA BARRA DE BUSQUEDA
                        document.getElementById("products").innerHTML = ''; // SE LIMPIA LA LISTA DE PRODUCTOS
                    }
                }
            },
            error: function() {
                alert("Hubo un error al realizar la búsqueda.");
            }
        });
    });

    $('#product-form').submit(function(e) {
        e.preventDefault();

        var yeison = {
            id: $('#productId').val(),
            nombre: $('#form-name').val(),
            marca: $('#form-brand').val(),
            modelo: $('#form-model').val(),
            precio: $('#form-price').val(),
            detalles: $('#form-details').val(),
            unidades: $('#form-units').val(),
            imagen: $('#form-img').val()
        };

        // Convertir el objeto a JSON
        var productoJsonString = JSON.stringify(yeison, null, 3);

        // Si necesitas manipular alguna propiedad en `yeison` despuÃ©s
        yeison['nombre'] = document.getElementById('form-name').value;
        yeison['id'] = document.getElementById('productId').value;

        // Volver a convertir el objeto actualizado a JSON si es necesario
        productoJsonString = JSON.stringify(yeison, null, 3);

        var finalJSON = JSON.parse(productoJsonString);
        productoJsonString = JSON.stringify(finalJSON, null, 3);

            let errorMessages = []; // Array para acumular los errores

            // Validar nombre
            if (!finalJSON.nombre) {
                errorMessages.push('Ingresa un nombre');
            }else if (finalJSON.nombre.length > 100) {
                errorMessages.push('El nombre debe tener máximo 100 caracteres');
            }
            
            // Validar marca
            if (!finalJSON.marca) {
                errorMessages.push('Selecciona una marca');
            }
            
            // Validar modelo
            if (!finalJSON.modelo) {
                errorMessages.push('Ingresa un modelo');
            }else if (!/^[a-zA-Z0-9 ]+$/.test(finalJSON.modelo) || finalJSON.modelo.length > 25) {
                errorMessages.push('El modelo debe ser alfanumérico y menor a 25 caracteres');
            }
            
            // Validar precio
            if (!finalJSON.precio) {
                errorMessages.push('Ingresa el precio');
            } else if (finalJSON.precio < 99.99) {
                errorMessages.push('El precio debe ser mayor a $99.99');
            }
            
            // Validar detalles
            if (finalJSON.detalles && finalJSON.detalles.length > 250) {
                errorMessages.push('Los detalles deben tener máximo 250 caracteres');
            }
            
            // Validar unidades
            if (!finalJSON.unidades) {
                errorMessages.push('Ingresa la cantidad de unidades');
            } else if (finalJSON.unidades < 0) {
                errorMessages.push('La cantidad mínima de unidades debe ser 0');
            }
            
            // Validar imagen
            if (!finalJSON.imagen) {
                finalJSON.imagen = 'img/pre.png';  // Asignar una imagen por defecto
                errorMessages.push('Se asignará una imagen por defecto');
            }
            
            // Si hay errores, mostrar todos
            if (errorMessages.length > 0) {
                let template_bar = '';
                errorMessages.forEach(message => {
                    template_bar += `<li>${message}</li>`;
                });
                template_bar += '';
                
                document.getElementById("product-result").className = "card my-4 d-block";
                document.getElementById("container").innerHTML = template_bar;
            
                return false;
            }            

        let url = edit === false ? './backend/product-add.php' : './backend/product-edit.php'; // SE ASIGNA LA URL DEPENDIENDO SI SE ESTA AGREGANDO O EDITANDO UN PRODUCTO

        // SE ENVIA EL JSON A TRAVES DE AJAX
        $.ajax({
            url: url, //'./backend/product-add.php',
            type: 'POST',
            contentType: 'application/json', // SE ESPECIFICA EL TIPO DE CONTENIDO 
            data: JSON.stringify(finalJSON), // SE ENVIA EL JSON

            success: function(response) {
                console.log(response);
                let respuesta = JSON.parse(response);
                let template_bar = '';
                template_bar += `
                            <li style="list-style: none;">status: ${respuesta.status}</li>
                            <li style="list-style: none;">message: ${respuesta.message}</li>
                        `;

                document.getElementById("product-result").className = "card my-4 d-block";
                document.getElementById("container").innerHTML = template_bar;

                listarProductos();

                edit = false; // SE REINICIA LA VARIABLE DE EDICION
                $('#submit-button').text('Agregar Producto'); // SE CAMBIA EL TEXTO DEL BOTON A AGREGAR PRODUCTO
                $('#form-name').val(''); // SE LIMPIA EL CAMPO DE NOMBRE
                $('#form-brand').val(''); // SE LIMPIA EL CAMPO DE MARCA
                $('#form-model').val(''); // SE LIMPIA EL CAMPO DE MODELO
                $('#form-price').val(''); // SE LIMPIA EL CAMPO DE PRECIO
                $('#form-details').val(''); // SE LIMPIA EL CAMPO DE DETALLES
                $('#form-units').val(''); // SE LIMPIA EL CAMPO DE UNIDADES
                $('#form-img').val(''); // SE LIMPIA EL CAMPO DE IMAGEN
                $('#productId').val(''); // SE LIMPIA EL CAMPO DE ID
            }
        });
    });

    function listarProductos() {
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',
            
            success: function(response){
                let productos = JSON.parse(response);  
                
                if(Object.keys(productos).length > 0) {
                    let template = '';
    
                    productos.forEach(producto => {
                        let descripcion = '';
                        descripcion += '<li>precio: '+producto.precio+'</li>';
                        descripcion += '<li>unidades: '+producto.unidades+'</li>';
                        descripcion += '<li>modelo: '+producto.modelo+'</li>';
                        descripcion += '<li>marca: '+producto.marca+'</li>';
                        descripcion += '<li>detalles: '+producto.detalles+'</li>';
    
                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td>
                                    <a href="#" class="product-item">${producto.nombre}</a>
                                </td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    document.getElementById("products").innerHTML = template;
                }
            }
        });
    }

    $(document).on('click', '.product-delete', function() {
        if( confirm("De verdad deseas eliinar el Producto") ) { // SE PREGUNTA SI SE DESEA ELIMINAR EL PRODUCTO
            var id = event.target.parentElement.parentElement.getAttribute("productId"); // SE OBTIENE EL ID DEL PRODUCTO A ELIMINAR 
            
            $.ajax({
                url: './backend/product-delete.php',
                type: 'GET',
                data: {id}, // SE ENVIA EL ID DEL PRODUCTO A ELIMINAR

                success: function(response) {
                    let respuesta = JSON.parse(response); // SE OBTIENE LA RESPUESTA DE LA PETICION AJAX 
                    let template_bar = ''; // SE CREA UNA VARIABLE PARA ALMACENAR EL HTML DE LA BARRA DE BUSQUEDA
                    template_bar += `
                                <li style="list-style: none;">status: ${respuesta.status}</li>
                                <li style="list-style: none;">message: ${respuesta.message}</li>
                            `;

                    document.getElementById("product-result").className = "card my-4 d-block"; // SE MUESTRA
                    document.getElementById("container").innerHTML = template_bar; // SE MUESTRA LA RESPUESTA DE LA PETICION AJAX

                    listarProductos();
                }
            })
        }
    });

    $(document).on('click', '.product-item', function() {
        
        let id = $(this)[0].parentElement.parentElement.getAttribute('productId'); // SE OBTIENE EL ID DEL PRODUCTO SELECCIONADO
        $.post('./backend/product-single.php', {id}, function(response){ // SE REALIZA UNA PETICION AJAX PARA OBTENER EL PRODUCTO SELECCIONADO
            const product = JSON.parse(response); // SE OBTIENE EL PRODUCTO SELECCIONADO

            $('#productId').val(id); // SE ASIGNA EL ID DEL PRODUCTO AL FORMULARIO
            $('#form-name').val(product[0].nombre); // SE ASIGNA EL NOMBRE DEL PRODUCTO AL FORMULARIO
            $('#form-brand').val(product[0].marca);
            $('#form-model').val(product[0].modelo);
            $('#form-price').val(product[0].precio);
            $('#form-details').val(product[0].detalles);
            $('#form-units').val(product[0].unidades);
            $('#form-img').val(product[0].imagen);
            
            edit = true;

            $('#submit-button').text('Editar Producto');

        })
    }); //esta funcion se encarga de cargar los datos del producto seleccionado en el formulario de agregar producto para poder editarlos 

    $('#form-name').keyup(function(e) {
        e.preventDefault(); // Prevenir el comportamiento por defecto del formulario
    
        // Obtener el valor de búsqueda usando jQuery
        var name = $('#form-name').val();
    
        // Realizar la solicitud AJAX
        $.ajax({
            url: './backend/product-singleByName.php',
            type: 'GET',
            data: { name: name },
            success: function(response) {
                let productos = JSON.parse(response);
                let template_bar = '';
    
                // Verificar si se encontró un producto con el nombre ingresado
                if (Object.keys(productos).length > 0) {
                    template_bar += `<li>Este nombre ya existe en la base de datos.</li>`;
                } else {
                    template_bar += `<li>El nombre está disponible.</li>`;
                }
    
                // Mostrar el estado en la barra de resultados
                document.getElementById("product-result").className = "card my-4 d-block";
                document.getElementById("container").innerHTML = template_bar;
            },
            error: function() {
                alert("Hubo un error al realizar la búsqueda.");
            }
        });
    });
});

function validarNombre(){
    var nombre = document.getElementById("form-name");
    if(nombre.value == ''){
        let template_bar = '';
        template_bar += `<li>El campo nombre es obligatorio</li>`;
        document.getElementById("product-result").className = "card my-4 d-block";
        document.getElementById("container").innerHTML = template_bar;
    }
    else if (nombre.value.length > 100){
        let template_bar = '';
        template_bar += `<li>El nombre debe tener como maximo 100 caracteres</li>`;
        document.getElementById("product-result").className = "card my-4 d-block";
        document.getElementById("container").innerHTML = template_bar;

    }
}

function validarMarca(){
    var marca = document.getElementById("form-brand");
    if (marca.value == ""){
        let template_bar = '';
        template_bar += `<li>El campo marca es obligatorio</li>`;
        document.getElementById("product-result").className = "card my-4 d-block";
        document.getElementById("container").innerHTML = template_bar;
    }
}

function validarModelo(){
    var modelo = document.getElementById("form-model");
    if (modelo.value == ''){
        let template_bar = '';
        template_bar += `<li>Ingresa un modelo</li>`;
        document.getElementById("product-result").className = "card my-4 d-block";            
        document.getElementById("container").innerHTML = template_bar;
    }
}

function validarPrecio(){
    var precio = document.getElementById("form-price");
    if (precio.value == ''){
        let template_bar = '';
        template_bar += `<li>Ingresa el precio</li>`;
        document.getElementById("product-result").className = "card my-4 d-block";            
        document.getElementById("container").innerHTML = template_bar;
    }
    else if (precio.value <= 99.99){
        let template_bar = '';
        template_bar += `<li>El precio debe ser mayor a $99.99</li>`;
        document.getElementById("product-result").className = "card my-4 d-block";
        document.getElementById("container").innerHTML = template_bar;
    }
}

function validarDetalles(){
    var detalles = document.getElementById("form-details");
    if(detalles.value > 250)
    {
        let template_bar = '';
        template_bar += `<li>Los detalles deben tener máximo 250 caracteres</li>`;
        document.getElementById("product-result").className = "card my-4 d-block";
        document.getElementById("container").innerHTML = template_bar;
    }
}

function validarUnidades(){
    var unidades = document.getElementById("form-units");
    if (unidades.value == ''){
        let template_bar = '';
        template_bar += `<li>El campo unidades es obligatorio</li>`;
        document.getElementById("product-result").className = "card my-4 d-block";
        document.getElementById("container").innerHTML = template_bar;
    }
    else if (unidades.value < 0){
        let template_bar = '';
        template_bar += `<li>Cantidad mínima de unidades es 0</li>`;
        document.getElementById("product-result").className = "card my-4 d-block";
        document.getElementById("container").innerHTML = template_bar;
    }
}

function validarImagen(){
    var imagen = document.getElementById("form-img");
    if (imagen.value == ''){
        let template_bar = '';
        template_bar += `<li>Se asignó una imagen por defecto</li>`;
        document.getElementById("product-result").className = "card my-4 d-block";
        document.getElementById("container").innerHTML = template_bar;

        imagen.value = "img/default.png";  
    }
}   







