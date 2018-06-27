<?php

require_once( 'Model.php' );

$model_ID = @$_POST['model_ID'];

$model = new Model();

$msg = $model->sold($model_ID);

echo $msg;exit;

?>