<?php
error_reporting(E_ALL ^ E_NOTICE);

class Db
{
    private $type = 'mysql';
    private $host = 'localhost';
    private $db = 'minicar';
    private $user = 'root';
    private $pass = '';
    private $DBH = NULL;

    public function __construct() 
    { 
    	//echo 'i am in constructor <br>';
    }

    function __destruct() 
    {
    	//echo 'i am in destructor <br>';
        $this->DBH = NULL;
    }

	public function connect()
	{
		try
		{
			#print "$this->type:host=$this->host;dbname=$this->db";exit;
			$this->DBH = new PDO("$this->type:host=$this->host;dbname=$this->db", "$this->user", "$this->pass");
			$this->DBH->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			#print "Database connected <br>";
			return $this->DBH;
		}
		catch(PDOException $e) {
		    echo "Error: " . $e->getMessage();exit;
		}
	}	

	private function makecond($key = array())
	{
		if($key == '')
		{
			$key = array();
		}
		$cond = '';
		foreach($key as $k => $v) 
		{
		    #echo "Key=" . $k . ", Value=" . $v . " <br>\n";
		    //echo "<br>";
		    //$cond .= "and $k=$v ";

	    	if(empty($k))
		    {
		    	$cond .= "and $v ";
		    }else{
		    	$cond .= "and $k = " . $this->DBH->quote($v) ;
		    }
		}
		$cond = substr($cond,4);
		return $cond;
	}

	public function query($query = '')
	{
		if($this->DBH == '')
		{
			$this->connect();
		}
		#print "q0_1: $query <br>\n";
		$cmd = $this->DBH->query($query);

		# setting the fetch mode
		$cmd->setFetchMode(PDO::FETCH_OBJ);
		//$r = $cmd->fetch();
		#print_r($r);exit;
		//return $cmd->fetch();
		return $cmd;
	}

	public function AddNewRow($table='', $data= array())
	{
		if($this->DBH == '')
		{
			$this->connect();
		}

		//print_r($this->DBH);exit;
		#print "<pre>";
		#print_r($data);
		#print "</pre>";//exit;
		//bindParam

		//$DBH = new PDO("mysql:host=localhost;dbname=test2", 'root', '');
		//$DBH->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

		$fields = $fields2 = '';
		foreach($data as $k => $v) 
		{
		    //echo "Key=" . $k . ", Value=" . $v;
		    //echo "<br>";
		    $fields .= ", $k";
		    $fields2 .= ", :$k";
		}
		$fields = substr($fields,2);
		$fields2 = substr($fields2,2);
		//print "fields: $fields <br>\n";
		//print "fields2: $fields2 <br>\n";

		$cmd = $this->DBH->prepare("INSERT INTO $table ($fields) VALUES ($fields2)");
			
		//$cmd->bindValue(':datec',date("Y-m-d H:i:s"));
		//$cmd->bindValue(':name','Anil');
		//$cmd->bindValue(':age',30);

		foreach($data as $k => $v) 
		{
		    //echo "Key=" . $k . ", Value=" . $v;
		    //echo "<br>";
		    $fields .= ", $k";
		    $fields2 .= ", :$k";
		    $cmd->bindValue(":$k",$v);
		}

		try {
			$cmd->execute();
		} catch (PDOException $e) {
		    print $e->getMessage();exit;
		}

		$last_id = $this->DBH->lastInsertId();
		#print "last_id: $last_id <br>";
		return $last_id;
	}

	public function UpdateRow($table, $data, $key)
	{
		if($this->DBH == '')
		{
			$this->connect();
		}

		$fields = '';
		foreach($data as $k => $v) 
		{
		    //echo "Key=" . $k . ", Value=" . $v;
		    //echo "<br>";
		    $fields .= ", $k=:$k ";
		}
		$fields = substr($fields,1);
		#print "fields: $fields <br>\n";

		#print_r($key);exit;
		$fields2 = '';
		//print count($key);
		if(count($key) >0)
		{
			foreach($key as $k => $v) 
			{
			    #echo "Key=" . $k . ", Value=" . $v . "<br>";
			    //echo "<br>";
			    if(empty($k))
			    {
			    	$fields2 .= "and $v ";
			    }else{
			    	$fields2 .= "and $k=:$k ";
			    }
			}
			$fields2 = "WHERE " . substr($fields2,4);
			#print "fields2: $fields2 <br>\n";
		}

		$q = "UPDATE $table SET $fields $fields2";
		#print $q;exit;
		$cmd = $this->DBH->prepare($q);
			
		foreach($data as $k => $v) 
		{
		    //echo "Key=" . $k . ", Value=" . $v;
		    //echo "<br>";
		    $cmd->bindValue(":$k",$v);
		}
		if(count($data) >0)
		{
			foreach($key as $k => $v) 
			{
			    #echo "Key=" . $k . ", Value=" . $v . "<br>";//exit;
			    //echo "<br>";
			    //$cmd->bindValue(":$k",$v);
		    	if(!empty($k))
			    {
			    	$cmd->bindValue(":$k",$v);
			    }
			}
		}

		try {
			$cmd->execute();
		} catch (PDOException $e) {
		    print $e->getMessage();exit;
		}

		return $cmd->rowCount();
	}

