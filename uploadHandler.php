<?php 
set_time_limit (0);
date_default_timezone_set('Asia/Kolkata');
// var_dump( $_FILES );

$target_dir = "uploads/";

$arr = explode(".", $_FILES["uploadfile"]["name"] );


$newfname = $arr[0] . "_" . date("YmdHis") . "." . $arr[1];
// echo $newfname;exit;

// echo $_FILES["uploadfile"]["name"]. "/". basename( $_FILES["uploadfile"]["name"] );exit;

// $target_file = $target_dir . basename( $_FILES["uploadfile"]["name"] );
$target_file = $target_dir . $newfname;
$uploadOk = 'true';
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

$msg = "";

// Check if image file is a actual image or fake image
// if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["uploadfile"]["tmp_name"]);
    if($check !== false) {
        $msg = "File is an image - " . $check["mime"] . ".";
        $uploadOk = 'true';
    } else {
        $msg = "File is not an image.";
        $uploadOk = 'false';
    }
// }
// Check if file already exists
if (file_exists($target_file)) {
    $msg = "Sorry, file already exists.";
    $uploadOk = 'false';
}
// Check file size
if ($_FILES["uploadfile"]["size"] > 500000) {
    $msg = "Sorry, your file is too large.";
    $uploadOk = 'false';
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 'false';
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 'false') {
// $msg = "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $target_file)) {
        $msg = "The file ". basename( $newfname ). " has been uploaded.";
    } else {
        $msg = "Sorry, there was an error uploading your file.";
    }
}


echo '{"success":'.$uploadOk.',"file":"'.$newfname.'","msg":"'.$msg.'"}';

?>