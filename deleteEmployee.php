<?php 
require_once("includes/Database.php"); 
require_once("includes/functions.php");

if(isset($_GET['removeemployee'])) {
   
    $conn = getconnection();
  
    $id = escape_it($_GET["removeemployee"]);
    
    if($id == "undefined" || $id == null || empty($id)){
       $tempMessage = "**Select An Employee first To Remove**";
       header("Location: viewAllEmployees.php?status=$tempMessage");
   }
    else{
        
      if(removeemployee($id)){
         remove_Employee_Location($id); 
        $tempMessage = "Successfully Removed!";
        header("Location: viewAllEmployees.php?status=$tempMessage");
          
      }
        
    }
    
}

?>