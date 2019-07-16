<?php 
// error_reporting(E_ALL); 
// ini_set('display_errors', 1); 

include("includes/Database.php");

include("includes/functions.php");

$id = $_POST['idedit'];
$employee = $_POST['employeeSelectEdit'];
$region = $_POST['regionselectedit'];
$date = $_POST['dateinputedit'];
$amount = $_POST['amountedit'];
$currency = $_POST['currencyselectedit'];
$description = $_POST['descriptionedit'];
$transactionid = $_POST['transactionidedit'];
$paymenttype = $_POST['paymenttypeselectedit'];

$updateResult = updateAccount($id, $region, $employee, $date, $amount, $currency, $description, $transactionid, $paymenttype);
// echo $updateResult;
if ($updateResult){
    header("Location: accounts.php?status=Record Edited!");
}else{
    header("Location: accounts.php?status=Error Editing Record!");
}



?>