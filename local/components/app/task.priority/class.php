<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/* Component */
class Task extends CBitrixComponent
{
	private $templatePage = "";
	private $errors = [];

	/* Get Tasks */
	private function getTasks()
	{
		/* Get tasks */
		$result = \Bitrix\Tasks\TaskTable::getList([
			"filter" => [
				"!STATUS" => [5,6,7]
			],
			"order" => [
				"UF_PRIORITY" => "DESC"
			],
			"select" => [
				"ID",
				"TITLE",
				"START_DATE_PLAN",
				"END_DATE_PLAN",
				"STATUS",
				"RESPONSIBLE_ID",
				"CREATED_BY",
				"UF_PRIORITY"
			],
			"limit" => 10
		]);
		
		/* Process */
		while ($row = $result->fetch()) {
			$row["START_DATE_PLAN"] = implode(" ", explode(" ", $row["START_DATE_PLAN"]));
			$row["END_DATE_PLAN"] = implode(" ", explode(" ", $row["END_DATE_PLAN"]));
			$row["RESPONSIBLE_NAME"] = CUser::getById($row["RESPONSIBLE_ID"])->fetch()["NAME"];
			$row["CREATED_BY_NAME"] = CUser::getById($row["CREATED_BY"])->fetch()["NAME"];
			$tasks[] = $row;
		}

		/* Return */
		return $tasks;
	}

	/* Get task priority history */
	private function getTaskPriorityHistory() {

		require($_SERVER["DOCUMENT_ROOT"]."/local/models/TaskPriorityHistoryTable.php");

		$result = TaskPriorityHistoryTable::getList([
			"order" => ["UF_DATE_CREATE" => "DESC"],
			"limit" => 10,
		]);

		while($row = $result->fetch()) {
		    $row["UF_DATE_CREATE"] = implode(" ", explode(" ", $row["UF_DATE_CREATE"]));
		    $row["TITLE"] = CTasks::getById($row["UF_TASK_ID"])->fetch()["TITLE"];
		    $row["NAME"] = CUser::getById($row["UF_USER_ID"])->fetch()["NAME"];
			$history[] = $row;
		}

		return $history;
	}

	/* Execute component */
	public function executeComponent()
	{
		global $USER;

		$this->arResult["tasks"] = $this->getTasks();
		$this->arResult["history"] = $this->getTaskPriorityHistory();
		$this->arResult["userId"] = $USER->GetID();

		$this->arResult["ERRORS"] = array_merge($this->errors, $this->arResult["ERRORS"]);

		$this->IncludeComponentTemplate($this->templatePage);
	}

}