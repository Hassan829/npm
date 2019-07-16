<?php 
// error_reporting(E_ALL); 
// ini_set('display_errors', 1); 

include("includes/Database.php");

include("includes/functions.php");

$id = $_GET['id'];

$updateResult = deleteAccount($id);
// echo $updateResult;
if ($updateResult){
    header("Location: accounts.php?status=Record Deleted!");
}else{
    header("Location: accounts.php?status=Error Deleting Record!");
}



?>