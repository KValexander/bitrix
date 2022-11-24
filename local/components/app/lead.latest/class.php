<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/* Component */
class Lead extends CBitrixComponent
{
	private $templatePage = "";
	private $action = "";
	private $errors = [];

	/* Api */
	private $response = "";
	private $code = 0;

	/* Get leads */
	private function getLeads()
	{
		/* Get leads */
		$result = \Bitrix\Crm\LeadTable::getList([
			'select' => [
				'ID',
				'TITLE',
				'DATE_CREATE',
				'ASSIGNED_BY_ID',
				'SOURCE_ID',
				'STATUS_ID',
				'UF_CHECK'
			],
			'order' => Array('DATE_CREATE' => 'DESC'),
			'limit' => 10,
		]);

		/* Process */
		$source = CCRMStatus::getStatusListEx("SOURCE");
		$status = CCRMStatus::getStatusListEx("STATUS");
		while($row = $result->fetch()) {
			$row["DATE_CREATE"] = implode(" ", explode(" ", $row["DATE_CREATE"]));
			$row["SOURCE_BY_NAME"] = $source[$row["SOURCE_ID"]];
			$row["STATUS_BY_NAME"] = $status[$row["STATUS_ID"]];
			$row["ASSIGNED_BY_NAME"] = CUser::getById($row["ASSIGNED_BY_ID"])->fetch()["NAME"];
			$leads[] = $row;
		}

		/* Return */
		$this->code = 200; // for api
		return $leads;
	}

	/* Update lead */
	private function updateLead()
	{
		/* Update lead */
		$result = \Bitrix\Crm\LeadTable::update($_REQUEST["ID"],[
			"UF_CHECK" => $_REQUEST["UF_CHECK"]
		])->isSuccess();

		/* Return */
		$this->code = ($result) ? 200 : 400; // for api, idk right code
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

	/* Test */
	private function test()
	{
		$this->code = 200;
		return [
			"GET" => $_GET,
			"POST" => $_POST,
			"REQUEST" => $_REQUEST,
			"PARAMS" => $this->arParams,
			"SERVER" => $_SERVER,
			"CONTENTS" => file_get_contents('php://input'),
			"JSON" => json_decode(file_get_contents('php://input'), true),
		];
	}

	/* Browser */
	private function browser()
	{
		$this->arResult["leads"] = $this->getLeads();
		$this->arResult["action"] = $this->action;
		$this->arResult["ERRORS"] = array_merge($this->errors, $this->arResult["ERRORS"]);
		$this->IncludeComponentTemplate($this->templatePage);
	}

}