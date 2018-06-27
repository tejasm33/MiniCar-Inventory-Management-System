<?php

session_start();

if( ! isset( $_SESSION['user_ID'] ) )
{
	echo "Unauthorized Access.";exit;
}

require_once( 'Manufacturer.php' );

// echo $_SESSION['user_ID'];exit;



$obj = new Db();

$STH1 = $obj->GetSelectedRows( $table = 'mnufcrr', $limit = '', $start = '', $columns = '', $orderby ='mnufcrr_name', $key = '', $join_ar = '', $group_by = '');

$men_sel = '<select class="form-control" id="modadd_mnufcrr" name="modadd_mnufcrr" style="display:  inline;width: 40%;"><option value="">Select</option>';

while($row = $STH1->fetch())
{
	//print $kk->e_id . '<br>';
	//print "kk: $kk<br>\n";

	$mnufcrr_ID = $row->mnufcrr_ID;
	$mnufcrr_name = $row->mnufcrr_name;

	$men_sel .= '<option value="'.$mnufcrr_ID.'">'.$mnufcrr_name.'</option>';
	
}

$men_sel .= '</select>';


?><!DOCTYPE html>
<html lang="en">
<head>
  <title>Add Model</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
  <script src="SimpleAjaxUploader.min.js"></script>
  
  <style>
  .error{
	color: orangered;
  }
  .suc{
	color: green;
  }
  
  .modimg{
	background-color: lightcoral;
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
      <li ><a href="add_menu.php">Add Menufacturer</a></li>
      <li class="active"><a href="add_model.php">Add model</a></li>
      <li><a href="view_model.php">View Model</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </div>
</nav>
...

<div class="container">
  <h2>Add Model</h2>
  <form action="" id="modadd_frm" name="modadd_frm" >
    <div class="form-group">
	
		<div class="col-md-6" style="padding: 0px;">
		  <label for="modadd_mnufcrr">Menufacturer:</label>
			<?php echo $men_sel; ?>
		</div>
		
		<div class="col-md-6" style="padding: 0px;">
		  <label for="modadd_name">Model Name:</label>
		  <input type="text" class="form-control" id="modadd_name" placeholder="Enter model name" name="modadd_name" value="" style="display:  inline;width: 40%;">
		</div>
	
    </div>
	
    <div class="form-group">
      <label for="modadd_color">Color:</label>
      <input type="text" class="form-control" id="modadd_color" placeholder="Enter color" name="modadd_color" value="" >
    </div>
	
    <div class="form-group">
      <label for="modadd_myear">Manufacturing Year:</label>
      <input type="text" class="form-control" id="modadd_myear" placeholder="Enter manufacturing year" name="modadd_myear" value="" >
    </div>	
	
    <div class="form-group">
      <label for="modadd_rnum">Registration Number:</label>
      <input type="text" class="form-control" id="modadd_rnum" placeholder="Enter registration number" name="modadd_rnum" value="" >
    </div>	
	
    <div class="form-group">
      <label for="modadd_note">Note:</label>
      <input type="text" class="form-control" id="modadd_note" placeholder="Enter note" name="modadd_note" value="" >
    </div>	
	
	
    <div class="form-group">
      <label for="modadd_pic">Pictures:</label>

		<input type="button" id="uploadButton" class="btn btn-primary btn-large clearfix" value="Choose file">
		<span style="padding-left:5px;vertical-align:middle;"><i>PNG, JPG, or GIF (1024K max file size, Only 2 images)</i></span>
		
		<div id="errormsg" class="clearfix redtext" style="padding-top: 10px;"></div>
		
		<div id="pic-progress-wrap" class="progress-wrap" style="margin-top:10px;margin-bottom:10px;"></div>
		
		<div id="progressBox"></div>
		
		<div id="picbox" class="clear" style="padding-top:0px;padding-bottom:10px;"></div>
	  
    </div>	
	
    <div class="checkbox suc" id="msg" style="display:none;">Model added successfully</div>
    <button id="mod_sub" type="button" class="btn btn-default">Submit</button>
  </form>
</div>

<br><br><br><br>

<script type="text/javascript">

$(document).ready( function() {

	//alert("succes");
	
			$("#modadd_frm").validate({
				rules: {
					modadd_mnufcrr: {
						required:true
					},
					modadd_name: {
						required:true
					},
					modadd_color: {
						required:true
					},
					modadd_myear: {
						required:true,
						number:true,
						minlength: 4,
						maxlength: 4
					},
					modadd_rnum: {
						required:true
					},
					modadd_note: {
						required:true
					}
					
				},
				messages: {
					modadd_mnufcrr: {
						required:"Please select manufacturer"
					},
					modadd_name: {
						required:"Please enter model name."
					},
					modadd_color: {
						required:"Please enter color."
					},
					modadd_myear: {
						required:"Please enter manufacturer year.",
						number: "Please enter a valid number.",
						min: "Year should be 4 digit number.",
						max: "Year should be 4 digit number."
					},
					modadd_rnum: {
						required:"Please enter registration number."
					},
					modadd_note: {
						required:"Please enter note."
					}
					
				}				
				});//validate

	$('#mod_sub').click( function() {
	
		if( $("#modadd_frm").valid() )
		{
			$('#mod_sub').attr("disabled", "disabled");
			var form_data = $("#modadd_frm").serialize();		
			
			$.ajax({
						url:"save_mod.php",
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
									$("#modadd_frm")[0].reset();
									$("#picbox").html('');
									$('#mod_sub').removeAttr("disabled");
								}, 3000); 
							}
								
						}
					});
		}		
	
	} );// click end
	
	
	
      wrap = document.getElementById('pic-progress-wrap'),
      picBox = document.getElementById('picbox'),
      errBox = document.getElementById('errormsg');
	
		var upcnt = 0;
	
