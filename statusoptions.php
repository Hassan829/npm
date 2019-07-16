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
$message = $_GET['status'];

if (strtolower($_SESSION["role"])!="super admin" && strtolower($_SESSION["role"])!="admin"){
  header("Location: index.php");
}

// var_dump($_SESSION);exit;

if(isset($_POST["add_status_option"])){
        
       
    $location = escape_it($_POST["location"]);
    $status_option = escape_it($_POST["status_option"]);
    $remarks_option = escape_it($_POST["remarks_option"]);
    
    
    if(empty($location) || empty($status_option) || empty($remarks_option)){
    $stateMessage = "**Fields can't be empty**";
    header("Location: statusoptions.php?status=$stateMessage");
    }
    elseif(strlen($remarks_option) > 3) {
    echo "**Max 3 characters**";
    
    }
    elseif(strlen($status_option) > 30) {
    $stateMessage = "**Max 30 characters**";
    header("Location: statusoptions.php?status=$stateMessage");
    }
    elseif(add_Status_Option($location, $status_option, $remarks_option)){
        
       echo "Successfully Added!";
        
    }
    else{
        
        echo "Option Already Exist";
        
    }


}

if(isset($_POST["add_remarks_option"])){
        
       
    $location = escape_it($_POST["location"]);
    $status_id = escape_it($_POST["status_option_id"]);
    
    $site_location = escape_it($_POST["site_location"]);
    
    if(empty($location) || empty($status_id) || empty($site_location)){
        $stateMessage =  "**Fields can't be empty**";
        header("Location: statusoptions.php?status=$stateMessage");
    
    }
    elseif(strlen($site_location) > 30) {
        $stateMessage =  "**Max 30 characters**";
        header("Location: statusoptions.php?status=$stateMessage");
    
    }
    elseif(add_Remarks_Option($site_location , $status_id)){
        
        $stateMessage =  "Successfully Added!";
        header("Location: statusoptions.php?status=$stateMessage");
        
    }
    else{
        
        $stateMessage =  "Option Already Exist";
        header("Location: statusoptions.php?status=$stateMessage");
        
    }


}

// var_dump($payrollData);exit;
?>

    <div class="container-fluid page-body-wrapper">

    <?php include("includes/sidebar.php");
    
    if (strtolower($_SESSION["role"])!="super admin" && strtolower($_SESSION["role"])!="admin"){
      echo "<div class='col-md-8 grid-margin stretch-card' style='padding:75px;'><h3>Unauthorized Access!</h3></div>";exit;
      }

    ?>

      <div class="main-panel">
        <div class="content-wrapper">


        <div class="row">
        
        <div class="col-md-6 grid-margin stretch-card" <?php if (strtolower($_SESSION["role"])!="super admin"){echo "hidden";} ?>>
              <div class="card">
                <div class="card-body">
                  <h3>View Status Options</h3>
                  <p class="card-description">
                    View All Status Options
                  </p>


                <div class="card" style="background: #fcfcfc; padding: 15px;" id = "singleform">

                   <form action="" method="get">    
                    
                    <div class="form-group">
                    <label for="users">Select location</label>
                    <select name="location" id="locationselect" class="form-control"> 
                            <?php

                        $result = getlocations();

                        while($row = mysqli_fetch_assoc($result)) {
                            
                            $location_name = $row["location_name"];
                            echo "<option value='{$location_name}'>{$location_name}</option>";
                        
                        }

                            ?>
                    </select>
                    </div>

                        </form>

                        <div class="col-md-5" id="statusoptionswrapper">
            
                        </div>
 
                </div>


              </div>
            </div>
        
        </div>

        <div class="col-md-3 grid-margin stretch-card" <?php if (strtolower($_SESSION["role"])!="super admin"){echo "hidden";} ?>>
              <div class="card">
                <div class="card-body">
                  <h3>Add Status Options</h3>
                  <p class="card-description">
                    Add New Status Options
                  </p>


                <div class="card" style="background: #fcfcfc; padding: 15px;" id = "singleform">

                <form action="" method="post">    
     
     <div class="form-group">
       <label for="users">Select location</label>
       <select name="location" class="form-control"> 
            <?php

        $result = getlocations();

        while($row = mysqli_fetch_assoc($result)) {
              
            $location_name = $row["location_name"];
            echo "<option value='{$location_name}'>{$location_name}</option>";
           
        }

            ?>
       </select>
      </div>
             
     <div class="form-group col-md-11">
       <label>Option Name</label>
       <input class="form-control" type="text" placeholder="upto 30 characters" name="status_option">
      </div>
             
    <div class="form-group col-md-11">
       <label>Code</label>
       <input class="form-control" type="text" maxlength="3" placeholder="upto 3 characters" name="remarks_option">
      </div>         
             
    <div class="form-group col-md-11">
       <input type="submit" value="Add" style="background:#006a4a;" name="add_status_option" class="btn btn-success">
      </div>

        </form>

                </div>

                </div>
            </div>
        </div>

        <div class="col-md-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h3>Add Site Location</h3>
                  <p class="card-description">
                  Add New Site Location
                  </p>


                <div class="card" style="background: #fcfcfc; padding: 15px;" id = "singleform">

                <form action="" method="post">    
     
     <div class="form-group">
       <label for="users">Select location</label>
       <select name="location" id="addremarksselect" class="form-control">
           <option value=""></option>
            <?php

if (strtolower($_SESSION["role"])=="super admin"){
  $result = getlocations();

  while($row = mysqli_fetch_assoc($result)) {
        
      $location_name = $row["location_name"];
      echo "<option value='{$location_name}'>{$location_name}</option>";
     
  }

}else if (strtolower($_SESSION["role"])=="admin"){
  echo "<option value='".$_SESSION["location"]."'>".$_SESSION["location"]."</option>";
}

            ?>
       </select>
      </div>
             
    <div class="form-group">
       <label for="users">Select Status Option</label>
       <select name="status_option_id" id="addremarkstatusselect" class="form-control">
        
       
       </select>
      </div>
             
     <div class="form-group col-md-11">
       <label>Site Location</label>
       <input class="form-control" type="text" placeholder="upto 30 characters" name="site_location">
      </div>
             
    <div class="form-group col-md-11">
       <input type="submit" value="Add" name="add_remarks_option" class="btn btn-success" style="background:#006a4a;">
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
    
    $(function(){
        
        
        var location = $('#locationselect').find(":selected").val();
      
        var url = "status_options_for_location.php?location="+location;
        
        $.get(url, function(data, status){
                
                $("#statusoptionswrapper").html(data);
    
                     });
        
      }); 
    //loading status options
            
            
        $('#locationselect').on('change', function() {
                
            
           var location = $('#locationselect').find(":selected").val();
      
        var url = "status_options_for_location.php?location="+location;
        
        $.get(url, function(data, status){
                
                $("#statusoptionswrapper").html(data);
    
                     });
            
            }); 

            $('#addremarksselect').on('change', function() {
                
            
                var location = $('#addremarksselect').find(":selected").val();
           
             var url = "get_status_options.php?location="+location;
             
             $.get(url, function(data, status){
                     
                     $("#addremarkstatusselect").html(data);
         
                          });
                 
                 });     

} );


</script>

</html>