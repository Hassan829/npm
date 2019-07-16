<?php use SimpleExcel\SimpleExcel; ?>
<?php

function redirect_to($new_location){
    header("Location:".$new_location);
//     exit;
}


function getconnection(){
    
     $db = Database::getInstance();
    return $db->getConnection();
    
}


function convert($string_to_convert){
    
    return htmlspecialchars($string_to_convert);
    
}

function escape_it($string){
    
    $conn = getconnection();
    return mysqli_real_escape_string($conn,trim($string));
    
    
}



function encryptPassword($password) {
    
    $blowfish_format = "$2y$11$";
    
    $salt_len = 22;
    
    $salt = generateSalt($salt_len);
    
    $blowfish_with_salt = $blowfish_format . $salt;
    
        
    $hash = crypt($password, $blowfish_with_salt);
        
        
    return $hash;
}


function generateSalt($len){
    
    $unique_random_string = md5(uniqid(mt_rand(), true));
    
    $base_64string = base64_encode($unique_random_string);
    
    $modified_base64_string = str_replace('+','.',$base_64string);
    
    $salt = substr($modified_base64_string,0,$len);
    
    return $salt;
    
}

/*For Matching the user password with password hashed in the database*/
function password_check($pass, $existing_hash){
    
    $hash = crypt($pass, $existing_hash);
    
    if($hash === $existing_hash){
        return true; 
    }
        
    else {
            return false;
        }

}


//employee login attempt
function loginAttempt($username, $password){
    $conn = getconnection();
    $query = "select * from employee a 
    left join employee_location b 
    on a.employee_id = b.id_employee where a.employee_username='$username'";
  
    $execute = mysqli_query($conn,$query);
        $conn->close();
                
        if($result = mysqli_fetch_assoc($execute))
        {
            if(password_check($password, $result["employee_password"])){
                return $result;
            }
            else {
            
                return null;
            }

        }
}

//post login accesses handdlers starts
function superadminloginAccess(){
    if(isset($_SESSION['superadmin_id'])){
        return true;
    }
    else{
        return false;
    }
}

function confirmsuperadminLogin(){
    
    if(!superadminloginAccess()){
        $_SESSION["loginmessage"]="Please Login To Continue";
        redirect_to("../index.php");
    }
    
}
function adminloginAccess(){
    if(isset($_SESSION['admin_id'])){
        return true;
    }
    else{
        return false;
    }
}

function confirmadminLogin(){
    
    if(!adminloginAccess()){
        $_SESSION["loginmessage"]="Please Login To Continue";
        redirect_to("../index.php");
    }
    
}
function entrymakerloginAccess(){
    if(isset($_SESSION['entrymaker_id'])){
        return true;
    }
    else{
        return false;
    }
}


function confirmentrymakerLogin(){
    
    if(!entrymakerloginAccess()){
        $_SESSION["loginmessage"]="Please Login To Continue";
        redirect_to("../index.php");
    }
    
}
function employeeloginAccess(){
    if(isset($_SESSION['employee_id'])){
        return true;
    }
    else{
        return false;
    }
}

function confirmemployeeLogin(){
    
    if(!employeeloginAccess()){
        $_SESSION["loginmessage"]="Please Login To Continue";
        redirect_to("../index.php");
    }
    
}
//post login accesses handdlers ends


//get profile image
function getimage($id){
    $conn = getconnection();
     $query = "SELECT employee_picture FROM employee WHERE employee_id='$id'";
    $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{
            
            if($result = mysqli_fetch_assoc($execute))
        {
        
            return $result["employee_picture"];

        }
        else {
            
                return null;
            }
            
    }
}

//get employee password
function get_Employee_Password($id){
    $conn = getconnection();
     $query = "SELECT employee_password FROM employee WHERE employee_id='$id'";
    $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{
            
            if($result = mysqli_fetch_assoc($execute))
        {
        
            return $result["employee_password"];

        }
        else {
            
                return null;
            }
            
    }
}
//get employee internal id
function get_Employee_Internalid($id){
    $conn = getconnection();
     $query = "SELECT employee_internal_id FROM employee WHERE employee_id='$id'";
    $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{
            
            if($result = mysqli_fetch_assoc($execute))
        {
        
            return $result["employee_internal_id"];

        }
        else {
            
                return null;
            }
            
    }
}

//get employee  id using internal id
function get_Employee_Id($internal_id){
    $conn = getconnection();
     $query = "SELECT employee_id FROM employee WHERE employee_internal_id='$internal_id'";
    $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{
            
            if($result = mysqli_fetch_assoc($execute))
        {
        
            return $result["employee_id"];

        }
        else {
            
                return null;
            }
            
    }
}
//get employee cnic
function get_Employee_Cnic($id){
    $conn = getconnection();
     $query = "SELECT employee_cnic FROM employee WHERE employee_id='$id'";
    $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{
            
            if($result = mysqli_fetch_assoc($execute))
        {
        
            return $result["employee_cnic"];

        }
        else {
            
                return null;
            }
            
    }
}
//get employee email
function get_Employee_Email($id){
    $conn = getconnection();
     $query = "SELECT employee_email FROM employee WHERE employee_id='$id'";
    $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{
            
            if($result = mysqli_fetch_assoc($execute))
        {
        
            return $result["employee_email"];

        }
        else {
            
                return null;
            }
            
    }
}
//get employee username
function get_Employee_Username($id){
    $conn = getconnection();
     $query = "SELECT employee_username FROM employee WHERE employee_id='$id'";
    $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{
            
            if($result = mysqli_fetch_assoc($execute))
        {
        
            return $result["employee_username"];

        }
        else {
            
                return null;
            }
            
    }
}

//get locations
function getlocations(){
    
    $conn = getconnection();
    $query = "SELECT location_name FROM location";
    $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{
            
        return $execute;
            
    }
    
}


//get employee roles
function get_Roles(){
    
    $conn = getconnection();
    $query = "SELECT role_name FROM roles";
    $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{
            
        return $execute;
            
    }
    
}

//get employee roles
function get_Employee_Roles(){
    
    $conn = getconnection();
    $query = "SELECT role_name FROM roles";
    $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{
            
        return $execute;
            
    }
    
}

//check if cnic exists
function check_Cnic_Exists($cnic){
    
    
    
    $conn = getconnection();
    $query = "SELECT employee_id FROM employee WHERE employee_cnic='$cnic'";
    $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    elseif(mysqli_num_rows($execute)>0){
        return true;
        
    }
    else {
        return false;
    }
    
}

//check if employee_internal_id already exists
function check_Employee_ID_Exists($employee_internal_id){
    
    
    
    $conn = getconnection();
    $query = "SELECT employee_id FROM employee WHERE employee_internal_id='$employee_internal_id'";
    $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    elseif(mysqli_num_rows($execute)>0){
        return true;
        
    }
    else {
        return false;
    }
    
}

function check_Employee_ID_Exists_Edit($employee_internal_id){
    
    
    
    $conn = getconnection();
    $query = "SELECT employee_id FROM employee WHERE employee_internal_id='$employee_internal_id'";
    $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    elseif(mysqli_num_rows($execute)>0){
        return true;
        
    }
    else {
        return false;
    }
    
}

//check if email exists
function check_Email_Exists($email){
    
    
    
    $conn = getconnection();
    $query = "SELECT employee_id FROM employee WHERE employee_email='$email'";
    $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    elseif(mysqli_num_rows($execute)>0){
        return true;
        
    }
    else {
        return false;
    }
    
}

//check if username exists
function check_Username_Exists($username){
    
    
    
    $conn = getconnection();
    $query = "SELECT employee_id FROM employee WHERE employee_username='$username'";
    $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    elseif(mysqli_num_rows($execute)>0){
        return true;
        
    }
    else {
        return false;
    }
    
}

function check_Username_Exists_Edit($username){
    
    
    
    $conn = getconnection();
    $query = "SELECT employee_id FROM employee WHERE employee_username='$username'";
    $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    elseif(mysqli_num_rows($execute)>0){
        return true;
        
    }
    else {
        return false;
    }
    
}

