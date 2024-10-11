let paso = 1;
let pasoInicial=1;
let pasoFinal=3;

const cita={
    id:'',
    nombre:'',
    fecha:'',
    hora:'',
    servicios:[]
}

document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
});


function iniciarApp(){
    tabs(); //cambia la seccion cuando se presionan las tabs
    mostrarSeccion();
    botonesPaginador(); //agrega o quita los botones del paginador
    paginaSiguiente();
    paginaAnterior();
    consultarAPI(); // consulta la api en el backend de php

    idCliente();
    nombreCliente();
    seleccionarFecha();
    seleccionarHora();
    mostrarResumen();
}

function mostrarSeccion(){
    //Ocultar la sección que contenga la clase de mostrar

    const seccionAnterior = document.querySelector('.mostrar');
    if(seccionAnterior){
        seccionAnterior.classList.remove('mostrar');
    }

    //seleccionar la seccion con el paso.....
    const pasoSelector =`#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');

    //quita la seleccion con el paso

    const tabAnterior=document.querySelector('.actual');
    if(tabAnterior){
        tabAnterior.classList.remove('actual');
    }

    //resaltar el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
}

function tabs(){
        const botones = document.querySelectorAll('.tabs button');

        botones.forEach(boton =>{
            boton.addEventListener('click', function(e){
                paso=parseInt( e.target.dataset.paso);
                mostrarSeccion();
                botonesPaginador();

                if(paso === 3){
                    mostrarResumen();
                }
            });
        })
}   

function botonesPaginador(){

    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if(paso===1){
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }else if(paso===3){
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
        mostrarResumen();
    }else{
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }
    mostrarSeccion();
}
function paginaAnterior(){
    const paginaAnterior=document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function(){
        if(paso<=pasoInicial) return;
        paso--;
        botonesPaginador();
    })
}

function paginaSiguiente(){
    const paginaSiguiente=document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function(){
        if(paso>=pasoFinal) return;
        paso++;
        botonesPaginador();
    })
}






async function consultarAPI(){
    try {
        const url = '/api/servicios';
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);
    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios){
    servicios.forEach( servicio=>{
        const { id, nombre, precio } = servicio;

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent= `$ ${precio}`;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick=function(){ //callbacj para pasar una funcion dentro de otra
            seleccionarServicio(servicio); //esto esta bien
        }
        
        
        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        document.querySelector('#servicios').appendChild(servicioDiv);

    });
}

function seleccionarServicio(servicio){
    const{id}=servicio; //descontruye el id disturing, extrae
    const{servicios }= cita; //extrae los servicios del objeto citas

    //identifica al elemento que se le da click
    const divServicio=document.querySelector(`[data-id-servicio="${id}"]`);
    //comprobar si un servicio ya fue agregado 
    if(servicios.some(agregado => agregado.id === id)){
        //eliminarlo
        cita.servicios = servicios.filter(agregado => agregado.id !== id);
        divServicio.classList.remove('seleccionado');
    }else{
        //agregarlo
        cita.servicios = [...servicios, servicio]; //accede al atributo servicios y realiza una copia de la memoria con el spread operator, y le agrega el nuevo servicio 
        divServicio.classList.add('seleccionado');
    }

    
    
    
    

    //console.log(cita);

}


function idCliente(){
    cita.id=document.querySelector('#id').value;

}

function nombreCliente(){
    cita.nombre=document.querySelector('#nombre').value;
}



function seleccionarFecha(){
    const inputFecha=document.querySelector('#fecha');
    inputFecha.addEventListener('input', function(e){
        const dia = new Date(e.target.value).getUTCDay();
        if([6,0].includes(dia)){
            e.target.value='';
            mostrarAlerta('Los fines de semana no abrimos :\'(', 'error', '.formulario');
        }else{
            cita.fecha=e.target.value;
        }
    });
}

function seleccionarHora(){
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input',function(e){

        const horaCita=e.target.value;
        const hora=horaCita.split(":")[0]; //split es para separar en este caso con un :
// ahora [0] significa que tomara la primera parte antes del : en este caso la hora

        //evaluamos el horario disponible con if

        if(hora<10 || hora> 18){
            e.target.value='';
            mostrarAlerta('Fuera de horario', 'error', '.formulario');

        }else{
            cita.hora=e.target.value;
            // console.log(cita);
        }


    } );
}





function mostrarAlerta(mensaje, tipo, elemento, desaparece = true){

    const alertaPrevia = document.querySelector('.alerta');

    if(alertaPrevia){
        alertaPrevia.remove();
    }
    

    //scrpt para generar la alerta

    const alerta= document.createElement('DIV');
    alerta.textContent=mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

        if (desaparece){
            
    setTimeout(()=>{
        alerta.remove();
    }, 3000);

        }

}

function mostrarResumen(){
    const resumen = document.querySelector('.contenido-resumen');

    //limpia el contenido del resumen 
    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
    }

    
    
    if(Object.values(cita).includes('')|| cita.servicios.length ===0){ //datos o servicios
        mostrarAlerta('faltan datos de servicios, fecha u hora', 'error', '.contenido-resumen', false);
        return;
    }

    //formatear el div de resumen

    const { nombre, fecha, hora, servicios } = cita;


    //heding para servicios en resumen

    const headingServicios =document.createElement('H3');
    headingServicios.textContent='Resumen de servicios';
    resumen.appendChild(headingServicios);

    //iterando y mostrando los servicios

    servicios.forEach(servicio=>{
        const{ id, precio, nombre}= servicio;
        const contenedorServicio=document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const textoServicio=document.createElement('P');
        textoServicio.textContent=nombre;

        const precioServicio=document.createElement('P');
        precioServicio.innerHTML=`<span>Precio:</span> $${precio}`;

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);
    })


      //heding para servicios en cita

      const headingcita =document.createElement('H3');
      headingcita.textContent='Resumen de cita';
      resumen.appendChild(headingcita);


    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML=`<span>Nombre:</span> ${nombre}`;

    //formatear la fecha en español

    const fechaObj= new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2; //siempre empieza en 0 los date, se le pone mas 2 porque se instancia 2 veces y cada vez pierde 1
    const year = fechaObj.getFullYear();

    const fechaUTC =new Date(Date.UTC(year, mes, dia));

    const opciones = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'}
    const fechaFormateada = fechaUTC.toLocaleDateString('es-MX', opciones);

    



    const fechaCita = document.createElement('P');
    fechaCita.innerHTML=`<span>fecha:</span> ${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML=`<span>hora:</span> ${hora} Horas`;


    //boton para reservar una cita :D

    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent='Reservar Cita';
    botonReservar.onclick= reservarCita;



    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);


    resumen.appendChild(botonReservar);
    

}


