<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/* Component */
class Lead extends CBitrixComponent
{
	private $templatePage = "";
	private $errors = [];

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
		return $leads;
	}

	/* Execute component */
	public function executeComponent()
	{
		$this->arResult["leads"] = $this->getLeads();

		$this->arResult["ERRORS"] = array_merge($this->errors, $this->arResult["ERRORS"]);

		$this->IncludeComponentTemplate($this->templatePage);
	}

}