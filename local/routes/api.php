<?php

/* Use route configurator */
use Bitrix\Main\Routing\RoutingConfigurator;

/* Use controller */
use Bitrix\Main\Routing\Controllers\PublicPageController;

/* Routes */
return function (RoutingConfigurator $routes) {

	/* Add task priority history */
	$routes->post("/task.priority.history.add", new PublicPageController('/local/api/add.php'));
	
	/* Get task priority history */
	$routes->get("/task.priority.history.get", new PublicPageController("/local/api/get.php"));

};