<?php require_once("includes/Database.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php

 if(isset($_GET['remarks_statusid'])) {
   
     $the_site_location;
     
     if(isset($_GET['site_location'])){
         
        
         $the_site_location = escape_it($_GET['site_location']);
         
     }
     
   
    $remarks_statusid = escape_it($_GET['remarks_statusid']);
    
    
     $result = get_site_location_For_Statusoption($remarks_statusid);
     
     if(mysqli_num_rows($result) > 0){
     
     while($row = mysqli_fetch_assoc($result )) {
        $site_location = $row['site_location'];
         
                if(isset($the_site_location)){
                    
                    
                 if($site_location === $the_site_location){
                 
                 
                echo "<option value='$site_location' selected>{$site_location}</option>"; 
             }
           else{
                 
                  echo "<option value='$site_location'>{$site_location}</option>";
             }
                    
                }else{
                    
                    
                    echo "<option value='$site_location'>{$site_location}</option>";
                    
                }
            
        }}
     else{
         
         echo "<option value=''></option>";
         
     }
     
}

?>
