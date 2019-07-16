<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">


<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<body>

  <div class="container-scroller">

<?php 
include("includes/header.php"); 
$message = $_GET['status'];

if (isset($_POST['regionselect'])){

    $region = $_POST['regionselect'];
    $employee = $_POST['employeeSelect'];
    $date = $_POST['dateinput'];
    $amount = $_POST['amount'];
    $currency = $_POST['currencyselect'];
    $dscription = $_POST['description'];
    $transactionid = $_POST['transactionid'];
    $paymenttype = $_POST['paymenttypeselect'];
    $paymentMonth = $_POST['monthPayment'];
    $paymentYear = $_POST['yearPayment'];

    $resultInsert = insertAccountsRecord($region, $employee, $date, $amount, $currency, $dscription, $transactionid, $paymenttype,$paymentMonth,$paymentYear);

    if ($resultInsert == true){

        echo "<script>alert('Record Inserted!')</script>";

    }else{
        echo "<script>alert('Error in Insertion!')</script>";
    }

}else if (isset($_GET['editstatus'])){

    if ($_GET['editstatus']=="done"){

        echo "<script>alert('Record Updated!')</script>";   

    }else{

        echo "<script>alert('Error in Editing!')</script>";

    }

}else if (isset($_GET['delstatus'])){

  if ($_GET['delstatus']=="done"){

      echo "<script>alert('Record Deleted!')</script>";   

  }else{

      echo "<script>alert('Error in Deleting!')</script>";

  }

}else if (isset($_GET['addpstatus'])){
  
  if ($_GET['addpstatus']=="done"){

    echo "<script>alert('Payment Type Added!')</script>";   

}else{

    echo "<script>alert('Error in Insertion!')</script>";

}
}else if (isset($_GET['importstatus'])){

  if ($_GET['importstatus']=="done"){
    echo "<script>alert('Data Importing Successful!')</script>";
  }else{
    echo "<script>alert('Error in Importing!')</script>";
  }

}

$employees = getAllEmployees();

$locations = getAllLocations();

$paymentTypes = getPaymentTypes();

if (isset($_GET['calltype'])){

$calltype = $_GET['calltype'];

if ($calltype=="all"){

  $accounts = getAllAccounts();

}else if ($calltype="daterange"){

  try{
  $startDate = $_POST['startdate'];
  $endDate = $_POST['enddate'];

  $accounts = getAllAccountsOnDateRange($startDate, $endDate);

  }catch(Exception $error){
    echo "alert('Invalid Date Range!')";
    $accounts = getAllAccounts();
  }

}else{

  $accounts = getAllAccounts();

}
}else{
  $accounts = getAllAccounts();
}

