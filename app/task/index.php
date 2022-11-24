<?
	$include = include_once($_SERVER["DOCUMENT_ROOT"] . "/local/include.php");
	require($_SERVER["DOCUMENT_ROOT"] . $include["header"]);
	global $APPLICATION;

	if($include["browser"]) {
		$APPLICATION->SetTitle("Задачи по приоритету");
		$APPLICATION->SetAdditionalCSS("/local/style/style.css");
	}

	$APPLICATION->IncludeComponent("app:task.priority", ".default", []);

	require($_SERVER["DOCUMENT_ROOT"] . $include["footer"]);
