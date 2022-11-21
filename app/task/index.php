<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

	$APPLICATION->SetTitle("Задачи по приоритету");
	$APPLICATION->SetAdditionalCSS("/local/style/style.css");
	$APPLICATION->IncludeComponent("app:task.priority", ".default", Array(), false);

	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");