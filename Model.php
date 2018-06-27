<?php

require_once( 'pdo.db.php' );

class Model{

	private $table = "model";

	public function __construct()
	{	
	}
		
	public function add($mnufcrr_name)
	{
		$modadd_mnufcrr = @$_POST['modadd_mnufcrr'];
		$modadd_name = @$_POST['modadd_name'];
		$modadd_color = @$_POST['modadd_color'];
		$modadd_myear = @$_POST['modadd_myear'];
		$modadd_rnum = @$_POST['modadd_rnum'];
		$modadd_note = @$_POST['modadd_note'];
		$modimg = @$_POST['modimg'];
				
		// var_dump( $modimg );exit;		
		
		$modimg = ( !empty( $modimg ) ) ? implode(",", $modimg) : "" ;
				
 		$obj = new Db();
		
		$data['model_mnufcrr'] = $modadd_mnufcrr;
		$data['model_name'] = $modadd_name;
		$data['model_color'] = $modadd_color;
		$data['model_myear'] = $modadd_myear;
		$data['model_rnum'] = $modadd_rnum;
		$data['model_note'] = $modadd_note;
		$data['model_img'] = $modimg;
		$id = $obj->AddNewRow($this->table, $data);
		
		return $id;
	}
	
	public function sold($model_ID)
	{
 		$obj = new Db();
		
		$data['model_sold'] = "Y";
		$key['model_ID'] = $model_ID;
		$id = $obj->UpdateRow($this->table, $data, $key);
		
		return $id;
	}
	
}



// echo "Added manufacturer";

?>