// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

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
                                <td>${producto.nombre}</td>
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
                    document.getElementById("product-result").className = "card my-4 d-block";
                    document.getElementById("container").innerHTML = template_bar;
                    document.getElementById("products").innerHTML = template;
                } else {
                    if(Object.keys(products).length == 0) { // SI NO SE ENCUENTRAN PRODUCTOS SE MUESTRA UN MENSAJE
                        let template_bar = ''; // SE CREA UNA VARIABLE PARA ALMACENAR EL HTML DE LA BARRA DE BUSQUEDA
                        template_bar += `<li>No se encontraron productos</il>`; // SE AGREGA EL MENSAJE A LA VARIABLE
                        document.getElementById("product-result").className = "card my-4 d-block"; 
                        document.getElementById("container").innerHTML = template_bar;
                        document.getElementById("products").innerHTML = ''; //para limpiar la tabla
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
        // SE OBTIENE EL STRING DEL JSON FINAL
        productoJsonString = JSON.stringify(finalJSON,null,2);

        // Validar nombre
        if (!finalJSON.nombre || finalJSON.nombre.length == 0) {
            alert('Ingresa un nombre');
            return false;
        }
        if (finalJSON.nombre.length > 100) {
            alert('El nombre debe tener máximo 100 caracteres');
            return false;
        }

        // Validar marca
        const marcasValidas = ['La Roche-Posay', 'KIEHLS', 'Rare Beauty', 'Neutrogena', 'The Ordinary','Maybelline', 'YSL','ISDIN', 'CLINIQUE', 'Drunk Elephant', 'Maybelline'];
        if (!finalJSON.marca || finalJSON.marca.length == 0) {
            alert('Selecciona una marca');
            return false;
        }
        if (!marcasValidas.includes(finalJSON.marca)) {
            alert('Marca no válida, selecciona una válida (La Roche-Posay, KIEHLS, Rare Beauty, Neutrogena, The Ordinary,Maybelline, YSL,ISDIN, CLINIQUE, Drunk Elephant, Maybelline)');
            return false;
        }

        // Validar modelo
        if (!finalJSON.modelo || finalJSON.modelo.length == 0) {
            alert('Ingresa un modelo');
            return false;
        }
        if (!/^[a-zA-Z0-9 ]+$/.test(finalJSON.modelo) || finalJSON.modelo.length > 25) {
            alert('El modelo debe ser alfanumérico y menor a 25 caracteres');
            return false;
        }

        // Validar precio
        if (!finalJSON.precio || finalJSON.precio.length == 0) {
            alert('Ingresa el precio');
            return false;
        }
        if (finalJSON.precio < 99.99) {
            alert('El precio debe ser mayor a $99.99');
            return false;
        }

        // Validar detalles
        if (finalJSON.detalles && finalJSON.detalles.length > 250) {
            alert('Los detalles deben tener máximo 250 caracteres');
            return false;
        }

        // Validar unidades
        if (finalJSON.unidades == null || finalJSON.unidades < 0) {
            alert('Cantidad mínima de unidades es 0');
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
        let id = $(this)[0].parentElement.parentElement.getAttribute('productid');
        //console.log(id);
        $.post('./backend/product-single.php', {id}, function(response){
            const product = JSON.parse(response);
            $('#name').val(product[0].nombre);
            let productWithoutNameAndId = {...product[0]};
            delete productWithoutNameAndId.nombre;
            delete productWithoutNameAndId.id;
            delete productWithoutNameAndId.eliminado;

            $('#description').val(JSON.stringify(productWithoutNameAndId, null, 4));
            edit = true;

            $('#submit-button').text('Editar Producto');

        })
    });
});
