<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<body>

  <div class="container-scroller">

<?php 
include("includes/header.php"); 

$employees = getAllEmployees();

$locations = getAllLocations();

$accounts = getAllAccounts();


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

                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                        <h3>Reporting</h3>
                        <p class="card-description">
                            Single or Bulk Reports
                        </p>

                        <form class = "custform" method="POST" action="summary.php"  target="_blank" id ="custform">

                            <div class="form-group">
                                <label for="regionselect"><b>Report Type:</b></label>

                                <select class="form-control" id="reporttypeselect" name="reporttypeselect">

                                <option value="" disabled selected>Select Report</option>

                                <option value = "Maintenance Timesheet">Maintenance Timesheet</option>
                                <option value = "Payslip">Payslip</option>
                                <option value = "Summary">Summary</option>

                                </select>

                            </div>

                            <div class="form-group">
                                <label for="regionselect"><b>Select Region:</b></label>

                                <select class="form-control" id="regionselect" name="regionselect">

                                <option value="" disabled selected >Select Region</option>

                                <?php foreach($locations as $row){ ?>

                                <option value="<?php echo $row['location_name'] ?>"><?php echo $row['location_name'] ?></option>

                                <?php } ?>

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="employeeSelect"><b>Select Employee:</b></label>

                                <select class="form-control" id="employeeSelect" name="employeeSelect">

                                </select>
                            </div>

                            <div class="form-group" id = "monthyeardiv" >

                            <label for="monthselect"><b>Select Month / Year:</b></label>

                                <select class="form-control" name="monthselect" id="monthselect">

                                    <option value="" disabled selected>Select Month</option>
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
                                    <option value = "all">All</option>

                                </select>

                                <br>

                                <select class="form-control" name="yearselect" id="yearselect" required>

                                    <option value="" disabled selected>Select Year</option>
                                    <option value = "2018">2018</option>
                                    <option value = "2019">2019</option>
                                    <option value = "2020">2020</option>

                                </select>

                            </div>

                            <input type="text" class="form-control" name="dateinput" id="dateinput" placeholder="yyyy/mm/dd" hidden>

                            <div class="form-group" hidden>
                                <label >Date Range:</label>

                                    <select class="form-control" name="rangetype" id="rangetype">

                                        <option value = "">Select Range Type</option>
                                        <option value = "daterange">Date Range</option>
                                        <option value = "monthyear" selected="selected">Month / Year</option>

                                    </select>

                            </div>

                            <button type="submit" class="btn btn-success" style="background:#006a4a;" name="insertbtn">Generate Reports</button>

                        </form>

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

$('#regionselect').on('change', function() {
  
  var region = $("#regionselect").val();

  $.ajax({
            type : "GET",
            data : "region="+ region,
            url  : "getregionalemployees.php",
            success : function(response)
            {
				      var data = $.parseJSON(response);
                      data = data + "<option value = 'all'> All </option>";
                      
              $('#employeeSelect').html(data);
				            
			      }
      	});

});


$( "#custform" ).submit(function( event ) {
    
    var region = $("#employeeSelect").val();
    var employee = $("#regionselect").val();
    var months = $("#monthselect").val();
    var year = $("#yearselect").val();
    var reportType = $("#reporttypeselect").val();
    

    if (region == "all" && months == "all"){
    
        alert("Select only one from 'All Employees' or 'All Months'");
        event.preventDefault();
    
    }else if (region == "" || employee == "" || months == "" || year == "" || reportType == "" || region == null || employee == null || months == null || year == null || reportType == null){
    
        alert("Please select all options to continue!");
        event.preventDefault();
    
    }else{
        return true;
    }

});

</script>

</html>