//add locations
function addlocation($location_name){
    
    $conn = getconnection();
    $query = "INSERT INTO location(location_name) ";
             
      $query .= "VALUES('{$location_name}') "; 
    
    $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        return true;
    }
    
}

//remove location locations
function removelocation($location_name){
    
     $conn = getconnection();
    
    $query = "DELETE FROM location WHERE location_name = '{$location_name}'";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return true;
    }
    
}

//remove attendance entry
function delete_Entry($attendance_id){
    
     $conn = getconnection();
    
    $query = "DELETE FROM master_attendance WHERE attendance_id = {$attendance_id}";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return true;
    }
    
}

//remove remarks
function remove_Remark($remarks_status_id, $site_location){
    
     $conn = getconnection();
    
    $query = "DELETE FROM remarks WHERE remarks_statusid = '{$remarks_status_id}' && site_location = '{$site_location}'";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return true;
    }
    
}

//add status options
function add_Status_Option($location, $status_option, $remarks_option){
    
     $conn = getconnection();
    
    $query = "INSERT INTO status(status_location, status_option, remarks_option) ";
             
      $query .= "VALUES('{$location}', '{$status_option}', '{$remarks_option}') "; 
             
      $execute = mysqli_query($conn,$query);
    
    if($execute){
        return true;
    }
    else{
       
        return false;
        
    }
    
}

//add remarks options for status options
function add_Remarks_Option($site_location, $status_id){
    
     $conn = getconnection();
    
    $query = "INSERT INTO remarks(remarks_statusid, site_location) ";
             
      $query .= "VALUES({$status_id}, '{$site_location}') "; 
             
      $execute = mysqli_query($conn,$query);
    
    if($execute){
        return true;
    }
    else{
        
        return false;
        
    }
    
}

//remove status options
function remove_Status_Option($status_id){
    
     $conn = getconnection();
    
    $query = "DELETE FROM status WHERE status_id = {$status_id}";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return true;
    }
    
}

//make direcotry function
function makedirectory($dir){
    
    
    if(!is_dir($dir)){

            
             mkdir($dir,0777,true);
         }
    
    
    
}


//add employee
function addemployee($employee_internal_id,$employee_NAME, $employee_cnic, $employee_nationality,$employee_email, $employee_dob, $employee_gender,$employee_image, $employee_mobile, $employee_password, $employee_username, $employee_job_title, $employee_role, $employee_address, $employee_adder_id)
{
    
     $conn = getconnection();
    
     $query = "INSERT INTO employee(employee_internal_id,employee_NAME, employee_cnic, employee_nationality ,employee_email, employee_dob,employee_gender,employee_picture,employee_mobile, employee_address,employee_password,employee_username,employee_job_title,employee_role,employee_adder_id) ";
             
      $query .= "VALUES('{$employee_internal_id}','{$employee_NAME}','{$employee_cnic}','{$employee_nationality}','{$employee_email}','{$employee_dob}','{$employee_gender}','{$employee_image}','{$employee_mobile}', '{$employee_address}', '{$employee_password}', '{$employee_username}', '{$employee_job_title}', '{$employee_role}', {$employee_adder_id}) "; 
            // echo $query;exit; 
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        return mysqli_insert_id($conn);
    }   
    
}


//update employee
function updateEmployee($employee_id, $employee_internal_id, $employee_NAME, $employee_cnic, $employee_nationality , $employee_email, $employee_dob, $employee_gender, $employee_image, $employee_mobile, $employee_address, $employee_username, $employee_password, $employee_job_title, $employee_role){
    
          $conn = getconnection();
    
          $query = "UPDATE employee SET ";
          $query .="employee_internal_id  = '{$employee_internal_id}', ";
          $query .="employee_NAME  = '{$employee_NAME}', ";
          $query .="employee_cnic = '{$employee_cnic}', ";
          $query .="employee_nationality = '{$employee_nationality}', ";
          $query .="employee_email   =  '{$employee_email}', ";
          $query .="employee_dob = '{$employee_dob}', ";
          $query .="employee_gender = '{$employee_gender}', ";
          $query .="employee_picture = '{$employee_image}', ";
          $query .="employee_mobile = '{$employee_mobile}', ";
          $query .="employee_address = '{$employee_address}', ";
          $query .="employee_password = '{$employee_password}', ";
          $query .="employee_username = '{$employee_username}', ";
          $query .="employee_job_title = '{$employee_job_title}', ";
          $query .="employee_role = '{$employee_role}' ";
          $query .= "WHERE employee_id = {$employee_id} ";
        //   echo  $query;
        // exit;
          $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return true;
    
    }   
    
}

//add employee salary
function add_Employee_Salary($emp_id, $account_no, $iban_no, $project_allowance, $housing_allowance,   $conveyance_allowance, $other_allowance, $basic_salary, $wps_salary, $deductions, $join_date,  $termination_date)
{
    
     $conn = getconnection();
    $query;
    
     if(empty($account_no)){
         
         
            if(empty($iban_no)){
        
              $query = "INSERT INTO employee_salary(emp_id, account_no, iban_no, project_allowance, housing_allowance, conveyance_allowance, other_allowance, basic_salary, wps_salary, deductions, join_date, termination_date) ";
             
      $query .= "VALUES('{$emp_id}', NULL , NULL ,{$project_allowance},{$housing_allowance},{$conveyance_allowance},{$other_allowance},{$basic_salary},{$wps_salary},{$deductions},'{$join_date}','{$termination_date}' ) "; 
            
        
         
                }else{
            
                  $query = "INSERT INTO employee_salary(emp_id, account_no, iban_no, project_allowance, housing_allowance, conveyance_allowance, other_allowance, basic_salary, wps_salary, deductions, join_date, termination_date) ";
             
      $query .= "VALUES('{$emp_id}', NULL ,'{$iban_no}',{$project_allowance},{$housing_allowance},{$conveyance_allowance},{$other_allowance},{$basic_salary},{$wps_salary},{$deductions},'{$join_date}','{$termination_date}' ) "; 
                
                
                
            
                }
         
     } 
     
     if(empty($iban_no)){
         
         if(empty($account_no)){
             
             
             $query = "INSERT INTO employee_salary(emp_id, account_no, iban_no, project_allowance, housing_allowance, conveyance_allowance, other_allowance, basic_salary, wps_salary, deductions, join_date, termination_date) ";
             
      $query .= "VALUES('{$emp_id}', NULL , NULL ,{$project_allowance},{$housing_allowance},{$conveyance_allowance},{$other_allowance},{$basic_salary},{$wps_salary},{$deductions},'{$join_date}','{$termination_date}' ) "; 
             
             
             
             
         }else{
             
             
               $query = "INSERT INTO employee_salary(emp_id, account_no, iban_no, project_allowance, housing_allowance, conveyance_allowance, other_allowance, basic_salary, wps_salary, deductions, join_date, termination_date) ";
             
      $query .= "VALUES('{$emp_id}','{$account_no}', NULL ,{$project_allowance},{$housing_allowance},{$conveyance_allowance},{$other_allowance},{$basic_salary},{$wps_salary},{$deductions},'{$join_date}','{$termination_date}' ) "; 
             
             
         }
        
         
     }
    
     if((!empty($iban_no)) && (!empty($account_no))){
         
           $query = "INSERT INTO employee_salary(emp_id, account_no, iban_no, project_allowance, housing_allowance, conveyance_allowance, other_allowance, basic_salary, wps_salary, deductions, join_date, termination_date) ";
             
      $query .= "VALUES('{$emp_id}','{$account_no}','{$iban_no}',{$project_allowance},{$housing_allowance},{$conveyance_allowance},{$other_allowance},{$basic_salary},{$wps_salary},{$deductions},'{$join_date}','{$termination_date}' ) "; 
         
         
         
         
     }
      
 
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        return true;
    }   
    
}


