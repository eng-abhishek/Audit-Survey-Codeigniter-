<?php

namespace Modules\Test\Config;

$routes = Services::routes();

$routes->group("Test", ["namespace" => "\Modules\Test\Controllers"], function ($routes) {

	$routes->get("/", "Test::index");
	$routes->get("add", "Test::add");
	$routes->post("add", "Test::add");
	$routes->get("edit/(:hash)", "Test::edit/$1");
	$routes->post("edit/(:hash)", "Test::edit/$1");
	$routes->get("delete/(:hash)", "Test::delete/$1");
	$routes->get("getListData", "Test::getListData");

});