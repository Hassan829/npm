<?php
include("includes/Database.php");

include("includes/functions.php");

// $_GET['region'] = "SAUDI ARABIA";

$region = $_GET['region'];

$result = getRegionalEmployees($region);

$returnString="";
$returnString = '<option value = "-1"> Select </option>';
foreach($result as $row){

    $returnString = $returnString."<option value = '".$row['employee_internal_id']."'>".$row['employee_internal_id']
    ." - ".$row['employee_NAME']."</option>";

}

echo json_encode($returnString);

?>