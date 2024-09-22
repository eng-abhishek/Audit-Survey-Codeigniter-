<?php
namespace Modules\BusRoute\Config;
$routes = Services::routes();
$routes->group("bus-routes", ["namespace" => "\Modules\BusRoute\Controllers"], function ($routes) {
	$routes->get("/", "BusRoutes::index");
	$routes->post("listofRoute/", "BusRoutes::listofRoute");
	$routes->get("add", "BusRoutes::add");
	$routes->post("add", "BusRoutes::add");
	$routes->get("edit/(:hash)", "BusRoutes::edit/$1");
	$routes->post("edit/(:hash)", "BusRoutes::edit/$1");
	$routes->get("delete/(:hash)", "BusRoutes::delete/$1");
	$routes->get("export", "BusRoutes::export");
	$routes->post("get-user-detail-for-busRoute", "BusRoutes::getUserForBusRoute");
    $routes->get("getListData", "BusRoutes::getListData");
    $routes->post("importFile", "BusRoutes::importFile");
    $routes->get("exportStudentData", "BusRoutes::exportStudentData");
    $routes->get("exportTemplate", "BusRoutes::exportTemplate");
    $routes->get("view-student/(:hash)", "BusRoutes::viewStudent/$1");
    $routes->post("assigin-bus-route-to-student", "BusRoutes::assiginBusRouteToStudent");
    $routes->post("remove-assigin-bus-route-to-student", "BusRoutes::removeAssiginBusRouteToStudent");
    $routes->post("update_status", "BusRoutes::update_status");
    $routes->get("view/(:hash)", "BusRoutes::details/$1");

    $routes->get("company/(:hash)", "BusRoutes::index/$1");

});