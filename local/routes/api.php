<?php

/* Use route configurator */
use Bitrix\Main\Routing\RoutingConfigurator;

/* Routes */
return function (RoutingConfigurator $routes) {

	/* Add task priority history */
	$routes->post("/task.priority.history.add", function() {
		$connection = Bitrix\Main\Application::getConnection();

		$sql = sprintf(
			"INSERT INTO `b_task_priority_history`(
				`UF_TASK_ID`,
				`UF_OLD_PRIORITY`,
				`UF_NEW_PRIORITY`,
				`UF_DATE_CREATE`,
				`UF_USER_ID`
			) VALUES ('%s', '%s', '%s', CURRENT_TIMESTAMP(), '%s')",
			$_POST["ID"],
			$_POST["OLD"],
			$_POST["NEW"],
			$_POST["USER_ID"]
		);

		if(!$connection->query($sql)) {
			echo "false";
		}

		else {
			echo "true";	
		}
	});
	
	/* Get task priority history */
	$routes->get("/task.priority.history.get", function() {

		$connection = Bitrix\Main\Application::getConnection();
		$sql = "
			SELECT
				`t`.`TITLE`,
				`u`.`NAME`,
				`p`.`UF_OLD_PRIORITY`,
				`p`.`UF_NEW_PRIORITY`,
				`p`.`UF_DATE_CREATE`
			FROM `b_task_priority_history` as `p`
			INNER JOIN `b_tasks` as `t` ON `t`.`ID`=`p`.`UF_TASK_ID`
			INNER JOIN `b_user` as `u` ON `u`.`ID`=`p`.`UF_USER_ID`
			ORDER BY `p`.`UF_DATE_CREATE` DESC
			LIMIT 10
		";

		$result = $connection->query($sql);
		while ($row = $result->fetch()) {
			$row["UF_DATE_CREATE"] = implode(" ", explode(" ", $row["UF_DATE_CREATE"]));
			$res[] = $row;
		}

		echo json_encode($res);

	});

};