?>

    <div class="container-fluid page-body-wrapper">

    <?php include("includes/sidebar.php"); 
    
    if (strtolower($_SESSION["role"])!="super admin"){
      echo "<div class='col-md-8 grid-margin stretch-card' style='padding:75px;'><h3>Unauthorized Access!</h3></div>";exit;
      }
    
    ?>

      <div class="main-panel">
        <div class="content-wrapper">


        <div class="row">
        
        <div class="col-md-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h3>Add Accounts Record</h3>
                  <p class="card-description">
                    Record Payments
                  </p>


                <div class="card" style="background: #fcfcfc; padding: 15px;" id = "singleform">

                <form class = "custform" method="post" action="#">

                    <fieldset>

                    <div class="form-group">
                    <label for="regionselect">Select Region:</label>

                    <select class="form-control" id="regionselect" name="regionselect">

                    <option disabled selected>Select Region</option>

                    <?php foreach($locations as $row){ ?>

                    <option value="<?php echo $row['location_name'] ?>"><?php echo $row['location_name'] ?></option>

                    <?php } ?>

                    </select>
                    </div>

                    <div class="form-group">
                    <label for="employeeSelect">Select Employee:</label>

                    <select class="form-control" id="employeeSelect" name="employeeSelect">

                    </select>
                    </div>

                    <div class="form-group">
                    <label >Date</label>
                    <input type="text" class="form-control" name="dateinput" placeholder="yyyy/mm/dd" required>
                    </div>

                    <div class="form-inline">
                    <label >Payment Amount</label>
                    <div class="row">
                    <div class="col-md-7">
                    <input type="number" class="form-control" name="amount" placeholder="Enter Amount" required>
                    </div>
                    <div class="col-md-3">
                    <select class="form-control" name="currencyselect" id ="currencyselect">

                        <option disabled selected>**</option>



                    </select>
                    </div>
                    </div>
                    <br>
                    </div>

                    <div class="form-group">
                    <label >Payment Type</label>
                    <select name = "paymenttypeselect" id ="paymenttypeselect" class="form-control">
                    <?php 

                    foreach($paymentTypes as $row){
                    echo "<option value='".$row['type'].".'>".$row['type']."</option>";
                    }

                    ?>

                    </select>
                    </div>

                    <div class="form-group">
                    <label >Description</label>
                    <input type="text" class="form-control" name="description" placeholder="Enter any Comments" required>
                    </div>

                    <div class="form-group">
                    <label >Transaction ID</label>
                    <input type="text" class="form-control" name="transactionid" placeholder="Enter Reference Number" required>
                    </div>

                    <div class="form-group">
                    <label for="monthPayment">Payment For Month:</label>

                    <select class="form-control" id="monthPayment" name="monthPayment">

                      <option value = "1">1</option>
                      <option value = "2">2</option>
                      <option value = "3">3</option>
                      <option value = "4">4</option>
                      <option value = "5">5</option>
                      <option value = "6">6</option>
                      <option value = "7">7</option>
                      <option value = "8">8</option>
                      <option value = "9">9</option>
                      <option value = "10">10</option>
                      <option value = "11">11</option>
                      <option value = "12">12</option>

                    </select>
                    </div>

                    <div class="form-group">
                    <label for="yearPayment">Payment for Year:</label>

                    <select class="form-control" id="yearPayment" name="yearPayment">
                      <option value = "2018">2018</option>
                      <option value = "2019">2019</option>
                    </select>
                    </div>

                    <button type="submit" class="btn btn-primary" name="insertbtn">Submit</button>
                    </fieldset>
                    </form>

                    <br>
        <form method="get" action="addNewPaymentType.php" style="background-color: #f2f2f2;padding:20px;">

            <br>
            <label>Add Payment Type</label>

            <input type = "text" class="form-control" placeholder="Enter new Payment Type" name="ptype"/>
<br>
            <button type="submit" class="btn btn-sm btn-primary">Add</button>

        </form>
 
                </div>


              </div>
            </div>
        
        </div>

        <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h3>View Accounts Data</h3>
                  <p class="card-description">
                    View all Payments
                  </p>


                <div class="card" style="background: #fcfcfc; padding: 15px;" id = "singleform">

                    
                <form method="post" action="importaccounts.php" accept-charset="utf-8" enctype="multipart/form-data">

<div class="form-inline">
 
  <div class="row">
  <label >Import Data</label>&nbsp;&nbsp;&nbsp;
    <input type="file" class="form-control" name="csvdatafile" placeholder="Upload file" accept=".csv" required>
    &nbsp;&nbsp;&nbsp;
    <input type = "submit" class="btn btn-sm btn-primary"/>
 
</div>
<br><br><br>
</form>

<form method="post" action="accounts.php?calltype=daterange">


<div class="form-inline">
  <label >Date Range</label>
  <div class="row">
  <div class="col-md-3">
    <input type="text" class="form-control" name="startdate" placeholder="YYYY/MM/DD" style="width:90%;" required>
    
    </div>

    <div class="col-md-1">
    <label>to</label>
    </div>
    
    <div class="col-md-3">
      <input type="text" class="form-control" name="enddate" placeholder="YYYY/MM/DD" style="width:90%;" required>
      &nbsp;
    </div>

    <div class="col-sm-2" >
      <input type = "submit" class="btn btn-sm btn-primary"/>
      
    </div>

    <div class="col-md-2">
      <a href="accounts.php?calltype=all" class="btn btn-sm btn-primary">Reset</a>
    </div>



    </div>
    <br><br><br>
</div>


</form>

