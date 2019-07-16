<?php require_once("includes/Database.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
 
 if((isset($_GET['remarks_status_id'])) && (isset($_GET['site_location'])) ) {
   
   
     $remarks_status_id = escape_it($_GET['remarks_status_id']);
     $site_location = escape_it($_GET['site_location']);
     
     if($remarks_status_id == "undefined" || $remarks_status_id == null || empty($remarks_status_id) || $site_location == "undefined" || $site_location == null || empty($site_location) ){
        
         echo "remarks status id/option empty";
         
         
    }
     else{
         
       if(remove_Remark($remarks_status_id, $site_location)){
           
         echo "true";
           
       }
         
     }
     
 }
?>  