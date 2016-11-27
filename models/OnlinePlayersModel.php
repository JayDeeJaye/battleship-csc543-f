<?php
require_once('../models/Database.php');

class OnlinePlayer implements JsonSerializable
{
	public $userName;
	public $isAvailable;
	
	public function jsonSerialize() {
		$result = get_object_vars($this);
		return (object) $result;
	}
}
class OnlinePlayersModel
{
	private $dbConn;
	
	function __construct() {
		$this->dbConn = new Database();
	}

	function findAll () {
		$data = array();
		$sql = <<<SQL
			SELECT s.username
			FROM sessions s
SQL;
		$rows = $this->dbConn->get($sql);
		if (count($rows) > 0) {
			for ($i = 0; $i < count($rows); $i++) {
				$p = new OnlinePlayer();
				$p->userName = $rows[$i]['username'];
				$p->isAvailable = true;
				array_push($data, $p);
			}
		}
		return $data;
	}
	
}