//update employee
function update_Employee_Salary($emp_id, $account_no, $iban_no, $project_allowance, $housing_allowance,   $conveyance_allowance, $other_allowance, $basic_salary, $wps_salary, $deductions, $join_date,  $termination_date){
    
          $conn = getconnection();
          $query;
    
     if(empty($account_no)){
         
         
            if(empty($iban_no)){
        
          $query = "UPDATE employee_salary SET ";
          $query .="account_no  = NULL, ";
          $query .="iban_no  = NULL, ";
          $query .="project_allowance = {$project_allowance}, ";
          $query .="housing_allowance = {$housing_allowance}, ";
          $query .="conveyance_allowance = {$conveyance_allowance}, ";
          $query .="other_allowance = {$other_allowance}, ";
          $query .="basic_salary = {$basic_salary}, ";
          $query .="wps_salary = {$wps_salary}, ";
          $query .="deductions = {$deductions}, ";
          $query .="join_date = '{$join_date}', ";
          $query .="termination_date = '{$termination_date}' ";
          $query .= "WHERE emp_id = {$emp_id} ";
            
        
         
                }else{
            
                  $query = "UPDATE employee_salary SET ";
          $query .="account_no  = NULL, ";
          $query .="iban_no  = '{$iban_no}', ";
          $query .="project_allowance = {$project_allowance}, ";
          $query .="housing_allowance = {$housing_allowance}, ";
          $query .="conveyance_allowance = {$conveyance_allowance}, ";
          $query .="other_allowance = {$other_allowance}, ";
          $query .="basic_salary = {$basic_salary}, ";
          $query .="wps_salary = {$wps_salary}, ";
          $query .="deductions = {$deductions}, ";
          $query .="join_date = '{$join_date}', ";
          $query .="termination_date = '{$termination_date}' ";
          $query .= "WHERE emp_id = {$emp_id} ";
                
                
                
            
                }
         
     } 
     
     if(empty($iban_no)){
         
         if(empty($account_no)){
             
             
          $query = "UPDATE employee_salary SET ";
          $query .="account_no  = NULL, ";
          $query .="iban_no  = NULL, ";
          $query .="project_allowance = {$project_allowance}, ";
          $query .="housing_allowance = {$housing_allowance}, ";
          $query .="conveyance_allowance = {$conveyance_allowance}, ";
          $query .="other_allowance = {$other_allowance}, ";
          $query .="basic_salary = {$basic_salary}, ";
          $query .="wps_salary = {$wps_salary}, ";
          $query .="deductions = {$deductions}, ";
          $query .="join_date = '{$join_date}', ";
          $query .="termination_date = '{$termination_date}' ";
          $query .= "WHERE emp_id = {$emp_id} ";
             
             
             
             
         }else{
             
             
          $query = "UPDATE employee_salary SET ";
          $query .="account_no  = '{$account_no}', ";
          $query .="iban_no  = NULL, ";
          $query .="project_allowance = {$project_allowance}, ";
          $query .="housing_allowance = {$housing_allowance}, ";
          $query .="conveyance_allowance = {$conveyance_allowance}, ";
          $query .="other_allowance = {$other_allowance}, ";
          $query .="basic_salary = {$basic_salary}, ";
          $query .="wps_salary = {$wps_salary}, ";
          $query .="deductions = {$deductions}, ";
          $query .="join_date = '{$join_date}', ";
          $query .="termination_date = '{$termination_date}' ";
          $query .= "WHERE emp_id = {$emp_id} ";
             
         }
        
         
     }
    
     if((!empty($iban_no)) && (!empty($account_no))){
         
          $query = "UPDATE employee_salary SET ";
          $query .="account_no  = '{$account_no}', ";
          $query .="iban_no  = '{$iban_no}', ";
          $query .="project_allowance = {$project_allowance}, ";
          $query .="housing_allowance = {$housing_allowance}, ";
          $query .="conveyance_allowance = {$conveyance_allowance}, ";
          $query .="other_allowance = {$other_allowance}, ";
          $query .="basic_salary = {$basic_salary}, ";
          $query .="wps_salary = {$wps_salary}, ";
          $query .="deductions = {$deductions}, ";
          $query .="join_date = '{$join_date}', ";
          $query .="termination_date = '{$termination_date}' ";
          $query .= "WHERE emp_id = {$emp_id} ";
         
         
         
         
     }
        
     $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return true;
    
    }   
    
}



//get employee all data
function getemployeedata($id){
    
    
     $conn = getconnection();
    
     $query = "SELECT employee_internal_id, employee_NAME, employee_cnic, employee_nationality ,employee_email, employee_dob, employee_picture, employee_mobile, employee_address, employee_gender, employee_password, employee_username, employee_job_title, employee_role, employee_adder_id FROM employee WHERE employee_id = {$id}";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}


//get employee all salary data
function get_Employee_Salary_Data($id){
    
    
     $conn = getconnection();
    
     $query = "SELECT account_no, iban_no, project_allowance, housing_allowance, conveyance_allowance, other_allowance, basic_salary, wps_salary, deductions, join_date, termination_date FROM employee_salary WHERE emp_id = {$id}";
    
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}

//remove employee
function removeemployee($id){
    
    
    $conn = getconnection();
    
    $query = "UPDATE employee SET ";
    $query .="employee_role = NULL";
    $query .= " WHERE employee_id = {$id} ";
    
    
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return true;
    }
    
    
}

//remove admin
function removeadmin($id){
    
    
    $conn = getconnection();
    
    $query = "DELETE FROM admin WHERE admin_id = '{$id}'";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return true;
    }
    
    
}

//remove entrymaker
function removeentrymaker($id){
    
    
    $conn = getconnection();
    
    $query = "DELETE FROM entry_maker WHERE entrymaker_id = '{$id}'";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return true;
    }
    
    
}

//add employee location
function addemployeelocation($location, $id){
    
    
    $conn = getconnection();
    
     $query = "INSERT INTO employee_location(name_location, id_employee) ";
             
      $query .= "VALUES('{$location}',{$id}) "; 
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    
}

//remove employee location
function remove_Employee_Location($id){
    
    
    $conn = getconnection();
    
     $query = "DELETE FROM employee_location WHERE  id_employee = {$id}";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    
}

//update employee location
function update_Employee_Location($location, $employee_id){
    
    
    $conn = getconnection();
    
    $query = "UPDATE employee_location SET name_location='$location' WHERE id_employee='$employee_id'";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        return true;
    }
    
    
}


//get employess on location
function getemployeesonlocation($location){
    
    
     $conn = getconnection();
    
     $query = "SELECT id_employee FROM employee_location LEFT OUTER JOIN employee ON id_employee = employee_id WHERE employee_location.name_location = '{$location}' AND employee.employee_role IS NOT NULL";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}

//get employess on location
function get_Employees_On_Location($location, $page_1, $per_page){
    
    
     $conn = getconnection();
    
     $query = "SELECT employee_id FROM employee LEFT OUTER JOIN employee_location ON employee_id = id_employee WHERE employee_location.name_location = '{$location}' AND employee.employee_role IS NOT NULL LIMIT $page_1, $per_page";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}

//get employess count on location
function get_Employees_On_Location_count($location){
    
    
     $conn = getconnection();
    
     $query = "SELECT employee_id FROM employee LEFT OUTER JOIN employee_location ON employee_id = id_employee WHERE name_location = '{$location}' AND employee_role IS NOT NULL";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}

//get employess on location having role
function get_Employees_On_Location_Having_Role($location, $role ,$page_1, $per_page){
    
    
     $conn = getconnection();
    
     $query = "SELECT employee_id FROM employee LEFT OUTER JOIN employee_location ON employee_id = id_employee WHERE name_location = '{$location}' AND employee_role = '{$role}' LIMIT $page_1, $per_page";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}

//get employess count on location with role
function get_Employees_On_Location_Having_Role_count($location, $role){
    
    
     $conn = getconnection();
    
     $query = "SELECT employee_id FROM employee LEFT OUTER JOIN employee_location ON employee_id = id_employee WHERE name_location = '{$location}' AND employee_role = '{$role}'";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}

//get employess having role
function get_Employees_Having_Role($role ,$page_1, $per_page){
    
    
     $conn = getconnection();
    
     $query = "SELECT employee_id FROM employee WHERE employee_role = '{$role}' LIMIT $page_1, $per_page";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}

