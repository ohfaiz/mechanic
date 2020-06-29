<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php 
session_start();
if(isset($_SESSION["email"])){
          $stud = $_SESSION["email"];
      }else{
        header('Location:login.php');
      }
  
 
  include('connect.php');
?>

<head>
<style>
html *
{
   font-family: Arial !important;
}
table.calendar {
	border-left: 1px solid #999;
}
tr.calendar-row {
}
td.calendar-day {
	min-height: 80px;
	font-size: 11px;
	position: relative;
	vertical-align: top;
}
* html div.calendar-day {
	height: 80px;
}
td.calendar-day:hover {
	background: #eceff5;
}
td.calendar-day-np {
	background: #eee;
	min-height: 80px;
}
* html div.calendar-day-np {
	height: 80px;
}
td.calendar-day-head {
	background: #ccc;
	font-weight: bold;
	text-align: center;
	width: 120px;
	padding: 5px;
	border-bottom: 1px solid #999;
	border-top: 1px solid #999;
	border-right: 1px solid #999;
}
div.day-number {
	background: #999;
	padding: 5px;
	color: #fff;
	font-weight: bold;
	float: right;
	margin: -5px -5px 0 0;
	width: 20px;
	text-align: center;
}
td.calendar-day, td.calendar-day-np {
	width: 120px;
	padding: 5px;
	border-bottom: 1px solid #999;
	border-right: 1px solid #999;
}
</style>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Mechanic</title>
	<link rel="icon" href="img.png" type="image/gif" sizes="16x16">  
     <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="style5.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
	
	
