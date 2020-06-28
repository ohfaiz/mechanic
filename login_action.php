<?php 

	include('connect.php');

	if (isset($_POST['login_user'])) 
	{
   	$cust = $_POST["email"];
   	$pwd = $_POST["password"];

   	$login = mysqli_query($con, "SELECT * FROM `admin` WHERE `email`='$cust' AND `password`='$pwd'");
      
   	$row_array = mysqli_fetch_assoc($login);
      
   	$rows = mysqli_num_rows($login);
      

   	if ($rows == 1){
		 session_start();
		 $_SESSION['email'] = $cust;
		 session_write_close();
		 echo '<script language="javascript">';
         echo 'alert("Log in Success");';
         echo 'window.location.href="index.php"';
		 echo '</script>';
      }
     

   	else{
		echo '<script language="javascript">';	
      echo 'alert("UserID or Password is invalid");';
      echo 'window.location.href="login.php"';
	  echo '</script>';
   	}
      mysqli_close($con);
   	}
	
?>



