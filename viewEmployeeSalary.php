<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<body>

  <div class="container-scroller">

<?php 
include("includes/header.php"); 

$stats = "";

if (strtolower($_SESSION["role"])!="super admin"){

    $tempMessage = "Permission Denied!";
    header("Location: viewAllEmployees.php?status=$tempMessage");

}

if (isset($_GET['status'])){
    $stats = $_GET['status'];
    echo "<script>alert($stats);</script>";
}

if(isset($_GET['employee_id'])){

    $emp_id =  escape_it($_GET['employee_id']);

    $data = get_Employee_Salary_Data($emp_id);

    if($result = mysqli_fetch_assoc($data)){

        $account_no = convert($result['account_no']);
        $iban_no = convert($result['iban_no']);
        $project_allowance = convert($result['project_allowance']);
        $housing_allowance = convert($result['housing_allowance']);
        $conveyance_allowance = convert($result['conveyance_allowance']);
        $other_allowance = convert($result['other_allowance']);
        $basic_salary = convert($result['basic_salary']);
        $wps_salary = convert($result['wps_salary']);
        $deductions = convert($result['deductions']);
        
        $join_date = convert($result['join_date']);
        $termination_date = convert($result['termination_date']);

    }else{
        header("Location: viewAllEmployees.php?status=Unable To fetch Salary Information! Please try again.");
    }
}else{
    header("Location: viewAllEmployees.php?status=Unable To fetch Salary Information! Please try again.");
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
                        <h3>Edit Employee's Salary</h3>
                        <p class="card-description">
                            Manage Employee Salary<br>
                        </p>

                        <form class = "custform" method="POST" action="" id ="custform">
                                
                                        
                            <input type="hidden" name="emp_id" value="<?php echo $emp_id ;  ?>">
                            <input type="hidden" name="actual_account_no" value="<?php echo $account_no ;  ?>">
                            <input type="hidden" name="actual_iban_no" value="<?php echo $iban_no ;  ?>">
                            
                            <div class="form-group">
                            <label>Account No</label>
                            <input type="text" class="form-control" name="account_no" placeholder="upto 24 characters" maxlength="24" value="<?php echo $account_no; ?>">
                            </div>
                        
                        <div class="form-group">
                            <label>IBAN</label>
                            <input type="text" class="form-control" name="iban_no" placeholder="upto 24 characters" maxlength="24" value="<?php echo $iban_no; ?>">
                            </div>
                        
                        <div class="form-group">
                            <label>Project Allowance</label>
                            <input type="text" class="form-control" value="<?php echo $project_allowance; ?>" name="project_allowance" placeholder="upto 6 digits" maxlength="6">
                            </div>
                        
                                    <div class="form-group">
                            <label>Housing Allowance</label>
                            <input type="text" class="form-control" value="<?php echo $housing_allowance; ?>" name="housing_allowance" placeholder="upto 6 digits" maxlength="6">
                            </div>
                        
                                    <div class="form-group">
                            <label>Conveyance Allowance</label>
                            <input type="text" class="form-control" value="<?php echo $conveyance_allowance; ?>" name="conveyance_allowance" placeholder="upto 6 digits" maxlength="6">
                            </div>
                        
                                    <div class="form-group">
                            <label>Other Allowance</label>
                            <input type="text" class="form-control" value="<?php echo $other_allowance; ?>" name="other_allowance" placeholder="upto 6 digits" maxlength="6">
                            </div>
                        
                                    <div class="form-group">
                            <label>Basic Salary</label>
                            <input type="text" class="form-control" value="<?php echo $basic_salary; ?>" name="basic_salary" placeholder="upto 6 digits" maxlength="6">
                            </div>
                        
                                    <div class="form-group">
                            <label>WPS Salary</label>
                            <input type="text" class="form-control" value="<?php echo $wps_salary; ?>" name="wps_salary" placeholder="upto 6 digits" maxlength="6">
                            </div>
                        
                                    <div class="form-group">
                            <label>Deductions</label>
                            <input type="text" class="form-control" value="<?php echo $deductions; ?>" name="deductions" placeholder="upto 6 digits" maxlength="6">
                            </div>
                        
                                    
                                    
                            <div class="form-group">
                                <label >Join Date</label>
                                <input type="text" class="form-control" name="join_date" placeholder="yyyy-mm-dd" value="<?php echo $join_date; ?>">
                            </div>
                                    
                            <div class="form-group">
                                <label >Termination Date</label>
                                <input type="text" class="form-control" name="termination_date" placeholder="yyyy-mm-dd" value="<?php echo $termination_date; ?>">
                            </div>
                                
                            <div class="form-group">
                                <input class="btn btn-success" type="submit" name="update_emp_salary" style="background:#006a4a;" value="Update Salary">
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

    
<?php

 if(isset($_POST['update_emp_salary'])) {
     
     $employ_id = escape_it($_POST['emp_id']);
     $account_no = escape_it($_POST['account_no']);
     $iban_no = escape_it($_POST['iban_no']);
     $actual_account_no = escape_it($_POST['actual_account_no']);
     $actual_iban_no = escape_it($_POST['actual_iban_no']);
     $project_allowance = escape_it($_POST['project_allowance']);
     $housing_allowance = escape_it($_POST['housing_allowance']);
     $conveyance_allowance = escape_it($_POST['conveyance_allowance']);
     $other_allowance = escape_it($_POST['other_allowance']);
     $basic_salary = escape_it($_POST['basic_salary']);
     $wps_salary = escape_it($_POST['wps_salary']);
     $deductions = escape_it($_POST['deductions']);
     
     $join_date = escape_it($_POST['join_date']);
     $termination_date = escape_it($_POST['termination_date']);
     
     $dateless = explode('-',$join_date);
            
            if((!empty($dateless[0])) && (!empty($dateless[1])) && (!empty($dateless[2]))){
                
                $join_date = $dateless[1] ."/".$dateless[2]. "/".$dateless[0];
                
            }
            
            $join_date = strtotime($join_date);
            $join_date= date('Y/m/d',$join_date); 
     
     
     $dateless = explode('-',$termination_date);
     
     if((!empty($dateless[0])) && (!empty($dateless[1])) && (!empty($dateless[2]))){
                
                $termination_date = $dateless[1] ."/".$dateless[2]. "/".$dateless[0];
                
            }
            
            $termination_date = strtotime($termination_date);
            $termination_date = date('Y/m/d',$termination_date); 
     
    if(strlen($account_no) > 24){
        
        $tempMessage = "**Account No can have 24 characters**";
        header("Location: viewEmployeeSalary.php?status=".$tempMessage);
        
    }elseif(strlen($iban_no) > 24){
        
        $tempMessage = "**IBAN No can have 24 characters**";
        header("Location: viewEmployeeSalary.php?status=".$tempMessage);
        
    }elseif(strlen($iban_no) > 24){
        
        $tempMessage = "**IBAN No can have 24 characters**";
         header("Location: viewEmployeeSalary.php?status=".$tempMessage);
        
    }elseif(!is_numeric($project_allowance)){
        
        $tempMessage = "**Please give numeric values for allowances/salaries**";
         header("Location: viewEmployeeSalary.php?status=".$tempMessage);
        
    }elseif(!is_numeric($housing_allowance)){
        
        $tempMessage = "**Please give numeric values for allowances/salaries**";
         header("Location: viewEmployeeSalary.php?status=".$tempMessage);
        
    }elseif(!is_numeric($conveyance_allowance)){
        
        $tempMessage = "**Please give numeric values for allowances/salaries**";
         header("Location: viewEmployeeSalary.php?status=".$tempMessage);
        
    }elseif(!is_numeric($other_allowance)){
        
        $tempMessage = "**Please give numeric values for allowances/salaries**";
         header("Location: viewEmployeeSalary.php?status=".$tempMessage);
        
    }elseif(!is_numeric($basic_salary)){
        
        $tempMessage = "**Please give numeric values for allowances/salaries**";
         header("Location: viewEmployeeSalary.php?status=".$tempMessage);
        
    }elseif(!is_numeric($wps_salary)){
        
        $tempMessage = "**Please give numeric values for allowances/salaries**";
         header("Location: viewEmployeeSalary.php?status=".$tempMessage);
        
    }elseif(!is_numeric($deductions)){
        
        $tempMessage = "**Please give numeric values for allowances/salaries**";
         header("Location: viewEmployeeSalary.php?status=".$tempMessage);
        
    }
     else{
         
         if($account_no != $actual_account_no){
        
        if(!empty($account_no)){
            
            if(check_Account_No_Exists($account_no)){
        
        $tempMessage = "**Account no already exists**";
         header("Location: viewEmployeeSalary.php?status=".$tempMessage);
        
                                                    } }
         
        }
         
         
         if($iban_no != $actual_iban_no){
        
        
            if(!empty($iban_no)){
                   if(check_Iban_No_Exists($iban_no)){
        
        $tempMessage = "**IBAN No already exists**";
         header("Location: viewEmployeeSalary.php?status=".$tempMessage);
        
                                    }
                
                
            }
       
                            }
                            
         if(update_Employee_Salary($employ_id, $account_no, $iban_no, $project_allowance, $housing_allowance,   $conveyance_allowance, $other_allowance, $basic_salary, $wps_salary, $deductions, $join_date,  $termination_date)){
             
             $tempMessage = "**Successfully Updated Salary!**";
          header("Location: viewAllEmployees.php?status=".$tempMessage);
             
         }
         else{
             
             $tempMessage = "**Something Went Wrong, try Again!**";
         header("Location: viewAllEmployees.php?status=".$tempMessage);
             
             
         }

}
//else ends here
   
      
}
//isset ends here
?>