//get employess count on location with role
function get_Employees_Having_Role_count($role){
    
    
     $conn = getconnection();
    
     $query = "SELECT employee_id FROM employee WHERE employee_role = '{$role}'";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}


//get employess having name
function get_Employees_Having_Name($employee_NAME ,$page_1, $per_page){
    
    
     $conn = getconnection();
    
     $query = "SELECT employee_id FROM employee WHERE employee_NAME LIKE '%$employee_NAME%' LIMIT $page_1, $per_page";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}

//get employess count having name
function get_Employees_Having_Name_Count($employee_NAME){
    
    
     $conn = getconnection();
    
     $query = "SELECT employee_id FROM employee WHERE employee_NAME LIKE '%$employee_NAME%'";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}

//get employee with internal id 
function get_Employees_Having_Internal_Id($employee_internal_id ,$page_1, $per_page){
    
    
     $conn = getconnection();
    
     $query = "SELECT employee_id FROM employee WHERE employee_internal_id = '{$employee_internal_id}' LIMIT $page_1, $per_page";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}

//get employee count on internal id
function get_Employees_Having_Internal_Id_Count($employee_internal_id){
    
    
     $conn = getconnection();
    
     $query = "SELECT employee_id FROM employee WHERE employee_internal_id = '{$employee_internal_id}'";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}

//get employess all
function get_All_Employees($page_1, $per_page){
    
    
     $conn = getconnection();
    
     $query = "SELECT employee_id FROM employee WHERE employee_role IS NOT NULL ORDER BY employee_id ASC LIMIT $page_1, $per_page";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}

//get employess count
function get_All_Employees_Count(){
    
    
     $conn = getconnection();
    
     $query = "SELECT employee_id FROM employee WHERE employee_role IS NOT NULL";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}



//for admin
//get employess having role
function getadmin_Employees_Having_Role($role, $location ,$page_1, $per_page){
    
    
     $conn = getconnection();
    
     $query = "SELECT employee_id FROM employee LEFT OUTER JOIN employee_location ON employee_id = id_employee WHERE (employee_location.name_location = '{$location}' AND employee.employee_role = '{$role}') AND (employee.employee_role = 'Entry Maker' OR employee.employee_role = 'Employee') LIMIT $page_1, $per_page";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}

//get employess count on location with role
function getadmin_Employees_Having_Role_count($role, $location){
    
    
     $conn = getconnection();
    
     $query = "SELECT employee_id FROM employee LEFT OUTER JOIN employee_location ON employee_id = id_employee WHERE (employee_location.name_location = '{$location}' AND employee.employee_role = '{$role}') AND (employee.employee_role = 'Entry Maker' OR employee.employee_role = 'Employee') ";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}


//for admin
//get employess having name
function getadmin_Employees_Having_Name($employee_NAME, $location ,$page_1, $per_page){
    
    
     $conn = getconnection();
    
    $query = "SELECT employee_id FROM employee LEFT OUTER JOIN employee_location ON employee_id = id_employee WHERE (employee_location.name_location = '{$location}' AND employee.employee_NAME LIKE '%$employee_NAME%') AND (employee.employee_role = 'Entry Maker' OR employee.employee_role = 'Employee') LIMIT $page_1, $per_page";
    
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}
//for admin
//get employess count having name
function getadmin_Employees_Having_Name_Count($employee_NAME, $location){
    
    
     $conn = getconnection();
    
     $query = "SELECT employee_id FROM employee LEFT OUTER JOIN employee_location ON employee_id = id_employee WHERE (employee_location.name_location = '{$location}' AND employee.employee_NAME LIKE '%$employee_NAME%') AND (employee.employee_role = 'Entry Maker' OR employee.employee_role = 'Employee')";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}

//get employee with internal id 
function getadmin_Employees_Having_Internal_Id($employee_internal_id, $location ,$page_1, $per_page){
    
    
     $conn = getconnection();
    
     $query = "SELECT employee_id FROM employee LEFT OUTER JOIN employee_location ON employee_id = id_employee WHERE (employee_location.name_location = '{$location}' AND employee.employee_internal_id = '{$employee_internal_id}') AND (employee.employee_role = 'Entry Maker' OR employee.employee_role = 'Employee') LIMIT $page_1, $per_page";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}
//admin
//get employee count on internal id
function getadmin_Employees_Having_Internal_Id_Count($employee_internal_id, $location){
    
    
     $conn = getconnection();
    
     $query = "SELECT employee_id FROM employee LEFT OUTER JOIN employee_location ON employee_id = id_employee WHERE (employee_location.name_location = '{$location}' AND employee.employee_internal_id = '{$employee_internal_id}') AND (employee.employee_role = 'Entry Maker' OR employee.employee_role = 'Employee')";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}
//admin
//get employess all
function getadmin_All_Employees($location, $page_1, $per_page){
    
    
     $conn = getconnection();
    
     $query = "SELECT employee_id FROM employee LEFT OUTER JOIN employee_location ON employee_id = id_employee WHERE (employee_location.name_location = '{$location}') AND (employee.employee_role = 'Entry Maker' OR employee.employee_role = 'Employee') ORDER BY employee_id ASC LIMIT $page_1, $per_page";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}

//get employess count
function getadmin_All_Employees_Count($location){
    
    
     $conn = getconnection();
    
     $query = "SELECT employee_id FROM employee LEFT OUTER JOIN employee_location ON employee_id = id_employee WHERE (employee_location.name_location = '{$location}') AND (employee.employee_role = 'Entry Maker' OR employee.employee_role = 'Employee')";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}

//get status options for location
function get_Status_Options_For_location($location){
    
    
     $conn = getconnection();
    
     $query = "SELECT status_id, status_option, remarks_option FROM status WHERE status_location = '{$location}'";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}


//get remarks  options for status option
function get_site_location_For_Statusoption($status_id){
    
    
     $conn = getconnection();
    
     $query = "SELECT site_location  FROM remarks WHERE remarks_statusid = {$status_id}";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    } 
    
}

//get remarks  options for status option 
function get_remarks_Options_For_Statusoption($remarks_statusid){
    
    
     $conn = getconnection();
    
     $query = "SELECT remarks_option  FROM status WHERE status_id = {$remarks_statusid}";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}


//get employess count
function getEmployeesCount(){
    
    
    $conn = getconnection();
    
     $query = "SELECT employee_id FROM employee WHERE employee_role IS NOT NULL";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return mysqli_num_rows($execute);
        
    }    
}

//get Admins Count count
function getAdminsCount(){
    
    
    $conn = getconnection();
    
     $query = "SELECT employee_id FROM employee WHERE employee_role='Admin'";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return mysqli_num_rows($execute);
        
    }    
}

//get Admins Count count
function getEntrymakersCount(){
    
    
    $conn = getconnection();
    
     $query = "SELECT employee_id FROM employee WHERE employee_role='Entry Maker'";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return mysqli_num_rows($execute);
        
    }    
}
//get locations Count count
function getLocationsCount(){
    
    
    $conn = getconnection();
    
     $query = "SELECT location_name FROM location";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return mysqli_num_rows($execute);
        
    }    
}



//get admins on location
function get_Admins_On_Location($location){
    
    
     $conn = getconnection();
    
     $query = "SELECT id_employee FROM employee_location, admin WHERE name_location = '{$location}' AND admin_id = id_employee";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}


//get admins username
function get_Admin_username($id){
    
    
     $conn = getconnection();
    
     $query = "SELECT admin_username FROM admin WHERE admin_id = {$id}";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
         if($result = mysqli_fetch_assoc($execute))
        {
        
            return $result["admin_username"];

        }
        
    }  
    
}




//get entrymakers on location
function get_Entrymakers_On_Location($location){
    
    
     $conn = getconnection();
    
     $query = "SELECT id_employee FROM employee_location, entry_maker WHERE name_location = '{$location}' AND entrymaker_id = id_employee";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}

//get entry maker username
function get_Entrymaker_username($id){
    
    
     $conn = getconnection();
    
     $query = "SELECT entrymaker_username FROM entry_maker WHERE entrymaker_id = {$id}";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
         if($result = mysqli_fetch_assoc($execute))
        {
        
            return $result["entrymaker_username"];

        }
        
    }  
    
}

