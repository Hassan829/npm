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
    $operator = $_POST['operator'];

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

    if ($month < 10){
        $month="0".$month;
    }

    $daysLastMonth=cal_days_in_month(CAL_GREGORIAN,$lastMonth,$lastYear);

    $daysCurrentMonth=cal_days_in_month(CAL_GREGORIAN,$month,$year);

    $startLastDate = $year."-".$month."-01";
    $endLastDate = $year."-".$month."-".$daysCurrentMonth;

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

                $absence = getAttendanceRecordsForMonthYear($employee,$region,'Absence',$month,$year);
                
                if ($absence == null || $absence == ""){
                    $absence = 0;
                }

                $unpaidLeave = getAttendanceRecordsForMonthYear($employee,$region,'UnpaidLeave',$month,$year);

                if ($unpaidLeave == null || $unpaidLeave == ""){
                    $unpaidLeave = 0;
                }

                $Job = getAttendanceRecordsForMonthYear($employee,$region,'Job',$month,$year);

                if ($Job == null || $Job == ""){
                    $Job = 0;
                }
                
                // echo json_encode($absence);exit;
                
                // A = basic_salary x ((total days - (absence + unpaid leave)) / total days)
				$basicSalary = round( $employeeSalaryDetails[0]['basic_salary'] * (($daysCurrentMonth - ($absence + $unpaidLeave)) / $daysCurrentMonth));

				// B = housing_allowance x ((total days - (absence + unpaid leave)) / total days)
				$housingAllowance = round( $employeeSalaryDetails[0]['housing_allowance'] * (($daysCurrentMonth - ($absence + $unpaidLeave)) / $daysCurrentMonth));

				// C = conveyance_allowance x ((total days - (absence + unpaid leave)) / total days)
				$conveyanceAllowance = round( $employeeSalaryDetails[0]['conveyance_allowance'] * (($daysCurrentMonth - ($absence + $unpaidLeave)) / $daysCurrentMonth));

				// D = other_allowance x ((total days - (absence + unpaid leave)) / total days)
				$otherAllowance = round( $employeeSalaryDetails[0]['other_allowance'] * (($daysCurrentMonth - ($absence + $unpaidLeave)) / $daysCurrentMonth));

				// E = project_allowance x ((total days - (absence + unpaid leave)) / total days)
				$projectAllowance = round($employeeSalaryDetails[0]['project_allowance'] * ($Job));

                $netSalary = $projectAllowance+$housingAllowance+$conveyanceAllowance+$otherAllowance+$basicSalary+$wpsSalary;
                //arrears of last month = salary of last month - payments of last month
               //test case ########### 
                //$employeearrear = getEmployeeSalary($employeeDetailsData['employee_internal_id'],$lastmonth,$lastyear);
                   //  $arrearA = round( $empSalary['gross_salary']);
                // End here ###########
                if ($netSalary==null || $netSalary == ""){
                    $netSalary=0;
                }
                
                $lastMonthPayments = getLastMonthPayments($employee, $lastMonth, $lastYear);

                $totalPreviousPayments = $lastMonthPayments[0]['totalamount'];
                
                if ($totalPreviousPayments == null || $totalPreviousPayments == ""){
                    $totalPreviousPayments = 0;
                }
                // echo json_encode($totalPreviousPayments);exit;
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
                //$arrears = $lastSalary - $lastMonthSalary;
                

                $grossSalary = $netSalary + $arrears;
                // total payments this month
                $currentMonthPayments = getLastMonthPayments($employee, $month, $year);
                $totalCurrentMonthPayments = $currentMonthPayments[0]['totalamount'];

                if ($totalCurrentMonthPayments == null || $totalCurrentMonthPayments == ""){
                    $totalCurrentMonthPayments = 0;
                }
                $deductions = $totalCurrentMonthPayments;
                //attemp to fix
                // $netsalary2 = $projectAllowance + $housingAllowance + $conveyanceAllowance + $otherAllowance + $basicSalary -$totalPreviousPayments + $arrears;
                // $netSalary2 = $grossSalary - $totalCurrentMonthPayments;
                $insertStatus = InsertPayrollData($empId, $accountNo, $ibanNo, $projectAllowance, $housingAllowance, $conveyanceAllowance, $otherAllowance, $basicSalary, $wpsSalary, $deductions, $arrears, $grossSalary, $month, $year,$operator);
                
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