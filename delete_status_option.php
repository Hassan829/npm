<?php require_once("includes/Database.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
 
 if(isset($_GET['status_id'])) {
   
   
     $status_id = escape_it($_GET['status_id']);

     if($status_id == "undefined" || $status_id == null || empty($status_id) ){
        
         echo "remarks status id/option empty";
         
         
    }
     else{
         
       if(remove_Status_Option($status_id)){
           
         echo "true";
           
       }
         
     }
     
 }
?>  