//get employee location
function getemployeelocation($id){
    
    
     $conn = getconnection();
    
     $query = "SELECT name_location FROM employee_location WHERE id_employee = {$id}";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        if($result = mysqli_fetch_assoc($execute))
        {
        
            return $result["name_location"];

        }
        
    }  
    
}
//get all employees who dont have any location
//get employee location
function get_Employees_without_location(){
    
    
     $conn = getconnection();
    
     $query = "SELECT employee_id FROM employee LEFT OUTER JOIN employee_location ON employee_id = id_employee WHERE id_employee IS NULL AND employee_role IS NOT NULL";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}

function assignEmployeeOnLocation($location_name,$employee_id){
    
    
    $conn = getconnection();
    
     $query = "INSERT INTO employee_location(name_location, id_employee)";
             
      $query .= "VALUES('{$location_name}', {$employee_id}) "; 
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return true;
    }
    
    
    
}

//get employee name
function getemployeename($id){
    
    
     $conn = getconnection();
    
     $query = "SELECT employee_NAME FROM employee WHERE employee_id = {$id}";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
         if($result = mysqli_fetch_assoc($execute))
        {
        
            return $result["employee_NAME"];

        }
        
    }  
    
}

function isSuperUser($id){
    
    $conn = getconnection();
    
     $query = "SELECT employee_role FROM employee WHERE employee_id = {$id}";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
       if($result = mysqli_fetch_assoc($execute)){
           
           if($result["employee_role"] ==="Super Admin"){
               return true;
           }
           else{
               return false;
           }
           
       }
        
        
    }  
    
    
    
}

function isAdmin($id){
    
    $conn = getconnection();
    
     $query = "SELECT employee_role FROM employee WHERE employee_id = {$id}";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
       if($result = mysqli_fetch_assoc($execute)){
           
           if($result["employee_role"] ==="Admin"){
               return true;
           }
           else{
               return false;
           }
           
       }
        
        
    }  
    
    
    
}
//get employee ROLE
function get_Employee_Role($id){
    
    
     $conn = getconnection();
    
     $query = "SELECT employee_role FROM employee WHERE employee_id = {$id}";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        if($result = mysqli_fetch_assoc($execute)){
           
           
           return $result["employee_role"];
       }
        
    }  
    
}

//add entry maker
function addentrymaker($id, $username, $password){
    
    $conn = getconnection();
    
     $query = "INSERT INTO entry_maker(entrymaker_id, entrymaker_username, entrymaker_password)";
             
      $query .= "VALUES({$id}, '{$username}', '{$password}') "; 
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return true;
    }
    
}

//add admin
function addadmin($id, $username, $password){
    
    $conn = getconnection();
    
     $query = "INSERT INTO admin(admin_id, admin_username, admin_password)";
             
      $query .= "VALUES({$id}, '{$username}', '{$password}') "; 
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return true;
    }
    
}

//add attendance entry
function makeentry($attendance_emp_id, $status_option, $site_location, $time_in, $time_out, $hours_worked, $attendance_for_date, $remarks_option, $comment, $entry_maker_id){
    
    $conn = getconnection();
    
     $query = "INSERT INTO master_attendance(attendance_emp_id, status_option, site_location, time_in, time_out, hours_worked, attendance_for_date, remarks, comment, entry_maker_id)";
             
      $query .= "VALUES({$attendance_emp_id}, '{$status_option}', '{$site_location}', '{$time_in}','{$time_out}',{$hours_worked}, '{$attendance_for_date}','{$remarks_option}','{$comment}', {$entry_maker_id}) "; 
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return true;
    }
    
}

//import  attendance entries
function import_Attendance_Date($target_file, $FileType, $entry_maker_id){
    
$excel = new SimpleExcel($FileType);                    // instantiate new object (will automatically 

$excel->parser->loadFile($target_file);            // load file from server to be parsed

  
$result = $excel->parser->getField();  
    
$size = sizeof($result);
$index = 1;
$flag = true;
    
    if(array_key_exists($index, $result)){
        
         for($i = 1; $i < $size; $i++){
             
             
         $employee_internal_id;
         $employee_id;
         $status_option;
         $site_location;
         $remarks_option;
         $time_in;
         $time_out;
         $hours_worked;
         $comment;
         $date;  
             
                if(array_key_exists( 1, $result[$i])){
                    
                    $employee_internal_id = $result[$i][1];
                    $employee_internal_id = escape_it($employee_internal_id);
                    
                }
             
          $employee_id = convert(get_Employee_Id($employee_internal_id));
             
             if(!empty($employee_id)){
                 
                 if(array_key_exists( 3, $result[$i])){
                    
                    $status_option = $result[$i][3];
                    $status_option = escape_it($status_option);
                    
                }if(array_key_exists( 4, $result[$i])){
                    
                    $site_location = $result[$i][4];
                    $site_location = escape_it($site_location);
                    
                }if(array_key_exists( 5, $result[$i])){
                    
                    $remarks_option = $result[$i][5];
                    $remarks_option = escape_it($remarks_option);
                    
                }if(array_key_exists( 6, $result[$i])){
                    
                    $time_in = $result[$i][6];
                    $time_in = escape_it($time_in);
                    
                }if(array_key_exists( 7, $result[$i])){
                    
                    $time_out = $result[$i][7];
                    $time_out = escape_it($time_out);
                    
                }if(array_key_exists( 8, $result[$i])){
                    
                    $hours_worked = $result[$i][8];
                    $hours_worked = escape_it($hours_worked);
                    
                }if(array_key_exists( 9, $result[$i])){
                    
                    $comment = $result[$i][9];
                    $comment = escape_it($comment);
                    
                }if(array_key_exists( 10, $result[$i])){
                    
                    $date = $result[$i][10];
                    $date = escape_it($date);
                    
                }
                 
                 
                 
                 
                 
             }
             else{
                 
                 break;
             }
             //if internal
//time to perform some validation       
         $date = strtotime($date);
         $date = date('Y/m/d',$date);
            
        $time_in = explode(":", $time_in);
        $time_out = explode(":", $time_out);
            
        $the_time_in ="";
        $the_time_out ="";
            
            
        if((isset($time_in[0])) && (isset($time_in[1]))){
            
            
            $the_time_in = $time_in[0].":".$time_in[1];
            
            
        }elseif(isset($time_in[0])){
            
            $the_time_in = $time_in[0].":"."00";
            
        }
        else{
            
            $the_time_in = "00:00";
        }
            
            
        if((isset($time_out[0])) && (isset($time_out[1]))){
            
             $the_time_out = $time_out[0].":".$time_out[1];
            
            
        }elseif(isset($time_out[0])){
            
            $the_time_out = $time_out[0].":"."00";
            
        }else{
            
             $the_time_out = "00:00";
        }
            
        $time_in = $time_in[0];    
        $time_out = $time_out[0];    
            
            if(!is_numeric($time_in)){
                
                $time_in = "9";
                
            }
            if(!is_numeric($time_out)){
                
                $time_out = "17";
            }
            
            
            
            if(empty($time_in)){
                
                $time_in = 0;
                
            }
            
            if(empty($time_out)){
                
                $time_out = 0;
                
            }
            
            if($time_in == 0 || $time_out == 0){
                
                $hours_worked = 0;
            }
            else{
                
                $hours_worked = ceil(strval($time_out) - strval($time_in));    
            }
            
            if($hours_worked < 0){
                
                $hours_worked = 0;
            }
    
        if(!check_Entry_ON_Date($employee_id, $date)){
     if(makeentry($employee_id, $status_option, $site_location, $the_time_in, $the_time_out, $hours_worked, $date, $remarks_option, $comment , $entry_maker_id)){
         
                $flag = true;
                

        }else{
         
         $flag = false;
         
         
         
     }      
    

             
                    }
//             for loop closes           
         }
//       if external
    }
   else{
       
       $flag = false;
       
       
       
   }
return $flag;
}

