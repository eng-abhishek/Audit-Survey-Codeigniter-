<?php

namespace Modules\Cron\Config;

$routes = Services::routes();

$routes->group("cron-job", ["namespace" => "\Modules\Cron\Controllers"], function ($routes) {

	$routes->get("oac-invite-email", "Cron::oacInviteEmailCron");

	
	
});

