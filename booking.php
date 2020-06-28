<!DOCTYPE html>
<html>

<?php 
  session_start();
 
  include('connect.php');
  if(isset($_SESSION["email"])){
          $stud = $_SESSION["email"];
      }else{
        header('Location:login.php');
      }
?>

<head>
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
				<li><a href=""><i class="fa fa-calendar"></i> Appointment</a></li>
				<li><a href="invoice.php"><i class="fa fa-sticky-note"></i> Invoice</a></li>
				<li class="active"><a href="customer.php"><i class="fa fa-user"></i> Client List</a></li>
				<li><a href="service.php"><i class="fa fa-wrench"></i> Services</a></li>
				<li><a href="#"><i class="fa fa-bars"></i> Report</a></li>
				<li><a href="logout.php"><i class=""></i> Logout</a></li>
            </ul>
        </nav>

        <!-- Page Content Holder -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                    
                </div>
            </nav>
            
           <div class="main_content">
        <div class="header">Welcome!! Have a nice day.</div>  
        <div class="info">

                    <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Appointment Details</h6>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
					  <div class="buttonaddstaff"><input type="submit" value="Add Appointment" onClick="document.location.href='add_booking.php';"></br></div> 
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                          <thead>
                            <tr>
            <th>No.</th>
			<th>Appointment Date</th>
            <th>Customer Name</th>
			<th>Phone Number</th>
  			<th>Service Name</th>
			<th>Appointment Time</th>
            <th>Action</th>  
                            </tr>
                          </thead>
                         
                          <tbody>
                            <?php
                                $sql = "SELECT * FROM bookingcalendar";
          $result = mysqli_query($con,$sql);
          $x = 1;
          if(mysqli_num_rows($result) > 0 )
          {
          while($row = mysqli_fetch_array($result))
          {
                            ?>

                            <form action="" method="post">
          <tr>
            <td><?php echo $x++ ?></td>
			<td><?php echo $row['date_book'];?></td>
           <td><?php echo $row['name'];?></td>
		   <td><?php echo $row['phone'];?></td>
		   <td><?php echo $row['ServiceName'];?></td>
		   <td><?php echo $row['app_time'];?></td>
		   
			  
		   
		   
            
            <input name="id" autofocus required class="input" type="hidden" value="<?php echo $row['id']; ?>">
            
            
            <td><a href="invoice.php?delete=1&id='.$row["id"].'" class="delete">Delete</span></a></td>
          </tr>
          </form>
          <?php
        }
          }
        ?>                          
                          </tbody>
                        </table>
                      </div>
                    </div>
                    </div>
	  
	  
	  
        </div>
    </div>

    
</body>

</html>