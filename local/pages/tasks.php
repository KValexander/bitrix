<?	if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

	$APPLICATION->SetTitle("Задачи по приоритету");
	$APPLICATION->SetAdditionalCSS("/local/style/style.css");
	$APPLICATION->IncludeComponent("task:task.priority", ".default", Array(), false);

	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");