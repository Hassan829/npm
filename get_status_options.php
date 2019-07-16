<?php require_once("includes/Database.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php

if(isset($_GET['location'])) { 
     
    
    $location = escape_it($_GET["location"]);
    
    if(empty($location)||$location == ""||$location == "undefined"){
        
        
        }
     
     else{
         
         $result = get_Status_Options_For_location($location);
         
         while($row = mysqli_fetch_assoc($result )) {
        $status_id = $row['status_id'];
        $status_option = $row['status_option'];
          
    echo "<option value='{$status_option}' id='$status_id'>{$status_option}</option>";
             
            }}   

}
//isset close
?>