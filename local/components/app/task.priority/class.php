<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/* Loader */
\Bitrix\Main\Loader::IncludeModule("tasks");

/* Component */
class Task extends CBitrixComponent
{
	private $templatePage = "";
	private $action = "";
	private $errors = [];

	/* Api */
	private $response = "";
	private $code = 0;

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
		$this->code = 200; // for api
		return $tasks;
	}

	/* Update task */
	private function updateTask()
	{
		/* Update Task */
		$result = \Bitrix\Tasks\TaskTable::update($_REQUEST["ID"],[
			"UF_PRIORITY" => $_REQUEST["UF_PRIORITY"]
		])->isSuccess();

		/* Return */
		$this->code = ($result) ? 200 : 400; // for api, idk right code
		return $result;
	}

	/* Get task priority history */
	private function getTaskPriorityHistory()
	{
		/* Get */
		$result = TaskPriorityHistoryTable::getList([
			"order" => ["UF_DATE_CREATE" => "DESC"],
			"limit" => 10,
		]);

		/* Process */
		while($row = $result->fetch()) {
			$row["UF_DATE_CREATE"] = implode(" ", explode(" ", $row["UF_DATE_CREATE"]));
			$row["TITLE"] = CTasks::getById($row["UF_TASK_ID"])->fetch()["TITLE"];
			$row["NAME"] = CUser::getById($row["UF_USER_ID"])->fetch()["NAME"];
			$history[] = $row;
		}

		/* Return */
		$this->code = 200; // for api
		return $history;
	}

	/* Add task priority history */
	private function addTaskPriorityHistory()
	{
		/* Add */
		$result = TaskPriorityHistoryTable::add([
			"UF_TASK_ID" => $_REQUEST["TASK_ID"],
			"UF_USER_ID" => $_REQUEST["USER_ID"],
			"UF_OLD_PRIORITY" => $_REQUEST["OLD"],
			"UF_NEW_PRIORITY" => $_REQUEST["NEW"],
			"UF_DATE_CREATE" => \Bitrix\Main\Type\Datetime::createFromTimestamp(time())
		])->isSuccess();

		/* Return */
		$this->code = ($result) ? 201 : 400; // for api, idk right code
		return $result;
	}

	/* Execute component */
	public function executeComponent()
	{
		$this->arResult = [];
		$this->action = (isset($_REQUEST["action"])) ? $_REQUEST["action"] : $this->arParams["action"];

		(!$_SERVER['HTTP_BX_AJAX']) ? $this->browser() : $this->api();
	}

	/* Api */
	private function api()
	{
		$this->response = "Method not found";
		$this->code = 404;

		$method = $this->action;
		if(method_exists($this, $method)) {
			$this->response = $this->$method();
		}

		Header("Content-Type: application/json;charset=utf-8");
		Header("HTTP/1.1 ". $this->code);
		echo json_encode($this->response);
	}

	/* Browser */
	private function browser()
	{
		global $USER;

		$this->arResult["tasks"] = $this->getTasks();
		$this->arResult["history"] = $this->getTaskPriorityHistory();
		$this->arResult["userId"] = $USER->GetID();

		$this->arResult["action"] = $this->action;
		$this->arResult["ERRORS"] = array_merge($this->errors, $this->arResult["ERRORS"]);

		$this->IncludeComponentTemplate($this->templatePage);
	}

}