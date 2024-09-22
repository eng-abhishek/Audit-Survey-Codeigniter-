<?php

namespace Modules\BusCompany\Config;

$routes = Services::routes();

$routes->group("bus-companies", ["namespace" => "\Modules\BusCompany\Controllers"], function ($routes) {

	$routes->get("/", "BusCompanies::index",["filter" => "myauth"]);
	$routes->get("add", "BusCompanies::add",["filter" => "myauth"]);
	$routes->post("add", "BusCompanies::add",["filter" => "myauth"]);
	$routes->get("edit/(:hash)", "BusCompanies::edit/$1",["filter" => "myauth"]);
	$routes->post("edit/(:hash)", "BusCompanies::edit/$1",["filter" => "myauth"]);
	$routes->get("delete/(:hash)", "BusCompanies::delete/$1",["filter" => "myauth"]);
	$routes->get("view/(:hash)", "BusCompanies::view/$1",["filter" => "myauth"]);

	$routes->get("getcities/(:segment)", "BusCompanies::getcities/$1");
	$routes->post("ajaxDatatables", "BusCompanies::ajaxDatatables");
	$routes->post("check_mapping", "BusCompanies::checkMapping");

});