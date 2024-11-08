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

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;

    // SE LISTAN TODOS LOS PRODUCTOS
    //listarProductos();
}

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

        // SE OBTIENE DESDE EL FORMULARIO EL JSON A ENVIAR
        var productoJsonString = document.getElementById('description').value;
        // SE CONVIERTE EL JSON DE STRING A OBJETO
        var finalJSON = JSON.parse(productoJsonString);
        // SE AGREGA AL JSON EL NOMBRE DEL PRODUCTO
        finalJSON['nombre'] = document.getElementById('name').value;
        if (edit) {
            finalJSON['id'] = selectedProductId; // Aquí guardas el id del producto seleccionado para editar
        }

        // Validar nombre
        if (!finalJSON.nombre || finalJSON.nombre.length == 0) {
            let template_bar = '';
            template_bar += `<li>Ingresa un nombre</li>`;
            document.getElementById("product-result").className = "card my-4 d-block";
            document.getElementById("container").innerHTML = template_bar;

            return false;
        }

        if (finalJSON.nombre.length > 100) {
            let template_bar = '';
            template_bar += `<li>El nombre debe tener máximo 100 caracteres</li>`;
            document.getElementById("product-result").className = "card my-4 d-block";
            document.getElementById("container").innerHTML = template_bar;

            return false;
        }

        // Validar marca
        const marcasValidas = ['La Roche-Posay', 'KIEHLS', 'Rare Beauty', 'Neutrogena', 'The Ordinary','Maybelline', 'YSL','ISDIN', 'CLINIQUE', 'Drunk Elephant', 'Maybelline'];
        if (!finalJSON.marca || finalJSON.marca.length == 0) {
            let template_bar = '';
            template_bar += `<li>Selecciona una marca</li>`;
            document.getElementById("product-result").className = "card my-4 d-block";
            document.getElementById("container").innerHTML = template_bar;

            return false;
        }
        if (!marcasValidas.includes(finalJSON.marca)) {
            let template_bar = '';
            template_bar += `<li>Marca no válida, selecciona una válida: ${marcasValidas.join(', ')}</li>`;
            document.getElementById("product-result").className = "card my-4 d-block"; 
            document.getElementById("container").innerHTML = template_bar;
            
            return false;
        }

        // Validar modelo
        if (!finalJSON.modelo || finalJSON.modelo.length == 0) {
            let template_bar = '';
            template_bar += `<li>Ingresa un modelo</li>`;
            document.getElementById("product-result").className = "card my-4 d-block";
            document.getElementById("container").innerHTML = template_bar;

            return false;
        }
        if (!/^[a-zA-Z0-9 ]+$/.test(finalJSON.modelo) || finalJSON.modelo.length > 25) {
            let template_bar = '';
            template_bar += `<li>El modelo debe ser alfanumérico y menor a 25 caracteres</li>`;
            document.getElementById("product-result").className = "card my-4 d-block";
            document.getElementById("container").innerHTML = template_bar;

            return false; 
        }

        // Validar precio
        if (!finalJSON.precio || finalJSON.precio.length == 0) {
            let template_bar = '';
            template_bar += `<li>Ingresa el precio</li>`;
            document.getElementById("product-result").className = "card my-4 d-block";
            document.getElementById("container").innerHTML = template_bar;

            return false; 
        }

        if (finalJSON.precio < 99.99) {
            let template_bar = '';
            template_bar += `<li>El precio debe ser mayor a $99.99</li>`;
            document.getElementById("product-result").className = "card my-4 d-block";
            document.getElementById("container").innerHTML = template_bar;

            return false;
        }

        // Validar detalles
        if (finalJSON.detalles && finalJSON.detalles.length > 250) {
            let template_bar = '';
            template_bar += `<li>Los detalles deben tener máximo 250 caracteres</li>`;
            document.getElementById("product-result").className = "card my-4 d-block";
            document.getElementById("container").innerHTML = template_bar;

            return false;
        }

        // Validar unidades
        if (finalJSON.unidades == null || finalJSON.unidades < 0) {
            let template_bar = '';
            template_bar += `<li>Cantidad mínima de unidades es 0</li>`;
            document.getElementById("product-result").className = "card my-4 d-block";
            document.getElementById("container").innerHTML = template_bar;

            return false;
        }

        // Validar imagen
        if (!finalJSON.imagen || finalJSON.imagen.length == 0) {
            finalJSON.imagen = 'img/pre.png';  // Asignar una imagen por defecto
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
                init();
                edit = false; // SE REINICIA LA VARIABLE DE EDICION
                $('#submit-button').text('Agregar Producto'); // SE CAMBIA EL TEXTO DEL BOTON A AGREGAR PRODUCTO
                $('#name').val(''); // SE LIMPIA EL CAMPO DE NOMBRE
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
        selectedProductId = $(this)[0].parentElement.parentElement.getAttribute('productid'); // SE OBTIENE EL ID DEL PRODUCTO SELECCIONADO

        $.post('./backend/product-single.php', {id: selectedProductId}, function(response){ // SE OBTIENE EL PRODUCTO SELECCIONADO
            const product = JSON.parse(response);
            $('#name').val(product[0].nombre); // SE CARGA EL NOMBRE DEL PRODUCTO EN EL CAMPO DE NOMBRE
            let productWithoutId = {...product[0]}; // SE COPIA EL PRODUCTO PARA ELIMINAR EL ID Y ELIMINADO 
            delete productWithoutId.id; // SE ELIMINA EL ID para que no se muestre en el formulario
            delete productWithoutId.nombre; //SE ELIMINA EL NOMBRE PARA QUE NO SE MUESTRE EN EL FORMULARIO
            delete productWithoutId.eliminado; // SE ELIMINA EL ATRIBUTO "ELIMINADO" PARA QUE NO SE MUESTRE EN EL FORMULARIO

            $('#description').val(JSON.stringify(productWithoutId, null, 4)); // SE CARGA EL JSON DEL PRODUCTO EN EL CAMPO DE DESCRIPCION
            edit = true;

            $('#submit-button').text('Editar Producto');

        })
    }); //esta funcion se encarga de cargar los datos del producto seleccionado en el formulario de agregar producto para poder editarlos 
});
