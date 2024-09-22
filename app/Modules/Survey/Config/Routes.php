<?php
namespace Modules\Survey\Config;

$routes = Services::routes();

$routes->group("survey", ["namespace" => "\Modules\Survey\Controllers"], function ($routes) {
	$routes->get("/", "Survey::index");
	$routes->get("add", "Survey::add");
	$routes->post("add", "Survey::add");

	$routes->get("edit/(:hash)", "Survey::edit/$1");
	$routes->post("edit/(:hash)", "Survey::edit/$1");

	$routes->get("ajaxDatatables", "Survey::ajaxDatatables");
	$routes->get("view/(:hash)", "Survey::view/$1");

});


?>