<table id="accountsTable" class="display nowrap" style="width:100%" >
<thead>
    <tr>
        <th>Sr No.</th>
        <th>Region</th>
        <th>Employee ID</th>
        <th>Employee Name</th>
        <th>Date</th>
        <th>Paid for mm/yyyy</th>
        <th>Amount</th>
        <th>Currency</th>
        <th>Payment Type</th>
        <th>Comments</th>
        <th>Transaction ID</th>
        <th>Edit/Delete</th>
    </tr>
</thead>
<tfoot>
    <tr>
        <th>Sr No.</th>
        <th>Region</th>
        <th>Employee ID</th>
        <th>Employee Name</th>
        <th>Date</th>
        <th>Paid for mm/yyyy</th>
        <th>Amount</th>
        <th>Currency</th>
        <th>Payment Type</th>
        <th>Comments</th>
        <th>Transaction ID</th>
        <th>Edit/Delete</th>
    </tr>
</tfoot>

<tbody>


    <?php 
    $i=1;
    foreach($accounts as $row){
        $id = $row['id'];
        $employeeID = $row['employee'];
        $employee = $row['employee_NAME'];
        $region = $row['region'];
        $date = $row['date'];
        $amount = $row['amount'];
        $currency = $row['currency'];
        $description = $row['description'];
        $transactionid = $row['transactionid'];
        $paymenttype = $row['paymenttype'];
        $paymentMonth = $row['paymentmonth'];
        $paymentYear = $row['paymentyear'];

        ?>
    <tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['region']; ?></td>
    <td><?php echo $row['employee']; ?></td>
    <td><?php echo $row['employee_NAME']; ?></td>
    <td><?php echo $row['date']; ?></td>
    <td><?php echo $row['paymentmonth']." / ".$row['paymentyear']; ?></td>
    <td><?php echo $row['amount']; ?></td>
    <td><?php echo $row['currency']; ?></td>
    <td><?php echo $row['paymenttype']; ?></td>
    <td><?php echo $row['description']; ?></td>
    <td><?php echo $row['transactionid']; ?></td>
    <td><?php echo "<button type='button' class='btn btn-sm btn-link' data-toggle='modal' data-target='#myModal' onclick='updateEditFields(`$id`,`$employeeID`,`$employee`,`$region`,`$date`,`$paymentMonth`,`$paymentYear`,`$amount`,`$currency`,`$description`,`$transactionid`,`$paymenttype`)'>Edit</button>"; ?>
    <?php echo "<a type = 'button' href='deleteaccount.php?id=$id' class='btn btn-sm btn-link'>Delete</a>" ?></td>

    </tr>
    <?php 
    $i++;
    } ?>



</tbody>

</table>


                </div>

                </div>
            </div>
        </div>

        
        </div>

        </div>
        <!-- content-wrapper ends -->

        <?php include("includes/footer.php");?>

      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->



</body>


<div class="modal" tabindex="-1" role="dialog" id ="myModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      <form method="post" action="editaccounts.php">

        <fieldset>


        <div class="form-group">
        <label for="regionselectedit">Select Region:</label>

        <select class="form-control" id="regionselectedit" name="regionselectedit">

        <?php foreach($locations as $row){ ?>

        <option value="<?php echo $row['location_name'] ?>"><?php echo $row['location_name'] ?></option>

        <?php } ?>

        </select>
        </div>
        <div class="form-group">
        <label >Employee ID</label>
        <input type="text" class="form-control" name="EmployeeIDedit" id="EmployeeIDedit" placeholder="Enter any ID" required>
        </div>
        <div class="form-group">
        <label for="employeeSelectEdit">Select Employee:</label>

        <input type = "text" name="idedit" id="idedit" hidden />

        <select class="form-control" id="employeeSelectEdit" name="employeeSelectEdit">

        <?php foreach($employees as $row){ ?>

        <option value="<?php echo $row['employee_NAME'] ?>"><?php echo $row['employee_NAME'] ?></option>

        <?php } ?>

        </select>
        </div>

        <div class="form-group">
        <label >Date</label>
        <input type="text" class="form-control" name="dateinputedit" id="dateinputedit" placeholder="yyyy/mm/dd" required>
        </div>

        <div class="form-inline">
        <label >Payment amount</label>
        <div class="row">
        <div class="col-sm-8">
        <input type="number" class="form-control" name="amountedit" id="amountedit" placeholder="Enter amount" required>
        </div>
        <div class="col-sm-4">
        <select class="form-control" name="currencyselectedit" id="currencyselectedit">

            <option value = "PKR">PKR</option>
            <option value = "AED">AED</option>
            <option value = "SAR">SAR</option>
            <option value = "USD">USD</option>

        </select>
        </div>
        </div>
        <br>
        </div>

        <div class="form-group">
         <label >Payment Type</label>
          <select name = "paymenttypeselectedit" id ="paymenttypeselectedit" class="form-control">

