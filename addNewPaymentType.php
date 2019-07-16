<?php 
// error_reporting(E_ALL); 
// ini_set('display_errors', 1); 

include("includes/Database.php");

include("includes/functions.php");

$type = $_GET['ptype'];

$updateResult = addPaymentType($type);
// echo $updateResult;
if ($updateResult){
    header("Location: accounts.php?status=Payment Type Added!");
}else{
    header("Location: accounts.php?status=Error Adding Payment Type!");
}



?>