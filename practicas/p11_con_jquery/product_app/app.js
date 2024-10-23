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
        if($('#search').val()){ // SI EL CAMPO DE BUSQUEDA NO ESTA VACIO SE REALIZA LA BUSQUEDA
        
            let search = $('#search').val(); 
            $.ajax({  // SE HACE LA PETICION AJAX PARA BUSCAR LOS PRODUCTOS POR NOMBRE O DESCRIPCION 
                url: './backend/product-search.php', 
                type: 'GET',
                data : {search}, 

                success: function(response) {    // SE OBTIENE LA RESPUESTA DE LA PETICION AJAX
                    let products = JSON.parse(response);

                    if(Object.keys(products).length > 0) { // SI SE ENCUENTRAN PRODUCTOS SE MUESTRAN EN LA TABLA
                        let template = ''; // SE CREA UNA VARIABLE PARA ALMACENAR EL HTML DE LA TABLA
                        let template_bar = ''; // SE CREA UNA VARIABLE PARA ALMACENAR EL HTML DE LA BARRA DE BUSQUEDA
        
                        products.forEach(product => {
                            
                            let descripcion = '';
                            descripcion += '<li>precio: '+product.precio+'</li>';
                            descripcion += '<li>unidades: '+product.unidades+'</li>';
                            descripcion += '<li>modelo: '+product.modelo+'</li>';
                            descripcion += '<li>marca: '+product.marca+'</li>';
                            descripcion += '<li>detalles: '+product.detalles+'</li>';
                        
                            template += `
                                <tr productId="${product.id}">
                                    <td>${product.id}</td>
                                    <td>${product.nombre}</td>
                                    <td><ul>${descripcion}</ul></td>
                                    <td>
                                        <button class="product-delete btn btn-danger" onclick="eliminarproduct()">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            `;
        
                            template_bar += `<li>${product.nombre}</il>`;
                        });
                        document.getElementById("product-result").className = "card my-4 d-block";
                        document.getElementById("container").innerHTML = template_bar;  // SE MUESTRA LA BARRA DE BUSQUEDA CON LOS PRODUCTOS ENCONTRADOS
                        document.getElementById("products").innerHTML = template; // SE MUESTRA LA TABLA CON LOS PRODUCTOS ENCONTRADOS
                    }
                    if(Object.keys(products).length == 0) { // SI NO SE ENCUENTRAN PRODUCTOS SE MUESTRA UN MENSAJE
                        let template_bar = ''; // SE CREA UNA VARIABLE PARA ALMACENAR EL HTML DE LA BARRA DE BUSQUEDA
                        template_bar += `<li>No se encontraron productos</il>`; // SE AGREGA EL MENSAJE A LA VARIABLE
                        document.getElementById("product-result").className = "card my-4 d-block"; 
                        document.getElementById("container").innerHTML = template_bar;
                        document.getElementById("products").innerHTML = ''; //para limpiar la tabla
                    }
                }
            });
        }  
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

        // SE ENVIA EL JSON A TRAVES DE AJAX
        $.ajax({
            url: './backend/product-add.php',
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
                                <td>${producto.nombre}</td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger" onclick="eliminarProducto()">
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


    

});
