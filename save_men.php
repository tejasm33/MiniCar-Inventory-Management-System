<?php

require_once( 'Manufacturer.php' );

$mnufcrr_name = @$_POST['mnufcrr_name'];

/*  		var_dump( $_POST );
		exit;  */

if( empty( $mnufcrr_name ) )
{
	echo "Invalid Input. Please try again later.";exit;
}

// echo "login successful";exit;


$mfrr = new Manufacturer();
$msg = $mfrr->add($mnufcrr_name);
echo $msg;

?>