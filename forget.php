<!DOCTYPE html>
<html lang="en">
 <head>
<!--   	<meta http-equiv="refresh" content="5"/> -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mechanic</title>
	<link rel="icon" href="img.png" type="image/gif" sizes="16x16">  
    <meta name="description" content="Source code generated using layoutit.com">
    <meta name="author" content="LayoutIt!">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" href="akif.png" type="image/gif">
    <link rel="stylesheet" type="text/css" href="util.css">
	<link rel="stylesheet" type="text/css" href="main.css">


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


<link rel="stylesheet" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">




<style>
	.foo {
  float: left;
  width: 100px;
  height: 55px;
  margin: 5px;
  border: 2px solid rgba(0, 0, 0, .2);
}

.queue {
  background: #f2dede;
}

.blue {
  background: rgba(0, 0, 0, 0.075);
}

.completed {
  background: #fcf8e3;
}

.collected {
  background: #dff0d8;
}

.unstyled-button {
  border: none;
  padding: 0;
  background: none;
}

</style>




  </head>
  <body  style ="background-color: #fafafa;">
<div class="limiter">
<div class="container-login100">
<div class="row" >

				<div class="wrap-login100 p-t-30 p-b-50">
					<form action="" method="post">
						<div class="form-group">
							 <span style="margin:auto; display:table; font-weight:bold; color: black;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> ALERT! Your password will be reseted to default.</span><br>
					<label for="email" style="color:black;">
						Email: <span style="color:black;">*</span>
					</label>
					<input class="form-control" name="email" type="text"  placeholder="eg: " required>
					<label for="question" style="color:black;">
						What was the name of your best friend?  <span style="color:black;">*</span>
					</label>
					<input class="form-control" name="question" type="text" maxlength="50" required>
					<label for="question2" style="color:black;">
						When is your birthday? <span style="color:black;">*</span>
					</label>
					<input class="form-control" name="question2" type="text" maxlength="50" required>
					<label for="question3" style="color:black;">
						What is the name of your mother? <span style="color:black;">*</span>
					</label>
					<input class="form-control" name="question3" type="text" maxlength="50" required>
					 
						</div>
						<button type="submit" onclick="location.href='login.php';" class="btn btn-danger">Cancel <i class="fa fa-ban" aria-hidden="true"></i>

						</button>
						<button type="submit" name="submit" class="btn btn-info">Reset Password <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>

						</button>
				
					</form>
				</div>
			</div></body>
			<?php
include('connect.php');
if(isset($_POST['submit'])){
	$email=$_POST['email'];
	$question=$_POST['question'];
	$question2=$_POST['question2'];
	$question3=$_POST['question3'];



	$sql1 = "SELECT question, question2, question3 FROM `admin` WHERE email='$email'";
	$execute1=mysqli_query($con, $sql1) or die (mysqli_error($con));
	$row = mysqli_fetch_assoc($execute1);
	$soklan = $row ["question"];
	$soklan2 = $row ["question2"];
	$soklan3 = $row ["question3"];

			if($question == $soklan && $question2 == $soklan2 && $question3 == $soklan3){
				$sql = "UPDATE `admin` SET `password`='12345' WHERE `email`='$email'";
				$result = mysqli_query($con, $sql);

					if(mysqli_affected_rows($con) >0 ){
						echo '<script language="javascript">';
						echo 'alert("Password reseted to default. Please change your password once you have logged in.");';
						echo 'window.location.href="login.php";';
						echo '</script>';
					}
						echo '<script language="javascript">';
						echo 'alert("You are currently using the default password.");';
						echo 'window.location.href="login.php";';
						echo '</script>';

			}else{
						echo '<script language="javascript">';
						echo 'alert("Unable to reset password. Make sure your email and security answer is correct.");';
						echo 'window.location.href="forget.php";';
						echo '</script>';

			}
		}


	
	
	


?>
</html>