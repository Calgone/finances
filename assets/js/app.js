/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

// create global $ and jQuery variables, making them accessible inside templates
// https://symfony.com/doc/current/frontend/encore/legacy-applications.html
global.$ = global.jQuery = $;

const formatter = new Intl.NumberFormat('fr-FR', {
    style: 'currency',
    currency: 'EUR',
});
global.formatter = formatter;

require('bootstrap');

//console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

import greet from './greet';

// $(document).ready(function () {
//     $('body').prepend('<h1>' + greet('Greg') + '</h1>');
// });

const byId = function( id ) { return document.getElementById(id);};
global.byId = byId;