//puedes ahorrarte todo este codigo con el programa postman que te dira si hay respuesta o no desde el servidor xD

async function reservarCita(){

    const {nombre, fecha, hora, servicios, id} = cita;


    const idServicios= servicios.map(servicio => servicio.id); // iteras sobre los servicios, tomas la variable.id y la guardas en la variable


    const datos = new FormData();
    
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('usuarioId', id); //en la izquierda accedes ala parte del arreglo, a la derecha le metes la variable con la info que traes
    datos.append('servicios', idServicios); ///cuidado con las minusculas y mayusculas, es muy sensible

    try {

        const url = '/api/citas';

        const respuesta = await fetch(url, {
        method: 'POST', // creamos un objeto, nunca lleva ; porque si no te tira error
        body:datos // con body conectamos Fetch y los datos que estamos pidiendo 
        });
    
     // correcto: console.log(respuesta);
    
        const resultado = await respuesta.json();
        console.log(resultado.resultado);

        if(resultado.resultado){
            Swal.fire({
                icon: "success",
                title: "Cita creada",
                text: "La cita se creo correctamente",
                button:'OK'  
              }).then( ()=>{
                setTimeout(()=>{
                    window.location.reload();
                },3000);
              })
        }
        
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Algo salio mal al guardar la cita",
          });
    }


   
}
