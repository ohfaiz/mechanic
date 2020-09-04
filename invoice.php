<?php
session_start();
if(isset($_SESSION["email"])){
          $stud = $_SESSION["email"];
      }else{
        header('Location:login.php');
      }
  //invoice.php  
  include('database_connection.php');

  $statement = $connect->prepare("
    SELECT * FROM invoice 
    NATURAL JOIN customer
    ORDER BY invoice_id DESC
  ");

  $statement->execute();

  $all_result = $statement->fetchAll();

  $total_rows = $statement->rowCount();

  if(isset($_POST["create_invoice"]))
  { 
    $total_before_tax = 0;
    $total_tax1 = 0;
   
    $total_tax = 0;
    $total_after_tax = 0;
    $statement = $connect->prepare("
      INSERT INTO invoice 
        (invoice_no, order_date, CustomerId, receiver_name, total_before_tax, total_tax1, total_tax, total_after_tax, order_datetime,payment_status)
        VALUES (:invoice_no, :order_date, :CustomerId, :receiver_name, :total_before_tax, :total_tax1, :total_tax, :total_after_tax, :order_datetime,:status)
    ");
    $statement->execute(
      array(
          ':invoice_no'               =>  trim($_POST["invoice_no"]),
          ':order_date'             =>  trim($_POST["order_date"]),
          ':status'                 =>  trim($_POST["status"]),
          ':CustomerId'          =>  trim($_POST["CustomerId"]),
          ':receiver_name'       =>  trim($_POST["receiver_name"]),
          ':total_before_tax'       =>  $total_before_tax,
          ':total_tax1'           =>  $total_tax1,
          
          ':total_tax'            =>  $total_tax,
          ':total_after_tax'        =>  $total_after_tax,
          ':order_datetime'           =>  date("Y-m-d")
      )
    );

      $statement = $connect->query("SELECT LAST_INSERT_ID()");
      $invoice_id = $statement->fetchColumn();

      for($count=0; $count<$_POST["total_item"]; $count++)
      {
        $total_before_tax = $total_before_tax + floatval(trim($_POST["item_actual_amount"][$count]));

        $total_tax1 = $total_tax1 + floatval(trim($_POST["item_tax1_amount"][$count]));

       

        $total_after_tax = $total_after_tax + floatval(trim($_POST["item_final_amount"][$count]));

        $statement = $connect->prepare("
          INSERT INTO invoice_item 
          (invoice_id, item_name, item_quantity, item_price, item_actual_amount, item_tax1_rate, item_tax1_amount, item_final_amount)
          VALUES (:invoice_id, :item_name, :item_quantity, :item_price, :item_actual_amount, :item_tax1_rate, :item_tax1_amount, :item_final_amount)
        ");

        $statement->execute(
          array(
            ':invoice_id'               =>  $invoice_id,
            ':item_name'              =>  trim($_POST["item_name"][$count]),
            ':item_quantity'          =>  trim($_POST["item_quantity"][$count]),
            ':item_price'           =>  trim($_POST["item_price"][$count]),
            ':item_actual_amount'       =>  trim($_POST["item_actual_amount"][$count]),
            ':item_tax1_rate'         =>  trim($_POST["item_tax1_rate"][$count]),
            ':item_tax1_amount'       =>  trim($_POST["item_tax1_amount"][$count]),
           
            ':item_final_amount'        =>  trim($_POST["item_final_amount"][$count])
          )
        );
      }
      $total_tax = $total_tax1 ;

      $statement = $connect->prepare("
        UPDATE invoice 
        SET total_before_tax = :total_before_tax, 
        total_tax1 = :total_tax1, 
        
        total_tax = :total_tax, 
        total_after_tax = :total_after_tax 
        WHERE invoice_id = :invoice_id 
      ");
      $statement->execute(
        array(
          ':total_before_tax'     =>  $total_before_tax,
          ':total_tax1'         =>  $total_tax1,
          
          ':total_tax'          =>  $total_tax,
          ':total_after_tax'      =>  $total_after_tax,
          ':invoice_id'             =>  $invoice_id
        )
      );
      header("location:invoice.php");
  }

  if(isset($_POST["update_invoice"]))
  {
    $total_before_tax = 0;
      $total_tax1 = 0;
      
      $total_tax = 0;
      $total_after_tax = 0;
      
      $invoice_id = $_POST["invoice_id"];
      
      
      
      $statement = $connect->prepare("
                DELETE FROM invoice_item WHERE invoice_id = :invoice_id
            ");
            $statement->execute(
                array(
                    ':invoice_id'       =>      $invoice_id
                )
            );
      
      for($count=0; $count<$_POST["total_item"]; $count++)
      {
        $total_before_tax = $total_before_tax + floatval(trim($_POST["item_actual_amount"][$count]));
        $total_tax1 = $total_tax1 + floatval(trim($_POST["item_tax1_amount"][$count]));
       
        $total_after_tax = $total_after_tax + floatval(trim($_POST["item_final_amount"][$count]));
        $statement = $connect->prepare("
          INSERT INTO invoice_item 
          (invoice_id, item_name, item_quantity, item_price, item_actual_amount, item_tax1_rate, item_tax1_amount, item_final_amount) 
          VALUES (:invoice_id, :item_name, :item_quantity, :item_price, :item_actual_amount, :item_tax1_rate, :item_tax1_amount, :item_final_amount)
        ");
        $statement->execute(
          array(
            ':invoice_id'                 =>  $invoice_id,
            ':item_name'                =>  trim($_POST["item_name"][$count]),
            ':item_quantity'          =>  trim($_POST["item_quantity"][$count]),
            ':item_price'            =>  trim($_POST["item_price"][$count]),
            ':item_actual_amount'     =>  trim($_POST["item_actual_amount"][$count]),
            ':item_tax1_rate'         =>  trim($_POST["item_tax1_rate"][$count]),
            ':item_tax1_amount'       =>  trim($_POST["item_tax1_amount"][$count]),
            
            ':item_final_amount'      =>  trim($_POST["item_final_amount"][$count])
          )
        );
        $result = $statement->fetchAll();
      }
      $total_tax = $total_tax1 ;
      
      $statement = $connect->prepare("
        UPDATE invoice 
        SET invoice_no = :invoice_no, 
        order_date = :order_date, 
		    payment_status = :status,
        CustomerId = :CustomerId, 
        receiver_name = :receiver_name, 
        total_before_tax = :total_before_tax, 
        total_tax1 = :total_tax1, 
        
        total_tax = :total_tax, 
        total_after_tax = :total_after_tax 
        WHERE invoice_id = :invoice_id 
      ");
      
      $statement->execute(
        array(
          ':invoice_no'               =>  trim($_POST["invoice_no"]),
          ':order_date'             =>  trim($_POST["order_date"]),
		      ':status'                 =>  trim($_POST["status"]),
          ':CustomerId'        =>  trim($_POST["CustomerId"]),
          ':receiver_name'     =>  trim($_POST["receiver_name"]),
          ':total_before_tax'     =>  $total_before_tax,
          ':total_tax1'          =>  $total_tax1,
          
          ':total_tax'           =>  $total_tax,
          ':total_after_tax'      =>  $total_after_tax,
          ':invoice_id'               =>  $invoice_id
        )
      );
      
      $result = $statement->fetchAll();
            
      header("location:invoice.php");
  }

  if(isset($_GET["delete"]) && isset($_GET["id"]))
  {
    $statement = $connect->prepare("DELETE FROM invoice WHERE invoice_id = :id");
    $statement->execute(
      array(
        ':id'       =>      $_GET["id"]
      )
    );
    $statement = $connect->prepare(
      "DELETE FROM invoice_item WHERE invoice_id = :id");
    $statement->execute(
      array(
        ':id'       =>      $_GET["id"]
      )
    );
    header("location:invoice.php");
  }

  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Mechanic</title>
	<link rel="icon" href="img.png" type="image/gif" sizes="16x16">  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js-datatable/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	
	<!-- CSS only -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<!-- JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
   
 <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="style5.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <style>
      /* Remove the navbar's default margin-bottom and rounded borders */ 
      .navbar {
      margin-bottom: 4px;
      border-radius: 0;
      }
      /* Add a gray background color and some padding to the footer */
      footer {
      background-color: #f2f2f2;
      padding: 25px;
      }
      .carousel-inner img {
      width: 100%; /* Set width to 100% */
      margin: auto;
      min-height:200px;
      }
      .navbar-brand
      {
      padding:5px 40px;
      }
      .navbar-brand:hover
      {
      background-color:#ffffff;
      }
      /* Hide the carousel text when the screen is less than 600 pixels wide */
      @media (max-width: 600px) {
      .carousel-caption {
      display: none; 
      }
      }
    </style>
  </head>
  <body>
    <style>
      .box
      {
      width: 100%;
      max-width: 1390px;
      border-radius: 5px;
      border:1px solid #ccc;
      padding: 15px;
      margin: 0 auto;                
      margin-top:50px;
      box-sizing:border-box;
      }
    </style>
   <!--  <script src="js/bootstrap-datepicker1.js"></script>
	<script src = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
      $(document).ready(function(){
        $('#order_date').datepicker({
          format: "yyyy-mm-dd",
          autoclose: true
        });
      });
    </script> -->
  
    
	
	<div class="wrapper">
        <!-- Sidebar Holder -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Admin</h3>
            </div>

            <ul class="list-unstyled components">                
				<li><a href="index.php"><i class="fas fa-home"></i> Dashboard</a></li>
				<li><a href="appointment.php"><i class="fa fa-calendar"></i> Appointment</a></li>
				<li class="active"><a href="invoice.php"><i class="fa fa-sticky-note"></i> Invoice</a></li>
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
                                 <a href="logout.php" class="btn btn">
                        <span class="fas fa-sign-out-alt" title="Logout"></span>
                    </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            
			
            
			
        
	
    <div class="container-fluid">
      <?php
      if(isset($_GET["add"]))
      {
      ?>
      <form method="post" id="invoice_form">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tr>
              <td colspan="2" align="center"><h2 style="margin-top:10.5px">Create Invoice</h2></td>
            </tr>
            <tr>
                <td colspan="2">
                  <div class="row">
                    <div class="col-md-8">
                      To,<br />
                        <b>RECEIVER (BILL TO)</b><br />
						
              <?php
              include('connect.php');
              $name = "";
              $display = "SELECT CustomerId, Fullname FROM `customer`";
              $result = mysqli_query ($con, $display) or die (mysqli_error($con));

              date_default_timezone_set('Asia/Kuala_Lumpur');
              $time = date("H:i");
              $date = date('Y-m-d');

              while($row = mysqli_fetch_assoc($result)){
                $name .="<option value = '{$row['CustomerId']}' > {$row['Fullname']} </option>";
              } 
              ?>

						<select name="CustomerId" id="CustomerId" class="form-control input-sm">	
              <?php echo $name?>
						</select>
						
                       Mohd Abd Hadi Vejaya Bin Hj Saripan,<br />
                        <b>RECEIVER (BILL TO)</b><br />
                    </div>
                    <div class="col-md-4">
                      Reverse Charge<br />
                      <input type="text" name="invoice_no" id="invoice_no" class="form-control input-sm" value="<?php echo uniqid();?>" readonly />
                      <input type="text" name="order_date" id="order_date" value="<?php echo $date;?>" class="form-control input-sm" readonly/>
                      <input type="text" name="status" id="status" class="form-control input-sm" readonly value="Unpaid" />
                    </div>
                  </div>
                  <br />
                  <table id="invoice-item-table" class="table table-bordered">
                    <tr>
                      <th width="7%">Sr No.</th>
                      <th width="20%">Item Name</th>
                      <th width="5%">Quantity</th>
                      <th width="5%">Price</th>
                      <th width="10%">Actual Amt.</th>
                      <th width="12.5%" colspan="2">Tax1 (%)</th>
                      <th width="12.5%" rowspan="2">Total</th>
                      <th width="3%" rowspan="2"></th>
                    </tr>
                    <tr>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th>Rate</th>
                      <th>Amt.</th>
                    </tr>
                    <tr>
                      <td><span id="sr_no">1</span></td>
                      <td><input type="text" name="item_name[]" id="item_name1" class="form-control input-sm" /></td>
                      <td><input type="text" name="item_quantity[]" id="item_quantity1" data-srno="1" class="form-control input-sm item_quantity" /></td>
                      <td><input type="text" name="item_price[]" id="item_price1" data-srno="1" class="form-control input-sm number_only item_price" /></td>
                      <td><input type="text" name="item_actual_amount[]" id="item_actual_amount1" data-srno="1" class="form-control input-sm item_actual_amount" readonly /></td>
                      <td><input type="text" name="item_tax1_rate[]" id="item_tax1_rate1" data-srno="1" class="form-control input-sm number_only item_tax1_rate" /></td>
                      <td><input type="text" name="item_tax1_amount[]" id="item_tax1_amount1" data-srno="1" readonly class="form-control input-sm item_tax1_amount" /></td>
                      
                      <td><input type="text" name="item_final_amount[]" id="item_final_amount1" data-srno="1" readonly class="form-control input-sm item_final_amount" /></td>
                      <td></td>
                    </tr>
                  </table>
                  <div align="right">
                    <button type="button" name="add_row" id="add_row" class="btn btn-success btn-xs">+</button>
                  </div>
                </td>
              </tr>
              <tr>
                <td align="right"><b>Total</td>
                <td align="right"><b><span id="final_total_amt"></span></b></td>
              </tr>
              <tr>
                <td colspan="2"></td>
              </tr>
              <tr>
                <td colspan="2" align="center">
                  <input type="hidden" name="total_item" id="total_item" value="1" />
                  <input type="submit" name="create_invoice" id="create_invoice" class="btn btn-info" value="Create" />
                </td>
              </tr>
          </table>
        </div>
      </form>
      <script>
      $(document).ready(function(){
        var final_total_amt = $('#final_total_amt').text();
        var count = 1;
        
        $(document).on('click', '#add_row', function(){
          count++;
          $('#total_item').val(count);
          var html_code = '';
          html_code += '<tr id="row_id_'+count+'">';
          html_code += '<td><span id="sr_no">'+count+'</span></td>';
          
          html_code += '<td><input type="text" name="item_name[]" id="item_name'+count+'" class="form-control input-sm" /></td>';
          
          html_code += '<td><input type="text" name="item_quantity[]" id="item_quantity'+count+'" data-srno="'+count+'" class="form-control input-sm number_only item_quantity" /></td>';
          html_code += '<td><input type="text" name="item_price[]" id="item_price'+count+'" data-srno="'+count+'" class="form-control input-sm number_only item_price" /></td>';
          html_code += '<td><input type="text" name="item_actual_amount[]" id="item_actual_amount'+count+'" data-srno="'+count+'" class="form-control input-sm item_actual_amount" readonly /></td>';
          
          html_code += '<td><input type="text" name="item_tax1_rate[]" id="item_tax1_rate'+count+'" data-srno="'+count+'" class="form-control input-sm number_only item_tax1_rate" /></td>';
          html_code += '<td><input type="text" name="item_tax1_amount[]" id="item_tax1_amount'+count+'" data-srno="'+count+'" readonly class="form-control input-sm item_tax1_amount" /></td>';
          
          html_code += '<td><input type="text" name="item_final_amount[]" id="item_final_amount'+count+'" data-srno="'+count+'" readonly class="form-control input-sm item_final_amount" /></td>';
          html_code += '<td><button type="button" name="remove_row" id="'+count+'" class="btn btn-danger btn-xs remove_row">X</button></td>';
          html_code += '</tr>';
          $('#invoice-item-table').append(html_code);
        });
        
        $(document).on('click', '.remove_row', function(){
          var row_id = $(this).attr("id");
          var total_item_amount = $('#item_final_amount'+row_id).val();
          var final_amount = $('#final_total_amt').text();
          var result_amount = parseFloat(final_amount) - parseFloat(total_item_amount);
          $('#final_total_amt').text(result_amount);
          $('#row_id_'+row_id).remove();
          count--;
          $('#total_item').val(count);
        });

        function cal_final_total(count)
        {
          var final_item_total = 0;
          for(j=1; j<=count; j++)
          {
            var quantity = 0;
            var price = 0;
            var actual_amount = 0;
            var tax1_rate = 0;
            var tax1_amount = 0;
            
            var item_total = 0;
            quantity = $('#item_quantity'+j).val();
            if(quantity > 0)
            {
              price = $('#item_price'+j).val();
              if(price > 0)
              {
                actual_amount = parseFloat(quantity) * parseFloat(price);
                $('#item_actual_amount'+j).val(actual_amount);
                tax1_rate = $('#item_tax1_rate'+j).val();
                if(tax1_rate > 0)
                {
                  tax1_amount = parseFloat(actual_amount)*parseFloat(tax1_rate)/100;
                  $('#item_tax1_amount'+j).val(tax1_amount);
                }
               
                item_total = parseFloat(actual_amount) + parseFloat(tax1_amount);
                final_item_total = parseFloat(final_item_total) + parseFloat(item_total);
                $('#item_final_amount'+j).val(item_total);
              }
            }
          }
          $('#final_total_amt').text(final_item_total);
        }

        $(document).on('blur', '.item_price', function(){
          cal_final_total(count);
        });

        $(document).on('blur', '.item_tax1_rate', function(){
          cal_final_total(count);
        });

       

        $('#create_invoice').click(function(){
          if($.trim($('#CustomerId').val()).length == 0)
          {
            alert("Please Select Reciever Name");
            return false;
          }

          if($.trim($('#invoice_no').val()).length == 0)
          {
            alert("Please Enter Invoice Number");
            return false;
          }

          if($.trim($('#order_date').val()).length == 0)
          {
            alert("Please Select Invoice Date");
            return false;
          }

          for(var no=1; no<=count; no++)
          {
            if($.trim($('#item_name'+no).val()).length == 0)
            {
              alert("Please Enter Item Name");
              $('#item_name'+no).focus();
              return false;
            }

            if($.trim($('#item_quantity'+no).val()).length == 0)
            {
              alert("Please Enter Quantity");
              $('#item_quantity'+no).focus();
              return false;
            }

            if($.trim($('#item_price'+no).val()).length == 0)
            {
              alert("Please Enter Price");
              $('#item_price'+no).focus();
              return false;
            }

          }

          $('#invoice_form').submit();

        });

      });
      </script>
      <?php
      }
      elseif(isset($_GET["update"]) && isset($_GET["id"]))
      {
        $statement = $connect->prepare("
          SELECT * FROM invoice 
          NATURAL JOIN customer
            WHERE invoice_id = :invoice_id
            LIMIT 1
        ");
        $statement->execute(
          array(
            ':invoice_id'       =>  $_GET["id"]
            )
          );
        $result = $statement->fetchAll();
        foreach($result as $row)
        {
        ?>
        <script>
        $(document).ready(function(){
          $('#invoice_no').val("<?php echo $row["invoice_no"]; ?>");
          $('#order_date').val("<?php echo $row["order_date"]; ?>");
          $('#status').val("<?php echo $row["payment_status"]; ?>");
          $('#CustomerId').val("<?php echo $row["CustomerId"]; ?>");
          $('#Fullname').val("<?php echo $row["Fullname"]; ?>");
          $('#receiver_name').val("<?php echo $row["receiver_name"]; ?>");
        });
        </script>
        <form method="post" id="invoice_form">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tr>
              <td colspan="2" align="center"><h2 style="margin-top:10.5px">Edit Invoice</h2></td>
            </tr>
            <tr>
                <td colspan="2">
                  <div class="row">
                    <div class="col-md-8">
                      To,<br />
                        <b>RECEIVER (BILL TO)</b><br />                        
                        <input type="hidden" name="CustomerId" id="CustomerId" class="form-control input-sm" placeholder="Enter Receiver Name" readonly/>
                        <input type="text" name="Fullnamme" id="Fullname" class="form-control input-sm" placeholder="Enter Receiver Name" readonly/>
                        Mohd Abd Hadi Vejaya Bin Hj Saripan,<br />
                        <b>RECEIVER (BILL TO)</b><br />
                    </div>
                    <div class="col-md-4">
                      Reverse Charge<br />
                      <input type="text" name="invoice_no" id="invoice_no" class="form-control input-sm" placeholder="Enter Invoice No." />
                      <input type="text" name="order_date" id="order_date" class="form-control input-sm" readonly placeholder="Select Invoice Date" />
					  <select name="status" id="status" class="form-control input-sm" required>
					  <option value="Unpaid">Unpaid</option>
					  <option value="Paid">Paid</option>
					  </select>
                    </div>
                  </div>
                  <br />
                  <table id="invoice-item-table" class="table table-bordered">
                    <tr>
                      <th width="7%">Sr No.</th>
                      <th width="20%">Item Name</th>
                      <th width="5%">Quantity</th>
                      <th width="5%">Price</th>
                      <th width="10%">Actual Amt.</th>
                      <th width="12.5%" colspan="2">Tax1 (%)</th>
                      
                      <th width="12.5%" rowspan="2">Total</th>
                      <th width="3%" rowspan="2"></th>
                    </tr>
                    <tr>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th>Rate</th>
                      <th>Amt.</th>
               
                    </tr>
                    <?php
                    $statement = $connect->prepare("
                      SELECT * FROM invoice_item 
                      WHERE invoice_id = :invoice_id
                    ");
                    $statement->execute(
                      array(
                        ':invoice_id'       =>  $_GET["id"]
                      )
                    );
                    $item_result = $statement->fetchAll();
                    $m = 0;
                    foreach($item_result as $sub_row)
                    {
                      $m = $m + 1;
                    ?>
                    <tr>
                      <td><span id="sr_no"><?php echo $m; ?></span></td>
                      <td><input type="text" name="item_name[]" id="item_name<?php echo $m; ?>" class="form-control input-sm" value="<?php echo $sub_row["item_name"]; ?>" /></td>
                      <td><input type="text" name="item_quantity[]" id="item_quantity<?php echo $m; ?>" data-srno="<?php echo $m; ?>" class="form-control input-sm item_quantity" value = "<?php echo $sub_row["item_quantity"]; ?>"/></td>
                      <td><input type="text" name="item_price[]" id="item_price<?php echo $m; ?>" data-srno="<?php echo $m; ?>" class="form-control input-sm number_only item_price" value="<?php echo $sub_row["item_price"]; ?>" /></td>
                      <td><input type="text" name="item_actual_amount[]" id="item_actual_amount<?php echo $m; ?>" data-srno="<?php echo $m; ?>" class="form-control input-sm item_actual_amount" value="<?php echo $sub_row["item_actual_amount"];?>" readonly /></td>
                      <td><input type="text" name="item_tax1_rate[]" id="item_tax1_rate<?php echo $m; ?>" data-srno="<?php echo $m; ?>" class="form-control input-sm number_only item_tax1_rate" value="<?php echo $sub_row["item_tax1_rate"]; ?>" /></td>
                      <td><input type="text" name="item_tax1_amount[]" id="item_tax1_amount<?php echo $m; ?>" data-srno="<?php echo $m; ?>" readonly class="form-control input-sm item_tax1_amount" value="<?php echo $sub_row["item_tax1_amount"];?>" /></td>
                     
                      <td><input type="text" name="item_final_amount[]" id="item_final_amount<?php echo $m; ?>" data-srno="<?php echo $m; ?>" readonly class="form-control input-sm item_final_amount" value="<?php echo $sub_row["item_final_amount"]; ?>" /></td>
                      <td></td>
                    </tr>
                    <?php
                    }
                    ?>
                  </table>
                </td>
              </tr>
              <tr>
                <td align="right"><b>Total</td>
                <td align="right"><b><span id="final_total_amt"><?php echo $row["total_after_tax"]; ?></span></b></td>
              </tr>
              <tr>
                <td colspan="2"></td>
              </tr>
              <tr>
                <td colspan="2" align="center">
                  <input type="hidden" name="total_item" id="total_item" value="<?php echo $m; ?>" />
                  <input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo $row["invoice_id"]; ?>" />
                  <input type="submit" name="update_invoice" id="create_invoice" class="btn btn-info" value="Edit" />
                </td>
              </tr>
          </table>
        </div>
      </form>
      <script>
      $(document).ready(function(){
        var final_total_amt = $('#final_total_amt').text();
        var count = "<?php echo $m; ?>";
        
        $(document).on('click', '#add_row', function(){
          count++;
          $('#total_item').val(count);
          var html_code = '';
          html_code += '<tr id="row_id_'+count+'">';
          html_code += '<td><span id="sr_no">'+count+'</span></td>';
          
          html_code += '<td><input type="text" name="item_name[]" id="item_name'+count+'" class="form-control input-sm" /></td>';
          
          html_code += '<td><input type="text" name="item_quantity[]" id="item_quantity'+count+'" data-srno="'+count+'" class="form-control input-sm number_only item_quantity" /></td>';
          html_code += '<td><input type="text" name="item_price[]" id="item_price'+count+'" data-srno="'+count+'" class="form-control input-sm number_only item_price" /></td>';
          html_code += '<td><input type="text" name="item_actual_amount[]" id="item_actual_amount'+count+'" data-srno="'+count+'" class="form-control input-sm item_actual_amount" readonly /></td>';
          
          html_code += '<td><input type="text" name="item_tax1_rate[]" id="item_tax1_rate'+count+'" data-srno="'+count+'" class="form-control input-sm number_only item_tax1_rate" /></td>';
          html_code += '<td><input type="text" name="item_tax1_amount[]" id="item_tax1_amount'+count+'" data-srno="'+count+'" readonly class="form-control input-sm item_tax1_amount" /></td>';
         
          html_code += '<td><input type="text" name="item_final_amount[]" id="item_final_amount'+count+'" data-srno="'+count+'" readonly class="form-control input-sm item_final_amount" /></td>';
          html_code += '<td><button type="button" name="remove_row" id="'+count+'" class="btn btn-danger btn-xs remove_row">X</button></td>';
          html_code += '</tr>';
          $('#invoice-item-table').append(html_code);
        });
        
        $(document).on('click', '.remove_row', function(){
          var row_id = $(this).attr("id");
          var total_item_amount = $('#item_final_amount'+row_id).val();
          var final_amount = $('#final_total_amt').text();
          var result_amount = parseFloat(final_amount) - parseFloat(total_item_amount);
          $('#final_total_amt').text(result_amount);
          $('#row_id_'+row_id).remove();
          count--;
          $('#total_item').val(count);
        });

        function cal_final_total(count)
        {
          var final_item_total = 0;
          for(j=1; j<=count; j++)
          {
            var quantity = 0;
            var price = 0;
            var actual_amount = 0;
            var tax1_rate = 0;
            var tax1_amount = 0;
           
            var item_total = 0;
            quantity = $('#item_quantity'+j).val();
            if(quantity > 0)
            {
              price = $('#item_price'+j).val();
              if(price > 0)
              {
                actual_amount = parseFloat(quantity) * parseFloat(price);
                $('#item_actual_amount'+j).val(actual_amount);
                tax1_rate = $('#item_tax1_rate'+j).val();
                if(tax1_rate > 0)
                {
                  tax1_amount = parseFloat(actual_amount)*parseFloat(tax1_rate)/100;
                  $('#item_tax1_amount'+j).val(tax1_amount);
                }
               
                item_total = parseFloat(actual_amount) + parseFloat(tax1_amount);
                final_item_total = parseFloat(final_item_total) + parseFloat(item_total);
                $('#item_final_amount'+j).val(item_total);
              }
            }
          }
          $('#final_total_amt').text(final_item_total);
        }

        $(document).on('blur', '.item_price', function(){
          cal_final_total(count);
        });

        $(document).on('blur', '.item_tax1_rate', function(){
          cal_final_total(count);
        });

        

        $('#create_invoice').click(function(){
          if($.trim($('#CustomerId').val()).length == 0)
          {
            alert("Please Enter Reciever Name");
            return false;
          }

          if($.trim($('#invoice_no').val()).length == 0)
          {
            alert("Please Enter Invoice Number");
            return false;
          }

          if($.trim($('#order_date').val()).length == 0)
          {
            alert("Please Select Invoice Date");
            return false;
          }

          for(var no=1; no<=count; no++)
          {
            if($.trim($('#item_name'+no).val()).length == 0)
            {
              alert("Please Enter Item Name");
              $('#item_name'+no).focus();
              return false;
            }

            if($.trim($('#item_quantity'+no).val()).length == 0)
            {
              alert("Please Enter Quantity");
              $('#item_quantity'+no).focus();
              return false;
            }

            if($.trim($('#item_price'+no).val()).length == 0)
            {
              alert("Please Enter Price");
              $('#item_price'+no).focus();
              return false;
            }

          }

          $('#invoice_form').submit();

        });

      });
      </script>
        <?php 
        }
      }
      else
      {
      ?>
      <h3>Invoice</h3>

      <br />
      <div align="right">
        <a href="invoice.php?add=1" class="btn btn-info btn-xs">Create</a>
      </div>
      <br />
      <table id="data-table" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Invoice No.</th>
            <th>Invoice Date</th>
            <th>Receiver Name</th>
            <th>Invoice Total</th>
            <th>Status</th>
            <th>PDF</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
        <?php
        if($total_rows > 0)
        {
          foreach($all_result as $row)
          {
            echo '
              <tr>
                <td>'.$row["invoice_no"].'</td>
                <td>'.$row["order_date"].'</td>
                <td>'.$row["Fullname"].'</td>
                <td>'.$row["total_after_tax"].'</td>
                <td>'.$row["payment_status"].'</td>
                <td><a href="print_invoice.php?pdf=1&id='.$row["invoice_id"].'">PDF</a></td>
                <td><a href="invoice.php?update=1&id='.$row["invoice_id"].'">Edit</a></td>
                <td><a href="invoice.php?delete=1&id='.$row["invoice_id"].'" class="delete">Delete</span></a></td>
              </tr>
            ';
          }
        }
        ?>
      </table>
      <?php
      }
      ?>
    </div>
    <br>
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
<script type="text/javascript">
  $(document).ready(function(){
    var table = $('#data-table').DataTable({
          "order":[],
          "columnDefs":[
          {
            "targets":[4, 5, 6],
            "orderable":false,
          },
        ],
        "pageLength": 25
        });
    $(document).on('click', '.delete', function(){
      var id = $(this).attr("id");
      if(confirm("Are you sure you want to remove this?"))
      {
        window.location.href="invoice.php?delete=1&id="+id;
      }
      else
      {
        return false;
      }
    });
  });

</script>

<script>
$(document).ready(function(){
$('.number_only').keypress(function(e){
return isNumbers(e, this);      
});
function isNumbers(evt, element) 
{
var charCode = (evt.which) ? evt.which : event.keyCode;
if (
(charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
(charCode < 48 || charCode > 57))
return false;
return true;
}
});
</script>


