<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<body>

  <div class="container-scroller">

<?php 
include("includes/header.php"); 

if (strtolower($_SESSION["role"])!="super admin" && strtolower($_SESSION["role"])!="admin"){
    header("Location: index.php");
}


$stats = "";

if (isset($_GET['status'])){
    $stats = $_GET['status'];
    echo "<script>alert($stats);</script>";
}

$id = $_SESSION['id'];

if(isset($_POST['addemployee'])) {
   
     
    $conn = getconnection();
    
    $location = trim(mysqli_real_escape_string($conn,$_POST["location"]));
    
    $employee_NAME = trim(mysqli_real_escape_string($conn,$_POST["employee_NAME"]));
    
    $employee_cnic = trim(mysqli_real_escape_string($conn,$_POST["employee_cnic"]));
    
     $employee_nationality = trim(mysqli_real_escape_string($conn,$_POST["employee_nationality"]));
    
     $employee_email = trim(mysqli_real_escape_string($conn,$_POST["employee_email"]));
    
    $employee_dob = mysqli_real_escape_string($conn,$_POST["employee_dob"]);
    
     $dateless = explode('/',$employee_dob);
            
            if((!empty($dateless[0])) && (!empty($dateless[1])) && (!empty($dateless[2]))){
                
                $employee_dob = $dateless[1] ."/".$dateless[0]. "/".$dateless[2];
                
            }
     
     if(!empty($employee_dob)){
                $employee_dob = strtotime($employee_dob);
                $employee_dob = date('Y/m/d',$employee_dob);
            }
     
     $employee_gender = escape_it($_POST["employee_gender"]);
   
     $employee_username = escape_it($_POST["employee_username"]);
     $employee_job_title = escape_it($_POST["employee_job_title"]);
     $employee_role = escape_it($_POST["employee_role"]);
     $employee_adder_id = $id;
     
     $employee_internal_id = escape_it($_POST["employee_internal_id"]);
     
    $employee_mobile = trim(mysqli_real_escape_string($conn,$_POST["employee_mobile"]));
    
     $employee_address = trim(mysqli_real_escape_string($conn,$_POST["employee_address"]));
    
    $password = trim(mysqli_real_escape_string($conn,$_POST["employee_password"]));
     
    $employee_image        = $_FILES['employee_picture']['name'];
    $employee_image_temp   = $_FILES['employee_picture']['tmp_name'];
   if(empty($location)||empty($employee_NAME)||empty($password)||empty($employee_cnic)||empty($employee_email)||empty($employee_dob)||empty($employee_username)||empty($employee_role)||empty($employee_internal_id)){
        $tempMessage = "**All fields Must be filled out**";
        header("Location: addEmployee.php?status=$tempMessage");
    }
    elseif (!preg_match("/^[a-zA-Z ]*$/",$employee_NAME)) {
        $tempMessage = "**Only letters and white space allowed in Name**";
        header("Location: addEmployee.php?status=$tempMessage");
    }
    elseif(strlen($employee_NAME) > 40){
        $tempMessage = "**Name can have atmost 40 characters**";
        header("Location: addEmployee.php?status=$tempMessage");
    }elseif(strlen($employee_nationality) > 30){
        $tempMessage = "**Nationality can have atmost 30 characters**";
        header("Location: addEmployee.php?status=$tempMessage");
    }
    elseif(strlen($employee_NAME) < 3){
        $tempMessage = "**Name must have atleast 3 characters**";
        header("Location: addEmployee.php?status=$tempMessage");
    } elseif(strlen($employee_internal_id) > 10){
        $tempMessage = "**Employee Id can have upto 10 characters**";
        header("Location: addEmployee.php?status=$tempMessage");
    } 
    elseif(!filter_var($employee_email, FILTER_VALIDATE_EMAIL)) {
        $tempMessage = "**Invalid Email Format**";
        header("Location: addEmployee.php?status=$tempMessage"); 
    }
    elseif (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$employee_email)) {
        $tempMessage = "**Invalid Email Format**";
        header("Location: addEmployee.php?status=$tempMessage"); 
    }
    elseif(strlen($password) < 5){
        $tempMessage = "**Password must have atleast 5 characters**";
        header("Location: addEmployee.php?status=$tempMessage");
    }
    elseif(strlen($password) > 20){
        $tempMessage = "**Password must have atmost 20 characters**";
        header("Location: addEmployee.php?status=$tempMessage");
    }
    elseif(strlen($employee_address) > 100){
        $tempMessage = "**Address can have atmost 100 characters**";
       header("Location: addEmployee.php?status=$tempMessage");
    }elseif(!is_numeric($employee_mobile)){
        $tempMessage = "**For Mobile Only numbers allowed**";
        header("Location: addEmployee.php?status=$tempMessage");
    }elseif(!is_numeric($employee_internal_id)){
        $tempMessage = "**For Employee Id only numbers allowed**";
        header("Location: addEmployee.php?status=$tempMessage");
    }
     elseif(strlen($employee_mobile) > 20){
        $tempMessage = "**No can have atmost 20 characters**";
       header("Location: addEmployee.php?status=$tempMessage");
    }elseif(check_Employee_ID_Exists($employee_internal_id)){
        $tempMessage = "**Employee Id Already Exists**";
       header("Location: addEmployee.php?status=$tempMessage");
    }elseif(check_Cnic_Exists($employee_cnic)){
        $tempMessage = "**Cnic Already Exists**";
       header("Location: addEmployee.php?status=$tempMessage");
    }elseif(check_Email_Exists($employee_email)){
        $tempMessage = "**Email Already Exists**";
       header("Location: addEmployee.php?status=$tempMessage");
    }elseif(check_Username_Exists($employee_username)){
        $tempMessage = "**Username Already Exists**";
       header("Location: addEmployee.php?status=$tempMessage");
    }
     else{
         
    if(empty($employee_image)){
        
        if($employee_gender ==="male"){
         
                        $employee_image = "male.png";
         
                }else{
                        
                        $employee_image = "female.jpg";
         
         
                    } 
        
    }
         
    $employee_password = encryptPassword($password);
    $result_id =  addemployee($employee_internal_id,$employee_NAME, $employee_cnic, $employee_nationality ,$employee_email, $employee_dob, $employee_gender,$employee_image, $employee_mobile,$employee_password, $employee_username, $employee_job_title, $employee_role, $employee_address, $employee_adder_id);
     
    if((!empty($result_id)) || ($result_id != "undefined")){
        $imgdir = "employee_images/images/id/".$result_id;
        makedirectory($imgdir);
        if(!empty($employee_image)){
         
         $imgdir .= "/".$employee_image;
        movefile($employee_image_temp, $imgdir);
         
            }
        addemployeelocation($location, $result_id);
        header("Location: addEmployeeSalary.php?addsalary=".$result_id);
    }
    else{
        
         $tempMessage = "Something Went Wrong, try again!";
            
         header("Location: addEmployee.php?status=$tempMessage");
    }
     
   
      
     }
     //else ends
}

