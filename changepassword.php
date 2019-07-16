<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<body>

  <div class="container-scroller">

<?php 
include("includes/header.php"); 

if (count($_POST) > 0) {

    $employeeId = get_Employee_Id($_POST['employee']);

  
  //echo $encrptPassword =  encryptPassword($_POST["currentPassword"]);
   //$passwordMatch = password_check($_POST["currentPassword"], $existingPassword );

$password = encryptPassword($_POST["newPassword"]);
  if(updateUserPassword($employeeId,$password)){
    echo "<script>alert('Password changed successfully')</script>";
  }else{
     echo "<script>alert('Error occured ')</script>";
  }

}


if (strtolower($_SESSION["role"])!="super admin" && strtolower($_SESSION["role"])!="admin" && strtolower($_SESSION["role"])!="entry maker"){
  header("Location: index.php");
}

$id = $_SESSION["id"];

?>




    <div class="container-fluid page-body-wrapper">

    <?php 
    include("includes/sidebar.php");
    
    if (strtolower($_SESSION["role"])!="super admin" && strtolower($_SESSION["role"])!="admin" && strtolower($_SESSION["role"])!="entry maker"){
      echo "<div class='col-md-8 grid-margin stretch-card' style='padding:75px;'><h3>Unauthorized Access!</h3></div>";exit;
      }
    
    ?>
      <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-8 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Password Change</h3>
                            <div class="card" style="background: #fcfcfc; padding: 15px;" >
                                <form name="frmChange" method="post" action=""  class="form form-vertical">
                                    <div class="form-group">
                                        <label>Select location</label>
                                        <select name="location" id="locationselect" name="locationselect" class="form-control col-sm-5">
                                        <option value="">Select</option> 
                                          <?php if (strtolower($_SESSION["role"])=="super admin"){
                                                  $result = getlocations();
                                                  while($row = mysqli_fetch_assoc($result )) {
                                                    $location_name = $row['location_name'];
                                                    if($location_name === isset($_GET['location'])){                                                      
                                                      echo "<option value='$location_name' selected optionid='$location_name'>{$location_name}</option>"; 
                                                    }else{
                                                      echo "<option value='$location_name' optionid='$location_name'>{$location_name}</option>"; 
                                                    }
                                                  }
                                                }else if (strtolower($_SESSION["role"])=="admin" || strtolower($_SESSION["role"])=="entry maker"){
                                                  echo "<option value='".$_SESSION["location"]."'>".$_SESSION["location"]."</option>";
                                                  }
                                          ?>
                                     </select>
                                    </div>
                                    <div class="form-group col-sm-5">
                                        <label>Select Employee</label>
                                        <select class="form-control" id="employee" name="employee" class="form-control col-sm-4">

                              </select>
                                    </div>
                                    <div class="form-group">
                                        <label>New Password</label>
                                        <input type="password" name="newPassword" class="form-control" /><span id="newPassword" class="required">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
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
 



</body>




<script type="text/javascript">
  
  $('#locationselect').on('change', function() {
 
  var region = $("#locationselect").val();

  $.ajax({
            type : "GET",
            data : "region="+ region,
            url  : "getregionalemployees.php",
            success : function(response)
            { 
              var data = $.parseJSON(response);
              $('#employee').html(data);
                    
            }
        });

});


</script>

</html>