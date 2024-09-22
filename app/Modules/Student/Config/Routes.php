<?php
namespace Modules\Student\Config;

$routes = Services::routes();

$routes->group("student", ["namespace" => "\Modules\Student\Controllers"], function ($routes) {
	$routes->get("/", "Student::index");
	$routes->get("add", "Student::add");
	$routes->post("add", "Student::add");
	$routes->get("edit/(:hash)", "Student::edit/$1");
	$routes->post("edit/(:hash)", "Student::edit/$1");
	$routes->get("view/(:hash)", "Student::view/$1");
	$routes->get("delete/(:hash)", "Student::delete/$1");
	$routes->get("ajaxDatatables", "Student::ajaxDatatables");
	$routes->post("checktemplatename", "Student::checktemplatename");

  	$routes->get("other-method", "Student::otherMethod");
});


?>