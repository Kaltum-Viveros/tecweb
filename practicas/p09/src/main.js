function validarNombre(){
    var nombre = document.getElementById("form-name");
    if(nombre.value == ''){
        alert("El campo nombre es obligatorio");
    }
    else if (nombre.value.length > 100){
        alert("El nombre debe tener como maximo 100 caracteres");
    }
}

function validarMarca(){
    var marca = document.getElementById("form-brand");
    if (marca.value == ""){
        alert("El campo marca es obligatorio");
    }
}

function validarModelo(){
    var modelo = document.getElementById("form-model");
    if (modelo.value == ''){
        alert("El campo modelo es obligatorio");
    }
    else if (modelo.value.length > 25){
        alert("El modelo debe tener como maximo 25 caracteres");
    }
    else if (!/^[a-zA-Z0-9 ]+$/.test(modelo.value)){ //para que tambien acepte espacios debe de agregar un espacio en el regex /^[a-zA-Z0-9 ]+$/
        alert("El modelo debe ser alfanumerico");
    }
}

function validarPrecio(){
    var precio = document.getElementById("form-price");
    if (precio.value == ''){
        alert("El campo precio es obligatorio");
    }
    else if (precio.value <= 99.99){
        alert("El precio debe ser mayor a 99.99");
    }
}

function validarDetalles(){
    var detalles = document.getElementById("form-details");
    if(detalles.value > 250)
    {
        alert("Los detalles deben tener como maximo 250 caracteres");
    }
}

function validarUnidades(){
    var unidades = document.getElementById("form-units");
    if (unidades.value == ''){
        alert("El campo unidades es obligatorio");
    }
    else if (unidades.value < 0){
        alert("Las unidades deben ser mayores a 0");
    }
}

function validarImagen(){
    var imagen = document.getElementById("form-img");
    if (imagen.value == ''){
        alert("Se asigno una imagen por defecto");
        imagen.value = "img/default.png";  
    }
}


