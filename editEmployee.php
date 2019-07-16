<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<body>

  <div class="container-scroller">

<?php 
include("includes/header.php"); 

if(isset($_GET['employee_id'])){

    $employee_id =  escape_it($_GET['employee_id']);

    $data = getemployeedata($employee_id);

    if($employee = mysqli_fetch_assoc($data)){

        $employee_NAME = convert($employee["employee_NAME"]);
            
        $employee_cnic = convert($employee["employee_cnic"]);
                
        $employee_nationality = convert($employee["employee_nationality"]);
                
        $employee_picture = convert($employee["employee_picture"]);
                
        $employee_email = convert($employee["employee_email"]);
                
        $employee_mobile = convert($employee["employee_mobile"]);
                
        $employee_address = convert($employee["employee_address"]);
                
        $employee_dob = convert($employee["employee_dob"]);
                
        $employee_gender = convert($employee["employee_gender"]);
       
        $employee_username = convert($employee["employee_username"]);
                
        $employee_password = convert($employee["employee_password"]);
                
        $employee_internal_id = convert($employee["employee_internal_id"]);
         
        $employee_job_title = convert($employee["employee_job_title"]);
         
        $employee_role = convert($employee["employee_role"]);

    }else{
        header("Location: viewAllEmployees.php?status=Unable To Edit Employee! Please try again.");
    }

    // var_dump($data);

}else{
    header("Location: viewAllEmployees.php?status=Unable To Edit Employee! Please try again.");
}


