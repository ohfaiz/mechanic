<!DOCTYPE html>
<html>

<?php 
session_start();
if(isset($_SESSION["email"])){
          $stud = $_SESSION["email"];
      }else{
        header('Location:login.php');
      }
  
 
  include('connect.php');
?>

 <?php
    if(isset($_POST['update'])){

	  
      $Price = $_POST['Price'];
	  $ServiceId =$_POST['ServiceId'];
	  
	  
	  
	  
	  $sql = "CALL updateservices('$Price','$ServiceId')"; 
	  $execute = mysqli_query ($con,$sql) or die (mysqli_error ($con));
	  
      if(isset($update)){
        echo '<script language="javascript">';
        echo 'alert("Update Success");';
        echo 'window.location.href="service.php";';
        echo '</script>';
      }else{
        echo '<script language="javascript">';
        echo 'alert("Update Success");';
        echo 'window.location.href="service.php";';
        echo '</script>';
      }

      

     
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
				<li><a href="appointment.php"><i class="fa fa-calendar"></i> Appointment</a></li>
				<li><a href="invoice.php"><i class="fa fa-sticky-note"></i> Invoice</a></li>
				<li><a href="customer.php"><i class="fa fa-user"></i> Client List</a></li>
				<li class="active"><a href="service.php"><i class="fa fa-wrench"></i> Services</a></li>
				
				
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
            
           <div class="main_content">
        <div class="header">Welcome!! Have a nice day.</div>  
        <div class="info">

                    <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Service Details</h6>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
					  <div class="buttonaddstaff"><input type="submit" value="Add Services" onClick="document.location.href='add_service.php';"></br></div> 
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                              <th>No.</th>
            <th>Service Name</th>
            <th>Description</th>
			<th>Price</th>
            <th>Action</th>  
                            </tr>
                          </thead>
                         
                          <tbody>
                            <?php
                                $sql = "SELECT * FROM services";
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
           <td><?php echo $row['ServiceName'];?></td>
		   <td><?php echo $row['Description'];?></td>
		   <td><input type="text" name="Price" value="<?php echo $row['Price'];?>" /></td>
            
            <input name="ServiceId" autofocus required class="input" type="hidden" value="<?php echo $row['ServiceId']; ?>">
            
            
            <td><input type="submit" name="update" value="Update"></td>
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
<!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<!-- Custom styles for this page -->
  <link href="js-datatable/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Page level plugins -->
    <script src="js-datatable/jquery.dataTables.min.js"></script>
    <script src="js-datatable/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js-datatable/datatables-demo.js"></script>
	
	 <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
    
</body>

</html>
