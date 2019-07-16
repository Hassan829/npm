<?php
include("includes/Database.php");

include("includes/functions.php");

if (isset($_POST['updatedData']) && count($_POST['updatedData']) > 0){
	$updatedData = $_POST['updatedData'];
    $location = $_POST['location'];
    $fordate = $_POST['date'];
    $todate = $_POST['todate'];
	$data = json_decode($updatedData,true);
	foreach ($data as $object=> $value) {
     	if(update_Entry($value['attendanceId'], $value['status_option'], $value['site_location'], $value['timeIn'], $value['timeOut'], $value['hours_worked'], $value['remarks_option'], $value['comments'])){
         
         $messageTemp = "Successfully Updated!";

         header("Location: viewattendanceentry.php?status=$messageTemp");

        }
        else{          

                $messageTemp = "Some Error Occoured, Try Again";
                header("Location: viewattendanceentry.php?status=$messageTemp");
                
            } 	


    }
}////if ended
else{   

	     $messageTemp = "No record updated";
         header("Location: viewattendanceentry.php?status=$messageTemp");
}



?>