<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<style type="text/css">
    .container-flex {
    display: flex;
   width: 100%;
   justify-content: space-between;
}
</style>
<body>

  <div class="container-scroller">

<?php 
include("includes/header.php"); 
$locations = getAllLocations();

if (strtolower($_SESSION["role"])!="super admin" && strtolower($_SESSION["role"])!="admin"){
header("Location: index.php");
}

if (strtolower($_SESSION["role"])=="super admin"){

  $employees = getAllEmployeesData();

}else if (strtolower($_SESSION["role"])=="admin"){

  $employees = getAllEmployeesDataWithLocation($_SESSION['location']);

}else{
  $employees = array();
}



$stats = "";

if (isset($_GET['status'])){
    $stats = $_GET['status'];
    echo "<script>alert($stats);</script>";
}

// var_dump($employees);exit;
?>

    <div class="container-fluid page-body-wrapper">

    <?php include("includes/sidebar.php"); ?>

      <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">

                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                    <div class="card-body">
                    <div class="container-flex">
                    <div class="flex-start">
                    <h3>View All Employees</h3>
                    <p class="card-description">
                        Operations on Existing Employees
                  </p>
                       </div>
                       <?php if (strtolower($_SESSION["role"])=="super admin"){ ?>
                       <div class="flex-end">
                        <button type="button" class="btn btn-primary" data-toggle="modal" style="float: right" data-target="#myModal">Add Arears  </button>
                       </div>
                       <?php }?>
                    </div>

                        <table id="example" class="display" style="width:100%">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Gov ID</th>
                                <th>Nationality</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>DOB</th>
                                <th>Role</th>
                                <th>Job Title</th>
                                <th>Adder</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php foreach($employees as $row){
                            ?>

                            <tr>
                                <td><?php echo $row['employee_internal_id']; ?></td>
                                <td><?php echo $row['employee_NAME']; ?></td>
                                <td><?php echo $row['employee_gender']; ?></td>
                                <td><?php echo $row['employee_cnic']; ?></td>
                                <td><?php echo $row['employee_nationality']; ?></td>
                                
                                <td><?php echo $row['employee_email']; ?></td>
                                <td><?php echo $row['employee_mobile']; ?></td>
                                <td><?php echo $row['employee_dob']; ?></td>
                                <td><?php echo $row['employee_role']; ?></td>
                                <td><?php echo $row['employee_job_title']; ?></td>
                                <td><?php echo $row['operator']; ?></td>
                                <td>
                                
                                <a href='viewEmployeeSalary.php?employee_id=<?php echo $row['employee_id']; ?>' class="btn btn-sm btn-success btn-block" style="background:#006a4a;font-size:10px;">View Salary</a>
                                <a href='editEmployee.php?employee_id=<?php echo $row['employee_id']; ?>' class="btn btn-sm btn-success btn-block" style="background:#006a4a;font-size:10px;">Edit Employee</a>
                                <a data-toggle="modal" onclick="updateDeleteModal(<?php echo $row['employee_id']; ?>)" data-target="#myModal" class="btn btn-sm btn-success btn-block" style="background:#006a4a;font-size:10px;color:white;">Delete</a>
                                
                                </td>
                            </tr>

                            <?php
                        } ?>

                        </tbody>

                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Gov ID</th>
                                <th>Nationality</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>DOB</th>
                                <th>Role</th>
                                <th>Job Title</th>
                                <th>Adder</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>

                        </table>                        

                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- content-wrapper ends -->
        <div class="modal" tabindex="-1" role="dialog" id ="myModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Arear</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      <form method="post" action="addattandance.php">

        <fieldset>


        <div class="form-group">
        <label for="locationselect1">Select Region:</label>

        <select class="form-control" id="locationselect1" name="locationselect1">
          <option> Select </option>
        <?php foreach($locations as $row){ ?>

        <option value="<?php echo $row['location_name'] ?>"><?php echo $row['location_name'] ?></option>

        <?php } ?>

        </select>
        </div>
        

        <div class="form-group">
        <label for="employeeSelect">Select Employee&nbsp;&nbsp;</label>

          <select class="form-control" id="employeeSelect" name="employeeSelect">

          </select>
        </select>
        </div>

        <div class="form-group">
        <label for="monthPayment">Arear For Month:</label>

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
       
       <div class="form-group">
        <label >Arear Amount</label>
        <input type="text" class="form-control" name="amount" id="amount" placeholder="Amount" required>
        </div>
         <button type="button" name="submit" id="submit" onclick="addArearAmount();" class="btn btn-info pull-right">Submit</button>
        </fieldset>
        </form>

      </div>
      
    </div>
  </div>
</div>

        <?php include("includes/footer.php");?>

      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

</body>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title">Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">

        <h3 style="color:red;">Are you sure you want to delete?</h3>

      </div>
      <div class="modal-footer">
      <form action="deleteEmployee.php" method="get">
        <input id = "deleteid" name="removeemployee" type="text" hidden />
        <input type="submit" class="btn btn-default" value="Confirm Delete">
        </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<style>

#example{
  font-size: 12px;
}

.dataTables_wrapper {
    font-size: 12px;
}

</style>

<script>

$(document).ready( function () {

    var statusCheck = "<?php echo $stats; ?>";

    if (statusCheck != "" && statusCheck != null){
        alert(statusCheck);
    }

    $('#example').DataTable({
        "scrollX": true
    });

} );

function updateDeleteModal(empId){

    $("#deleteid").val(empId);

}

$('#locationselect1').on('change', function() {
 
  var region = $("#locationselect1").val();

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

   function addArearAmount(){
   
  var e = document.getElementById("locationselect1");
 var location = e.options[e.selectedIndex].value;

  var e = document.getElementById("employeeSelect");
 var employee = e.options[e.selectedIndex].value;

  var e = document.getElementById("monthPayment");
var  month = e.options[e.selectedIndex].value;

  var e = document.getElementById("yearPayment");
var  year = e.options[e.selectedIndex].value;

  var  amount = $("input#amount").val();

  $.ajax({
      type: "POST",
      url: "addarears.php",
      data:{ 'location':location,
            'employee':employee,
            'month':month, 
            'year':year,
            'amount' : amount
            },
      success: function(data) {
          alert(data);
           window.location.reload(true);
          //$('#registration-modal').modal('hide');
          //$(".modal-body input").val("")
      }
    });
  }

</script>

</html>