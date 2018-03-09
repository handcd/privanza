let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// Admin styles
mix.sass('resources/assets/sass/material-dashboard.scss','public/css/');

// Wizard Styles
mix.sass('resources/assets/sass_wizard/material-bootstrap-wizard.scss','public/wizard/css/');


// Datepicker

// Combinar los CSS en un datepicker.css
mix.styles([
	'resources/assets/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css'
],'public/css/datepicker.css');

// Combinar los JS en un datepicker.js
mix.scripts([
	'resources/assets/bower/moment/min/moment.min.js',
	'resources/assets/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
],'public/js/datepicker.js')
