<?php
namespace Modules\SchoolDistrict\Config;
$routes = Services::routes();

$routes->group("districts", ["namespace" => "\Modules\SchoolDistrict\Controllers"], function ($routes) {
	$routes->get("/", "SchoolDistricts::index");
	$routes->get("add", "SchoolDistricts::add");
	$routes->post("add", "SchoolDistricts::add");
	$routes->get("edit/(:hash)", "SchoolDistricts::edit/$1");
	$routes->post("edit/(:hash)", "SchoolDistricts::edit/$1");
	$routes->get("delete/(:hash)", "SchoolDistricts::delete/$1");
	$routes->get("getListData", "SchoolDistricts::getListData");
    $routes->post("getCityData", "SchoolDistricts::getCityData");
    $routes->post("listofDistrict", "SchoolDistricts::listofDistrict");
    $routes->get("view/(:hash)", "SchoolDistricts::view/$1");
    $routes->post("update_status", "SchoolDistricts::update_status");
    $routes->post("check_destrict_code_exist", "SchoolDistricts::check_destrict_code_exist");
    $routes->post("check_destrict_code_exist_on_edit", "SchoolDistricts::check_destrict_code_exist_on_edit"); 
});