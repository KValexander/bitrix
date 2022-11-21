<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
	
	require($_SERVER["DOCUMENT_ROOT"]."/local/models/TaskPriorityHistoryTable.php");

	$result = TaskPriorityHistoryTable::getList([
		"order" => ["UF_DATE_CREATE" => "DESC"],
		"limit" => 10,
	]);

	while($row = $result->fetch()) {
	    $row["UF_DATE_CREATE"] = implode(" ", explode(" ", $row["UF_DATE_CREATE"]));
		$res[] = $row;
	}

	echo json_encode($res);