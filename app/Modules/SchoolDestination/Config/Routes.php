<?php

namespace Modules\SchoolDestination\Config;
$routes = Services::routes();

$routes->group("school-destination", ["namespace" => "\Modules\SchoolDestination\Controllers"], function ($routes) {

	$routes->get("/", "SchoolDestinations::index");
	$routes->get("add", "SchoolDestinations::add");
	$routes->post("add", "SchoolDestinations::add");
	$routes->get("edit/(:hash)", "SchoolDestinations::edit/$1");
	$routes->post("edit/(:hash)", "SchoolDestinations::edit/$1");
	$routes->get("delete/(:hash)", "SchoolDestinations::delete/$1");
	$routes->get("view/(:hash)", "SchoolDestinations::view/$1");
	$routes->post("update_status", "SchoolDestinations::update_status");
	$routes->get("getListData", "SchoolDestinations::getListData");
	$routes->get("ajaxDatatables", "SchoolDestinations::ajaxDatatables");
    $routes->post("getCityData", "SchoolDestinations::getCityData");
    $routes->post("listofDestination", "SchoolDestinations::listofDestination");
    
});