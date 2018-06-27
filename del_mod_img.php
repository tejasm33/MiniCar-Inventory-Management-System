<?php


$fname = @$_POST['fname'];

unlink("uploads/$fname");

?>