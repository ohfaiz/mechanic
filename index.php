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
				<li class="active"><a href="index.php"><i class="fas fa-home"></i> Dashboard</a></li>
				<li><a href="appointment.php"><i class="fa fa-calendar"></i> Appointment</a></li>
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
			<div class="container"
				<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
				<script type="text/javascript">
				  // google.charts.load("current", {packages:["corechart"]});
				  // google.charts.setOnLoadCallback(drawChart);
				  // function drawChart() {
					// var data = google.visualization.arrayToDataTable([
					  // ['Status', 'Total'],
					 // <?php
									
						// $st = "";
						// $rt = mysqli_query($con,$st) or die (mysqli_error($con));

						// while($rowwt = mysqli_fetch_assoc($rt))
						// {
							// ?>

							// ["<?php echo $rowwt['Status']?>", <?php echo $rowwt['TS']?>], 
							// <?php
						// }
					  // ?>
					// ]);

					// var options = {
					  // title: 'Total Student for each Status',
					  // is3D: true,
					// };

					// var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
					// chart.draw(data, options);
				  // }
				</script>
				
				
				
			<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Total Profit'],
							<?php  
						  
						  
                          $sqlc = "SELECT * FROM `profit`";
							$resultc= mysqli_query($con,$sqlc);

							if(mysqli_num_rows($resultc) > 0 )
							{
								while($rowc = mysqli_fetch_array($resultc))
							{ 
								echo "['".$rowc["Month"]."', ".$rowc["TotalAmount"]."],";  
							} 
							}
							?>  
        ]);

        var options = {
          title: 'Profit',
          hAxis: {title: 'Month',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>	
			
	
			
				<div class="row">
				
				
					<div class="col-xl-3 col-sm-6 py-2">
                            <div class="card text-white bg-secondary h-100">
                                <div class="card-body bg-secondary">
                                    <div class="rotate">
                                        <i class="fa fa-user fa-4x"></i>
                                    </div>
                                    <?php
                                        $sqlcat = "SELECT * FROM `totalcat`";
                                        $resultcat= mysqli_query($con,$sqlcat);

                                        if(mysqli_num_rows($resultcat) > 0 )
                                        {
                                        while($rowcat = mysqli_fetch_array($resultcat))
                                        {
                                    ?> 
                                    <h6 class="text-uppercase">Total Customer </h6>
									<p class="text-white">by current month</p>
                                    <h1 class="display-4"><?php echo $rowcat['TOTALCAT'];?></h1>
                                    <?php
                                        }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
						
						<div class="col-xl-3 col-sm-6 py-2">
                            <div class="card text-white bg-secondary h-100">
                                <div class="card-body bg-secondary">
                                    <div class="rotate">
                                        <i class="fa fa-user fa-4x"></i>
                                    </div>
                                    <?php
                                        $sqlc = "SELECT * FROM `cust`";
                                        $resultc= mysqli_query($con,$sqlc);

                                        if(mysqli_num_rows($resultc) > 0 )
                                        {
                                        while($rowc = mysqli_fetch_array($resultc))
                                        {
                                    ?> 
                                    <h6 class="text-uppercase">Total Customer </h6>
									<p class="text-white">by current year</p>
                                    <h1 class="display-4"><?php echo $rowc['TOTALCAT'];?></h1>
                                    <?php
                                        }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
						
						<div class="col-xl-3 col-sm-6 py-2">
                            <div class="card text-white bg-info h-100">
                                <div class="card-body bg-info">
                                    <div class="rotate">
                                        <i class="fa fa-calendar fa-4x"></i>
                                    </div>
                                    <?php
                                        $sqlcat = "SELECT COUNT(appointment_id) AS 'TOTALAPP'
                                                FROM appointment";
                                        $resultcat= mysqli_query($con,$sqlcat);

                                        if(mysqli_num_rows($resultcat) > 0 )
                                        {
                                        while($rowcat = mysqli_fetch_array($resultcat))
                                        {
                                    ?> 
                                    <h6 class="text-uppercase">Total Appointment</h6><br/><br/>
                                    <h1 class="display-4"><?php echo $rowcat['TOTALAPP'];?></h1>
                                    <?php
                                        }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
						
						<div class="col-xl-3 col-sm-6 py-2">
                            <div class="card text-white bg-info h-100">
                                <div class="card-body bg-info">
                                    <div class="rotate">
                                        <i class="fa fa-calendar fa-4x"></i>
                                    </div>
                                    <?php
                                        $sqlapp = "SELECT * FROM `totalapp`";
										
                                        $resultapp= mysqli_query($con,$sqlapp);

                                        if(mysqli_num_rows($resultapp) > 0 )
                                        {
                                        while($rowapp = mysqli_fetch_array($resultapp))
                                        {
                                    ?> 
                                    <h6 class="text-uppercase">Total Appointment </h6>
									<p class="text-white">by current month</p>
                                    <h1 class="display-4"><?php echo $rowapp['DATE'];?></h1>
                                    <?php
                                        }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
						
                    </div>
				
				
				<br/>
				<div class="row">
					<div class="col-md-12"  id="chart_div" style="width: 550px; height: 350px;"></div>
				</div><br/>
				
			
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
	
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ['ServiceName', 'Total'],
          <?php

            $se = "SELECT * FROM `servicecount`";
            $re = mysqli_query($con,$se) or die (mysqli_error($con));
                        
            while($rowwe = mysqli_fetch_assoc($re))
            {
                ?>

                ["<?php echo $rowwe['ServiceName']?>", <?php echo $rowwe['ServiceCount']?>],
                <?php
            }
          ?>
        ]);

        var options = {
          title: 'Chess opening moves',
          width: 900,
          legend: { position: 'none' },
          chart: { title: 'Top pick by service',
                   subtitle: 'popularity by percentage' },
          bars: 'vertical', // Required for Material Bar Charts.
          axes: {
            x: {
              0: { side: 'top', label: 'Percentage'} // Top x-axis.
            }
          },
          bar: { groupWidth: "90%" }
        };

        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        chart.draw(data, options);
      };
    </script>
	<div id="top_x_div" style="height: 400px;"></div>
	</br>
			<div class="row">
<div class = "col-sm-1"></div>
<div class = "col-md-12">
<div class="card shadow  mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-dark">Appointment List</h6>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table  bg-info table-bordered" id="dataTable" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Phone Number</th>
                              <th>Start day</th>
							  <th>End day</th>
                              <th>Start time</th>
                              <th>End time</th>
                            </tr>
                          </thead>
                          
                          <tbody>
                            <?php
                                $sql = "SELECT * FROM `appointments`";
                                $result = mysqli_query($con,$sql);
                                $x = 1;
                                if(mysqli_num_rows($result) > 0 )
                                {
                                while($row = mysqli_fetch_array($result))
                                {

                                  
                            ?>

                            <tr>
                              
                              <td><?php echo $row['Fullname'];?></td>
							  <td><?php echo $row['phone'];?></td>
							  <td><?php echo $row['STARTDATE'];?></td>
							  <td><?php echo $row['ENDDATE'];?></td>
							  <td><?php echo $row['STARTTIME'];?></td>
							  <td><?php echo $row['ENDTIME'];?></td>
                              
                            </tr> 

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
