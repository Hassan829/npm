<?php 
include("includes/Database.php");
include("includes/functions.php");
 //ini_set('display_errors', 'ON');
require_once 'PHPExcel/Classes/PHPExcel.php';

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["accountsData"]["name"]);
$uploadOk = 1;
$resultInsert = false;
$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if file already exists
if (file_exists($target_file)) {
    unlink($target_file);
}
// Allow certain file formats
if($fileType != "xlsx") {
    $responce = "Sorry, only xlsx file is allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $responce = "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["accountsData"]["tmp_name"], $target_file)) {
        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        $responce = "Sorry, there was an error uploading your file.";
        $uploadOk == 0;
    }
}

if($uploadOk == 1){
 try{

    $inputFileType = PHPExcel_IOFactory::identify($target_file);  
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);  

    $objReader->setReadDataOnly(true);

    /**  Load $inputFileName to a PHPExcel Object  **/  
    $objPHPExcel = $objReader->load($target_file);

    $total_sheets=$objPHPExcel->getSheetCount(); 

    $allSheetName=$objPHPExcel->getSheetNames(); 
    $objWorksheet = $objPHPExcel->setActiveSheetIndex(0); 
    $highestRow = $objWorksheet->getHighestRow(); 
    $highestColumn = $objWorksheet->getHighestColumn();  
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);  

    for ($row = 3; $row <= $highestRow; ++$row){
        $accountsData = [];
        $i = 0;
        for ($col = 0; $col <$highestColumnIndex;++$col) { 
            if($objWorksheet->getCellByColumnAndRow($col, $row)->getValue() != null){
                if($col == 0){
               $location = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
               $location = str_replace('_', ' ', $location);
                $accountsData[$i] = $location;  
                }elseif ($col == 1){
                    $accountsData[$i] = $objWorksheet->getCellByColumnAndRow($col, $row)->getFormattedValue();                
                    if($accountsData[$i] == null)
                        break;
                }elseif ($col == 7){
                    $accountsData[$i] = $objWorksheet->getCellByColumnAndRow($col, $row)->getFormattedValue();                
                }elseif($col == 3){
                   $accountsData[$i] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow($col, $row)->getValue()));
                }else{
                  $accountsData[$i] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();  
                }
               
               $i++; 
            }  
            
       }  
       if($accountsData[1] != null && !empty($accountsData)){
        $resultInsert =  insertAccountsRecord($accountsData[0], $accountsData[1], $accountsData[3], $accountsData[6], 
        $accountsData[7], $accountsData[9], $accountsData[10], $accountsData[8],$accountsData[4],$accountsData[5]);
        $responce = "Accounts Data Imported Successfully!";
       }
      

    }

    }catch(Exception $e){
        $resultInsert = false;
        $responce = "Failed to Import Accounts Data!";

    }
}

if ($resultInsert == true && $uploadOk == 1){
    header("Location:accounts.php?status=".$responce);
}else{
    header("Location:accounts.php?status=".$responce);
}


?>
