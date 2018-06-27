<?php

session_start();

require_once( 'pdo.db.php' );

class User{

	public function __construct()
	{

	}

	public function check($user_name, $user_pass)
	{
		// return "checking...";

 		$obj = new Db();	
		$stmt = $obj->GetInfoRow( "user", "user_ID", array("user_active" => "Y", "user_name" => $user_name, "user_pass" => md5($user_pass) ) );
		$result = $stmt->fetch();

/*  		var_dump( @$result->user_ID );
		exit; */  
		
		if( $result )
		{
			$_SESSION["user_ID"] = @$result->user_ID;
			return "1";
		}
		else
			return "0";
	}
	
}

$user_name = @$_POST['user_name'];
$user_pass = @$_POST['user_pass'];

/*  		var_dump( $_POST );
		exit;  */

if( empty( $user_name ) && empty( $user_pass ) )
{
	echo "Invalid Input. Please try again later.";exit;
}

// echo "login successful";exit;


$user = new User();
$msg = $user->check($user_name, $user_pass);
echo $msg;

?>