//update attendance entry
function update_Entry($attendance_id, $status_option, $site_location, $the_time_in, $the_time_out, $hours_worked, $remarks_option, $comment){
    
    $conn = getconnection();
    
         $query = "UPDATE master_attendance SET ";
          $query .="status_option  = '{$status_option}', ";
          $query .="site_location  = '{$site_location}', ";
          $query .="time_in = '{$the_time_in}', ";
          $query .="time_out = '{$the_time_out}', ";
          $query .="hours_worked   =  {$hours_worked}, ";
          $query .="remarks = '{$remarks_option}', ";
          $query .="comment = '{$comment}' ";
          $query .= "WHERE attendance_id = {$attendance_id} ";
           
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return true;
    }
    
}

//view attendance entry by date and for specific entrymaker
function view_Entries($entry_maker_id, $for_date){
    
    $conn = getconnection();
    
    $query = "SELECT attendance_id, attendance_emp_id, status_option, site_location, time_in, time_out, hours_worked, remarks, comment FROM master_attendance WHERE entry_maker_id = {$entry_maker_id} AND attendance_for_date = '{$for_date}'";     
    
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
    }
    
}

//view entries for a particular location for a particular date
function view_Admin_Entries($location, $for_date){
    
    
     $conn = getconnection();
    
     $query = "SELECT attendance_id, attendance_emp_id, status_option, site_location, time_in, time_out, hours_worked, remarks, comment, attendance_for_date  FROM master_attendance LEFT OUTER JOIN employee_location ON attendance_emp_id = id_employee WHERE (employee_location.name_location = '{$location}') AND (master_attendance.attendance_for_date = '{$for_date}')";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}


//view entries for a particular location between two dates
function view_Admin_From_To_Entries($location, $from_date, $to_date,$employeeId){
    
    
     $conn = getconnection();
    
    if($employeeId < 0){
         $query = "SELECT attendance_id, attendance_emp_id, status_option, site_location, time_in, time_out, hours_worked, remarks, comment, attendance_for_date  FROM master_attendance LEFT OUTER JOIN employee_location ON attendance_emp_id = id_employee 
     WHERE (employee_location.name_location = '{$location}') AND (master_attendance.attendance_for_date BETWEEN '{$from_date}' AND '{$to_date}') ORDER BY master_attendance.attendance_for_date ASC";
 }else{
   $query = "SELECT attendance_id, attendance_emp_id, status_option, site_location, time_in, time_out, hours_worked, remarks, comment, attendance_for_date  FROM master_attendance LEFT OUTER JOIN employee_location ON attendance_emp_id = id_employee 
     LEFT JOIN employee e ON   attendance_emp_id = e.employee_id
     WHERE (employee_location.name_location = '{$location}') AND (master_attendance.attendance_for_date BETWEEN '{$from_date}' AND '{$to_date}') and e.employee_internal_id = {$employeeId} ORDER BY master_attendance.attendance_for_date ASC";
 }
     
             
      $execute = mysqli_query($conn,$query);

    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        return $execute;
        
    }  
    
}



//checking wwhether attendences were made on a particular date

function check_Entry_Made($entry_maker_id, $date){
    
    
      $conn = getconnection();
    
     $query = "SELECT attendance_for_date FROM master_attendance WHERE entry_maker_id = {$entry_maker_id} AND attendance_for_date = '{$date}'";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        if(mysqli_num_rows($execute) > 0){
           
           
           return true;
       }
        else{
            
            return false;
        }
        
    } 
    
    
}

//checking wwhether attendences were made on a particular date for employees of particular location
function check_Admin_Entry_Made($location, $date){
    
    
      $conn = getconnection();
   
     $query = "SELECT attendance_for_date FROM master_attendance LEFT OUTER JOIN employee_location ON attendance_emp_id = id_employee WHERE (employee_location.name_location = '{$location}') AND (master_attendance.attendance_for_date = '{$date}')";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        if(mysqli_num_rows($execute) > 0){
           
           
           return true;
       }
        else{
            
            return false;
        }
        
    } 
    
    
}


//checking wwhether attendences were made on a particular from to date for employees of particular location
function check_Admin_From_To_Entry_Made($location, $from_date, $to_date){
    
    
      $conn = getconnection();
   
     $query = "SELECT attendance_for_date FROM master_attendance LEFT OUTER JOIN employee_location ON attendance_emp_id = id_employee WHERE (employee_location.name_location = '{$location}') AND (master_attendance.attendance_for_date BETWEEN '{$from_date}' AND '{$to_date}')";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        if(mysqli_num_rows($execute) > 0){
           
           
           return true;
       }
        else{
            
            return false;
        }
        
    } 
    
    
}


//checking wwhether attendence entry for a particular employee on a particular date was made
function check_Entry_ON_Date($attendance_emp_id, $date){
    
    
      $conn = getconnection();
    
     $query = "SELECT attendance_emp_id FROM master_attendance WHERE attendance_emp_id = {$attendance_emp_id} AND attendance_for_date = '{$date}'";
             
      $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        if(mysqli_num_rows($execute) > 0){
           
           
           return true;
       }
        else{
            
            return false;
        }
        
    } 
    
    
}


//move uploaded file
function movefile($filename, $dir ){
    
    
    if(move_uploaded_file($filename, $dir )){
        
        return true;
        
        }
       else{
          return false;
       } 
    
    
}
     
         
//check whether an username has been already registered or not
function checkUsernameExists($username, $tablename){
    
    $tableusername;
    
    if($tablename == "entry_maker"){
        
        $tableusername = "entrymaker_username";
        
    }
    else{
        
        $tableusername =  $tablename."_username";
        
    }
    
    
    $conn = getconnection();
    $query = "SELECT * FROM ".$tablename." WHERE ".$tableusername."='$username'";
    $execute = mysqli_query($conn,$query);
    if(mysqli_num_rows($execute)>0){
        return true;
        
    }
    else {
        return false;
    }
    
}

//check whether an id has been already assigned to entrymaker or admin
function checkIDExists($id, $tablename){
    
    $tableid;
    
    if($tablename == "entry_maker"){
        
        $tableid = "entrymaker_id";
        
    }
    else{
        
        $tableid =  $tablename."_id";
        
    }
    
    
    $conn = getconnection();
    $query = "SELECT * FROM ".$tablename." WHERE ".$tableid."='$id'";
    $execute = mysqli_query($conn,$query);
    if(mysqli_num_rows($execute)>0){
        return true;
        
    }
    else {
        return false;
    }
    
}

//check whether the location already exists
function checkLocationExists($location_name){
    
    $conn = getconnection();
    $query = "SELECT * FROM location WHERE location_name='$location_name'";
    $execute = mysqli_query($conn,$query);
    if(mysqli_num_rows($execute)>0){
        return true;
        
    }
    else {
        return false;
    }
    
}

//check whether the account no exists
function check_Account_No_Exists($account_no){
    
    $conn = getconnection();
    $query = "SELECT emp_id FROM employee_salary WHERE account_no='$account_no'";
    $execute = mysqli_query($conn,$query);
    if(mysqli_num_rows($execute)>0){
        return true;
        
    }
    else {
        return false;
    }
    
}

//check whether the iban no exists
function check_Iban_No_Exists($iban_no){
    
    $conn = getconnection();
    $query = "SELECT emp_id FROM employee_salary WHERE iban_no='$iban_no'";
    $execute = mysqli_query($conn,$query);
    if(mysqli_num_rows($execute)>0){
        return true;
        
    }
    else {
        return false;
    }
    
}

function updatePassword($email,$password){
    
    global $conn;
//    = mysqli_connect('localhost','tomeship','root','tomeship');
    $query = "UPDATE accounts SET password='$password' WHERE email='$email'";
    $execute = mysqli_query($conn,$query);
    
    if($execute){
        
        return true;
    }
    else{
        
        return false;
    }
    
}

function getid($email){
    global $conn;
        $query = "SELECT * FROM accounts WHERE email='$email'";
        $execute = mysqli_query($conn,$query);
        if($result = mysqli_fetch_assoc($execute))
        {
            
            return $result["id"];
            
        }
}


