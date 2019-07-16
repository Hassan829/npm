<?php
ob_start();
include_once("includes/Database.php");
include_once("includes/functions.php");

try{

if (isset($_POST['payrolltype'])){

    $payrollType = $_POST['payrolltype'];
    $region = $_POST['regionselect'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $emailIntimation = $_POST['sendemail'];

    $lastMonth = "";
    $lastYear = "";

    if ($month=="1"){
        $lastMonth = "12";
        $lastYear=$year-1;
    }else{
        $lastMonth = $month-1;
        $lastYear=$year;
    }

    if ($lastMonth < 10){
        $lastMonth="0".$lastMonth;
    }

    $daysLastMonth=cal_days_in_month(CAL_GREGORIAN,$lastMonth,$lastYear);

    $startLastDate = $lastYear."-".$lastMonth."-01";
    $endLastDate = $lastYear."-".$lastMonth."-".$daysLastMonth;

    if ($payrollType == "all"){

        if ($region == "all"){
            //for all regions / all employess
        }else{
            //for employees of only one region
        }
        echo json_encode("success");

    }else if ($payrollType == "single"){

        $employee = $_POST['employeeSelect'];

        if ($employee != "" && $employee != null && $employee != "null"){
            //generate payroll of one selected employee

            $employeeSalaryDetails = getEmployeeSalaryDetailsForPayroll($employee);

            //iterate through above object as [0]['basic_salary']

            if (isset($employeeSalaryDetails[0]['emp_id'])){

                $empId = $employeeSalaryDetails[0]['emp_id'];
                $accountNo = $employeeSalaryDetails[0]['account_no'];
                $ibanNo = $employeeSalaryDetails[0]['iban_no'];
                // $projectAllowance = $employeeSalaryDetails[0]['project_allowance'];
                // $housingAllowance = $employeeSalaryDetails[0]['housing_allowance'];
                // $conveyanceAllowance = $employeeSalaryDetails[0]['conveyance_allowance'];
                // $otherAllowance = $employeeSalaryDetails[0]['other_allowance'];
                // $basicSalary = $employeeSalaryDetails[0]['basic_salary'];
                // $wpsSalary = $employeeSalaryDetails[0]['wps_salary'];
                $wpsSalary = 0;

                $absence = getAttendanceRecordsForMonthYear($employee,$region,'Absence',$lastMonth,$lastYear);
                
                if ($absence == null || $absence == ""){
                    $absence = 0;
                }
// echo json_encode($absence);exit;
                $unpaidLeave = getAttendanceRecordsForMonthYear($employee,$region,'UnpaidLeave',$lastMonth,$lastYear);

                if ($unpaidLeave == null || $unpaidLeave == ""){
                    $unpaidLeave = 0;
                }

                $Job = getAttendanceRecordsForMonthYear($employee,$region,'Job',$lastMonth,$lastYear);

                if ($Job == null || $Job == ""){
                    $Job = 0;
                }
                
                
                // A = basic_salary x ((total days - (absence + unpaid leave)) / total days)
				$basicSalary = round( $employeeSalaryDetails[0]['basic_salary'] * (($daysLastMonth - ($absence + $unpaidLeave)) / $daysLastMonth));

				// B = housing_allowance x ((total days - (absence + unpaid leave)) / total days)
				$housingAllowance = round( $employeeSalaryDetails[0]['housing_allowance'] * (($daysLastMonth - ($absence + $unpaidLeave)) / $daysLastMonth));

				// C = conveyance_allowance x ((total days - (absence + unpaid leave)) / total days)
				$conveyanceAllowance = round( $employeeSalaryDetails[0]['conveyance_allowance'] * (($daysLastMonth - ($absence + $unpaidLeave)) / $daysLastMonth));

				// D = other_allowance x ((total days - (absence + unpaid leave)) / total days)
				$otherAllowance = round( $employeeSalaryDetails[0]['other_allowance'] * (($daysLastMonth - ($absence + $unpaidLeave)) / $daysLastMonth));

				// E = project_allowance x ((total days - (absence + unpaid leave)) / total days)
				// $e = round( $employeeDetailsData['project_allowance'] * (($daysLastMonth - ($absence + $unpaidLeave)) / $daysLastMonth));
				$projectAllowance = 20 * ($Job);

                $netSalary = $projectAllowance+$housingAllowance+$conveyanceAllowance+$otherAllowance+$basicSalary+$wpsSalary;
                //arrears of last month = salary of last month - payments of last month
                

                if ($netSalary==null || $netSalary == ""){
                    $netSalary=0;
                }
                
                $lastMonthPayments = getLastMonthPayments($employee,$startLastDate, $endLastDate);

                $totalPreviousPayments = $lastMonthPayments[0]['totalamount'];
                
                if ($totalPreviousPayments == null || $totalPreviousPayments == ""){
                    $totalPreviousPayments = 0;
                }
                
                $lastMonthSalary = getLastMonthSalary($empId, $lastMonth, $lastYear);

                if (isset($lastMonthSalary[0]['totalsalary'])){

                    $lastSalary = $lastMonthSalary[0]['totalsalary'];

                    if ($lastSalary == "" || $lastSalary == null){
                        $lastSalary = 0;
                    }

                }else{
                    $lastSalary = 0;
                }


                $arrears = $lastSalary - $totalPreviousPayments;

                // echo json_encode($lastSalary);exit;

                $grossSalary = $netSalary + $arrears;
                
                $insertStatus = InsertPayrollData($empId, $accountNo, $ibanNo, $projectAllowance, $housingAllowance, $conveyanceAllowance, $otherAllowance, $basicSalary, $wpsSalary, $totalPreviousPayments, $arrears, $grossSalary, $month, $year);
                // $insertStatus = true;
                if ($insertStatus==true){

                    if ($emailIntimation == "notsend"){
                        echo json_encode("success");
                    }else if ($emailIntimation == "send"){

                        $empEmailRow = GetEmployeeEmailForPayroll($empId);

                        // $mailto = $empEmailRow[0]['employee_email'];

                        $mailto = "adnan@npm.works";

                        $empName = getemployeename($empId);

                        $salaryDetailsEmail = "<b>Account No:</b> $accountNo<br><b>Food Allowance:</b> $projectAllowance<br><b>Housing Allowance: </b>$housingAllowance<br><b>Conveyance Allowance: </b>$conveyanceAllowance<br><b>Other Allowance: </b>$otherAllowance<br><b>Basic Salary: </b>$basicSalary<br><b>Arrears: </b>$arrears<br><b>Payments Made: </b>$totalPreviousPayments<br><b>Gross Salary: </b>$grossSalary";
                        
                        //The header can include their name, ID and the month,year for payroll.
                        $headEmail = "Salary Information | Employee ID: $employee | Name: $empName | Month: $month | Year: $year";
                        
                        $subject = $headEmail;
                        $headers = "From: NPM\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                        $messageCommon = "Dear Employee,<br><br>";
                        $messageCommon .= "Please find below the details of your salary for $month-$year,<br/><br/>";
                        $messageCommon .= $salaryDetailsEmail."<br/><br/>";  //sending table via email
                        $messageCommon .= "Regards,<br>";
                        $messageCommon .= "NPM";

                        if (@mail ($mailto, $subject, $messageCommon, $headers)){
                            // echo $EMAILINTIMATION='SENT';
                        }else{
                            // echo $EMAILINTIMATION='NOT SENT';
                        }

                        //email sending code goes here...

                        echo json_encode("success");
                    }

                    
                }else{
                    echo json_encode("failure");
                }

            }else{
                echo json_encode("failure");
            }

            
        }else{
            echo json_encode("error");
        }


    }else{

        echo json_encode("error");

    }

}else{
    echo json_encode("error");
}

}catch(Exception $e){

    echo json_encode("error");

}
?>