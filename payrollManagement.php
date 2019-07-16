<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<body>

  <div class="container-scroller">

<?php 
include("includes/header.php"); 
$locations = getAllLocations();
$payrollData = GetAllPayRollData();
$operator = $_SESSION['id'];
// var_dump($payrollData);exit;
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
                  <h3>Manage Payroll</h3>
                  <p class="card-description">
                    Single or All Employees Payroll
                  </p>

                  Single &nbsp;
                  <label class="switch">
                    <input type="checkbox" id = "checksingleall" onclick="checkPanels()">
                    <span class="slider round"></span> 
                  </label>
                  &nbsp;All
                  <div class="card" style="background: #fcfcfc; padding: 15px;" id = "singleform">

                    <fieldset>

                    <legend style="font-size:16px;"><b>Single Employee Payroll</b></legend>

                    <input type = "text" value="single" name="payrolltype" hidden/>

                    <!-- 
                      <div class="form-group">
                        <label>Default input</label>
                        <input type="text" class="form-control" placeholder="Username" aria-label="Username">
                      </div> -->

                      <div class="form-group">
                        <label for="exampleFormControlSelect2">Select Region</label>
                        <select class="form-control regionselect" name="regionselect" id="regionselectsingle" required>
                          <option value="" disabled selected>Select Region</option>
                          <?php foreach($locations as $row){ ?>

                            <option value="<?php echo $row['location_name']; ?>"><?php echo $row['location_name']; ?></option>

                          <?php } ?>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="exampleFormControlSelect2">Select Employee</label>
                        <select class="form-control employeeSelect"  name="employeeSelect" id="employeeSelectSingle">
                        
                        </select>
                      </div>

                      <div class="form-group">
                          <label for="exampleFormControlSelect2">Select Month</label>
                          <select class="form-control" name="month" id="month">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                          </select>
                        </div>

                        <div class="form-group">
                          <label for="exampleFormControlSelect2">Select Year</label>
                          <select class="form-control" name="year" id="year">
                          <option value = "2017">2017</option>
                            <option value = "2018">2018</option>
                            <option value = "2019">2019</option>
                            <option value = "2020">2020</option>
                          </select>
                        </div>

                        <div class="form-group" style="padding-bottom:3px;">

                              <select class="form-control" name = "sendemail" id = "sendemail">

                              <option value="notsend">Do Not Send Email</option>
                              <option value="send">Send Email</option>

                          </select>
                
                        </div>

                        <div class="form-group">

                          <button class="btn btn-success" style="background:#006a4a;" onclick="generatepayrollSingle()">Generate Payroll </button>

                        </div>

                      </fieldset>

                          </div>


                    <div class="" style="background: #fcfcfc; padding: 15px;" id = "allform" >

                      <fieldset>

                      <legend style="font-size:16px;"><b>All Employees Payroll</b></legend>
                      <!-- 
                        <div class="form-group">
                          <label>Default input</label>
                          <input type="text" class="form-control" placeholder="Username" aria-label="Username">
                        </div> -->

                        <input type = "text" value="all" name="payrolltype" hidden/>

                        <div class="form-group">
                        <label for="regionselectall">Select Region</label>
                        <select class="form-control" name="regionselectall" id="regionselectall" required>
                          <option value="" disabled selected>Select Region</option>
                          <?php foreach($locations as $row){ ?>

                            <option value="<?php echo $row['location_name']; ?>"><?php echo $row['location_name']; ?></option>

                          <?php } ?>
                          <!-- <option value="all">All</option>  -->
                        </select>
                      </div>

                        <div class="form-group">
                          <label for="monthall">Select Month</label>
                          <select class="form-control" name="monthall" id="monthall">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                          </select>
                        </div>

                        <div class="form-group">
                          <label for="yearall">Select Year</label>
                          <select class="form-control" name="yearall" id="yearall">
                            <option value = "2018">2018</option>
                            <option value = "2019">2019</option>
                            <option value = "2020">2020</option>
                          </select>
                        </div>

                        <div class="form-group" style="padding-bottom:3px;">

                        <select class="form-control" name = "sendemailall" id = "sendemailall">

                        <option value="notsend">Do Not Send Email</option>
                        <option value="send">Send Email</option>

                        </select>