function sendMail($from,$message,$name){
    
    
$to = "tutlecutleg@gmail.com";
$subject = "Received A Message";
$message = "Name : ".$name."\n Message : ".$message;
//$message = "some thing ";
$header  = "From: ".$from;
    
    if(mail($to,$subject,$message,$header)){
        return true;}
    else{
        return false;
    }
}

//get all employees
function getAllEmployees(){
    $conn = getconnection();
     $query = "SELECT employee_NAME FROM employee";
    $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{

        while($row = mysqli_fetch_assoc($execute)){
            $result[] = $row;
       }
       
            
        return $result;
            
    }
}

//get all locations
function getAllLocations(){
    $conn = getconnection();
     $query = "SELECT location_name FROM location";
    $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{

        while($row = mysqli_fetch_assoc($execute)){
            $result[] = $row;
       }
       
            
        return $result;
            
    }
}

function insertAccountsRecord($location, $employee, $date, $amount, $currency, $description, $transactionid, $paymenttype,$paymentMonth,$paymentYear){

    $queryInsert = "INSERT INTO accounts (id, region, employee, date, amount, currency, description, transactionid, paymenttype,paymentmonth,paymentyear) 
    VALUES (NULL, '$location', '$employee', '$date', '$amount', '$currency', '$description', '$transactionid','$paymenttype','$paymentMonth','$paymentYear')";

    $conn = getconnection();
    $execute = mysqli_query($conn,$queryInsert);

    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        return true;
    }

}

//get all accounts
function getAllAccounts(){
    $conn = getconnection();
     $query = "select a.*,b.employee_NAME from accounts a
     left join employee b on a.employee = b.employee_internal_id";
    $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{

        while($row = mysqli_fetch_assoc($execute)){
            $result[] = $row;
       }
       
            
        return $result;
            
    }
}

function updateAccount($id, $region, $employee, $date, $amount, $currency, $description, $transactionid, $paymenttype){
    
    $conn = getconnection();

    $queryUpdate = "UPDATE accounts SET region =  '$region', employee = '$employee', date = '$date', amount = '$amount',
    currency = '$currency', description = '$description', transactionid = '$transactionid', paymenttype='$paymenttype'
    WHERE accounts.id = '$id'";

    $execute = mysqli_query($conn,$queryUpdate);

    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        return true;
    }

}

function getRegionalEmployees($region){

    $conn = getconnection();
     $query = "SELECT * FROM employee WHERE employee_id in (
        select id_employee from employee_location where name_location = '$region')";
    $execute = mysqli_query($conn,$query);
    $result = array();
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{

        while($row = mysqli_fetch_assoc($execute)){
            $result[] = $row;
       }
       
            
        return $result;
            
    }

}


function getEmployeeDetails($internal_id,$region){

    $conn = getconnection();
     $query = "SELECT * FROM employee emp , employee_salary emp_sal, employee_location emp_loc WHERE emp_loc.id_employee = emp.employee_id and  emp.employee_internal_id = $internal_id and emp_sal.emp_id = emp.employee_id";
    $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{

        while($row = mysqli_fetch_assoc($execute)){
            $result[] = $row;
       }
       
            
        return $result;
            
    }

}


function getAllEmployeeDetails($region){

    $conn = getconnection();
     $query = "SELECT * FROM employee emp , employee_salary emp_sal, employee_location emp_loc WHERE emp_loc.id_employee = emp.employee_id and  emp_sal.emp_id = emp.employee_id and emp_loc.name_location ='$region'";
    $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{

        while($row = mysqli_fetch_assoc($execute)){
            $result[] = $row;
       }
       
            
        return $result;
            
    }

}

function getAttendanceRecordsForMonthYear($internal_id,$region,$status_option,$month,$year){
    $conn = getconnection();
     $query = "SELECT  COUNT(ss.STATUS_OPTION) total FROM `status` ss LEFT JOIN `master_attendance` emp_att on ss.status_option = emp_att.status_option join employee emp on emp.employee_id = emp_att.attendance_emp_id where ss.status_location = '$region' and emp.employee_internal_id = $internal_id and ss.status_option = '$status_option' and attendance_for_date LIKE '".$year."-".$month."%' group by ss.STATUS_OPTION";
     // exit();
     $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{
            
            if($result = mysqli_fetch_assoc($execute))
        {
        
            return $result["total"];

        }
        else {
            
                return null;
            }
            
    }
}

function getAttendanceRecordsForRange($internal_id,$region,$status_option,$fromDate,$toDate){
    $conn = getconnection();
    $fromDate = date('Y-m-d',strtotime($fromDate));
    $toDate = date('Y-m-d',strtotime($toDate));
    $query = "SELECT  COUNT(ss.STATUS_OPTION) total FROM `status` ss LEFT JOIN `master_attendance` emp_att on ss.remarks_option = emp_att.remarks join employee emp on emp.employee_id = emp_att.attendance_emp_id where ss.status_location = '$region' and emp.employee_internal_id = $internal_id and ss.status_option = '$status_option' and attendance_for_date >= '".$fromDate."' and attendance_for_date <= '".$toDate."' group by ss.STATUS_OPTION";
     // exit();
     $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{
            
            if($result = mysqli_fetch_assoc($execute))
        {
        
            return $result["total"];

        }
        else {
            
                return null;
            }
            
    }
}

function getEmployeeSalaryDetails($internal_id){
    $conn = getconnection();
     $query = "SELECT * FROM employee emp , employee_salary emp_sal WHERE emp.employee_internal_id = $internal_id and emp_sal.emp_id = emp.employee_id";
    $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{

        while($row = mysqli_fetch_assoc($execute)){
            $result[] = $row;
       }
       
            
        return $result;
            
    }
}

function getEmployeePaymentDetails($internal_id,$region,$date1,$date2){
    $conn = getconnection();
     $query = "SELECT * FROM accounts WHERE employee = $internal_id and date >= '$date1' and date <= '$date2' and region = '$region' order by id desc";
    $execute = mysqli_query($conn,$query);
    $result = array();
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{

        while($row = mysqli_fetch_assoc($execute)){
            $result[] = $row;
       }
       
            
        return $result;
            
    }
}

function getSiteLocation($internal_id,$region,$date){
    $conn = getconnection();
     $query = "SELECT emp_att.* FROM employee emp JOIN master_attendance emp_att on emp_att.attendance_emp_id = emp.employee_id WHERE emp.employee_internal_id = $internal_id and attendance_for_date = '$date'";
    $execute = mysqli_query($conn,$query);
    $result = array();
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{

        while($row = mysqli_fetch_assoc($execute)){
            $result[] = $row;
       }
       
            
        return $result;
            
    }
}

function checkRemarks($remarks,$internal_id,$regionselect){
    $conn = getconnection();
     $query = "SELECT emp_att.* FROM employee emp LEFT JOIN master_attendance emp_att on emp_att.attendance_emp_id = emp.employee_id WHERE emp.employee_internal_id = $internal_id and attendance_for_date = '$date'";
    $execute = mysqli_query($conn,$query);
    $result = array();
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{

        while($row = mysqli_fetch_assoc($execute)){
            $result[] = $row;
       }
       
            
        return $result;
            
    }
}

function getAllAccountsOnDateRange($startDate, $endDate){
    $conn = getconnection();
    $query = "select a.*,b.employee_NAME from accounts a
    left join employee b on a.employee = b.employee_internal_id
    where date >= '$startDate' and date <= '$endDate'";
   $execute = mysqli_query($conn,$query);
   if(!$execute){
       die("Error in query:". mysqli_error($conn));
   } 
   else{

       while($row = mysqli_fetch_assoc($execute)){
           $result[] = $row;
      }
      
           
       return $result;
           
   }
}

function deleteAccount($id){
    $conn = getconnection();

    $queryUpdate = "DELETE FROM accounts WHERE accounts.id = '$id'";

    $execute = mysqli_query($conn,$queryUpdate);

    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        return true;
    }
   
}


function getPaymentTypes(){
    $conn = getconnection();
    $query = "select type from payment_types";
   $execute = mysqli_query($conn,$query);
   if(!$execute){
       die("Error in query:". mysqli_error($conn));
   } 
   else{

       while($row = mysqli_fetch_assoc($execute)){
           $result[] = $row;
      }
      
           
       return $result;
           
   }
}