// if(isset($_GET['employee_id'])){

// }else{
//     header("Location: viewAllEmployees.php?status=Unable To fetch Salary Information! Please try again.");
// }

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

                <div class="col-md-8 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                        <h3>Add Employee</h3>
                        <p class="card-description">
                            Add New Employee<br>
                        </p>

                        <form class = "custform" method="POST" action="" id ="custform" enctype="multipart/form-data">
                                
                                
     <div class="form-group">
       <label for="users">Where To Add?</label>
       <select name="location" class="form-control">
           
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
         <label for="title">Employee ID</label>
          <input type="text" class="form-control" name="employee_internal_id" placeholder="upto 10 digits">
      </div>
            
     <div class="form-group">
         <label >Name</label>
          <input type="text" class="form-control" name="employee_NAME">
      </div>

       <div class="form-group">
         <label >National ID</label>
          <input type="text" class="form-control" name="employee_cnic">
      </div> 
            
     <div class="form-group">
         <label >Nationality</label>
          <input type="text" class="form-control" maxlength="30" name="employee_nationality" placeholder="max 30 characters">
      </div> 
            
     <div class="form-group">
         <label f>Email</label>
          <input type="email" class="form-control" maxlength="70" name="employee_email">
      </div> 
            
    <div class="form-group">
         <label >Birth Date</label>
          <input type="text" class="form-control" name="employee_dob" placeholder="yyyy/mm/dd">
    </div>
    
<!--    <div class="form-group">-->
    <div class="form-group">
                <label class="control-label">Gander:</label>
                <label style="margin-right:20px;margin-left:20px;"><input type="radio" name="employee_gender"  value="female">Female</label>
                    
                <label><input type="radio" name="employee_gender" checked value="male">Male</label>
    </div>
<!--    </div>-->
      
    <div class="form-group">
         <label >Employee Photo</label>
          <input type="file"  name="employee_picture" value="no pic selected">
    </div>

      <div class="form-group">
         <label >Phone No</label>
          <input type="text" class="form-control" name="employee_mobile" placeholder="upto 20 digits">
      </div>
      
      <div class="form-group">
         <label >Address</label>
         <textarea class="form-control black" name="employee_address" cols="15" rows="2" placeholder="More than 5 upto 100 characters">
         </textarea>
      </div>
            
    <div class="form-group">
         <label>Job Title</label>
         <input class="form-control "name="employee_job_title" type="text" placeholder="upto 50 characters">
      </div>
            
    <div class="form-group">
       <label >Select Role</label>
       <select name="employee_role" class="form-control">
           
            <?php

        $result = get_Employee_Roles();

        while($row = mysqli_fetch_assoc($result)) {
              
            $role_name = $row["role_name"];
            echo "<option value='{$role_name}'>{$role_name}</option>";
           
        }

            ?>
           
        
       </select>
      
      </div>        
            
            
    <div class="form-group">
         <label >Username</label>
         <input class="form-control "name="employee_username" type="text" placeholder="30 characters max">
      </div>
            
    <div class="form-group">
         <label >Password</label>
         <input class="form-control " name="employee_password" type="password" placeholder="20 characters max">
      </div>
      
       <div class="form-group">
          <input class="btn btn-success" style="background:#006a4a;" type="submit" name="addemployee" value="Add Employee">
      </div>



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


</style>

<script>

$(document).ready( function () {

var statusCheck = "<?php echo $stats; ?>";

if (statusCheck != "" && statusCheck != null){
    alert(statusCheck);
}

} );

</script>

</html>