<link href="jquery-ui.css" rel="stylesheet">
<script src="jquery-1.10.2.js"></script>
<script src="jquery-ui.js"></script>
<!--<script src="lang/datepicker-fi.js"></script>-->
<script>
    $(function() {
	<!--$.datepicker.setDefaults($.datepicker.regional['fi']);-->
    $( "#from" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to" ).datepicker({
      defaultDate: "+1w",
	  regional: "fi",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });  </script>
</head>

<body>

 <div class="wrapper">
        <!-- Sidebar Holder -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Admin</h3>
            </div>

            <ul class="list-unstyled components">                
				<li><a href="index.php"><i class="fas fa-home"></i> Dashboard</a></li>
				<li  class="active"><a href="appointment.php"><i class="fa fa-calendar"></i> Appointment</a></li>
				<li><a href="invoice.php"><i class="fa fa-sticky-note"></i> Invoice</a></li>
				<li><a href="customer.php"><i class="fa fa-user"></i> Client List</a></li>
				<li><a href="service.php"><i class="fa fa-wrench"></i> Services</a></li>
				
				
            </ul>
        </nav>

       
       <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a href="change.php" class="btn">
                        <span class="fa fa-unlock-alt" title="Change Password"></span>
                            </li>
                            <li class="nav-item">
                                <a href="question.php" class="btn">
                        <span class="fa fa-book" title="Security Question"></span>
                            </li>
                         
                            <li class="nav-item">
                                 <a href="logout.php" class="btn">
                        <span class="fas fa-sign-out-alt" title="Logout"></span>
                    </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
			<h1><td>Appointment Calendar</td></h1>
			<?php
					/* draws a calendar */
					function draw_calendar($month,$year){

					include 'config.php';

					// Create connection
					$conn = mysqli_connect($servername, $username, $password,  $dbname);

					// Check connection
					if (!$conn) {
						die("Connection failed: " . mysqli_connect_error());
					}

					/* draw table */
					$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

					/* table headings */
					$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

					/* days and weeks vars now ... */
					$running_day = date('w',mktime(0,0,0,$month,1,$year));
					$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
					$days_in_this_week = 1;
					$day_counter = 0;
					$dates_array = array();

					/* row for week one */
					$calendar.= '<tr class="calendar-row">';

					/* print "blank" days until the first of the current week */
					for($x = 0; $x < $running_day; $x++):
						$calendar.= '<td class="calendar-day-np"> </td>';
						$days_in_this_week++;
					endfor;

					/* keep going with days.... */
					for($list_day = 1; $list_day <= $days_in_month; $list_day++):
						$calendar.= '<td class="calendar-day">';
							/* add in the day number */
							$calendar.= '<div class="day-number">'.$list_day.'</div>';

							/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
							$calendar.= str_repeat('<p> </p>',2);
							$current_epoch = mktime(0,0,0,$month,$list_day,$year);
							
							$sql = "SELECT * 
									FROM $tablename 
									natural join customer
									natural join appointment
									natural join services
									WHERE $current_epoch 
									BETWEEN start_day AND end_day 
									";
										
							$result = mysqli_query($conn, $sql);
							
							if (mysqli_num_rows($result) > 0) {
								// output data of each row
								while($row = mysqli_fetch_assoc($result)) {
									if($row["canceled"] == 1) $calendar .= "<font color=\"grey\"><s>";
									$calendar .="<br>Name: " . $row["ServiceName"] .  "<br>ID: " . $row["id"] . "<br>" . $row["Fullname"] . "<br>" . $row["phone"] . "<br>";
									if($current_epoch == $row["start_day"] AND $current_epoch != $row["end_day"]) {
										$calendar .= "Booking starts: " . sprintf("%02d:%02d", $row["start_time"]/60/60, ($row["start_time"]%(60*60)/60)) . "<br><hr><br>";
									}
									if($current_epoch == $row["start_day"] AND $current_epoch == $row["end_day"]) {
										$calendar .= "Booking starts: " . sprintf("%02d:%02d", $row["start_time"]/60/60, ($row["start_time"]%(60*60)/60)) . "<br>";
									}
									if($current_epoch == $row["end_day"]) {
										$calendar .= "Booking ends: " . sprintf("%02d:%02d", $row["end_time"]/60/60, ($row["end_time"]%(60*60)/60)) . "<br><hr><br>";
									}
									if($current_epoch != $row["start_day"] AND $current_epoch != $row["end_day"]) {
										$calendar .= "Booking: 24h<br><hr><br>";
									}
									if($row["canceled"] == 1) $calendar .= "</s></font>";
								}
							} else {
								$calendar .= "No bookings";
							}
							
						$calendar.= '</td>';
						if($running_day == 6):
							$calendar.= '</tr>';
							if(($day_counter+1) != $days_in_month):
								$calendar.= '<tr class="calendar-row">';
							endif;
							$running_day = -1;
							$days_in_this_week = 0;
						endif;
						$days_in_this_week++; $running_day++; $day_counter++;
					endfor;

					/* finish the rest of the days in the week */
					if($days_in_this_week < 8 AND $days_in_this_week > 1):
						for($x = 1; $x <= (8 - $days_in_this_week); $x++):
							$calendar.= '<td class="calendar-day-np"> </td>';
						endfor;
					endif;

					/* final row */
					$calendar.= '</tr>';

					/* end the table */
					$calendar.= '</table>';

					mysqli_close($conn);

					/* all done, return result */
					return $calendar;
					}

					include 'config.php';

					$d = new DateTime(date("Y-m-d"));
					echo '<h3>' . $months[$d->format('n')-1] . ' ' . $d->format('Y') . '</h3>';
					echo draw_calendar($d->format('m'),$d->format('Y'));

					$d->modify( 'first day of next month' );
					echo '<h3>' . $months[$d->format('n')-1] . ' ' . $d->format('Y') . '</h3>';
					echo draw_calendar($d->format('m'),$d->format('Y'));

					$d->modify( 'first day of next month' );
					echo '<h3>' . $months[$d->format('n')-1] . ' ' . $d->format('Y') . '</h3>';
					echo draw_calendar($d->format('m'),$d->format('Y'));
					
					

					?>
					<div = "row">
					<h3>Appointment</h3>
					<table border="1" cellpadding="5" width="800">
					<tr>
						<td valign="top">
						<form action="book.php" method="post">
							<h3>Make booking</h3>
							<h6>Please select service below :</h6>
							
					<select multiple data-live-search="true" id="select-appointment" name="ServiceName[]" required>
					<?php
					 $sql="SELECT * FROM services";
					 $result = mysqli_query($con, $sql);
					if (mysqli_num_rows($result)) 
					{
						while($row = mysqli_fetch_array($result)) 
						{					
					 ?>
					<option value="<?php echo $row['ServiceId'];?>"><?php echo $row['ServiceName'];?></option>
					<?php
		}
	
	}
	else
	{
		echo "0 result";
	}
 
 
// mysqli_close($connect);
?>


  </select>
  <table>
	<tbody id ="tbody">
	</tbody>
  </table>
							
			<table style="width: 70%">
				<tr>
					<td>Name:</td>
					<td> <select name="name" id="name" class="form-control input-sm">
					<option></option>
						<?php
						include('connect.php');
							$sql="SELECT Fullname, CustomerId FROM `customer`";
							$result = mysqli_query($con,$sql);
							$x = 1;
							if(mysqli_num_rows($result) > 0 )
							{
							while($row = mysqli_fetch_array($result))
							{
						?>
						
						<option value="<?php echo $row['CustomerId']; ?>"><?php echo $row['Fullname']; ?></option>
						<?php
							}
							}
							?>
							
                
						</select></td>
					<td></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Phone:</td>
					<td>
			<input maxlength="20" name="phone" required="" type="text" /></td>
					<td></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Reservation time:</td>
					<td>
			<input id="from" name="start_day" required="" type="text" /></td>
					<td>-</td>
					<td><input id="to" name="end_day" required="" type="text" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td> <select name="start_hour">
			<option selected="selected">00</option>
			<option>01</option>
			<option>02</option>
			<option>03</option>
			<option>04</option>
			<option>05</option>
			<option>06</option>
			<option>07</option>
			<option>08</option>
			<option>09</option>
			<option>10</option>
			<option>11</option>
			<option>12</option>
			<option>13</option>
			<option>14</option>
			<option>15</option>
			<option>16</option>
			<option>17</option>
			<option>18</option>
			<option>19</option>
			<option>20</option>
			<option>21</option>
			<option>22</option>
			<option>23</option>
			</select>:<select name="start_minute">
			<option selected="selected">00</option>
			<option>30</option>
			</select></td>
					<td>&nbsp;</td>
					<td><select name="end_hour">
			<option>00</option>
			<option>01</option>
			<option>02</option>
			<option>03</option>
			<option>04</option>
			<option>05</option>
			<option>06</option>
			<option>07</option>
			<option>08</option>
			<option>09</option>
			<option>10</option>
			<option>11</option>
			<option>12</option>
			<option>13</option>
			<option>14</option>
			<option>15</option>
			<option>16</option>
			<option>17</option>
			<option>18</option>
			<option>19</option>
			<option>20</option>
			<option>21</option>
			<option>22</option>
			<option selected="selected">23</option>
			</select>:<select name="end_minute">
			<option>00</option>
			<option selected="selected">30</option>
			</select></td>
				</tr>
			</table>
			<p>
			<img id="captchaimg3" src="captcha_code_file3.php?rand=<?php echo rand(); ?>" /><br>
			<input id="captcha3" name="captcha3" required="" type="text" /></p>
			<input name="book" type="submit" value="Book" />
		</form>
		</td>
		<td valign="top">
		<h3>Cancel booking</h3>
		<form action="cancel.php" method="post">
			<p></p>
			ID: <input name="id" required="" type="text" /><br />
			<p>
			<img id="captchaimg2" src="captcha_code_file2.php?rand=<?php echo rand(); ?>" /><br>
			<input id="captcha2" name="captcha2" required="" type="text" /></p>
			<p><input name="cancel" type="submit" value="Cancel" /></p>
		</form>
		
		</td>
	</tr>
	<td valign="top">
	<h3>Delete booking</h3>
		<form action="delete.php" method="post">
			<p></p>
			ID: <input name="id" required="" type="text" /><br />
			<p>
			<img id="captchaimg" src="captcha_code_file.php?rand=<?php echo rand(); ?>" /><br>
			<input id="captcha" name="captcha" required="" type="text" /></p>
			<p><input name="delete" type="submit" value="Delete" /></p>
		</form>
		</td>
</table>
 <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
	
	<!--
	<script>
	
		$(document).ready(function(){
			$('#select_appointment').on('change',function (){
				var service = $('#select_appointment :selected').val();
				
				console.log(service);
			});
		});
		
	</script>-->
	
</body>

</html>
