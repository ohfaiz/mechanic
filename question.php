<!DOCTYPE html>
<html lang="en">
<?php

$session_lifetime = 3600 * 24 * 2; // 2 days
session_set_cookie_params ($session_lifetime);
session_start();
	
	if(isset($_SESSION["email"])){
			$user = $_SESSION["email"];
	}else{
		header('Location: login.php');
	}
	 include('connect.php');

	

  if (isset ($_POST['submit'])){
    $user = $_SESSION['email'];
    $question = $_POST['question'];
	$question2 = $_POST['question2'];
	$question3 = $_POST['question3'];
     
    
  $sql = "UPDATE admin 
          SET question = '$question' , question2 = '$question2' , question3 = '$question3' 
          WHERE email = '$user'";
    
  $execute = mysqli_query ($con,$sql) or die (mysqli_error ($con));
  if(mysqli_affected_rows($con) >0 ){
  $_SESSION ['question'] = $question;
  $_SESSION ['question2'] = $question2;
  $_SESSION ['question3'] = $question3;
  echo "<script>alert('Security question updated.');</script>";
  echo "<meta http-equiv='refresh' content='0; url=index.php'/>";
  
  }

  else{
      echo "<script>alert('Enter a valid location.');</script>";
      echo "<meta http-equiv='refresh' content='0; url=question.php'/>";

  }
}

  mysqli_close ($con);


?>
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

    <div class="container-fluid">
	<div class="row" ">
		<div class="col-md-12">
			<div class="page-header" align="center">
				<br>
				
				


			</div>
			
			
						
			
	<br>
<div class="row">
				<div class="col-md-4">
				</div>
				<div class="col-md-4">
					<form action="" method="post">
						<div class="form-group">
							 <span style="margin:auto; display:table; font-weight:bold;">Security Question</span><br>
							<label for="question">
								What is the name of your best friend?
							</label>
							<input type="text" class="form-control" name="question" required maxlength="50"/>
							<label for="question">
								When is your birthday? 
							</label>
							<input type="text" class="form-control" name="question2" required maxlength="50"/>
							<label for="question">
								What is the name of your mother?
							</label>
							<input type="text" class="form-control" name="question3" required maxlength="50"/>
							
							
						</div>
						
						<button type="submit" name="submit" class="btn btn-info">Submit <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></br>
						</button>
						<input type="button" class="btn btn-info" value="Cancel" onClick="document.location.href='index.php';">
						</button>
					</form>
				</div>
				<div class="col-md-4">
				</div>
			</div>
			
</div></body></html>