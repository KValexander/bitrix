<?php 
	Bitrix\Main\Loader::includeModule("highloadblock");

	$resData = \Bitrix\Highloadblock\HighloadBlockTable::getList();
	while ($hlblock = $resData->fetch()) {
		\Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
	}