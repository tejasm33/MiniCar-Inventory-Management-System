<?php

session_start();

if( ! isset( $_SESSION['user_ID'] ) )
{
	echo "Unauthorized Access.";exit;
}

require_once( 'Model.php' );

$obj = new Db();

$join_ar = array(
				0 => array(
					"table" => "mnufcrr",
					"condition" => "model.model_mnufcrr = mnufcrr.mnufcrr_ID",
					"type" => "INNER"
				)
			);

$STH1 = $obj->GetSelectedRows( $table = 'model', $limit = '', $start = '', $columns = '', $orderby ='model_name', $key = array("model_sold" => "N"), $join_ar, $group_by = '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>View Model</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.jqueryui.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
  
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.jqueryui.min.js"></script>
  
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
      <li ><a href="add_model.php">Add model</a></li>
      <li class="active"><a href="view_model.php">View Model</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </div>
</nav>
...

<div class="container">
  <h2>View Model</h2>
  
<table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>Manufacturer Name</th>
                <th>Model Name</th>
            </tr>
        </thead>
        <tbody>
          
			
<?php

$snum = 1;
$models = '';

while($row = $STH1->fetch())
{
	//print $kk->e_id . '<br>';
	//print "kk: $kk<br>\n";

	$mnufcrr_ID = $row->mnufcrr_ID;
	$mnufcrr_name = $row->mnufcrr_name;
	$model_ID = $row->model_ID;
	$model_name = $row->model_name;
	$model_color = $row->model_color;
	$model_myear = $row->model_myear;
	$model_rnum	= $row->model_rnum;
	$model_note = $row->model_note;
	$model_img = $row->model_img;

	$models .= '<tr data-model_ID="'.$model_ID.'" data-mnufcrr_name="'.$mnufcrr_name.'" data-model_name="'.$model_name.'" data-model_color="'.$model_color.'" data-model_myear="'.$model_myear.'" data-model_rnum="'.$model_rnum.'" data-model_note="'.$model_note.'" data-model_img="'.$model_img.'" >
                <td class="mod_row">'.$snum.'</td>
                <td class="mod_row">'.$mnufcrr_name.'</td>
                <td class="mod_row">'.$model_name.'</td>
            </tr>';
			
$snum++;
	
}

echo $models;

?>
            
        </tfoot>
    </table>
  
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Model Details</h4>
      </div>
      <div class="modal-body">
        
    <div class="form-group">
	
		<div class="col-md-6" style="padding: 0px;">
		  <label for="modv_mnufcrr">Menufacturer:</label>
			<input type="text" class="form-control" id="modv_mnufcrr" placeholder="Enter model name" name="modv_mnufcrr" value="" style="display:  inline;width: 40%;">
		</div>
		
		<div class="col-md-6" style="padding: 0px;">
		  <label for="modv_name">Model Name:</label>
		  <input type="text" class="form-control" id="modv_name" placeholder="Enter model name" name="modv_name" value="" style="display:  inline;width: 40%;">
		</div>
	
    </div>
	
    <div class="form-group">
      <label for="modv_color">Color:</label>
      <input type="text" class="form-control" id="modv_color" placeholder="Enter model name" name="modv_color" value="" >
    </div>
	
    <div class="form-group">
      <label for="modv_myear">Manufacturing Year:</label>
      <input type="text" class="form-control" id="modv_myear" placeholder="Enter model name" name="modv_myear" value="" >
    </div>	
	
    <div class="form-group">
      <label for="modv_rnum">Registration Number:</label>
      <input type="text" class="form-control" id="modv_rnum" placeholder="Enter model name" name="modv_rnum" value="" >
    </div>	
	
    <div class="form-group">
      <label for="modv_note">Note:</label>
      <input type="text" class="form-control" id="modv_note" placeholder="Enter model name" name="modv_note" value="" >
    </div>	
	
	
    <div class="form-group">
      <label for="modv_pic">Pictures:</label>

			<div id="modimg_div"></div>
	  
    </div>	
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<input type="hidden" name="model_ID" id="model_ID" value="Y">
		<button id="mod_sold" type="button" class="btn btn-default" style="background-color: orangered;color:white;">Sold</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">

$(document).ready( function() {
	//alert("succes");
	$('#example').DataTable();
	
	$(".mod_row").click( function() {
		
		var model_ID = $(this).closest("tr").data("model_id");
		var mnufcrr_name = $(this).closest("tr").data("mnufcrr_name");
		var model_name = $(this).closest("tr").data("model_name");
		var model_name = $(this).closest("tr").data("model_name");
		var model_color = $(this).closest("tr").data("model_color");
		var model_myear = $(this).closest("tr").data("model_myear");
		var model_rnum = $(this).closest("tr").data("model_rnum");
		var model_note = $(this).closest("tr").data("model_note");
		var model_img = $(this).closest("tr").data("model_img");

		console.log( "model_ID:" + model_ID );
		
		modimg = '';
		
		if( model_img != "" )
		{
			var arr = model_img.split(",");
			
			for( var i = 0 ; i < arr.length ; i++ )
			{
				modimg += '<br><br><div><img style="width: 100px;" src="uploads/' + arr[i] + '"></div>';
			}
		}
		
		
		$("#model_ID").val( model_ID );
		$("#modv_mnufcrr").val( mnufcrr_name );
		$("#modv_name").val( model_name );
		$("#modv_color").val( model_color );
		$("#modv_myear").val(model_myear);
		$("#modv_rnum").val( model_rnum );
		$("#modv_note").val( model_note );
		$("#modimg_div").html( modimg );
		
		
		$('#myModal').modal('show');
	} );
	
	$("#myModal").on("click", "#mod_sold", function(){
		var model_ID = $("#model_ID").val();
		console.log( model_ID  );
		
		$.ajax({
					url:"mod_sold.php",
					type: "POST",
					data:{model_ID: model_ID},
					 success: function (res) {

							
							location.reload();
							
					 }
		});
		
	});
	
} );

</script>

</body>
</html>