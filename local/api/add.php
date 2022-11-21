<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

	require($_SERVER["DOCUMENT_ROOT"]."/local/models/TaskPriorityHistoryTable.php");

	$result = TaskPriorityHistoryTable::add([
		"UF_TASK_ID" => $_POST["TASK_ID"],
		"UF_USER_ID" => $_POST["USER_ID"],
		"UF_OLD_PRIORITY" => $_POST["OLD"],
		"UF_NEW_PRIORITY" => $_POST["NEW"],
		"UF_DATE_CREATE" => Bitrix\Main\Type\Datetime::createFromTimestamp(time())
	]);

	echo ($result->isSuccess()) ? "true" : "false";