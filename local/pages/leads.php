<?	if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

	$APPLICATION->SetTitle("Последние лиды");
	$APPLICATION->SetAdditionalCSS("/local/style/style.css");
	$APPLICATION->IncludeComponent("lead:latest.leads", ".default", Array(), false);
	
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");