// var_dump($payrollData);exit;
?>

    <div class="container-fluid page-body-wrapper">

    <?php include("includes/sidebar.php"); ?>

      <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">

                <div class="col-md-8 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                        <h3>Edit Employee</h3>
                        <p class="card-description">
                            Manage Employee Editing<br>
                        </p>

                        <form class = "custform" method="POST" action="editEmployee.php?employee_id=<?php echo $employee_id; ?>"  enctype="multipart/form-data" id ="custform">

                        <div class="form-group">
                            <label for="users">Change Location</label>
                            <select name="location" class="form-control">
                                
                                    <?php
                                
                                $employee_location = getemployeelocation($employee_id);
                                $result = getlocations();

                                while($row = mysqli_fetch_assoc($result)) {
                                    
                                    $location_name = $row["location_name"];
                                    
                                    
                                    if($employee_location === $location_name){
                                        echo "<option value='{$location_name}' selected>{$location_name}</option>";
                                    }
                                    else{
                                        echo "<option value='{$location_name}'>{$location_name}</option>";
                                    }
                                    
                                
                                }

                                    ?>
                                
                            </select>
                            
                        </div>  

                        <div class="form-group">
                            <label for="title">Employee ID</label>
                            <input type="text" class="form-control" name="employee_internal_id" placeholder="upto 10 digits" value="<?php echo $employee_internal_id; ?>" readonly>
                        </div>    

                                    
                        <div class="form-group">
                            <label for="title">Name</label>
                            <input type="text" class="form-control" name="employee_NAME" value="<?php echo $employee_NAME; ?>">
                        </div>

                        <div class="form-group">
                            <label for="title">National ID</label>
                            <input type="text" class="form-control" name="employee_cnic" value="<?php echo $employee_cnic; ?>">
                        </div> 
                                
                        <div class="form-group">
                            <label >Nationality</label>
                            <input type="text" class="form-control" maxlength="30" name="employee_nationality" placeholder="max 30 characters" value="<?php echo $employee_nationality; ?>">
                        </div> 
                                
                        <div class="form-group">
                            <label for="title">Email</label>
                            <input type="email" value="<?php echo $employee_email; ?>" class="form-control" maxlength="70" name="employee_email">
                        </div> 
                                
                        <div class="form-group">
                            <label for="title">Birth Date</label>
                            <input type="date" class="form-control" name="employee_dob" value="<?php echo $employee_dob; ?>">
                        </div>
                                
                        <div class="form-group">
                                    <label class="control-label">Gander:</label>
                                    
                                <?php 
                            
                                        if($employee_gender ==="male"){
                                            
                        echo '<label style="margin-right:20px;margin-left:20px;"><input type="radio" name="employee_gender" checked value="male">Male</label>';
                                            
                        echo '<label><input type="radio" name="employee_gender" value="female">Female</label>';      
                                            
                                        }
                                        else{
                                            
                        echo '<label style="margin-right:20px;margin-left:20px;"><input type="radio" name="employee_gender" value="male">Male</label>';
                                            
                        echo '<label><input type="radio" name="employee_gender" checked value="female">Female</label>';                   
                                        }
                            
                                    ?>      
                        </div>
                        
                        <div class="form-group">
                                <input type="hidden" name="employee_actual_picture" value="<?php echo $employee_picture; ?>">
                                <input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>">
                                <img width="100" src="employee_images/images/id/<?php echo $employee_id; ?>/<?php echo $employee_picture; ?>" alt="<?php echo $employee_picture; ?>">
                            <input type="file"  name="employee_picture" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="post_tags">Phone No</label>
                            <input type="text" class="form-control" name="employee_mobile" value="<?php echo $employee_mobile; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="post_content">Address</label>
                            <textarea class="form-control "name="employee_address" id="" cols="15" rows="2"><?php echo $employee_address; ?>
                            </textarea>
                        </div>
                                
                        <div class="form-group">
                            <label>Job Title</label>
                            <input class="form-control "name="employee_job_title" type="text" placeholder="upto 50 characters" value="<?php echo $employee_job_title; ?>">
                        </div>
                                
                        <div class="form-group">
                        <label >Select Role</label>
                        <select name="employee_role" class="form-control">
                            
                                <?php

                            $result = get_Employee_Roles();

                            while($row = mysqli_fetch_assoc($result)) {
                                
                                $role_name = $row["role_name"];
                                
                                if($employee_role == $role_name){
                                    
                                    echo "<option value='{$role_name}' selected>{$role_name}</option>";
                                    
                                }else{
                                    
                                    echo "<option value='{$role_name}'>{$role_name}</option>";
                                }
                                
                            
                            }

                                ?>
                            
                            
                        </select>
                        
                        </div>        
                                
                                
                        <div class="form-group">
                            <label >Username</label>
                            <input class="form-control "name="employee_username" type="text" placeholder="30 characters max" value="<?php echo $employee_username; ?>" readonly>
                        </div>
                                
                        <div class="form-group">
                            <label >Password</label>
                            <input class="form-control "name="employee_password" type="password" placeholder="20 characters max" value="<?php echo $employee_password; ?>">
                        </div>
                        
                        
                        <div class="form-group">
                            <input class="btn btn-success" type="submit" name="updateemployee" value="Edit Employee" style="background:#006a4a;">
                        </div>

                        </form>

                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- content-wrapper ends -->


        <?php
    
    if(isset($_POST['updateemployee'])) {
        
        
    $conn = getconnection();
        
    $employee_id = escape_it($_POST["employee_id"]);   
        
    $location = escape_it($_POST["location"]);   
        
    $employee_actual_picture = escape_it($_POST["employee_actual_picture"]);    
        
    $employee_NAME = trim(mysqli_real_escape_string($conn,$_POST["employee_NAME"]));
    
    $employee_cnic = trim(mysqli_real_escape_string($conn,$_POST["employee_cnic"]));
        
    $employee_nationality = trim(mysqli_real_escape_string($conn,$_POST["employee_nationality"]));
    
    $employee_email = trim(mysqli_real_escape_string($conn,$_POST["employee_email"]));
    
    $employee_dob = mysqli_real_escape_string($conn,$_POST["employee_dob"]);
     
    $employee_mobile = trim(mysqli_real_escape_string($conn,$_POST["employee_mobile"]));
    
     $employee_address = trim(mysqli_real_escape_string($conn,$_POST["employee_address"]));
        
    $employee_gender = escape_it($_POST["employee_gender"]);
   
    $employee_username = escape_it($_POST["employee_username"]);
        
    $employee_actual_password = get_Employee_Password($employee_id);
    $employee_actual_internalid = get_Employee_Internalid($employee_id);
    $employee_actual_cnic = get_Employee_Cnic($employee_id);
    $employee_actual_email = get_Employee_Email($employee_id);
    $employee_actual_username = get_Employee_Username($employee_id);
            
    $password = $_POST["employee_password"];
    
            
    $employee_internal_id = escape_it($_POST["employee_internal_id"]);
     
    $employee_job_title = escape_it($_POST["employee_job_title"]);
     
    $employee_role = escape_it($_POST["employee_role"]);
     
    $employee_image        = $_FILES['employee_picture']['name'];
    $employee_image_temp   = $_FILES['employee_picture']['tmp_name'];

    if((empty($employee_NAME))||(empty($employee_cnic))||(empty($employee_email))||(empty($employee_dob))||(empty($employee_mobile))||(empty($employee_username))||(empty($employee_role))||(empty($location))){
        //$tempMessage = "**All fields Must be filled out**";
        header("Location: viewAllEmployees.php?status=All fields Must be filled out");
    }
    elseif (!preg_match("/^[a-zA-Z ]*$/",$employee_NAME)) {
        $tempMessage = "**Only letters and white space allowed in Name**";
        header("Location: viewAllEmployees.php?status=$tempMessage");
    }
    elseif(strlen($employee_NAME) > 40){
        $tempMessage = "**Name can have atmost 40 characters**";
        header("Location: viewAllEmployees.php?status=$tempMessage");
    }
    elseif(strlen($employee_NAME) < 3){
        $tempMessage = "**Name must have atleast 3 characters**";
        header("Location: viewAllEmployees.php?status=$tempMessage");
    }elseif(strlen($employee_nationality) > 30){
        $tempMessage = "**Nationality can have atmost 30 characters**";
        redirect_to("addemployee.php");
    }
    elseif(strlen($employee_internal_id) > 10){
        $tempMessage = "**Employee Id can have upto 10 characters**";
        header("Location: viewAllEmployees.php?status=$tempMessage");
    }elseif(strlen($employee_cnic) > 20){
        $tempMessage = "**cnic can have atmost 20 characters**";
        header("Location: viewAllEmployees.php?status=$tempMessage");
    }
    elseif(!filter_var($employee_email, FILTER_VALIDATE_EMAIL)) {
        $tempMessage = "**Invalid Email Format**";
        header("Location: viewAllEmployees.php?status=$tempMessage");
    }
    elseif (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$employee_email)) {
        $tempMessage = "**Invalid Email Format**";
        header("Location: viewAllEmployees.php?status=$tempMessage");
    }
    elseif(strlen($employee_address) > 100){
        $tempMessage = "**Address can have atmost 100 characters**";
       header("Location: viewAllEmployees.php?status=$tempMessage");
    }elseif(!is_numeric($employee_mobile)){
        $tempMessage = "**For Mobile Only numbers allowed**";
        header("Location: viewAllEmployees.php?status=$tempMessage");
    }
     elseif(strlen($employee_mobile) > 20){
        $tempMessage = "**No can have atmost 20 characters**";
       header("Location: viewAllEmployees.php?status=$tempMessage");
         
    }elseif(!is_numeric($employee_internal_id)){
        $tempMessage = "**For Employee Id only numbers allowed**";
        header("Location: viewAllEmployees.php?status=$tempMessage");
         
    }elseif(strlen($password) < 5){
        $tempMessage = "**Password must have atleast 5 characters**";
        header("Location: viewAllEmployees.php?status=$tempMessage");
    }
     else{
         
         
        if(empty($employee_image)) {
        
        $employee_image = $employee_actual_picture;
        
                    }
            else{
        
        $imgdir = "../employee/images/id/".$employee_id;
         makedirectory($imgdir);
        $imgdir .= "/".$employee_image;
        movefile($employee_image_temp, $imgdir);}
         


         
         $password = encryptPassword($password);
                
        if(updateEmployee($employee_id, $employee_internal_id, $employee_NAME, $employee_cnic, $employee_nationality, $employee_email, $employee_dob, $employee_gender, $employee_image, $employee_mobile, $employee_address, $employee_username, $password, $employee_job_title, $employee_role)){
        
            update_Employee_Location($location, $employee_id);
            $tempMessage = "Successfully Updated";
            header("Location: viewAllEmployees.php?status=$tempMessage");
           
            
                                    
        }else{
        $tempMessage = "Failed, Try Again!";
        header("Location: viewAllEmployees.php?status=$tempMessage");
            }

     }
     //else ends

}
//isset update ends here 
ob_end_flush();               
?>

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

</script>

</html>