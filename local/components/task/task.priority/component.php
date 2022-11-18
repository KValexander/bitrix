<?	if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
	
	/* Get tasks */
	$result = CTasks::getList(
		[	// order
			"UF_PRIORITY" => "DESC"
		],
		[	// filter
			"!STATUS" => [5,6,7]
		],
		[	// select
			"ID",
			"TITLE",
			"START_DATE_PLAN",
			"END_DATE_PLAN",
			"STATUS",
			"RESPONSIBLE_NAME",
			"RESPONSIBLE_LAST_NAME",
			"RESPONSIBLE_SECOND_NAME",
			"CREATED_BY_NAME",
			"CREATED_BY_LAST_NAME",
			"CREATED_BY_SECOND_NAME",
			"UF_PRIORITY"
		],
		[] // params
	);

	while($row = $result->fetch()) {
		$arResult["tasks"][] = $row;
	}

	/* Get highload block TaskPriorityHistory */
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
		$arResult["history"][] = $row;
	}

	$arResult["user_id"] = $USER->GetID();

	$this->IncludeComponentTemplate();

?>