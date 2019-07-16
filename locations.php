<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<body>

  <div class="container-scroller">

<?php 
include("includes/header.php"); 

if (strtolower($_SESSION["role"])!="super admin"){
  header("Location: index.php");
}

$locations = getAllLocations();
$payrollData = GetAllPayRollData();
$message = $_GET['status'];

if(isset($_GET['removelocation'])) {
   
    $conn = getconnection();
  
    $location = trim(mysqli_real_escape_string($conn,$_GET["removelocation"]));
    
    if($location == "undefined" || $location == null || empty($location) ){
       $stateMessage = "**Select A location First**";
        header("Location: locations.php?status=$stateMessage");
   }
    else{
        
      if(removelocation($location)){
          
        $stateMessage = "Successfully Removed!";
       header("Location: locations.php?status=$stateMessage");
          
      }
        
    }
    
}

if(isset($_GET["addlocation"])){
        
    $conn = getconnection();
     $location_name = mysqli_real_escape_string($conn,$_GET["location_name"]);
     $location_name = strtoupper($location_name);
     
     if(empty($location_name)){
        $stateMessage = "**Field can't be empty**";
     header("Location: locations.php?status=$stateMessage");
     }
     elseif(checkLocationExists($location_name)) {
        $stateMessage = "**Location Already Exists**";
        header("Location: locations.php?status=$stateMessage");
     }
     elseif(addlocation($location_name)){
         
         $stateMessage = "Successfully Added!";
         header("Location: locations.php?status=$stateMessage");
         
     }
     else{
         
         $stateMessage = "Could not Add, try Again";
         header("Location: locations.php?status=$stateMessage");
         
     }
 
 
 }

 if(isset($_POST["assignemployees"])){
        

    $location_name = escape_it($_POST["location"]);
    $employee_id = escape_it($_POST["employee"]);
    
    
    if(empty($location_name)||empty($employee_id)||$location_name == "" || $employee_id==""||$location_name == "undefined" ||$employee_id == "undefined"){
    $stateMessage = "**Select both Employee & location**";
    header("Location: locations.php?status=$stateMessage");
    }
    elseif(!checkLocationExists($location_name)) {
    $stateMessage = "**Location Does Not Exists**";
    header("Location: locations.php?status=$stateMessage");
    }
    
    else{
        
        if(assignEmployeeOnLocation($location_name,$employee_id)){
            
             
            $stateMessage = "Successfully Assigned!";
            header("Location: locations.php?status=$stateMessage");
            
        }
        
    }

}

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
        
        <div class="col-md-5 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h3>View All Locations</h3>
                  <p class="card-description">
                    View and Remove Locations
                  </p>


                <div class="card" style="background: #fcfcfc; padding: 15px;" id = "singleform">

                <?php

                $result = getlocations();

                if(mysqli_num_rows($result) === 0){
                    

                $stat = "No Record Found";
                    
                    
                }else{ ?>
                    
                    
                    <table class="table table-bordered table-hover" >
                <thead>
                            <tr>
                                <th>Location Name</th>
                                <th>Delete</th>
                            
                            </tr>
                </thead>     
                <tbody>
                    <?php
                    
                    while($row = mysqli_fetch_assoc($result)) {
                    $location = $row['location_name'];
                    
                    echo "<tr>";
                    echo "<td>$location</td>";
                        ?>
                    
                    <form method="get">

                    
                <?php   

                    echo '<td><input rel="'.$location.'" class="btn btn-danger deletebtn" type="submit" name="delete" value="Delete"></td>';

                ?>
                        
                </form>     
                <?php
                    }
                    
                    
                }
                    echo "</tr></tbody>
                    </table>";
                    ?>
 
                </div>


              </div>
            </div>
        
        </div>

        <div class="col-md-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h3>Add Locations</h3>
                  <p class="card-description">
                    Add New Locations
                  </p>


                <div class="card" style="background: #fcfcfc; padding: 15px;" id = "singleform">

                <form action="" method="get">    
                    
                    <div class="form-group">
                        <label for="title">Name</label>
                        <input type="text" class="form-control" name="location_name">
                    </div>
                    
                    <div class="form-group">
                        <input class="btn btn-primary" style="background:#006a4a;" type="submit" name="addlocation" value="Add">
                    </div>


                </form>

                </div>

                </div>
            </div>
        </div>

        <div class="col-md-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h3>Assign Employees</h3>
                  <p class="card-description">
                  Assign Employees on Location
                  </p>


                <div class="card" style="background: #fcfcfc; padding: 15px;" id = "singleform">


                <form action="" method="post">    
     
                    <div class="form-group">
                    <label for="users">Select location</label>
                    <select name="location" class="form-control">
                    <option value="">Select</option>    
                            <?php

                        $result = getlocations();

                        while($row = mysqli_fetch_assoc($result)) {
                            
                            $location_name = $row["location_name"];
                            echo "<option value='{$location_name}'>{$location_name}</option>";
                        
                        }

                            ?>
                    </select>
                    </div>
                    
                    <div class="form-group">
                    <label for="users">Select Employee</label>
                    <select name="employee" class="form-control">
                    <option value="">Select</option>    
                            <?php

                        $result = get_Employees_without_location();
                        
                        while($row = mysqli_fetch_assoc($result)) {
                            $employee_id = $row["employee_id"];
                            
                            $employee_name = getemployeename($employee_id);
                        
                            echo "<option value='{$employee_id}'>({$employee_id}) {$employee_name}</option>";
                        

                            
                        }

                            ?>
                    </select>
                    </div>
                    
                            
                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" style="background:#006a4a;" name="assignemployees" value="Assign">
                    </div>


                        </form>


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


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        
        <h4 class="modal-title">Confirm Delete</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">
        <h5 class="text-center">Are You Sure To remove this location, All employees on this location would be unchained?</h5>
      </div>
      <div class="modal-footer">
      	<a href="" class="btn btn-danger modal_delete_link">Remove</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
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
    $("#allform").hide();
    // $('#example').DataTable();

    var status = "<?php echo $message; ?>";

    if (status!="" && status != null){
        alert(status);
    }
    
    $(".deletebtn").on('click', function(e){

        e.preventDefault();   
            
        var name = $(this).attr("rel");

        var delete_url = "locations.php?removelocation="+ name;
            
            
        $(".modal_delete_link").attr("href", delete_url);


        $("#myModal").modal('show');

    });

} );


</script>

</html>