<html>
<head>
<title>Mechanic Management System</title>    
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
<div class="row" >
    <div class="">
   
        <form action="" method="post">
		<div class="form-group">
           <label for="ic" style="color:white;">
						Email: <span style="color:red;">*</span>
					</label>
					<input class="form-control" name="email" type="text" placeholder="eg: awie@gmail.com" required>
					<label for="email" style="color:white;">
						What was the name of the hospital that you were born? (Case-sensitive) <span style="color:red;">*</span>
					</label>
					<input class="form-control" name="question" type="text" maxlength="50" required>
					
					
        
		</div>
		<button type="submit" onclick="location.href='login.php';" class="btn btn-danger">Cancel <i class="fa fa-ban" aria-hidden="true"></i>
		</button>
		<button type="submit" name="submit" class="btn btn-info">Reset Password <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
		</button>
		</form>
    </div>
</div>

</body>
</head>
<?php
include('connect.php');
if(isset($_POST['submit'])){
	$email=$_POST['email'];
	$question=$_POST['question'];


	$sql1 = "SELECT question FROM `admin` WHERE email='$email'";
	$execute1=mysqli_query($connect, $sql1) or die (mysqli_error($connect));
	$row = mysqli_fetch_assoc($execute1);
	$soklan = $row ["question"];

			if($question == $soklan){
				$sql = "UPDATE `admin` SET `password`='12345' WHERE `email`='$email'";
				$result = mysqli_query($connect, $sql);

					if(mysqli_affected_rows($connect) >0 ){
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