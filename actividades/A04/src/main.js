function getDatos(){
    var nombre = prompt('Nombre: ', '');
    var edad = prompt('Edad: ', 0);;

    var div1 = document.getElementById('nombre');
    div1.innerHTML = '<h3>Nombre: ' + nombre + '</h3>';

    var div2 = document.getElementById('edad');
    div2.innerHTML = '<h3>Edad: ' + edad + '</h3>';
}

//Ejemplo JS01 - pag. 8
function ejemplo1(){
    document.write('<h3>Hola Mundo</h3>');
}

//Ejemplo JS02 - pag. 6
function ejemplo2(){
    var nombre = 'Kaltum Abdala';
    var edad = 20;
    var altura = 1.65;
    var casado = false;
    
    document.write( nombre );
    document.write( '<br>' );
    document.write( edad );
    document.write( '<br>' );
    document.write( altura );
    document.write( '<br>' );
    document.write( casado ); 
}

//Ejemplo JS02 - pag. 12
function ejemplo3(){
    var nombre;
    var edad;
    nombre = prompt('Ingresa tu nombre: ', '');
    edad = prompt('Ingresa tu edad: ', '');
    document.write('Hola ');
    document.write(nombre);
    document.write(' así que tienes ');
    document.write(edad);
    document.write(' años');
}

//Ejemplo JS03 - pag. 3
function ejemplo4(){
    var valor1;
    var valor2;
    valor1 = prompt('Introducir primer número:', '');
    valor2 = prompt('Introducir segundo número', '');
    var suma = parseInt(valor1)+parseInt(valor2);
    var producto = parseInt(valor1)*parseInt(valor2);
    document.write('La suma es ');
    document.write(suma);
    document.write('<br>');
    document.write('El producto es ');
    document.write(producto);
}

//Ejemplo JS03 - pag. 8
function ejemplo5(){
    var nombre;
    var nota;
    nombre = prompt('Ingresa tu nombre:', '');
    nota = prompt('Ingresa tu nota:', '');
    if (nota>=4) {
    document.write(nombre+' esta aprobado con un '+nota);
    }
}

//Ejemplo JS03 - pag. 11
function ejemplo6(){
    var num1,num2;
    num1 = prompt('Ingresa el primer número:', '');
    num2 = prompt('Ingresa el segundo número:', '');
    num1 = parseInt(num1);
    num2 = parseInt(num2);
    if (num1>num2) {
    document.write('el mayor es '+num1);
    }
    else {
    document.write('el mayor es '+num2);
    }
}

//Ejemplo JS03 - pag. 15-16
function ejemplo7(){
    var nota1,nota2,nota3;

    nota1 = prompt('Ingresa 1ra. nota:', '');
    nota2 = prompt('Ingresa 2da. nota:', '');
    nota3 = prompt('Ingresa 3ra. nota:', '');

    //Convertimos los 3 string en enteros
    nota1 = parseInt(nota1);
    nota2 = parseInt(nota2);
    nota3 = parseInt(nota3);

    var pro;
    pro = (nota1+nota2+nota3)/3;

    if (pro>=7) {
    document.write('aprobado');
    }
    else {
    if (pro>=4) {
    document.write('regular');
    }
    else {
    document.write('reprobado');
    }
    }
}

//Ejemplo JS03 - pag. 18
function ejemplo8(){
    var valor;
    valor = prompt('Ingresar un valor comprendido entre 1 y 5:', '' );
    //Convertimos a entero
    valor = parseInt(valor);
    switch (valor) {
    case 1: document.write('uno');

    break;

    case 2: document.write('dos');

    break;

    case 3: document.write('tres');

    break;

    case 4: document.write('cuatro');

    break;

    case 5: document.write('cinco');

    break;

    default:document.write('debe ingresar un valor comprendido entre 1 y 5.');
    }
}

