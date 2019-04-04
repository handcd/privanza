/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 7);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */,
/* 1 */,
/* 2 */,
/* 3 */,
/* 4 */,
/* 5 */,
/* 6 */,
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(8);
__webpack_require__(9);
module.exports = __webpack_require__(10);


/***/ }),
/* 8 */
/***/ (function(module, exports) {

/**
 * Order Wizard 
 * 
 * Este archivo contiene la lógica para control de las reglas de negocio
 * en el formulario general de Privanza.
 */

var largoBrazoIzquierdo = document.getElementById("tallaIzquierda");
var largoBrazoDerecho = document.getElementById("tallaDerecha");
var largoChaleco = document.getElementById("tallaChaleco");
var largoEspaldaSaco = document.getElementById('largoEspaldaSaco');
var expresionRegularFracciones = /[1-9]+\/[1-9]+$/;
    

//Variables para obtener elementos input
var tipoAccesorio1 = document.getElementById('tipoAccesorio1');
var tipoAccesorio2 = document.getElementById('tipoAccesorio2');
var tipoAccesorio3 = document.getElementById('tipoAccesorio3');
var solapaEnContraste = document.getElementById('ojalEnSolapa');
var ojalDeMangaEnContraste = document.getElementById('tipoDeOjalEnManga');
//var checkSinAletilla = document.getElementById('sinAletilla');


//Variables para obtener paletas de colores y ocultar componentes
var coloresDeSolapaEnContraste = document.getElementById('solapaContraste');
var colorDeMangaEnContraste = document.getElementById('colorDeOjalEnMangas');
var colorDeBiesPinpoint = document.getElementById('colorPaletteBiesPinpoint');

// Elementos Ocultos
var divMarcaEtiqueta = document.getElementById('marcaEtiqueta');
var divMarcaTela = document.getElementById('marcaTela');
var divPerGancho = document.getElementById('personalizacionGancho');
var divPerPortatraje = document.getElementById('personalizacionPortatrajes');
var divPerSaco = document.getElementById('personalizacionHolguraSaco');
var divForroChaleco = document.getElementById('otroForroChaleco');
var divOjalesActivosManga = document.getElementById('divOjalesActivosManga');
var divOjalesActivosSolapa = document.getElementById('divOjalesActivosSolapa');
var divCantidadDeBotones = document.getElementById('cantidadBotones');
var divPosicionOjalesManga = document.getElementById('divPosicionOjalesManga');

// Elementos que contienen la lógica de hide/show
var checkEtiquetaMarca = document.getElementById('checkEtiquetaMarca');
var checkEtiquetaTela = document.getElementById('checkEtiquetaTela');
var selectTipoGancho = document.getElementById('tipoGancho');
var selectTipoPortatrajes = document.getElementById('tipoPortatrajes');
var selectTipoHolguraSaco = document.getElementById('tipoHolguraSaco');
var checkForroChaleco = document.getElementById('tipoForroChaleco');
var checkOjalesActivosManga = document.getElementById('ojalesActivosManga');
var checkBotonesDeCliente = document.getElementById('botonesCliente');
//var imgPickStitch = document.getElementById('pickstitch');

//Funcion para oocultar componentes
function iniciarComponentes() {
    $(colorDeMangaEnContraste).hide();
    $(coloresDeSolapaEnContraste).hide();
    $(colorDeBiesPinpoint).hide();
    $(divCantidadDeBotones).hide();
    $(divMarcaEtiqueta).hide();
    $(divMarcaTela).hide();
    $(divPerGancho).hide();
    $(divPerPortatraje).hide();
    $(divPerSaco).hide();
    $(divOjalesActivosManga).hide();
    $(divOjalesActivosSolapa).hide();
    $(divPosicionOjalesManga).hide();
}

/**
 * Funciones para lógica de control de elementos, cada una es específica
 * a lo que se defina en el Business Logic.
 */
 //Mostrar u ocultar imagen con o sin pickstitch
 /*function cambiarImagenPickstitch(){
    if ( checkSinAletilla.checked) {
        $("#imgPickStitch").attr("src","{{ asset('img/suit_options/saco/pick-stitch-saletilla.png') }}");
        console.log('Sin Aletilla');
    }else{
        $("#imgPickStitch").attr("src","{{ asset('img/suit_options/saco/pick-stitch.png') }}");
        console.log('Con Aletilla');
    }
 }*/
//Mostrar el campo para ingresar el número de botones, sólo si los entrega el cliente
function mostrarOcultarCantidadBotones(){
    if (checkBotonesDeCliente.checked) {
        $(divCantidadDeBotones).show();
    }else{
        $(divCantidadDeBotones).hide();
    }
}
// Mostrar el campo para otra marca sólamente si se reciben etiquetas de marca de etiqueta.
function mostrarOcultarOtraMarca() {
    $(divMarcaEtiqueta).toggle();
}
// Mostrar el campo para otra marca sólamente si se reciben etiquetas de marca de tela.
function mostrarOcultarOtraMarcaTela() {
    $(divMarcaTela).toggle();
}

// Mostrar el campo para seleccionar otro forro de chaleco únicamente si no
// selecciona el mismo en cuerpo
function mostrarOcultarOtroForroChaleco() {
    $(divForroChaleco).toggle();
}

// Mostrar el campo para ojales activos en manga
function mostrarOcultarOjalesActivosManga() {
    if (checkOjalesActivosManga.checked) {
        $(divOjalesActivosManga).show();
    }else{
        $(divOjalesActivosManga).hide();
    }
}
function mostrarOcultarOjalesActivosSolapa() {
    if (solapaEnContraste.value == 2) {
        $(divOjalesActivosSolapa).show();
    }else{
        $(divOjalesActivosSolapa).hide();
    }
}

//Mostrar y ocultar paleta de colores para ojal de solapa en contraste
function coloresSolapaEnContraste() {
    if (solapaEnContraste.value == 1) {
        $(coloresDeSolapaEnContraste).show();
    }else if(ojalDeMangaEnContraste.value == 1){
        $(coloresDeSolapaEnContraste).show();
    }else if (solapaEnContraste.value == 1 || ojalDeMangaEnContraste.value == 1) {
        $(coloresDeSolapaEnContraste).show();
    } else {
        $(coloresDeSolapaEnContraste).hide();
    }
}
//Mostrar y ocultar campo para posición del ojal que va en contraste
function posicionOjalEnContraste(){
    if (ojalDeMangaEnContraste.value == 1) {
        $(divPosicionOjalesManga).show();
    }else{
        $(divPosicionOjalesManga).hide();   
    }
}

//Lógica para Bies & pinpoint
function coloresBies() {
    if (tipoAccesorio1.checked) {
        $(colorDeBiesPinpoint).show();
    } else {
        $(colorDeBiesPinpoint).hide();
    }
}
function coloresPinPoint() {
    if (tipoAccesorio2.checked ) {
        $(colorDeBiesPinpoint).show();
    } else {
        $(colorDeBiesPinpoint).hide();
    }
}
function coloresBiesPinpoint() {
    if (tipoAccesorio3.checked ) {
        $(colorDeBiesPinpoint).show();
    } else {
        $(colorDeBiesPinpoint).hide();
    }
}
// Mostrar y ocultar personalización de gancho
function mostrarOcultarPersonalizacionGancho() {
    if (selectTipoGancho.value == "2") {
        $(divPerGancho).show();
    } else {
        $(divPerGancho).hide();
    }
}

// Mostrar y ocultar personalización de portatrajes
function mostrarOcultarPersonalizacionPortatraje() {
    if (selectTipoPortatrajes.value == "2") {
        $(divPerPortatraje).show();
    } else {
        $(divPerPortatraje).hide();
    }
}
function mostrarOcultarPersonalizacionSaco() {
    if (selectTipoHolguraSaco.value == "1") {
        $(divPerSaco).show();
    } else {
        $(divPerSaco).hide();
    }
}
function fraccionBrazoIzquierdo(){
    if( expresionRegularFracciones.test(largoBrazoIzquierdo.value) == false){
        alert("Debe insertar una fracción"); 
    }
}
function fraccionBrazoDerecho(){    
    if( expresionRegularFracciones.test(largoBrazoDerecho.value) == false){
        alert("Debe insertar una fracción"); 
    }
}
function fraccionChaleco(){    
    if( expresionRegularFracciones.test(largoChaleco.value) == false){
        alert("Debe insertar una fracción"); 
    }
}
function fraccionEspaldaSaco(){    
    if( expresionRegularFracciones.test(largoEspaldaSaco.value) == false){
        alert("Debe insertar una fracción"); 
    }
}
/**
 * Helper Functions para cotización de productos.
 */

//Función para agregar eventos 
function agregarEventos() {
    console.log('Declarando eventos dentro de la funcion');

    largoBrazoIzquierdo.addEventListener('change', function () {
        fraccionBrazoIzquierdo();
    });
    largoBrazoDerecho.addEventListener('change', function () {
        fraccionBrazoDerecho();
    });
    largoChaleco.addEventListener('change', function () {
        fraccionChaleco();
    });
    largoEspaldaSaco.addEventListener('change', function () {
        fraccionEspaldaSaco();
    });
    tipoAccesorio1.addEventListener('click', function () {
        coloresBies();
    });
    tipoAccesorio2.addEventListener('click', function () {
        coloresPinPoint();
    });
    tipoAccesorio3.addEventListener('click', function () {
        coloresBiesPinpoint();
    });
    solapaEnContraste.addEventListener('click', function () {
        coloresSolapaEnContraste();
    });
    ojalDeMangaEnContraste.addEventListener('click', function () {
        coloresSolapaEnContraste();
    });
    solapaEnContraste.addEventListener('click',function(){
        mostrarOcultarOjalesActivosSolapa();
    });
    ojalDeMangaEnContraste.addEventListener('click',function(){
        posicionOjalEnContraste();
    });

    checkEtiquetaMarca.addEventListener('click', function () {
        mostrarOcultarOtraMarca();
    });

    checkEtiquetaTela.addEventListener('click', function () {
        mostrarOcultarOtraMarcaTela();
    });

    selectTipoGancho.addEventListener('change', function () {
        mostrarOcultarPersonalizacionGancho();
    });

    selectTipoPortatrajes.addEventListener('change', function () {
        mostrarOcultarPersonalizacionPortatraje();
    });
    selectTipoHolguraSaco.addEventListener('change', function () {
        mostrarOcultarPersonalizacionSaco();
    });

    checkForroChaleco.addEventListener('click', function () {
        mostrarOcultarOtroForroChaleco();
    });

    checkOjalesActivosManga.addEventListener('click', function () {
        mostrarOcultarOjalesActivosManga();
    });
    checkBotonesDeCliente.addEventListener('click', function () {
        mostrarOcultarCantidadBotones();
    });

    console.log('Finalización de Declaración de Eventos en función:)');
}

//Agregar eventos y ocultar componentes al cargar la página
$(document).ready(function () {
    console.log('Ocultando componentes... ');
    iniciarComponentes();
    console.log('Agregando eventos...');
    agregarEventos();
    console.log('Listo!');
});

/***/ }),
/* 9 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 10 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);