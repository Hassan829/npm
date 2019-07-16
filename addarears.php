<?php
session_start();
 require_once("includes/Database.php"); 
 require_once("includes/functions.php"); 
  $operator =$_SESSION['id'];
	$response = "error";
		if( 
			isset($_POST['location']) && 
			isset($_POST['employee']) && ($_POST['employee'] > 0) && 
			isset($_POST['month']) &&
			isset($_POST['year']) &&
			isset($_POST['amount']) ){
			$location = $_POST['location'];
			$employee = $_POST['employee'];
			$month = $_POST['month'];
			$year = $_POST['year'];
			$amount = $_POST['amount'];
			//$empDetails = getemployeedataWithInternalId($employee);
			$response =  getEmployeeArrears($employee,$month,$year);
			if(sizeof($response)==0){
			 	/*if($empDetails['employee_id'] > 0){
			 		$response = InsertArrears($empDetails['employee_id'], 0, 0, 0, 0, 0, 0, 0, 0, 0, $amount, 0, $month, $year, $operator);
			 		if($response)
				 		$response = "Arrears added successfully";
				 	else
				 		$response = "Error occurred while adding arrears";
			 	}else{
			 		$response = "Arrears added successfully";
			 	}*/
			 	$response = "Update Payroll First";
			 		
			}else{
			 	$response = updateArrears($response[0]['id'], $amount);
				 	if($response)
				 		$response = "Arrears updated successfully";
				 	else
				 		$response = "Error occurred while updating arrears";
			 }


			
			
	    }else{
    		$response = "Error Occured"; 
    	}
    
    //}
	if($response == "success"){
		//header('location:../AddCities.php?response=Record Save Successfully');
		echo $response;
	}else{
		//header('location:../AddCities.php?response=Error While Saving Record ');
		echo $response;
	}

?>