	public function DeleteRow($table, $data)
	{
		if($this->DBH == '')
		{
			$this->connect();
		}

		$fields = '';

		if(count($data) >0)
		{
			foreach($data as $k => $v) 
			{
			    //echo "Key=" . $k . ", Value=" . $v;
			    //echo "<br>";
			    //$fields .= "and $k=:$k ";
			    if(empty($k))
			    {
			    	$fields .= "and $v ";
			    }else{
			    	$fields .= "and $k=:$k ";
			    }
			}
			$fields = "WHERE " . substr($fields,4);
			#print "fields: $fields <br>\n";
		}

		$q = "DELETE from $table $fields";
		#print $q;exit;
		$cmd = $this->DBH->prepare($q);
		
		if(count($data) >0)
		{	
			foreach($data as $k => $v) 
			{
			    #echo "Key=" . $k . ", Value=" . $v . "<br>";
			    //echo "<br>";
		    	if(!empty($k))
			    {
			    	$cmd->bindValue(":$k",$v);
			    }
			}
		}

		try {
			$cmd->execute();
		} catch (PDOException $e) {
		    print $e->getMessage();exit;
		}

		return $cmd->rowCount();
	}

	public function GetInfoRow($table, $col = "*", $key)
	{
		if($this->DBH == '')
		{
			$this->connect();
		}
		$cond = $this->makecond($key);

		#print "cond: $cond<br>";exit;
		if(!empty($cond))
		{
			$cond = " WHERE $cond";
		}
		
		
		$q0_1 = "SELECT $col FROM $table $kyval $cond";
		#print "q0_1: $q0_1 <br>\n";//exit;
		#$q0_1 = "SELECT * FROM tbl_keyuser  ";

		try {
			$cmd = $this->DBH->query($q0_1);
		} catch (PDOException $e) {
		    print $e->getMessage();exit;
		}

		# setting the fetch mode
		$cmd->setFetchMode(PDO::FETCH_OBJ);
		//$r = $cmd->fetch();
		#print_r($r);exit;
		//return $cmd->fetch();
		return $cmd;
	}

	public function GetSelectedRows($table = '', $limit = '', $start = '', $columns = '', $orderby ='', $key='', $join_ar = '', $group_by = '', $count = '')
	{
		if($this->DBH == '')
		{
			$this->connect();
		}

		if(!empty($limit))
		{
			if(!empty($start))
			{
				$limitquery = " limit $start, $limit ";
			}else{
				$limitquery = " limit $limit ";
			}
		}

		if(!empty($orderby))
		{
			$orderbyquery = " ORDER BY $orderby ";
		}
		$columnsquery = (!empty($columns)) ? " $columns " : "*";
		
		$cond = $this->makecond($key);
		#print "cond: $cond<br>";exit;
		if(!empty($cond))
		{
			$cond = " WHERE $cond";
		}

		#print_r($join_ar);exit;

		$joinquery = '';

		if($join_ar == '') $join_ar = array();
		foreach($join_ar as $j)
		{
			#print "j:  <br>" ;
			#print_r($j);
			#print "<hr>\n";
			$type = $jtable = $condition = '';
			foreach($j as $k => $v)
			{
				#echo "Key=" . $k . ", Value=" . $v . "<br>";
				if($k == 'type')
				{
					$type = $v;
				}
				if($k == 'table')
				{
					$jtable = $v;
				}
				if($k == 'condition')
				{
					$condition = $v;
				}
			}
			$joinquery .= " $v JOIN $jtable ON $condition";
		}
		#print "joinquery: $joinquery <br>";exit;
		if(!empty($group_by))
		{
			$group_byquery = " GROUP BY $group_by ";
		}

		if($count == '1')
		{
			$columnsquery = "count(*) total";
		}
		$q0_1 = "SELECT $columnsquery FROM $table $joinquery $cond $group_byquery $orderbyquery $limitquery ";
		#print "query: $q0_1 <br>\n";
		
		try {
			$cmd = $this->DBH->query($q0_1);
		} catch (PDOException $e) {
		    print $e->getMessage();exit;
		}

		# setting the fetch mode
		$cmd->setFetchMode(PDO::FETCH_OBJ);
		//$r = $STH1->fetch();
		//print_r($r);exit;
		//return $STH1->fetch();

		if($count == '1')
		{
			while($row_1 = $cmd->fetch())
			{
				$total = $row_1->total;
				//print "total: $total <br>\n";
			}
			return $total;
		}else{
			return $cmd;
		}

		/*
		while($row_1 = $cmd->fetch())
		{
			$datec = $row_1->datec;
			$name = $row_1->name;
			$age = $row_1->age;

			print "datec: $datec * name: $name * age: $age <br>\n";
		}
		*/
	}	

}


?>