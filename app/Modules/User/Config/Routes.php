<?php

namespace Modules\User\Config;

$routes = Services::routes();

$routes->group("users", ["namespace" => "\Modules\User\Controllers"], function ($routes) {

	$routes->get("/", "Users::index");
	$routes->get("add", "Users::add");
	$routes->post("add", "Users::add");
	$routes->get("edit/(:hash)", "Users::edit/$1");
	$routes->post("edit/(:hash)", "Users::edit/$1");
	$routes->get("view/(:hash)", "Users::view/$1");
	$routes->get("delete/(:segment)", "Users::delete/$1");
  	$routes->get("getusers/(:hash)", "Users::getusers/$1",["filter" => "myauth"]);
  	$routes->get("getschooldestination/(:hash)", "Users::getschooldestination/$1",["filter" => "myauth"]);
  	$routes->get("getuserdistricts/(:hash)", "Users::getuserdistricts/$1",["filter" => "myauth"]);
	$routes->get("getalldistricts", "Users::getalldistricts",["filter" => "myauth"]);
	$routes->get("listingAjax", "Users::listingAjax");

	$routes->get("ajaxDatatables", "Users::ajaxDatatables");
	$routes->post("ajaxDatatables", "Users::ajaxDatatables");

	$routes->get("groups", "Groups::index");
	$routes->post("update_status", "Users::update_status",["filter" => "myauth"]);

	$routes->get("dashboard", "Users::dashboard");
	$routes->post("check_email_exist", "Users::check_email_exist",["filter" => "myauth"]);




});