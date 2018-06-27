<?php

require_once( 'Model.php' );

$modadd_mnufcrr = @$_POST['modadd_mnufcrr'];
$modadd_name = @$_POST['modadd_name'];

/*  		var_dump( $_POST );
		exit;  */

if( empty( $modadd_mnufcrr ) && empty( $modadd_name ) )
{
	echo "Invalid Input. Please try again later.";exit;
}

// echo "login successful";exit;


$model = new Model();
$msg = $model->add($mnufcrr_name);
echo $msg;exit;

?>