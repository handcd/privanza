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
