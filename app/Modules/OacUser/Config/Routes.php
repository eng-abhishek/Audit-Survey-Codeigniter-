<?php

namespace Modules\OacUser\Config;
$routes = Services::routes();
$routes->group("oac-invites", ["namespace" => "\Modules\OacUser\Controllers"], function ($routes) {
	$routes->get("/", "OacUsers::index");
	$routes->post("invite", "OacUsers::invite");

	$routes->get("list-approvals", "OacUsers::listApprovals");
	$routes->get("ajaxDatatables", "OacUsers::ajaxDatatables");

	$routes->get("view/(:hash)", "OacUsers::view/$1");
	$routes->post("approve-user/(:hash)", "OacUsers::approveUser/$1");


	$routes->get("user-register/(:hash)", "OacUserRegister::inviteRegister/$1");
	$routes->post("user-register/(:hash)", "OacUserRegister::inviteRegister/$1");

	$routes->get("register-success", "OacUserRegister::registrationSuccess");

	
	$routes->post("check_email_exist", "OacUserRegister::check_email_exist");
	$routes->post("reject", "OacUsers::rejectOAC",["filter" => "myauth"]);
	$routes->post("approve", "OacUsers::approveOAC",["filter" => "myauth"]);

});	
