<?php
set_time_limit (0);
date_default_timezone_set('Asia/Kolkata');

include "pdo.db.php";

$obj = new Db();
$dbh = $obj->connect();

$sql = "SELECT * FROM tbl_keywords";

/* PDO */
$stmt = $dbh->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();

foreach($result as $row){
    echo "{$row['keyword']}<br>\n";
}

#exit;

$data['datec'] = date("Y-m-d H:i:s");
$data['name'] = "Anil's Pande";
$data['age'] = 30;
//$data = array('datec' => date("Y-m-d H:i:s"),'name' => 'Anil','age' => 30);

$id = $obj->AddNewRow('employees', $data);

/*
	AddNewRow($table, $data) - add new record in single table
	UpdateRow($table, $data, $key) - single record based on certain criteria
	DeleteRow($table, $key) - single record based on certain criteria
	GetInfoRow($table, $key) - single record based on certain criteria
	query($key) - single query

	GetSelectedRows($table, $limit, $start, $columns = '', $orderby ='', $key ='', $search = '', $count = 1) //counting
	GetSelectedRows($table, $limit, $start, $columns = '', $orderby ='', $key ='', $search = '')
*/


/*
$STH0 = $obj->GetInfoRow('employees', array('e_id' => 31, 'age'=>30)); 
#print_r($STH0->fetch());exit;
print "deleted: " . $obj->DeleteRow('employees', array('e_id' => 29));
print "updated: " . $obj->UpdateRow('employees', array('name' => 'Shailendra'), array('e_id' => 28));//
*/

#print "updated: " . $obj->UpdateRow('employees', array('name' => 'Shailendra'), array('e_id' => 28));//
#print "updated: " . $obj->UpdateRow('employees', array('name' => 'Shailendra'), array('e_id IN(28)'));//
#print "updated: " . $obj->UpdateRow('employees', array('name' => 'Shailendra'), array());//
#print "deleted: " . $obj->DeleteRow('employees', array());
#$STH0 = $obj->GetInfoRow('employees', array('e_id IN(31)', 'age'=>30)); 

$join_ar = array(
				0 => array(
					"table" => "employees_dept c1",
					"condition" => "employees.e_id = c1.e_id",
					"type" => "INNER"
				)
			);

//$STH1 = $obj->GetSelectedRows( $table = 'employees', $limit = '2', $start = '0', $columns = '', $orderby ='e_id desc', $key='', $join_ar = '', $group_by = '' );
$STH1 = $obj->GetSelectedRows( $table = 'employees', $limit = '2', $start = '0', $columns = '', $orderby ='employees.e_id desc', $key=array('employees.e_id' => 25), $join_ar, $group_by = 'department');
print "total: " . $obj->GetSelectedRows( $table = 'employees', $limit = '2', $start = '0', $columns = '', $orderby ='employees.e_id desc', $key=array('employees.e_id' => 25), $join_ar, $group_by = 'department', $count = 1 );
#print_r($row_1->fetch());exit;

while($row = $STH1->fetch())
{
	//print $kk->e_id . '<br>';
	//print "kk: $kk<br>\n";

	$datec = $row->datec;
	$name = $row->name;
	$age = $row->age;

	print "<hr>datec: $datec * name: $name * age: $age <br>\n";
	
}

?>