<?php

/* Use route configurator */
use Bitrix\Main\Routing\RoutingConfigurator;

/* Use public page controller */
use Bitrix\Main\Routing\Controllers\PublicPageController;

/* Routes */
return function (RoutingConfigurator $routes) {
	
	/* Latest leads */
	$routes->get("/leads/latest", new PublicPageController("/local/pages/leads.php"));

	/* Task priority */
	$routes->get("/tasks/priority", new PublicPageController("/local/pages/tasks.php"));

};
