<?
	$include = include_once($_SERVER["DOCUMENT_ROOT"] . "/local/include.php");
	require($_SERVER["DOCUMENT_ROOT"] . $include["header"]);
	global $APPLICATION;

	if($include["browser"]) {
		$APPLICATION->SetTitle("Последние лиды");
		$APPLICATION->SetAdditionalCSS("/local/style/style.css");
	}

	$APPLICATION->IncludeComponent("app:lead.latest", ".default", []);

	require($_SERVER["DOCUMENT_ROOT"] . $include["footer"]);