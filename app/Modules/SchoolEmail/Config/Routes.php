<?php

namespace Modules\SchoolEmail\Config;
$routes = Services::routes();
$routes->group("school-emails", ["namespace" => "\Modules\SchoolEmail\Controllers"], function ($routes) {
	$routes->get("/", "SchoolEmails::index");
});