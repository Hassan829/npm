<?php require_once("includes/Database.php"); ?>
<?php require_once("includes/functions.php");
$result;
$filename;
if((isset($_GET["location"])) && (isset($_GET["fordate"])) && (isset($_GET["todate"]))){                
    $location = escape_it($_GET["location"]);
    $date = escape_it($_GET["fordate"]);
    $to_date = escape_it($_GET["todate"]);
    $filename = $location.$date."-".$to_date.".csv";
    $result = view_Admin_From_To_Entries($location, $date, $to_date);}
elseif((isset($_GET["location"])) && (isset($_GET["fordate"]))){                
    $location = escape_it($_GET["location"]);
    $date = escape_it($_GET["fordate"]);
    $filename = "Attendance".$location.$date.".csv";
    $result = view_Admin_Entries($location, $date);}
if(mysqli_num_rows($result) > 0){
    $f = fopen('php://memory', 'w');
    $sr_no = 1;
    $new_array = array();                     
$array = array("Sr No", "Employee Id", "Staff Name", "Status Option", "Site Location", "Code", "Time In", "Time Out" , "Hours", "Comments", "Date");
function write_array($arrayy) {
    global $f; 
    fputcsv($f, $arrayy);}    
                 write_array($array);
                $sr_no = 1;
                while($entery = mysqli_fetch_assoc($result)){         
                    $employee_id = convert($entery['attendance_emp_id']);
                    $employee_name = getemployeename($employee_id);     
                    $employee_internal_id = get_Employee_Internalid($employee_id);          
                    $attendance_id = convert($entery['attendance_id']);
                    $the_status_option = convert($entery['status_option']);
                    $the_site_location = convert($entery['site_location']);
                    $time_in = convert($entery['time_in']);
                    $time_out = convert($entery['time_out']);
                    $hours_worked = convert($entery['hours_worked']);
                    $the_remarks_option = convert($entery['remarks']);
                    $comment = convert($entery['comment']);        
                    $date = convert($entery['attendance_for_date']);        
                    $abc = array($sr_no++, $employee_internal_id, $employee_name, $the_status_option, $the_site_location, $the_remarks_option, $time_in, $time_out, $hours_worked, $comment, $date);
                    write_array($abc);}
    header("Content-Disposition:attachment;filename='{$filename}'");
    header("Content-Type:application/csv");
    fseek($f, 0);
    fpassthru($f);
    fclose($f);}else{
    echo "nothing to download";
}
?>