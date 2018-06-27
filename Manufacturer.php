<?php

require_once( 'pdo.db.php' );

class Manufacturer{

	private $table = "mnufcrr";

	public function __construct()
	{
	}
	
	public function get_all_men()
	{
 		$obj = new Db();
		
		$data['mnufcrr_name'] = $mnufcrr_name;
		$id = $obj->AddNewRow($this->table, $data);
		
		return $id;
	}
	
	public function add($mnufcrr_name)
	{
 		$obj = new Db();
		
		$data['mnufcrr_name'] = $mnufcrr_name;
		$id = $obj->AddNewRow($this->table, $data);
		
		return $id;
	}
}



// echo "Added manufacturer";

?>