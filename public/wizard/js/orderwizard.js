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

//Variables para obtener elementos input
//var biesInterno = document.getElementById('BiesInterno');
//var pinPointInterno = document.getElementById('PinPointInterno');
//var biesPinPointInterno = document.getElementById('biesPinPointInterno');
var tipoAccesorio1 = document.getElementById('tipoAccesorio1');
var tipoAccesorio2 = document.getElementById('tipoAccesorio2');
var tipoAccesorio3 = document.getElementById('tipoAccesorio3');
var solapaEnContraste = document.getElementById('ojalEnSolapa');
var ojalDeMangaEnContraste = document.getElementById('tipoDeOjalEnManga');


//Variables para obtener paletas de colores y ocultar componentes
var coloresDeSolapaEnContraste = document.getElementById('solapaContraste');
var colorDeMangaEnContraste = document.getElementById('colorDeOjalEnMangas');
//var colorDeBies = document.getElementById('colorPaletteBies');
//var colorDePinpoint = document.getElementById('colorPalettePinpoint');
var colorDeBiesPinpoint = document.getElementById('colorPaletteBiesPinpoint');

// Elementos Ocultos
var divMarcaEtiqueta = document.getElementById('marcaEtiqueta');
var divPerGancho = document.getElementById('personalizacionGancho');
var divPerPortatraje = document.getElementById('personalizacionPortatrajes');
var divForroChaleco = document.getElementById('otroForroChaleco');
var divOjalesActivosManga = document.getElementById('divOjalesActivosManga');
var divOjalesActivosSolapa = document.getElementById('divOjalesActivosSolapa');
var divCantidadDeBotones = document.getElementById('cantidadBotones');

// Elementos que contienen la lógica de hide/show
var checkEtiquetaMarca = document.getElementById('checkEtiquetaMarca');
var selectTipoGancho = document.getElementById('tipoGancho');
var selectTipoPortatrajes = document.getElementById('tipoPortatrajes');
var checkForroChaleco = document.getElementById('tipoForroChaleco');
var checkOjalesActivosManga = document.getElementById('ojalesActivosManga');
var checkBotonesDeCliente = document.getElementById('botonesCliente');
//var tipoOjalEnSolapa = document.getElementById('ojalEnSolapa');

//Funcion para oocultar componentes
function iniciarComponentes() {
    $(colorDeMangaEnContraste).hide();
    $(coloresDeSolapaEnContraste).hide();

    $(colorDeBiesPinpoint).hide();
    //$(colorDeBies).hide();
    //$(colorDePinpoint).hide();
    $(divCantidadDeBotones).hide();
    $(divMarcaEtiqueta).hide();
    $(divPerGancho).hide();
    $(divPerPortatraje).hide();
    $(divOjalesActivosManga).hide();
    $(divOjalesActivosSolapa).hide();
}

/**
 * Funciones para lógica de control de elementos, cada una es específica
 * a lo que se defina en el Business Logic.
 */
//Mostrar el campo para ingresar el número de botones, sólo si los entrega el cliente
function mostrarOcultarCantidadBotones(){
    if (checkBotonesDeCliente.checked) {
        $(divCantidadDeBotones).show();
    }else{
        $(divCantidadDeBotones).hide();
    }

}
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
    if (solapaEnContraste.value == 2) {
        $(coloresDeSolapaEnContraste).show();
    }else if(ojalDeMangaEnContraste.value == 1){
        $(coloresDeSolapaEnContraste).show();
    }else if (solapaEnContraste.value == 2 || ojalDeMangaEnContraste.value == 1) {
        $(coloresDeSolapaEnContraste).show();
    } else {
        $(coloresDeSolapaEnContraste).hide();
    }
}

//Mostrar y ocultar paleta de colores para ojal en contraste de manga
/*function coloresOjalEnManga() {
    if (ojalDeMangaEnContraste.value == 1) {
        $(coloresDeSolapaEnContraste).show();
    } else {
        $(coloresDeSolapaEnContraste).hide();
    }
}*/

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

/**
 * Helper Functions para cotización de productos.
 */

//Función para agregar eventos 
function agregarEventos() {
    console.log('Declarando eventos dentro de la funcion');
    tipoAccesorio1.addEventListener('click', function () {
        coloresBies();
    });
    tipoAccesorio2.addEventListener('click', function () {
        coloresPinPoint();
    });
    tipoAccesorio3.addEventListener('click', function () {
        coloresBiesPinpoint();
    });
    /*pinPointInterno.addEventListener('click', function () {
        coloresBiesPinpoint();
    });*/
    solapaEnContraste.addEventListener('click', function () {
        coloresSolapaEnContraste();
    });
    ojalDeMangaEnContraste.addEventListener('click', function () {
        coloresSolapaEnContraste();
    });
    solapaEnContraste.addEventListener('click',function(){
        mostrarOcultarOjalesActivosSolapa();
    });


    checkEtiquetaMarca.addEventListener('click', function () {
        mostrarOcultarOtraMarca();
    });

    selectTipoGancho.addEventListener('change', function () {
        mostrarOcultarPersonalizacionGancho();
    });

    selectTipoPortatrajes.addEventListener('change', function () {
        mostrarOcultarPersonalizacionPortatraje();
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