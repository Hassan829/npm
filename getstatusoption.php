<?php require_once("includes/Database.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php

if(isset($_POST['remarks_statusid']) && strlen($_POST['remarks_statusid']) >0 ) {
   
    $remarks_statusid = escape_it($_POST['remarks_statusid']);
    $result = getStatusById($remarks_statusid);
    echo "<option value='".$result."' >".$result."</option>";      
}else{  
    echo "<option value=''></option>";
       }
?>