function addPaymentType($type){
    
    $conn = getconnection();
    $query = "INSERT INTO payment_types(type) ";
             
      $query .= "VALUES('{$type}') "; 
    
    $execute = mysqli_query($conn,$query);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        return true;
    }
    
}

function getEmployeeSalaryDetailsForPayroll($employee_id){

    $conn = getconnection();
    $result = array();
    $query = "SELECT * FROM employee_salary WHERE emp_id in (
    select employee_id from employee where employee_internal_id = '$employee_id' )";

    $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{

        while($row = mysqli_fetch_assoc($execute)){
            $result[] = $row;
    }
    
            
        return $result;
            
    }
}

function getLastMonthPayments($emp_internal_id,$month, $year){

    $conn = getconnection();
    $query = "SELECT sum(amount) as totalamount FROM accounts WHERE employee = '$emp_internal_id' 
    and paymentmonth = '$month' and paymentyear = '$year'";
// echo json_encode($query);exit;
    $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{

        while($row = mysqli_fetch_assoc($execute)){
            $result[] = $row;
    }

            
        return $result;
            
    }

}

function getLastMonthSalary($empid, $lastMonth, $lastYear){

    $conn = getconnection();
    $query= "SELECT gross_salary 
    as totalsalary FROM `payroll` WHERE emp_id = '$empid' and month = '$lastMonth' and year = '$lastYear' and status = 'active'";
    $result = array();
    $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{

        while($row = mysqli_fetch_assoc($execute)){
            $result[] = $row;
    }

            
        return $result;
            
    }

}

function InsertPayrollData($empid, $accountNo, $ibanNo, $projectAllowance, $housingAllowance, $conveyanceAllowance, $otherAllowance, $basicSalary, $wpsSalary, $totalPreviousPayments, $arrears, $grossSalary, $month, $year, $operator){

    $conn = getconnection();
    // session_start();
    // $operator = $_SESSION["id"];

    // $operator = "test";

    $queryUpdate = "UPDATE payroll set status = 'expired' where emp_id = '$empid' and month = '$month' and year='$year' ";

    $execute = mysqli_query($conn,$queryUpdate);
    
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    }
    else{
        
        $query="INSERT INTO payroll (id, emp_id, account_no, iban_no, project_allowance, 
        housing_allowance, conveyance_allowance, other_allowance, basic_salary, 
        wps_salary, deductions, arrears, gross_salary, month, year, operator, 
        processingdate, status) 
        VALUES (NULL, '$empid', '$accountNo', '$ibanNo', '$projectAllowance', '$housingAllowance', '$conveyanceAllowance',
        '$otherAllowance', '$basicSalary', '$wpsSalary', '$totalPreviousPayments', '$arrears', '$grossSalary', 
        '$month', '$year', '$operator', CURRENT_TIMESTAMP, 'active')";

        $execute2 = mysqli_query($conn,$query);

        if(!$execute2){
            die("Error in query:". mysqli_error($conn));
        }
        else{
            return true;
        }
    
    }   


}

function GetAllPayRollData(){

    $conn = getconnection();
    $query= "SELECT e.employee_internal_id,e.employee_NAME, p.* FROM payroll p
    left join employee e on p.emp_id = e.employee_id where p.status = 'active'";

    $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{

        while($row = mysqli_fetch_assoc($execute)){
            $result[] = $row;
    }

            
        return $result;
            
    }

}

function GetEmployeeEmailForPayroll($empId){

    $conn = getconnection();
    $result = array();
    $query= "SELECT employee_email FROM employee WHERE employee_id = '$empId'";

    $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{

        while($row = mysqli_fetch_assoc($execute)){
            $result[] = $row;
    }

        return $result;
            
    }

}

function getEmployeeArrears($employee_internal_id,$month,$year){
    $conn = getconnection();
     $query = "SELECT pr.* FROM payroll pr join employee e on pr.emp_id = e.employee_id WHERE e.employee_internal_id = $employee_internal_id and pr.month = '$month' and pr.year = '$year' and pr.status = 'active'";
    $execute = mysqli_query($conn,$query);
    $result = array();
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{

        while($row = mysqli_fetch_assoc($execute)){
            $result[] = $row;
       }
       
            
        return $result;
            
    }
}

function getAllEmployeesData(){

    $conn = getconnection();
     $query = "select a.*,b.employee_NAME as operator from employee a 
     left join employee b 
     on a.employee_adder_id = b.employee_id";
    $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{

        while($row = mysqli_fetch_assoc($execute)){
            $result[] = $row;
       }
       
            
        return $result;
            
    }

}

function getAllEmployeesDataWithLocation($location){

    $conn = getconnection();
     $query = "select a.*,b.employee_NAME as operator,c.name_location as operator from employee a 
     left join employee b on a.employee_adder_id = b.employee_id
     left join employee_location c on a.employee_id = c.id_employee
     where c.name_location = '$location'";
    $execute = mysqli_query($conn,$query);

    $result = array();

    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{

        while($row = mysqli_fetch_assoc($execute)){
            $result[] = $row;
       }
       
            
        return $result;
            
    }

}


function getEmployeeSalary($employee_internal_id,$month,$year){
    $conn = getconnection();
     $query = "SELECT pr.* FROM payroll pr join employee e on pr.emp_id = e.employee_id WHERE e.employee_internal_id = $employee_internal_id and pr.month = '$month' and pr.year = '$year' and pr.status = 'active'";
    $execute = mysqli_query($conn,$query);
    $result = array();
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{

        while($row = mysqli_fetch_assoc($execute)){
            $result[] = $row;
       }
       
            
        return $result;
            
    }
}

function getEmployeeSalaryTotal($employee_internal_id,$year){
    $conn = getconnection();
     $query = "SELECT SUM(project_allowance) project_allowance_total , SUM(housing_allowance) housing_allowance_total, SUM(conveyance_allowance) conveyance_allowance_total, SUM(other_allowance) other_allowance_total, SUM(basic_salary) basic_salary_total, SUM(wps_salary) wps_salary_total,SUM(deductions) deductions_total, SUM(arrears) arrears_total, SUM(gross_salary) gross_salary_total FROM payroll pr join employee e on pr.emp_id = e.employee_id WHERE e.employee_internal_id = $employee_internal_id  and pr.year = '$year' and pr.status = 'active'";
    $execute = mysqli_query($conn,$query);
    $result = array();
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{

        while($row = mysqli_fetch_assoc($execute)){
            $result[] = $row;
       }
       
            
        return $result;
            
    }
}

function getAttendanceRecordsForYear($internal_id,$region,$status_option,$year){
    $conn = getconnection();
     $query = "SELECT  COUNT(ss.STATUS_OPTION) total FROM `status` ss LEFT JOIN `master_attendance` emp_att on ss.status_option  = emp_att.status_option  join employee emp on emp.employee_id = emp_att.attendance_emp_id where ss.status_location = '$region' and emp.employee_internal_id = $internal_id and ss.status_option = '$status_option' and attendance_for_date LIKE '".$year."%' group by ss.STATUS_OPTION";
     // exit();
     $execute = mysqli_query($conn,$query);
    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{
            
            if($result = mysqli_fetch_assoc($execute))
        {
        
            return $result["total"];

        }
        else {
            
                return null;
            }
            
    }
}


function getStatusById($statusId){

    $conn = getconnection();
    $query = "SELECT remarks_option FROM status where status_id = " . $statusId;
    $execute = mysqli_query($conn,$query);

    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{
        $value = mysqli_fetch_object($execute);
        return $value->remarks_option;
    }

}

function getsiteLocations($remarksstatusId){

    $conn = getconnection();
     $query = "SELECT * FROM remarks where remarks_statusid = ".$remarksstatusId;
    $execute = mysqli_query($conn,$query);

    $result = array();

    if(!$execute){
        die("Error in query:". mysqli_error($conn));
    } 
    else{

        while($row = mysqli_fetch_assoc($execute)){
            $result[] = $row;
       }
       
            
        return $result;
            
    }

}




?>