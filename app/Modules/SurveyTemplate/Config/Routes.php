<?php
namespace Modules\SurveyTemplate\Config;

$routes = Services::routes();

$routes->group("surveytemplate", ["namespace" => "\Modules\SurveyTemplate\Controllers"], function ($routes) {
	$routes->get("/", "SurveyTemplate::index");
	$routes->get("add", "SurveyTemplate::add");
	$routes->post("add", "SurveyTemplate::add");
	$routes->get("edit/(:hash)", "SurveyTemplate::edit/$1");
	$routes->post("edit/(:hash)", "SurveyTemplate::edit/$1");
	$routes->get("view/(:hash)", "SurveyTemplate::view/$1");
	$routes->get("delete/(:hash)", "SurveyTemplate::delete/$1");
	$routes->get("ajaxDatatables", "SurveyTemplate::ajaxDatatables");
	$routes->post("checktemplatename", "SurveyTemplate::checktemplatename");

  	$routes->get("other-method", "SurveyTemplate::otherMethod");
});


?>