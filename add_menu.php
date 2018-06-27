<?php
session_start();

// echo $_SESSION['user_ID'];exit;

if( ! isset( $_SESSION['user_ID'] ) )
{
	echo "Unauthorized Access.";exit;
}
?><!DOCTYPE html>
<html lang="en">
<head>
  <title>Add Menufacturer</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
  
  <style>
  .error{
	color: orangered;
  }
  .suc{
	color: green;
  }
  </style>
  
  
  
</head>
<body>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">MiniCar</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="add_menu.php">Add Menufacturer</a></li>
      <li><a href="add_model.php">Add model</a></li>
      <li><a href="view_model.php">View Model</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </div>
</nav>
...

<div class="container">
  <h2>Add Menufacturer</h2>
  <form action="" id="menadd_frm" name="menadd_frm" >
    <div class="form-group">
      <label for="mnufcrr_name">Menufacturer Name:</label>
      <input type="text" class="form-control" id="mnufcrr_name" placeholder="Enter manufacturer name" name="mnufcrr_name" value="">
    </div>
    <div class="checkbox suc" id="msg" style="display:none;">Menufacturer added successfully</div>
    <button id="men_sub" type="button" class="btn btn-default">Submit</button>
  </form>
</div>

<script type="text/javascript">

$(document).ready( function() {

	//alert("succes");
	
			$("#menadd_frm").validate({
				rules: {
					mnufcrr_name: {
						required:true
					}
				},
				messages: {
					mnufcrr_name: {
						required:"Please enter name."
					}		
					
				}				
				});//validate

	$('#men_sub').click( function() {
	
		if( $("#menadd_frm").valid() )
		{
			$('#men_sub').attr("disabled", "disabled");
			var form_data = $("#menadd_frm").serialize();		
			
			$.ajax({
						url:"save_men.php",
						type:"POST",
						data:form_data,
						success: function(res)
						{
							console.log("msg: " + res);
							
							if( res )
							{
								$("#msg").show();
								setTimeout(function(){ 
									$("#msg").hide(); 
									$("#menadd_frm")[0].reset();
									$('#men_sub').removeAttr("disabled");
								}, 3000); 
							}
								
						}
					});
		}		
	
	} );// click end
	
} );

</script>

</body>
</html>
