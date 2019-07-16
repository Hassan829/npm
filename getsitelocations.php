<?php 
require_once("includes/Database.php");
require_once("includes/functions.php");


if(isset($_POST['remarks_statusid']) && strlen($_POST['remarks_statusid']) >0 ) {
  
    $remarks_statusid = escape_it($_POST['remarks_statusid']);    
    $result = getsiteLocations($remarks_statusid);   
	if(sizeof($result)>0){
		$res = "";
	     for( $i = 0; $i < sizeof($result); $i++ ){
	     	
	     	$res=$res."<option value='".$result[$i]['site_location']."' >".$result[$i]['site_location']."</option>";  
	     }
	 }else{  
	    $res = "<option value=''></option>";
	       }
	       echo $res;

	   }
?>
