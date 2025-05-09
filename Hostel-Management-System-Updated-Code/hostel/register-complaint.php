<?php
session_start();
include('includes/config.php');
date_default_timezone_set('Asia/Kolkata');
include('includes/checklogin.php');
check_login();
$aid=$_SESSION['id'];

if(isset($_POST['submit']))
{
// Posted Values
$complainttype=$_POST['ctype'];
$complaintdetails=$_POST['cdetails'];
$imgfile=$_FILES["image"]["name"];
$cnumber=mt_rand(100000000,999999999);

if($imgfile!=''):
// get the image extension
$extension = substr($imgfile,strlen($imgfile)-4,strlen($imgfile));
// allowed extensions
$allowed_extensions = array(".jpg","jpeg",".png",".gif",'.pdf');
// Validation for allowed extensions .in_array() function searches an array for a specific value.
if(!in_array($extension,$allowed_extensions))
{
echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
}
else
{
//rename the image file
$imgnewfile=md5($imgfile.time()).$extension;
// Code for move image into directory
move_uploaded_file($_FILES["image"]["tmp_name"],"comnplaintdoc/".$imgnewfile);


$query="insert into  complaints(ComplainNumber,userId,complaintType,complaintDetails,complaintDoc) values(?,?,?,?,?)";
$stmt = $mysqli->prepare($query);
$rc=$stmt->bind_param('iisss',$cnumber,$aid,$complainttype,$complaintdetails,$imgnewfile);
$stmt->execute();

echo "<script>alert('Complaint registerd. Complaint number is :  is: $cnumber');</script>";
echo "<script type='text/javascript'> document.location = 'my-complaints.php'; </script>";
}
else:

// Query for insertion data into database
$query="insert into  complaints(ComplainNumber,userId,complaintType,complaintDetails,complaintDoc) values(?,?,?,?,?)";
$stmt = $mysqli->prepare($query);
$rc=$stmt->bind_param('iisss',$cnumber,$aid,$complainttype,$complaintdetails,$imgnewfile);
$stmt->execute();

echo "<script>alert('Complaint registerd. Complaint number is :  is: $cnumber');</script>";
echo "<script type='text/javascript'> document.location = 'my-complaints.php'; </script>";
endif;
}



?>

<!doctype html>
<html lang="en" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	<title>Complaint Registration</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">>
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
<script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
<script type="text/javascript" src="js/validation.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>

</head>
<body>
	<?php include('includes/header.php');?>
	<div class="ts-main-content">
		<?php include('includes/sidebar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">
	
				<div class="row">
					<div class="col-md-12">
						<h2 class="page-title">Register Complaint </h2>

						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-primary">

									

<div class="panel-body">
<form method="post" action="" name="complaint" class="form-horizontal" enctype="multipart/form-data">
								
								

<div class="form-group">
<label class="col-sm-2 control-label"> Complaint Type </label>
<div class="col-sm-8">
<select  class="form-control" required="required" name="ctype">
<option value="">Select Complaint Type</option>
<option value="Food Related">Food Related</option>
<option value="Room Related">Room Related</option>
<option value="Fee Related">Fee Related</option>
<option value="Electrical">Electrical</option>
<option value="Plumbing">Plumbing</option>
<option value="Discipline">Discipline</option>
<option value="Other">Other</option>
</select>
</div>
</div>


<div class="form-group">
<label class="col-sm-2 control-label">Explain the Complaint</label>
<div class="col-sm-8">
<textarea name="cdetails" id="cdetails"  class="form-control"    required="required" ></textarea>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">File (if any)</label>
<div class="col-sm-8">
<input type="file" name="image" id="image"  class="form-control" >
</div>
</div>


						



<div class="col-sm-6 col-sm-offset-4">

<input type="submit" name="submit" Value="Submit" class="btn btn-primary">
</div>
</form>

									</div>
									</div>
								</div>
							</div>
						</div>
							</div>
						</div>
					</div>
				</div> 	
			</div>
		</div>
	</div>
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
</body>
<script type="text/javascript">
	$(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){
                $('#paddress').val( $('#address').val() );
                $('#pcity').val( $('#city').val() );
                $('#pstate').val( $('#state').val() );
                $('#ppincode').val( $('#pincode').val() );
            } 
            
        });
    });
</script>
	<script>
function checkAvailability() {

$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#email").val(),
type: "POST",
success:function(data){
$("#user-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>

</html>