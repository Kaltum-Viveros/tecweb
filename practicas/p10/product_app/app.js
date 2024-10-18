// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

// FUNCIÓN CALLBACK DE BOTÓN "Buscar"
function buscarID(e) {
    /**
     * Revisar la siguiente información para entender porqué usar event.preventDefault();
     * http://qbit.com.mx/blog/2013/01/07/la-diferencia-entre-return-false-preventdefault-y-stoppropagation-en-jquery/#:~:text=PreventDefault()%20se%20utiliza%20para,escuche%20a%20trav%C3%A9s%20del%20DOM
     * https://www.geeksforgeeks.org/when-to-use-preventdefault-vs-return-false-in-javascript/
     */
    e.preventDefault();

    // SE OBTIENE EL ID A BUSCAR
    var id = document.getElementById('search').value;

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n'+client.responseText);
            
            // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
            let productos = JSON.parse(client.responseText);    // similar a eval('('+client.responseText+')');
            
            // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
            if(Object.keys(productos).length > 0) {
                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                let descripcion = '';
                    descripcion += '<li>precio: '+productos.precio+'</li>';
                    descripcion += '<li>unidades: '+productos.unidades+'</li>';
                    descripcion += '<li>modelo: '+productos.modelo+'</li>';
                    descripcion += '<li>marca: '+productos.marca+'</li>';
                    descripcion += '<li>detalles: '+productos.detalles+'</li>';
                
                // SE CREA UNA PLANTILLA PARA CREAR LA(S) FILA(S) A INSERTAR EN EL DOCUMENTO HTML
                let template = '';
                    template += `
                        <tr>
                            <td>${productos.id}</td>
                            <td>${productos.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;

                // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                document.getElementById("productos").innerHTML = template;
            }
        }
    };
    client.send("id="+id);
}

function agregarProducto(e) {
    e.preventDefault();

    // SE OBTIENE DESDE EL FORMULARIO EL JSON A ENVIAR
    var productoJsonString = document.getElementById('description').value;

    // SE CONVIERTE EL JSON DE STRING A OBJETO
    var finalJSON = JSON.parse(productoJsonString);

    // SE AGREGA AL JSON EL NOMBRE DEL PRODUCTO
    finalJSON['nombre'] = document.getElementById('name').value;

    // VALIDAR EL OBJETO JSON ANTES DE ENVIARLO
    if (!validarJson(finalJSON)) {
        // Si la validación falla, detener el proceso de envío
        return;
    }

    // SE OBTIENE EL STRING DEL JSON FINAL
    productoJsonString = JSON.stringify(finalJSON, null, 2);

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/create.php', true);
    client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");

    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log(client.responseText);
        }
    };

    // SE ENVÍA EL JSON VALIDADO AL SERVIDOR
    client.send(productoJsonString);
}

// SE CREA EL OBJETO DE CONEXIÓN COMPATIBLE CON EL NAVEGADOR
function getXMLHttpRequest() {
    var objetoAjax;

    try{
        objetoAjax = new XMLHttpRequest();
    }catch(err1){
        /**
         * NOTA: Las siguientes formas de crear el objeto ya son obsoletas
         *       pero se comparten por motivos historico-académicos.
         */
        try{
            // IE7 y IE8
            objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(err2){
            try{
                // IE5 y IE6
                objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(err3){
                objetoAjax = false;
            }
        }
    }
    return objetoAjax;
}

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
}

function buscarProducto(e) {
    e.preventDefault();

    // SE OBTIENE EL TÉRMINO DE BÚSQUEDA
    var searchProduct = document.getElementById('search').value;

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n' + client.responseText);

            // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
            let productos = JSON.parse(client.responseText);

            // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
            if (productos.length > 0) {
                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                let template = '';
                productos.forEach(producto => {
                    let descripcion = '';
                    descripcion += `<li>precio: ${producto.precio !== undefined ? producto.precio : 'No disponible'}</li>`;
                    descripcion += `<li>unidades: ${producto.unidades !== undefined ? producto.unidades : 'No disponible'}</li>`;
                    descripcion += `<li>modelo: ${producto.modelo !== undefined ? producto.modelo : 'No disponible'}</li>`;
                    descripcion += `<li>marca: ${producto.marca !== undefined ? producto.marca : 'No disponible'}</li>`;
                    descripcion += `<li>detalles: ${producto.detalles !== undefined ? producto.detalles : 'No disponible'}</li>`;

                    // SE CREA UNA PLANTILLA PARA CREAR LA(S) FILA(S) A INSERTAR EN EL DOCUMENTO HTML
                    template += `
                        <tr>
                            <td>${producto.id !== undefined ? producto.id : 'No disponible'}</td>
                            <td>${producto.nombre !== undefined ? producto.nombre : 'No disponible'}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;
                });

                // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                document.getElementById("productos").innerHTML = template;
            } else {
                // Manejar el caso cuando no hay productos
                document.getElementById("productos").innerHTML = '<tr><td colspan="3">No se encontraron productos.</td></tr>';
            }
        }
    };
    client.send("searchProduct=" + encodeURIComponent(searchProduct));
}

function validarNombre(){
    var nombre = document.getElementById("name");
    if(nombre.value == ''){
        alert("El campo nombre es obligatorio");
    }
    else if (nombre.value.length > 100){
        alert("El nombre debe tener como maximo 100 caracteres");
    }
}


function validarJson(finalJSON) {
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

    // Si pasa todas las validaciones
    return true;
}