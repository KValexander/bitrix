<?php
	$include = [];

	$include["browser"] = (!$_SERVER['HTTP_BX_AJAX']);
	if($_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest") {
		$include["browser"] = false;
	}

	if(!$include["browser"]) {
		define('STOP_STATISTICS',    true);
		define('NO_AGENT_CHECK',     true);
		define('PUBLIC_AJAX_MODE', true);
		define('DisableEventsCheck', true);
	}

	$include["header"] = ($include["browser"]) ? "/bitrix/header.php" : "/bitrix/modules/main/include/prolog_before.php";
	$include["footer"] = ($include["browser"]) ? "/bitrix/footer.php" : "/bitrix/modules/main/include/epilog_after.php";

	return $include;