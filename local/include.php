<?php
	$include = [];

	$include["browser"] = (!$_SERVER['HTTP_BX_AJAX']);

	$include["header"] = ($include["browser"]) ? "/bitrix/header.php" : "/bitrix/modules/main/include/prolog_before.php";
	$include["footer"] = ($include["browser"]) ? "/bitrix/footer.php" : "/bitrix/modules/main/include/epilog_after.php";

	return $include;