<br>
                        <div class="form-group">

                          <button class="btn btn-success" style="background:#006a4a;" onclick="generatepayrollAll()">Generate Payroll </button>

                        </div>

                        </fieldset>

                          </div>

              </div>
            </div>
        
        </div>

        <div class="col-md-8 grid-margin stretch-card" id ="detaildiv">

            <div class="card">
              <div class="card-body">
                  <h3 >Payroll History</h3>
                  <p class="card-description">
                    All payrolls generated
                  </p>


                  <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Sr#</th>
                <th>Name</th>
                <th>Salary Disbursed</th>
                <th>Month</th>
                <th>Year</th>
                <th>Status</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
          <?php $i=1; 
          foreach($payrollData as $row){ ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row['employee_NAME']; ?></td>
                <td><?php echo $row['gross_salary']; ?></td>
                <td><?php echo $row['month']; ?></td>
                <td><?php echo $row['year']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                  <?php

                    $id = $row['employee_internal_id'];
                    $name = $row['employee_NAME'];
                    $month = $row['month'];
                    $year = $row['year'];
                    $account = $row['account_no'];
                    $iban = $row['iban_no'];
                    $project = $row['project_allowance'];
                    $housing = $row['housing_allowance'];
                    $conveyance = $row['conveyance_allowance'];
                    $others = $row['other_allowance'];
                    $basic = $row['basic_salary'];
                    $wps = $row['wps_salary'];
                    $payments = $row['deductions'];
                    $arrears = $row['arrears'];
                    $gross = $row['gross_salary'];

                    $finalVar = "`$id`,`$name`,`$month`,`$year`,`$account`,`$iban`,`$project`,`$housing`,`$conveyance`,`$others`,`$basic`,`$wps`,`$payments`,`$arrears`,`$gross`";
                  ?>
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" 
                data-target="#myModal" onclick="fillDetailedSalary(<?php echo $finalVar; ?>)" style="background:#006a4a;font-size:12px;">View</button>
                </td>
            </tr>
          <?php 
        $i++;
        } ?>
            
        </tbody>
        <tfoot>
            <tr>
                 <th>Sr#</th>
                <th>Name</th>
                <th>Salary Disbursed</th>
                <th>Month</th>
                <th>Year</th>
                <th>Status</th>
                <th>Details</th>
            </tr>
        </tfoot>
    </table>
                  

              </div>
            </div>



        </div>

        <div class="col-md-8 grid-margin stretch-card" id = "loaderdiv" style="padding-left:200px;padding-top:150px;">

        <div class="loader row" ></div>
        
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
        
      <div class="table-responsive">
        <table class="table table-striped">

             <tbody>

                <tr>
                  <td><b>Employee ID:</b></td>
                  <td id ="empidtd"></td>
                </tr>

                <tr>
                  <td><b>Employee Name:</b></td>
                  <td id ="empnametd"></td>
                </tr>

                <tr>
                  <td><b>Month:</b></td>
                  <td id ="monthtd"></td>
                </tr>

                <tr>
                  <td><b>Year</b></td>
                  <td id ="yeartd"></td>
                </tr>

                <tr>
                  <td><b>Account No:</b></td>
                  <td id ="accounttd"></td>
                </tr>

                <tr>
                  <td><b>IBAN No:</b></td>
                  <td id ="ibantd"></td>
                </tr>

                <tr>
                  <td><b>Project Allowance: </b></td>
                  <td id ="projecttd"></td>
                </tr>

                <tr>
                  <td><b>Housing Allowance:</b></td>
                  <td id ="housingtd"></td>
                </tr>

                <tr>
                  <td><b>Conveyance Allowance:</b></td>
                  <td id ="conveyancetd"></td>
                </tr>

                <tr>
                  <td><b>Other Allowance:</b></td>
                  <td id ="othertd"></td>
                </tr>

                <tr>
                  <td><b>Basic Salary:</b></td>
                  <td id ="basictd"></td>
                </tr>

                <tr>
                  <td><b>WPS Salary:</b></td>
                  <td id ="wpstd"></td>
                </tr>

                <tr>
                  <td><b>Payments Deducted:</b></td>
                  <td id ="paymentstd"></td>
                </tr>

                <tr>
                  <td><b>Arrears:</b></td>
                  <td id ="arrearstd"></td>
                </tr>

                <tr>
                  <td><b>Gross Salary:</b></td>
                  <td id ="grosstd"></td>
                </tr>

            </tbody>

        </table>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>



