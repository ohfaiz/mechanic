<?php
session_start();
if(isset($_SESSION["email"])){
          $stud = $_SESSION["email"];
      }else{
        header('Location:login.php');
      }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Make booking</title>
</head>

<body>

<?php
// Captcha
if(empty($_SESSION['captcha3'] ) ||
	strcasecmp($_SESSION['captcha3'], $_POST['captcha3']) != 0)
	{
		//Note: the captcha code is compared case insensitively.
		//if you want case sensitive match, update the check above to
		// strcmp()
		$errors = "<h3><font color=\"red\">Wrong code!</font></h3>";
		echo $errors;
	}
	
	if(empty($errors))
	{
		include 'config.php';
		
		// Create connection
		$conn = mysqli_connect($servername, $username, $password,  $dbname);
		
		// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
		
		$start_day = intval(strtotime(htmlspecialchars($_POST["start_day"])));
		$start_time = (60*60*intval(htmlspecialchars($_POST["start_hour"]))) + (60*intval(htmlspecialchars($_POST["start_minute"])));
		$end_day = intval(strtotime(htmlspecialchars($_POST["end_day"])));
		$end_time = (60*60*intval(htmlspecialchars($_POST["end_hour"]))) + (60*intval(htmlspecialchars($_POST["end_minute"])));
		
		$phone = htmlspecialchars($_POST["phone"]);
		$f = ($_POST["ServiceName"]);
		
		$CustomerId = ($_POST["name"]);
		$start_epoch = $start_day + $start_time;
		$end_epoch = $end_day + $end_time;
		
		/*foreach ($_POST["ServiceName"] AS $f){
			$ServiceName = implode("","$f");
	    } echo $ServiceName;
	
	*/
		
		// prevent double booking
		$sql = "SELECT * FROM $tablename WHERE ServiceId='$f' AND (start_day>=$start_day OR end_day>=$start_day) AND canceled=0";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			// handle every row
			while($row = mysqli_fetch_assoc($result)) {
				// check overlapping at 10 minutes interval
				for ($i = $start_epoch; $i <= $end_epoch; $i=$i+600) {
					if ($i>($row["start_day"]+$row["start_time"]) && $i<($row["end_day"]+$row["end_time"])) {
						echo '<h3><font color="red">Unfortunately Session has already been booked for the time requested.</font></h3>';
						goto end;
					}
				}
			}				
		}
				
		$sql = "INSERT INTO $tablename (phone, start_day, end_day, start_time, end_time, canceled, CustomerId )
			VALUES ('$phone', $start_day, $end_day, $start_time, $end_time, 0, $CustomerId)";
			
	
		if (mysqli_query($conn, $sql)==TRUE) {

  		$sql2="SELECT MAX(id) FROM `bookingcalendar`";
		$result= mysqli_query($conn, $sql2);
		$row=mysqli_fetch_row($result);
		$someString=implode("",$row);
		foreach ($_POST['ServiceName'] as $icon) {
			$sql3="INSERT INTO `appointment`(`id`, `ServiceId`) VALUES ('$someString','$icon')";
			mysqli_query($conn, $sql3);
			}
		
		    echo "<h3>Booking succeed.</h3>";
			
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		
		end:
		mysqli_close($conn);
		
		
	}
?>

<a href="appointment.php"><p>Back to the booking calendar</p></a>

</body>

</html>
