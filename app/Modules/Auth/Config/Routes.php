<?php

namespace Modules\User\Config;

$routes = Services::routes();

$routes->group("/", ["namespace" => "\Modules\Auth\Controllers"], function ($routes) {

	$routes->post('/login', 'Auth::login');
	$routes->get('/login', 'Auth::login');
	
	$routes->get('/forgot-password', 'Auth::forgot_password');
	$routes->post('/forgot-password', 'Auth::forgot_password');

	$routes->get('/reset-password/(:any)', 'Auth::reset_password/$1');
	$routes->post('/reset-password/(:any)', 'Auth::reset_password/$1');

	$routes->get('/signup-password/(:any)', 'Auth::signup_password/$1');
	$routes->post('/signup-password/(:any)', 'Auth::signup_password/$1');

	$routes->get('/change-password', 'Auth::change_password');
	$routes->post('/change-password', 'Auth::change_password');

	$routes->get('/edit-profile', 'Auth::edit_profile');
	$routes->post('/edit-profile', 'Auth::edit_profile');

	$routes->get('/logout', 'Auth::logout');

});

