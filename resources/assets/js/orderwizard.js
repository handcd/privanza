/**
 * Order Wizard 
 * 
 * Este archivo contiene la lógica para control de las reglas de negocio
 * en el formulario general de Privanza.
 */


//Variables para obeter elementos input
const biesInterno = document.getElementById('BiesInterno');
const pinPointInterno = document.getElementById('PinPointInterno');
const solapaEnContraste = document.getElementById('ojalEnSolapa');
const ojalDeMangaEnContraste = document.getElementById('tipoDeOjalEnManga');

//Variables para obtener paletas de colores y ocultar componentes
const coloresDeSolapaEnContraste = document.getElementById('solapaContraste');
const colorDeMangaEnContraste = document.getElementById('colorDeOjalEnMangas'); 
const colorDeBiesYPinPoint = document.getElementById('colorPalette');

// Elementos Ocultos
const divMarcaEtiqueta = document.getElementById('marcaEtiqueta');
const divPerGancho = document.getElementById('personalizacionGancho');
const divPerPortatraje = document.getElementById('personalizacionPortatrajes');
const divForroChaleco = document.getElementById('otroForroChaleco');
const divOjalesActivosManga = document.getElementById('divOjalesActivosManga');

// Elementos que contienen la lógica de hide/show
const checkEtiquetaMarca = document.getElementById('checkEtiquetaMarca');
const selectTipoGancho = document.getElementById('tipoGancho');
const selectTipoPortatrajes = document.getElementById('tipoPortatrajes');
const checkForroChaleco = document.getElementById('tipoForroChaleco');
const checkOjalesActivosManga = document.getElementById('ojalesActivosManga');

//Funcion para oocultar componentes
function iniciarComponentes(){ 
    $(colorDeMangaEnContraste).hide();
    $(coloresDeSolapaEnContraste).hide();
    $(colorDeBiesYPinPoint).hide();

    $(divMarcaEtiqueta).hide();
    $(divPerGancho).hide();
    $(divPerPortatraje).hide();
    $(divOjalesActivosManga).hide();
}

/**
 * Funciones para lógica de control de elementos, cada una es específica
 * a lo que se defina en el Business Logic.
 */


// Mostrar el campo para otra marca sólamente si se reciben etiquetas de marca.
function mostrarOcultarOtraMarca() {
    $(divMarcaEtiqueta).toggle();
}

// Mostrar el campo para seleccionar otro forro de chaleco únicamente si no
// selecciona el mismo en cuerpo
function mostrarOcultarOtroForroChaleco() {
    $(divForroChaleco).toggle();
}

// Mostrar el campo para ojales activos en manga
function mostrarOcultarOjalesActivosManga() {
    $(divOjalesActivosManga).toggle();
}

//Mostrar y ocultar paleta de colores para ojal de solapa en contraste
function coloresSolapaEnContraste(){		
    if(solapaEnContraste.value == 2){
        $(coloresDeSolapaEnContraste).show();
    }else {
        $(coloresDeSolapaEnContraste).hide();
    }
}

//Mostrar y ocultar paleta de colores para ojal en contraste de manga
function coloresOjalEnManga(){		
    if(ojalDeMangaEnContraste.value == 1){
        $(colorDeMangaEnContraste).show();
    }else {
        $(colorDeMangaEnContraste).hide();
    }
}

//Lógica para Bies & pinpoint
function coloresPinPointBies(){	
    if(biesInterno.checked || pinPointInterno.checked){			
        $(colorDeBiesYPinPoint).show();
    }else {
        $(colorDeBiesYPinPoint).hide();
    }
}

// Mostrar y ocultar personalización de gancho
function mostrarOcultarPersonalizacionGancho() {
    if (selectTipoGancho.value == "1") {
        $(divPerGancho).show();
    } else {
        $(divPerGancho).hide();
    }
}

// Mostrar y ocultar personalización de portatrajes
function mostrarOcultarPersonalizacionPortatraje() {
    if (selectTipoPortatrajes.value == "1") {
        $(divPerPortatraje).show();
    } else {
        $(divPerPortatraje).hide();
    }
}


/**
 * Helper Functions para cotización de productos.
 */

//Función para agregar eventos 
function agregarEventos(){
    console.log('Declarando eventos dentro de la funcion');
    biesInterno.addEventListener('click', () => {
        coloresPinPointBies();
    });
    pinPointInterno.addEventListener('click', () => {
        coloresPinPointBies();
    });
    solapaEnContraste.addEventListener('click', () => {
        coloresSolapaEnContraste();
    });
    ojalDeMangaEnContraste.addEventListener('click', () => {
        coloresOjalEnManga();
    });

    checkEtiquetaMarca.addEventListener('click', () => {
        mostrarOcultarOtraMarca();
    });

    selectTipoGancho.addEventListener('change', () => {
        mostrarOcultarPersonalizacionGancho();
    });

    selectTipoPortatrajes.addEventListener('change', () => {
        mostrarOcultarPersonalizacionPortatraje();
    });

    checkForroChaleco.addEventListener('click', () => {
        mostrarOcultarOtroForroChaleco();
    });

    checkOjalesActivosManga.addEventListener('click', () => {
        mostrarOcultarOjalesActivosManga();
    });

    console.log('Finalización de Declaración de Eventos en función.');
}


//Agregar eventos y ocultar componentes al cargar la página
$(document).ready(function() {
    console.log('Ocultando componentes... ');
    iniciarComponentes();
    console.log('Agregando eventos...');
    agregarEventos();
    console.log('Listo!');
});