var uploader = new ss.SimpleUpload({
      button: 'uploadButton',
      url: 'uploadHandler.php', // server side handler
      progressUrl: 'uploadProgress.php', // enables cross-browser progress support (more info below)
      responseType: 'json',
      name: 'uploadfile',
      multiple: true,
      allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'], // for example, if we were uploading pics
      hoverClass: 'ui-state-hover',
      focusClass: 'ui-state-focus',
      disabledClass: 'ui-state-disabled',   
      onSubmit: function(filename, extension) {
		  
			console.log("upcnt: " + upcnt );

		  if( upcnt <= 1 )
		  {
				  
			  // Create the elements of our progress bar
			  var progress = document.createElement('div'), // container for progress bar
				  bar = document.createElement('div'), // actual progress bar
				  fileSize = document.createElement('div'), // container for upload file size
				  wrapper = document.createElement('div'), // container for this progress bar
				  //declare somewhere: <div id="progressBox"></div> where you want to show the progress-bar(s)
				  progressBox = document.getElementById('progressBox'); //on page container for progress bars
			  
			  // Assign each element its corresponding class
			  progress.className = 'progress progress-striped';
			  bar.className = 'progress-bar progress-bar-success';
			  fileSize.className = 'size';
			  wrapper.className = 'wrapper';
			  
			  // Assemble the progress bar and add it to the page
			  progress.appendChild(bar); 
			  wrapper.innerHTML = '<div class="name">'+filename+'</div>'; // filename is passed to onSubmit()
			  wrapper.appendChild(fileSize);
			  wrapper.appendChild(progress);                                       
			  progressBox.appendChild(wrapper); // just an element on the page to hold the progress bars    
			  
			  // Assign roles to the elements of the progress bar
			  this.setProgressBar(bar); // will serve as the actual progress bar
			  this.setFileSizeBox(fileSize); // display file size beside progress bar
			  this.setProgressContainer(wrapper); // designate the containing div to be removed after upload
		  
			}
			else
			{
				return false;
			}
		  
        },
        
       // Do something after finishing the upload
       // Note that the progress bar will be automatically removed upon completion because everything 
       // is encased in the "wrapper", which was designated to be removed with setProgressContainer() 
	   
	   /*
      onComplete:   function(filename, response) {
          if (!response) {
            alert(filename + 'upload failed');
            return false;
          }
          // Stuff to do after finishing an upload...
        }
		*/
		
		onComplete: function(file, response) { 
			console.log( response );
		
            if (!response) {
              errBox.innerHTML = 'Unable to upload file';
            }     
            if (response.success === true) {
              picBox.innerHTML += '<br><br><div id="imgrow_'+ upcnt +'"><img style="width: 100px;" src="uploads/' + response.file + '"> <button type="button" id="img_'+ upcnt +'" class="btn btn-primary btn-large clearfix modimg" data-fname="' + response.file + '" data-upcnt="' + upcnt + '"><span class="glyphicon glyphicon-trash"></span><input type="hidden" name="modimg[]" value="' + response.file + '"></button></div>';
			  upcnt++;
			  
			  
            } else {
              if (response.msg)  {
                errBox.innerHTML = response.msg;
              } else {
                errBox.innerHTML = 'Unable to upload file';
              }
            }            
            
        }
		
});

		$("#picbox").on("click", ".modimg", function(){
			var id = $(this).attr("id");
			var fname = $(this).data("fname");
			var cupcnt = $(this).data("upcnt");
			console.log( id + "-" + fname + "-" + cupcnt );
			
			$.ajax({
						url:"del_mod_img.php",
						type: "POST",
						data:{fname: fname},
						 success: function (res) {

								
								$("#imgrow_" + cupcnt).remove();
								upcnt--;
								
						 }
			});
			
		});

	
} );

</script>

</body>
</html>
