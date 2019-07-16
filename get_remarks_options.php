<?php require_once("includes/Database.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php

if(isset($_GET['remarks_statusid'])) {
   
    $the_remarks_option;
     
    
    if(isset($_GET['remarks_option'])){
         
         
         $the_remarks_option = escape_it($_GET['remarks_option']);
         
     }
     
   
    $remarks_statusid = escape_it($_GET['remarks_statusid']);
    
    
     $result = get_remarks_Options_For_Statusoption($remarks_statusid);
     
    if(mysqli_num_rows($result) > 0){
    
     while($row = mysqli_fetch_assoc($result )) {
       $remarks_option = $row['remarks_option'];
         
         if(isset($the_remarks_option)){
                    
                    
                 if($remarks_option == $the_remarks_option){
                 
                 
                echo "<option value='$remarks_option' selected>{$remarks_option}</option>"; 
             }
           else{
                 
                  echo "<option value='$remarks_option'>{$remarks_option}</option>";
             }
                    
                }else{
                    
                    
                   echo "<option value='$remarks_option'>{$remarks_option}</option>";
                    
                }
            
        }}
    else{
         
         echo "<option value=''></option>";
         
     }
     
}

?>
