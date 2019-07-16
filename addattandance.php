<?php
session_start();
 require_once("includes/Database.php"); 
 require_once("includes/functions.php"); 
$id = $_SESSION["id"];

  $todaydate=date("Y/m/d");
 
$dateless = explode('-',$_POST['date']);
 
  $currDay = $dateless[0];
  $currMonth = $dateless[1];
  $currYear = $dateless[2];

  $currDate = $currDay."-".$currMonth."-".$currYear;
  $currDate = date_create($currDate);
   $currDate = date_format($currDate,"Y/m/d");

if($currDate>$todaydate){
   $messageTemp = "Future date entry not allowed!";

}else{
if(isset($_POST["employeeSelect"]) && isset($_POST['locationselect1']) && $_POST["employeeSelect"]>0){
      
      $employeeDetails = getEmployeeDetails($_POST["employeeSelect"],$_POST["locationselect1"]);

      for($i = 0; $i < sizeof($employeeDetails); $i++){
      $employee_id = $employeeDetails[$i]['employee_id'];
      }


	      $region = $_POST["locationselect1"];
        $status_option = $_POST["status_option"];
        $site_location = $_POST["site_location"];
        $remarks_option = $_POST["remarks_option"];
        $time_in = $_POST["time_in"];
        $time_out = $_POST["time_out"];
        $hours_worked = $_POST["hours_worked"];
        $comment = "";
        $date = $_POST["date"];       
           
        $employee_id = escape_it($employee_id);
        $status_option = escape_it($status_option);
        $site_location = escape_it($site_location);
        $remarks_option = escape_it($remarks_option);
        $time_in = escape_it($time_in);
        $time_out = escape_it($time_out);
        $hours_worked = escape_it($hours_worked);
        $comment = escape_it($comment);
        $date = escape_it($date);

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
             if(makeentry($employee_id, $status_option, $site_location, $the_time_in, $the_time_out, $hours_worked, $date, $remarks_option, $comment , $id)){
            
           
            $messageTemp = "Successfully marked attendance";

           }
           else{
                    $messageTemp = "Error Occured";
                   
               }
               
               
           }else{
             $messageTemp = "Record already exists";
           }

        
        header("Location: viewattendanceentry.php?status=$messageTemp");
}else{
$messageTemp = "invalid values";
}
}
 header("Location: viewattendanceentry.php?status=$messageTemp");
?>