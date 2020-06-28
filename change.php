<html>
<head>

<?php


	session_start();
 
  include('connect.php');
  if(isset($_SESSION["email"])){
          $stud = $_SESSION["email"];
      }else{
        header('Location:login.php');
      }
	  
	if (isset ($_POST['register'])){
		$_SESSION['email'] = $stud;
		$password = $_POST['password_1'];
		$retypepassword = $_POST['password_2'];
		
	 if($password == $retypepassword){ 
    if (strlen($password) < '8') {
        echo "<script>alert('Password needs to be at least 8 characters.');</script>";
        echo "<meta http-equiv='refresh' content='0; url=change.php'/>";
    }
    elseif(!preg_match("#[0-9]+#",$password)) {
        echo "<script>alert('Your Password Must Contain At Least 1 Number!');</script>";
        echo "<meta http-equiv='refresh' content='0; url=change.php'/>";
    }
    elseif(!preg_match("#[A-Z]+#",$password)) {
        echo "<script>alert('Your Password Must Contain At Least 1 Capital Letter!');</script>";
        echo "<meta http-equiv='refresh' content='0; url=change.php'/>";

    }
    elseif(!preg_match("#[a-z]+#",$password)) {
        echo "<script>alert('Your Password Must Contain At Least 1 Lowercase Letter!');</script>";
        echo "<meta http-equiv='refresh' content='0; url=change.php'/>";
    }else{
   $sql =  "UPDATE admin SET password = '$retypepassword' WHERE email='$stud'";
 
		  
  $execute = mysqli_query ($con,$sql) or die (mysqli_error ($con));
	
  echo "<script>alert('Update Success!.');</script>";
  echo "<meta http-equiv='refresh' content='0; url=login.php'/>";
}
  
  }

  else{
      echo "<script>alert('Please log in first');</script>";
      echo "<meta http-equiv='refresh' content='0; url=password.php'/>";

  }
  

	}
	
	mysqli_close ($con);
?>

<title>Mechanic</title>    
<link rel="icon" href="img.png" type="image/gif" sizes="16x16">  
    <style>

</style>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<script>
    var myInput = document.getElementById("password_1");
    var letter = document.getElementById("letter");
    var capital = document.getElementById("capital");
    var number = document.getElementById("number");
    var length = document.getElementById("length");

    // When the user clicks on the password field, show the message box
    myInput.onfocus = function() {
      document.getElementById("message").style.display = "block";
    }

    // When the user clicks outside of the password field, hide the message box
    myInput.onblur = function() {
      document.getElementById("message").style.display = "none";
    }

    // When the user starts to type something inside the password field
    myInput.onkeyup = function() {
      // Validate lowercase letters
      var lowerCaseLetters = /[a-z]/g;
      if(myInput.value.match(lowerCaseLetters)) {  
        letter.classList.remove("invalid");
        letter.classList.add("valid");
      } else {
        letter.classList.remove("valid");
        letter.classList.add("invalid");
      }
      
      // Validate capital letters
      var upperCaseLetters = /[A-Z]/g;
      if(myInput.value.match(upperCaseLetters)) {  
        capital.classList.remove("invalid");
        capital.classList.add("valid");
      } else {
        capital.classList.remove("valid");
        capital.classList.add("invalid");
      }

      // Validate numbers
      var numbers = /[0-9]/g;
      if(myInput.value.match(numbers)) {  
        number.classList.remove("invalid");
        number.classList.add("valid");
      } else {
        number.classList.remove("valid");
        number.classList.add("invalid");
      }
      
      // Validate length
      if(myInput.value.length >= 8) {
        length.classList.remove("invalid");
        length.classList.add("valid");
      } else {
        length.classList.remove("valid");
        length.classList.add("invalid");
      }
    }
    </script>
	

<body style ="background-color: #fafafa;">
    <div class="register" style="height:600px;">
        <h2>Change password</h2>
        <form method="post" action="" onSubmit="return checkInput()">
            <p>Password</p>
            <input type="password" name="password_1" id="password_1"  placeholder="Enter password" >
			<div id="message">
                    <h5>Password must contain the following:</h5>
                    <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                    <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                    <p id="number" class="invalid">A <b>number</b></p>
                    <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                  </div>
            <p>Confirm Password</p>
            <center>
            <input type="password" name="password_2" id="password_2" placeholder="Repeat password">
            <input type="submit" name="register" value="Submit">
            	<input type="reset" value="Reset" onClick="resetInput()">
            <input type="button" value="Cancel" onClick="document.location.href='index.php';">
            </center>
        </form>
    </div>

</body>
</head>
</html>