<?php

namespace Modules\RegionalAuthority\Config;

$routes = Services::routes();

$routes->group("regional-authorities", ["namespace" => "\Modules\RegionalAuthority\Controllers"], function ($routes) {

	$routes->get("/", "RegionalAuthorities::index");
	$routes->get("add", "RegionalAuthorities::add");
	$routes->post("add", "RegionalAuthorities::add");
	$routes->get("edit/(:hash)", "RegionalAuthorities::edit/$1");
	$routes->post("edit/(:hash)", "RegionalAuthorities::edit/$1");
	$routes->delete("delete/(:segment)", "RegionalAuthorities::delete");

});