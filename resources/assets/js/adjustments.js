/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

const endpoint = '/validador/allclients';

axios.get(endpoint)
	.then(function(response) {
		console.log(response);
	})
	.catch(function (error) {
		console.log(error);
	});
