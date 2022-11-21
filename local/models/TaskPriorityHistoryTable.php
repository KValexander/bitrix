<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\UserTable;

class TaskPriorityHistoryTable extends \Bitrix\Main\Entity\DataManager
{
    public static function getTableName()
    {
        return 'b_task_priority_history';
    }

    public static function getMap()
    {
    	return [
    		new \Bitrix\Main\Entity\IntegerField("ID", ["primary" => true]),
    		new \Bitrix\Main\Entity\IntegerField("UF_TASK_ID"),
    		new \Bitrix\Main\Entity\IntegerField("UF_USER_ID"),
    		new \Bitrix\Main\Entity\IntegerField("UF_OLD_PRIORITY"),
    		new \Bitrix\Main\Entity\IntegerField("UF_OLD_PRIORITY"),
    		new \Bitrix\Main\Entity\IntegerField("UF_NEW_PRIORITY"),
    		new \Bitrix\Main\Entity\DatetimeField("UF_DATE_CREATE"),
    	];
    }
}