<?php 

foreach($paymentTypes as $row){
  echo "<option value='".$row['type'].".'>".$row['type']."</option>";
}

?>

          </select>
        </div>

        <div class="form-group">
        <label >Description</label>
        <input type="text" class="form-control" name="descriptionedit" id="descriptionedit" placeholder="Enter any Comments" required>
        </div>

        <div class="form-group">
        <label >Transaction ID</label>
        <input type="text" class="form-control" name="transactionidedit" id="transactionidedit" placeholder="Enter Reference Number" required>
        </div>
        
        <div class="form-group">
        <label for="monthPaymentedit">Payment month:</label>

        <select class="form-control" id="monthPaymentedit" name="monthPaymentedit">

                      <option value = "1">1</option>
                      <option value = "2">2</option>
                      <option value = "3">3</option>
                      <option value = "4">4</option>
                      <option value = "5">5</option>
                      <option value = "6">6</option>
                      <option value = "7">7</option>
                      <option value = "8">8</option>
                      <option value = "9">9</option>
                      <option value = "10">10</option>
                      <option value = "11">11</option>
                      <option value = "12">12</option>

        </select>
        </div>
        
        <div class="form-group">
        <label for="yearPaymentedit">Payment Year:</label>

        <select class="form-control" id="yearPaymentedit" name="yearPaymentedit">

                      <option value = "2018">2018</option>
                      <option value = "2019">2019</option>


        </select>
        </div>
        
        <button type="submit" class="btn btn-primary" name="insertbtn">Submit</button>
        </fieldset>
        </form>

      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<style>

#accountsTable tr td{
  font-size: 12px;
}

.dataTables_wrapper {
    font-size: 12px;
}

</style>

<script>
 

$(document).ready( function () {
 $('#accountsTable').DataTable( {
        dom: 'Bfrtip',
        "scrollX": true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );

    // $('#accountsTable').DataTable({
    //     "scrollX": true
    // });

    var status = "<?php echo $message; ?>";

    if (status!="" && status != null){
        alert(status);
    }


} );

$('#myModal').on('shown.bs.modal', function () {
  $('#myInput').trigger('focus')
});

$('#regionselect').on('change', function() {
    alert('asda');
  var region = $("#regionselect").val();

  if (region=="UNITED ARAB EMIRATES"){
    $("#currencyselect").html("<option value = 'AED'>AED</option>");
  }else if (region=="PAKISTAN"){
    $("#currencyselect").html("<option value = 'PKR'>PKR</option>");
  }else if (region=="SAUDI ARABIA"){
    $("#currencyselect").html("<option value = 'SAR'>SAR</option>");
  }else if (region=="USA"){
    $("#currencyselect").html("<option value = 'USD'>USD</option>");
  }

  $.ajax({
            type : "GET",
            data : "region="+ region,
            url  : "getregionalemployees.php",
            success : function(response)
            {
				      var data = $.parseJSON(response);
              $('#employeeSelect').html(data);
				            
			      }
      	});

});


function updateEditFields(id,employee,region,date,amount,currency,description,transactionid,paymenttype,monthPayment,yearPayment){

$("#idedit").val(id);
$("#employeeSelectEdit").val(employee);
$("#regionselectedit").val(region);
$("#dateinputedit").val(date);
$("#amountedit").val(amount);
$("#currencyselectedit").val(currency);
$("#descriptionedit").val(description);
$("#transactionidedit").val(transactionid);
$("#paymenttypeselectedit").val(paymenttype);
$("#paymentMonth").val(monthPayment);
$("#paymentYear").val(yearPayment);

    
}


</script>

</html>