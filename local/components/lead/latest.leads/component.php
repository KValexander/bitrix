<?	if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

	// /* LEAD TABLE NOT FOUND */
	// class Lead extends \Bitrix\Main\ORM\Data\DataManager {

	// 	public static function getTableName() {

	// 		return "b_crm_lead";

	// 	}

	// }

	// var_dump(Lead::getList([
	// 	"select" => [
	// 		"TITLE",
	// 		"DATE_CREATE",
	// 		"ASSIGNED_BY_NAME",
	// 		"SOURCE_ID",
	// 		"STATUS_ID",
	// 		"UF_CHECK"
	// 	],
	// 	"order" => ["DATE_CREATE" => "DESC"],
	// 	"limit" => 10
	// ]));


	/* Rest */
	/* А всё, просто false */
	// $method = "crm.lead.list";
	// $domain = "185.207.2.10";
	// $params = [
	// 	"auth" => $_REQUEST["AUTH_ID"],
	// 	"select" => ["TITLE", "DATE_CREATE"]
	// ];

	// $url = "http://". $domain ."/rest/". $method .".json";
	// $data = http_build_query($params);

	// $result = file_get_contents($url, false, stream_context_create([
	// 	"http" => [
	// 		"method" => "POST",
	// 		"header" => "Content-Type: application/x-www-form-urlencoded",
	// 		"content" => $data
	// 	]
	// ]));

	// var_dump($_REQUEST);
	// var_dump($result);
	// var_dump($data);


	/* ORM */
	/* GetList с документации работает некорректно, только GetListEx с несколькими аргументами */
	// $group = CGroup::GetList("ID", "sort", ["ID"=>"1"]);
	// var_dump($group);
	// var_dump(CCRMLead::GetById(1)["UF_CHECK"]);
	// var_dump(CUser::GetById(1)->Fetch());

	// $result = CCrmLead::GetList([
	// 	'select' => Array(
	// 		'TITLE',
	// 		'DATE_CREATE',
	// 		'ASSIGNED_BY_NAME',
	// 		'SOURCE_ID',
	// 		'STATUS_ID',
	// 		'UF_CHECK'
	// 	),
	// 	'order' => Array('DATE_CREATE' => 'DESC'),
	// 	'limit' => 10,
	// 	'filter' => ['=ID' => 1]
	// ]);

	// $result = CCrmLead::GetEntity();
	// $result->setSelect(array(
	// 		"TITLE",
	// 		"DATE_CREATE",
	// 		"ASSIGNED_BY_NAME",
	// 		"SOURCE_ID",
	// 		"STATUS_ID",
	// 		"UF_CHECK"
	// 	));


	// echo "<pre>";
	// var_dump($result);

	// var_dump(CCRMStatus::getList([
	// 			"select" => ["NAME"],
	// 			"filter" => [
	// 				"=ENTITY_ID" => "SOURCE",
	// 				"=STATUS_ID" => "PARTNER"
	// 			]
	// 		])->fetch());

	// $re = CCRMStatus::getList();
	// while($r = $re->fetch()) {
	// 	var_dump($r);
	// }
	// var_dump(CCRMStatus::getList()->fetch());
	// echo "</pre>";

	/* GetListEx */
	$result = CCrmLead::GetListEx(
		array('DATE_CREATE' => 'DESC'), // order
		array(), // filter
		false, // idk
		array('nTopCount' => 10), // limit
		Array( // select
			'ID',
			'TITLE',
			'DATE_CREATE',
			'ASSIGNED_BY_NAME',
			'SOURCE_ID',
			'STATUS_ID',
			'UF_CHECK'
		));

	$source = CCRMStatus::getStatusListEx("SOURCE");
	$status = CCRMStatus::getStatusListEx("STATUS");
	while($row = $result->fetch()) {
		$row["SOURCE_BY_NAME"] = $source[$row["SOURCE_ID"]];
		$row["STATUS_BY_NAME"] = $status[$row["STATUS_ID"]];
		$arResult[] = $row;
	}


	/* SQL */
	/* Не знаю как получить пользовательские поля */
	// $connection = Bitrix\Main\Application::getConnection();
	// $sqlHelper = $connection->getSqlHelper();

	// $sql = "
	// 	SELECT  `l`.`TITLE`,
	// 			`l`.`DATE_CREATE`,
	// 			-- (SELECT `u`.`NAME` FROM `b_user` as `u` WHERE `l`.`ASSIGNED_BY_ID`=`u`.`ID`) as `ASSIGNED`,
	// 			-- (SELECT `s`.`NAME` FROM `b_crm_status` as `s` WHERE `l`.`STATUS_ID`=`s`.`STATUS_ID` AND `s`.`ENTITY_ID`='STATUS') as `STATUS`,
	// 			-- (SELECT `s`.`NAME` FROM `b_crm_status` as `s` WHERE `l`.`SOURCE_ID`=`s`.`STATUS_ID` AND `s`.`ENTITY_ID`='SOURCE') as `SOURCE`
	// 			`u`.`NAME` as `ASSIGNED`,
	// 			`s`.`NAME` as `STATUS`,
	// 			`s2`.`NAME` as `SOURCE`
		
	// 	FROM `b_crm_lead` as `l`
	// 	INNER JOIN `b_user` as `u` ON `l`.`ASSIGNED_BY_ID`=`u`.`ID`
	// 	INNER JOIN `b_crm_status` as `s` ON `l`.`STATUS_ID`=`s`.`STATUS_ID` AND  `s`.`ENTITY_ID`='STATUS'
	// 	INNER JOIN `b_crm_status` as `s2` ON `l`.`SOURCE_ID`=`s2`.`STATUS_ID` AND  `s2`.`ENTITY_ID`='SOURCE'

	// 	ORDER BY `l`.`DATE_CREATE` DESC LIMIT 10
		
	// ";

	// $recordset = $connection->query($sql);
	// while ($record = $recordset->fetch()) {
	// 	$record["DATE_CREATE"] = implode(" ", explode(" ", $record["DATE_CREATE"]));
	// 	$arResult[] = $record;
	// }

	$this->IncludeComponentTemplate();

?>