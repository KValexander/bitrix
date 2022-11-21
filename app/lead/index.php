<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

	$APPLICATION->SetTitle("Последние лиды");
	$APPLICATION->SetAdditionalCSS("/local/style/style.css");
	$APPLICATION->IncludeComponent("app:lead.latest", ".default", Array(), false);
	
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");