<style>

.loader {
  border: 16px solid #7fa397; /* Light grey */
  border-top: 16px solid #006a4a; /* Blue */
  border-radius: 50%;
  width: 200px;
  height: 200px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.switch {
  position: relative;
  display: inline-block;
  width: 52px;
  height: 25px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 20px;
  width: 20px;
  left: 4px;
  bottom: 3px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #006a4a;
}

input:focus + .slider {
  box-shadow: 0 0 1px #7fa397;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

#example{
  font-size: 12px;
}

.dataTables_wrapper {
    font-size: 12px;
}

</style>

<script>

$(document).ready( function () {
    $("#allform").hide();
    $('#example').DataTable();
    // $("#detaildiv").hide("slow");
    $("#loaderdiv").hide();
} );



function checkPanels(){

$("#singleform").toggle("fast");
$("#allform").toggle("fast");
// alert("hello");
}

$('.regionselect').on('change', function() {
  
  var region = $(".regionselect").val();

  $.ajax({
            type : "GET",
            data : "region="+ region,
            url  : "getregionalemployees.php",
            success : function(response)
            {
				      var data = $.parseJSON(response);
              $('.employeeSelect').html(data);
				            
			      }
      	});

});

function generatepayrollSingle(){
  var payrollType = "single";
  var region = $("#regionselectsingle").val();
  var employee = $("#employeeSelectSingle").val();
  var month = $("#month").val();
  var year = $("#year").val();
  var emailIntimation = $("#sendemail").val();
  var operator = "<?php echo $operator; ?>";

  $("#detaildiv").hide("slow");
  $("#loaderdiv").show("slow");

  if (region != "" && region != null && employee != "" && employee != null){

    $.ajax({
              type : "POST",
              data : "regionselect="+ region+"& payrolltype="+payrollType+"& employeeSelect="+employee+"& month="+month+"&year="+year+"&sendemail="+emailIntimation+"&operator="+operator,
              url  : "payrollGeneration.php",
              success : function(response)
              {
                var data = $.parseJSON(response);
                console.log(data);
                if (data=="success"){
                  alert("Payroll Generated Successfully!");
                  location.reload();
                }else{
                  alert("Error in Generating Payroll!");
                }
              }
          });
      $("#detaildiv").show("slow");
      $("#loaderdiv").hide("slow");
  }else{
    alert("Please select all fields!");
    $("#detaildiv").show("slow");
    $("#loaderdiv").hide("slow");
  }

}

function generatepayrollAll(){

  var payrollType = "all";
  var region = $("#regionselectall").val();
  var month = $("#monthall").val();
  var year = $("#yearall").val();
  var emailIntimation = $("#sendemailall").val();
  var operator = "<?php echo $operator; ?>";

  if (region != "" && region != null){

  $.ajax({
            type : "POST",
            data : "regionselect="+ region+"& payrolltype="+payrollType+"& month="+month+"&year="+year+"&sendemail="+emailIntimation+"&operator="+operator,
            url  : "payrollGenerationForAll.php",
            success : function(response)
            { alert(response);
               
              var data = $.parseJSON(response);
              console.log(data);
              if (data=="success"){
               
                alert("Payroll Generated Successfully!");
                location.reload();
              }else{
             
                alert("Error in Generating Payroll!");
              }
            }
        });
    $("#detaildiv").show("slow");
    $("#loaderdiv").hide("slow");
  }else{
  alert("Please select all fields!");
  $("#detaildiv").show("slow");
  $("#loaderdiv").hide("slow");
  }

}

function fillDetailedSalary(empid,empname,month,year,account,iban,project,housing,conveyance,other,basic,wps,payments,arrears,gross){

  $("#empidtd").html(empid);
  $("#empnametd").html(empname);
  $("#monthtd").html(month);
  $("#yeartd").html(year);
  $("#accounttd").html(account);
  $("#ibantd").html(iban);
  $("#projecttd").html(project);
  $("#housingtd").html(housing);
  $("#conveyancetd").html(conveyance);
  $("#othertd").html(other);
  $("#basictd").html(basic);
  $("#wpstd").html(wps);
  $("#paymentstd").html(payments);
  $("#arrearstd").html(arrears);
  $("#grosstd").html(gross);

}

</script>

</html>