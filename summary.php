<?php ob_start(); ?>
<!DOCTYPE html>
<head>

<meta charset="utf-8">
 <meta name="author" content="Hussnain Ali Hamza Shah">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <meta name="robots" content="noindex, nofollow">
 
<!-- <link rel="icon" href="images/favicon.png"> -->
    
<link href="oldassets/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="oldassets/js/jquery.min.js"></script>
<!-- Custom Theme files -->
<link href="oldassets/css/style.css" rel='stylesheet' type='text/css' />
 <!-- Custom Theme files -->
 
 <script type="text/javascript" src="https://www.google.com/jsapi"></script>   
    
<!-- webfonts -->
	<link href='//fonts.googleapis.com/css?family=Asap:400,700,400italic' rel='stylesheet' type='text/css'>
	<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    
<!-- webfonts -->
    
<!--    icons -->
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    
<!--    icons end-->
 <!---- start-smoth-scrolling---->
<script type="text/javascript" src="oldassets/js/move-top.js"></script>
<script type="text/javascript" src="oldassets/js/easing.js"></script>
	<script type="text/javascript">
			jQuery(document).ready(function($) {
                
                checkForChanges();
                function checkForChanges(){
                        
                            var width = $( document ).width();
                        var set_width_element = $(".navigationcontainer");
                        var set_height_element = $(".dashboard");
                        var target_height_element = $(".contentswrapper");
                        var target_height = target_height_element.css("height");
                        set_width_element.css("width", width);
                        set_height_element.css("height", target_height);
                    setTimeout(checkForChanges, 500);
                }                
                //detect change in width and height and change the width and height
                
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
				});
			});
		</script>

<style>

table{
	border: 2px solid #000;
}

@media{
	.print_white{
		color: white;
	}
}
</style>

</head>

<?php //include("includes/header.php");
include_once("includes/Database.php");
include_once("includes/functions.php");
include_once ("NumtoWord.php");
// convert_number_to_words(round(1500,2));
// exit();
// 
// 
// print_r($_POST);
// exit();
$t=$a=$b=$c=$d=$e=$totalDeductions  = 0;
$jan_a=$jan_b=$jan_c=$jan_d=$jan_e=$jan_t=$jan_totalDeductions=$feb_a=$feb_b=$feb_c=$feb_d=$feb_e=$feb_t=$feb_totalDeductions=$mar_a=$mar_b=$mar_c=$mar_d=$mar_e=$mar_t=$mar_totalDeductions=$apr_a=$apr_b=$apr_c=$apr_d=$apr_e=$apr_t=$apr_totalDeductions=$may_a=$may_b=$may_c=$may_d=$may_e=$may_t=$may_totalDeductions=$jun_a=$jun_b=$jun_c=$jun_d=$jun_e=$jun_t=$jun_totalDeductions=$jul_a=$jul_b=$jul_c=$jul_d=$jul_e=$jul_t=$jul_totalDeductions=$aug_a=$aug_b=$aug_c=$aug_d=$aug_e=$aug_t=$aug_totalDeductions=$sep_a=$sep_b=$sep_c=$sep_d=$sep_e=$sep_t=$sep_totalDeductions=$oct_a=$oct_b=$oct_c=$oct_d=$oct_e=$oct_t=$oct_totalDeductions=$nov_a=$nov_b=$nov_c=$nov_d=$nov_e=$nov_t=$nov_totalDeductions=$dec_a=$dec_b=$dec_c=$dec_d=$dec_e=$dec_t=$dec_totalDeductions = '';

$regionselect = $_POST['regionselect'];
$monthselect = $_POST['monthselect'];



$dateinput = $_POST['dateinput'];
$yearselect = $_POST['yearselect'];
$rangetype = $_POST['rangetype'];
$reporttypeselect = $_POST['reporttypeselect'];

$employeeInternalId = $_POST['employeeSelect'];

if($monthselect != 'all'){



	if($employeeInternalId == 'all'){
		$employeeDetails = getAllEmployeeDetails($_POST['regionselect']);
	}


	else{

		$employeeSelect = $employeeInternalId;
		$employeeDetails = getEmployeeDetails($employeeSelect,$regionselect);
	}


	foreach($employeeDetails as $employeeDetailsData){

		$employeeSelect = $employeeDetailsData['employee_internal_id'];
		$regionselect = $employeeDetailsData['name_location'];


		if($rangetype == 'monthyear' ){
			$year = $yearselect;
			if(strlen($monthselect) == 1){
				$month = '0'.$monthselect;
			}
			else{
				$month = $monthselect;
			}

			$date1 = $year."-".$month."-01";
			$date2 = $year."-".$month."-".date("t",strtotime($date1));

		}
		else{

			$explodedData1 = explode("-", $dateinput);
			$explodedData2 = explode("/", trim($explodedData1[0]));

			$date1 = date('Y-m-d',strtotime(trim($explodedData1[0])));
			$date2 = date('Y-m-d',strtotime(trim($explodedData1[1])));
			$year = $explodedData2[2];
			
		}

		$monthName = date('M',strtotime($date1));

		// print_r($month);
		// exit();

		$totalDays2 = date('t',strtotime($year."-".$month."-01"));

		$absence = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'Absence',$month,$yearselect);
		$unpaidLeave = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'UnpaidLeave',$month,$yearselect);
		$CasualLeave = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'CasualLeave',$month,$yearselect);
		$Idle = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'Idle',$month,$yearselect);
		$Job = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'Job',$month,$yearselect);
		$NationalHoliday = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'NationalHoliday',$month,$yearselect);
		$Office = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'Office',$month,$yearselect);
		$SickLeave = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'SickLeave',$month,$yearselect);
		$WeekOffDay = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'WeekOffDay',$month,$yearselect);
		$AnnualLeave = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'AnnualLeave',$month,$yearselect);


		$workDays = 0;
		if(!$Office){
			$Office = 0;
		};

		$workDays = $Office + $Job;


		if($monthselect == '01' || $monthselect == '03' || $monthselect == '05' || $monthselect == '07' || $monthselect == '08' || $monthselect == '10' || $monthselect == '12'){
			$totalDays = 31;
		}
		else if($monthselect == '02'){
			$totalDays = $totalDays2;
		}
		else{
			$totalDays = 30;
		}

		

		// $employeePayments = getEmployeePaymentDetails($employeeSelect,$regionselect,$date1,$date2);
		$employeeSalary = getEmployeeSalary($employeeSelect,$month,$year);
		$arrears = 0;
		foreach($employeeSalary as $empSalary){
			$arrears += $empSalary['arrears'];

			// A = basic_salary x ((total days - (absence + unpaid leave)) / total days)
			$a = round( $empSalary['basic_salary']);

			// B = housing_allowance x ((total days - (absence + unpaid leave)) / total days)
			$b = round( $empSalary['housing_allowance']);

			// C = conveyance_allowance x ((total days - (absence + unpaid leave)) / total days)
			$c = round( $empSalary['conveyance_allowance']);

			// D = other_allowance x ((total days - (absence + unpaid leave)) / total days)
			$d = round( $empSalary['other_allowance']);

			// E = project_allowance x ((total days - (absence + unpaid leave)) / total days)
			// $e = round( $employeeDetailsData['project_allowance'] * (($totalDays - ($absence + $unpaidLeave)) / $totalDays));
			$e = round( $empSalary['project_allowance']);

			$totalDeductions = round($empSalary['deductions']);

			// T = A+B+C+D+E + F
			// $t = round($empSalary['gross_salary']);
			$t = $a + $b + $c + $d + $e;
		}	
		
		$food_allowance = 0;

		// F = T - P.T (of previous month)

		// $absenceDeduction = ($absence/$totalDays)*$t;
		$absenceDeduction = $t*($totalDays/(($totalDays-($unpaidLeave + $absence))))*($absence/$totalDays);
		// $leaveWithoutDeduction = ($unpaidLeave/$totalDays)*$t;
		$leaveWithoutDeduction = $t*($totalDays/(($totalDays-($unpaidLeave + $absence))))*($unpaidLeave/$totalDays);
        // The total deduction caused by absences, unpaid L and other fines
        $totalded = round($absenceDeduction + $leaveWithoutDeduction,2);

		if($reporttypeselect == 'Payslip' ){

		
		$totalPayment = 0;
		if(!empty($employeePayments)){ $sr = 1; $totalPayment = 0; foreach($employeePayments as $payments) {

			$totalPayment = $totalPayment + $payments['amount'];
		} }


		 ?>
		<title>Payslip</title>
		<style>

		    body{
		        padding:50px;
		    }
            
		    table tr td{
		        padding: 2px;
		        font-size: 10px;
		        width: 125px;
		        word-wrap: break-word;         /* All browsers since IE 5.5+ */
		        overflow-wrap: break-word;     /* Renamed property in CSS3 draft spec */
		    }

		    .innersubdetail tr td{
		        width: 95px;
		    }

		</style>

		<body>
		    
        <div align="center">
        <style> 
        img {
            padding: 10px;
            margin-left: 380px;
            }
        </style>
        
        <img src="hollow-NPM.png" alt="Logo main" style="width:140px; align:center">
        </div>
        
		<!-- START OUTER TABLE 1 --->
		<div align="center">
			<table class="outer1" >
            
			<!-- START INNER TABLE 1 --->
			<table border=2 style= "text-align: center;width:512px;margin-bottom:10px;">

			    <tr>

			        <td><?php echo $employeeDetailsData['employee_NAME']; ?> <br> <?php echo $employeeDetailsData['employee_job_title']; ?></td>

			        <td>
			        	<table border=1>
			        		<tr>
			        			<td><?php echo $employeeDetailsData['employee_internal_id']; ?></td>
			        		</tr>
			        		<tr>
			        			<td><?php echo $employeeDetailsData['employee_nationality']; ?></td>
			        		</tr>
			        	</table>
			        </td>


			        
			        
			        <td> Month </td>
			        <td><?php

			        	$year = $yearselect;

			         if(strlen($monthselect) == 1){
			        	$month = '0'.$monthselect;
			        	$newDate = '01-'.$month.'-'.$year;
			        	echo  date('M',strtotime($newDate)) .'-'.$year;
			        } else{ 
		        	$month = $monthselect;
		        	$newDate = '01-'.$month.'-'.$year;
		        	echo  date('M',strtotime($newDate)) .'-'.$year;
		        } ?></td>

			    </tr>

			</table>
			<!-- END INNER TABLE 1 --->

			<!-- <br> -->

			<!-- START INNER TABLE 2 --->
			<table border=2 style= "text-align: center;width:512px;margin-bottom:10px;">

			    <tr style="height: 50px;">

			        <td colspan="4" style="font-size: 20px;"><b>Salary Pay Slip</b></td>

			    </tr>

			    <tr>

			        <td>ID: <?php echo $employeeDetailsData['employee_cnic']; ?></td>
			        <td>Mobile No: <?php echo $employeeDetailsData['employee_mobile']; ?></td>
			        <td><?php echo $employeeDetailsData['account_no']; ?> </td>
			        <td ></td>

			    </tr>

			</table>

			<table border=2 style= "text-align: center;width:245px;margin-bottom:10px;display: inline;">

			    <tr style="height: 50px;">

			        <td>Basic: <?php echo round(($totalDays/(($totalDays-($unpaidLeave + $absence))))*$a,1)//$employeeDetailsData['basic_salary'];?></td>
		            <td>Housing: <?php echo round(($totalDays/(($totalDays-($unpaidLeave + $absence))))*$b,1) //$employeeDetailsData['housing_allowance'];?></td>
		            <!--<td>Office Travel: <?php echo round(($totalDays/(($totalDays-($unpaidLeave + $absence))))*$c,1);?></td>
		            <td style=""></td> -->

			    </tr>

			    <tr style="font-style:italic;">

			        <td><table border = 1 class="innersubdetail"><tr><td>Work Days</td><td>Idle Days</td></tr></table></td>
			        <td><table border = 1 class="innersubdetail"><tr><td style="font-size:9px;">Paid Leave</td><td>Absence</td></tr></table></td>
			        <!-- <td><table border = 1 class="innersubdetail"><tr><td style="font-size:9px;">Office Days</td><td style="font-size:9px;">Unpaid Leave</td></tr></table></td>
			        <td>Total Days</td> -->

			    </tr>

			    <tr>
					<?php
					$workDays = 0;
							if(!$Office){
								$Office = 0;
							};

					 $workDays = $Office + $Job; ?>
			        <td><table border = 1 class="innersubdetail"><tr><td><?php echo $workDays; ?></td><td><?php if($Idle) echo $Idle; else echo 0; ?></td></tr></table></td>
			        <td><table border = 1 class="innersubdetail"><tr><td><?php if($CasualLeave) echo $CasualLeave; else echo 0; ?></td><td><?php if($absence) echo $absence; else echo 0; ?></td></tr></table></td>
			        <!-- <td><table border = 1 class="innersubdetail"><tr><td><?php if($Office) echo $Office; else echo 0; ?></td><td><?php if($unpaidLeave) echo $unpaidLeave; else echo 0; ?></td></tr></table></td> -->
			        <!-- <td><?php echo $totalDays; ?></td> -->

			    </tr>

			    <tr>

			        <td>National Holidays: <?php echo $NationalHoliday;?></td>
			        <td></td>
			        <!-- <td colspan="2"></td> -->

			    </tr>

			    <tr style="height: 20px;">

			        <td><table border = 1 style="height: 20px;"><tr><td style="width: 25px;"></td><td style="width: 100px;"></td></tr></table></td>
			        <td></td>
			       <!--  <td></td>
			        <td style=""></td> -->

			    </tr>

			    <tr>

			        <td><table border = 1 ><tr><td style="width: 25px;"></td><td style="width: 100px;text-align:right;">Basic</td></tr></table></td>
			        <td ><?php echo $a;//$employeeDetailsData['basic_salary'];?></td>
			        <!-- <td style="text-align:right;">Jizan Substation</td>
			        <td >3</td> -->

			    </tr>

			    <tr>

			        <td><table border = 1 ><tr><td style="width: 25px;"></td><td style="width: 100px;text-align:right;">Housing</td></tr></table></td>
			        <td ><?php echo $b;//$employeeDetailsData['housing_allowance'];?></td>
			        <!-- <td style="text-align:right;">Not Joined</td>
			        <td >28</td> -->

			    </tr>

			        <tr>

			        <td><table border = 1 ><tr><td style="width: 25px;"></td><td style="width: 100px;text-align:right;">Office Travel</td></tr></table></td>
			        <td ><?php echo $c;//$employeeDetailsData['conveyance_allowance'];?></td>
			        <!-- <td style="text-align:right;"></td>
			        <td ></td> -->

			    </tr>

			    <tr>

			        <td><table border = 1 ><tr><td style="width: 25px;"></td><td style="font-size:9px;width: 100px;text-align:right;">Other Allowance</td></tr></table></td>
			        <td ><?php echo $d;//$employeeDetailsData['other_allowance'];?></td>
			        <!-- <td style="text-align:right;"></td>
			        <td ></td> -->

			    </tr>

			    <tr>
                <!-- ########## Improvisation here. see /10 -->
			        <td><table border = 1 ><tr><td style="width: 25px;"></td><td style="font-size:9px;width: 100px;text-align:right;">Food Allowance</td></tr></table></td>
			        <td ><?php echo $food_allowance = $e; ?></td>
			        <!-- <td style="text-align:right;"></td>
			        <td ></td> -->

			    </tr>

			    <tr>

			        <td><table border = 1 ><tr><td style="width: 25px;"></td><td style="font-size:9px;width: 100px;text-align:right;">Total</td></tr></table></td>
			        <td ><?php echo $t; ?></td>
			        <!-- <td style="text-align:right;"></td>
			        <td ></td> -->

			    </tr>

			    <tr>

			        <td><table border = 1 ><tr><td style="width: 25px;"></td><td style="font-size:9px;width: 100px;text-align:right;">Absences</td></tr></table></td>
			        <td ><?php echo round($absenceDeduction,2);?></td>
			        <!-- <td style="text-align:right;"></td>
			        <td ></td> -->

			    </tr>

			    <tr>

			        <td><table border = 1 ><tr><td style="width: 25px;"></td><td style="font-size:9px;width: 100px;text-align:right;">Leave without Pay</td></tr></table></td>
			        <td ><?php echo round($leaveWithoutDeduction,2);?></td>
			        <!-- <td style="text-align:right;"></td>
			        <td ></td> -->

			    </tr>

			    <tr>

			        <td><table border = 1 ><tr><td style="width: 25px;"></td><td style="font-size:9px;width: 100px;text-align:right;">Any other Deduction</td></tr></table></td>
			        <td ><?php echo $totalPayment - $totalDeductions; ?></td>
			        <!-- <td style="text-align:right;"></td>
			        <td ></td> -->

			    </tr>
			    
			    <!-- Arrear output command below -->
<!--
			    <tr>

			        <td><table border = 1 ><tr><td style="width: 25px;"></td><td style="font-size:9px;width: 100px;text-align:right;">Arrears</td></tr></table></td>
			        <td ><?php echo $arrears;?></td>
			        <!-- <td style="text-align:right;"></td>
			        <td ></td> -->

			    </tr>

<!--
			    <tr>

			        <td><table border = 1 ><tr><td style="width: 25px;"></td><td style="font-size:9px;width: 100px;text-align:right;">Total Deductions</td></tr></table></td>
			        <td ><?php echo $totalDeductions;?></td>
			        <!-- <td style="text-align:right;"></td>
			        <td ></td> -->

			    </tr>

                <tr>

			        <td><table border = 1 ><tr><td style="width: 25px;"></td><td style="font-size:9px;width: 100px;text-align:right;">Total Deductions</td></tr></table></td>
			        <td ><?php echo -$totalded + ($totalPayment - $totalDeductions);?></td>
			        <!-- <td style="text-align:right;"></td>
			        <td ></td> -->

			    </tr>

			    <tr>

			        <td><table border = 1 ><tr><td style="width: 25px;"></td><td style="font-size:9px;width: 100px;text-align:right;"><b>Net Salary Payable</b></td></tr></table></td>
			        <td ><b><?php echo $netPay = $t + $arrears; ?></b></td>
			       <!--  <td style="text-align:right;"></td>
			        <td ></td> -->

			    </tr>

			    
			</table>
			<!-- END INNER TABLE 3 --->
			<table border=2 style= "text-align: center;width:245px;margin-bottom:10px;display: inline;">



			    <tr style="height: 50px;">

			        <!-- <td>Basic: <?php echo $employeeDetailsData['basic_salary'];?></td>
			        <td>Housing: <?php echo $employeeDetailsData['housing_allowance'];?></td> -->
			        <td>Total Salary: <?php echo floor(($totalDays/(($totalDays-($unpaidLeave + $absence))))*$t);?></td>
		            <td style=""></td>
			        

			    </tr>

			    <tr style="font-style:italic;">

			        <!-- <td><table border = 1 class="innersubdetail"><tr><td>Work Days</td><td>Idle Days</td></tr></table></td>
			        <td><table border = 1 class="innersubdetail"><tr><td style="font-size:9px;">Paid Leave</td><td>Absence</td></tr></table></td> -->
			        <td><table border = 1 class="innersubdetail"><tr><td style="font-size:9px;">Office Days</td><td style="font-size:9px;">Unpaid L</td></tr></table></td>
			        <!-- <td></td> -->

			        <td><table border = 1 class=""><tr><td >Total Days</td></tr></table></td>
			        <!-- <td><table border = 1 class="innersubdetail"><tr><td style="font-size:9px;">Paid Leave</td><td>Absence</td></tr></table></td> -->

			    </tr>

			    <tr>
					<?php
					$workDays = 0;
							if(!$Office){
								$Office = 0;
							};

					 $workDays = $Office + $Job; ?>
			        <!-- <td><table border = 1 class="innersubdetail"><tr><td><?php echo $workDays; ?></td><td><?php if($Idle) echo $Idle; else echo 0; ?></td></tr></table></td>
			        <td><table border = 1 class="innersubdetail"><tr><td><?php if($CasualLeave) echo $CasualLeave; else echo 0; ?></td><td><?php if($absence) echo $absence; else echo 0; ?></td></tr></table></td> -->
			        <td><table border = 1 class="innersubdetail"><tr><td><?php if($Office) echo $Office; else echo 0; ?></td><td><?php if($unpaidLeave) echo $unpaidLeave; else echo 0; ?></td></tr></table></td>
			        
			        <td><table border = 1 class=""><tr><td ><?php echo $totalDays; ?></td></tr></table></td>

			    </tr>

			    <tr>

			        <!-- <td>National Holidays: <?php echo $NationalHoliday;?></td> -->
			        <td>&nbsp;</td>
			        <td colspan="2">&nbsp;</td>

			    </tr>

			    <tr style="height: 20px;">

			        <td><table border = 1 style="height: 20px;"><tr><td style="width: 25px;"></td><td style="width: 100px;"></td></tr></table></td>
			        <td></td>
			       <!--  <td></td>
			        <td style=""></td> -->

			    </tr>

			    <?php  $monthDays = cal_days_in_month(CAL_GREGORIAN, $month, $year); $location_summary = array();  for($i=0; $i<$monthDays ; $i++){

			    	// print_r($monthName);
			    	// exit();

			                    	$getSiteLocation = getSiteLocation($employeeSelect,$regionselect,date("Y-m-d", strtotime(($i+1)."-".$monthName.'-'.$year)));

			                    	// print_r($getSiteLocation);
			                    	// exit();

			                    	if(isset($getSiteLocation[0]['site_location'])){
			                    		if(!array_key_exists(trim($getSiteLocation[0]['site_location']), $location_summary) ){
			                    			$location_summary[trim($getSiteLocation[0]['site_location'])] = 1;
			                    		}
			                    		else{
			                    			$location_summary[trim($getSiteLocation[0]['site_location'])] += 1;
			                    		}
			                    	}

			                    	
			                    	}

			                    	// print_r($location_summary);
			                    	// exit();
			                    	// 
			                    	$remainingTr = 12 - count($location_summary);

			                    	if($remainingTr < 0){
			                    		$remainingTr = 0;
			                    	}

			                     ?>

			                      <?php if(isset($location_summary)) { foreach ($location_summary as $key => $value) { ?>
							
							<tr style="height: 20px;">

						        <td><table border = 1 style="height: 20px;"><tr><td style="width: 25px;"></td><td style="width: 100px;"><?php echo $key; ?></td></tr></table></td>
						        <td><?php echo $value; ?></td>
						       <!--  <td></td>
						        <td style=""></td> -->

						    </tr>

		                <?php } } ?>

			    
			</table>


			<!-- START INNER TABLE 4 --->
			<table border=2 style= "text-align: center;width:512px;height:100px;">
				<tr>

				    <!-- <td style="width: 25px;"></td> -->
				    <td colspan="3"><b><?php  echo convert_number_to_words(round($netPay,2)). " only" ?></b></td>
				

				</tr>
			    <tr>

			        <td style="text-align:right;">HR Incharge&nbsp;&nbsp;</td>
			        <td style="text-align:left;">&nbsp;&nbsp;Approved By</td>
			        <td rowspan="2">Thumb Impression</td>

			    </tr>

			    <tr>

			        <td style="text-align:right;">Accounts&nbsp;&nbsp;</td>
			        <td style="text-align:left;">&nbsp;&nbsp;Received By</td>

			    </tr>

			</table>
			<!-- END INNER TABLE 4 --->

			</table>
			<!-- END OUTER TABLE 1 --->
		</div>
		<?php }

		else if ($reporttypeselect == 'Summary'){



		$getRegionStatus = get_Status_Options_For_location($regionselect);

		$employeePayments = getEmployeePaymentDetails($employeeSelect,$regionselect,$date1,$date2); ?>

	<!DOCTYPE html>
	<html>
	<head>
		<title>Summary</title>
		<style>
		body{
		    padding:20px;
		}
		.outerNew td{
		    padding:8px;
		    font-size: 12px;
		}

		.smallcolumns td{
		    font-size: 10px;
		    height:3%;
		    padding: 4px;
		}

		.smallcolumns1 td{
		    padding: 1px;
		}

		.smallcolumns3 td{
		    font-size: 10px;
		    height:3%;
		    padding: 4px;
		    text-align:right;
		}
		</style>
	</head>
	<body>		
    <div align="right">
        <style> 
        img {
            padding: 10px;
            margin-right: 0px;
            }
        </style>
        
        <img src="hollow-NPM.png" alt="Logo main" style="width:160px; align:center">
        </div>
			
	<?php if($rangetype == 'monthyear' ) {

		$absence = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'Absence',$month,$yearselect);
		$unpaidLeave = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'UnpaidLeave',$month,$yearselect);
		$CasualLeave = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'CasualLeave',$month,$yearselect);
		$Idle = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'Idle',$month,$yearselect);
		$Job = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'Job',$month,$yearselect);
		$NationalHoliday = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'NationalHoliday',$month,$yearselect);
		$Office = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'Office',$month,$yearselect);
		$SickLeave = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'SickLeave',$month,$yearselect);
		$WeekOffDay = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'WeekOffDay',$month,$yearselect);
		$AnnualLeave = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'AnnualLeave',$month,$yearselect);




		if($monthselect == '01' || $monthselect == '03' || $monthselect == '05' || $monthselect == '07' || $monthselect == '08' || $monthselect == '10' || $monthselect == '12'){
			$totalDays = 31;
		}
		else if($monthselect == '02'){
			$totalDays = $totalDays2;
		}
		else{
			$totalDays = 30;
		}
?>
		


			<div align="center">
	
    <table class="outerNew" border="1">
        <tr>

            <td colspan="3">Employee Name: <?php echo $employeeDetailsData['employee_NAME']; ?> </td>
            <td colspan="2">Job Title: <?php echo $employeeDetailsData['employee_job_title']; ?></td>
            <td style="width:5%;">Internal ID: <?php echo $employeeDetailsData['employee_internal_id']; ?></td>
            <td colspan="2">CNIC: <?php echo $employeeDetailsData['employee_cnic']; ?></td>
            <td colspan="2">Mobile Number: <?php echo $employeeDetailsData['employee_mobile']; ?></td>
            <td colspan="3">Account Number: <?php echo $employeeDetailsData['account_no']; ?> </td>
            <td >Year </td>
            <td colspan="2"><?php echo $year; ?> </td>
        </tr>

        <tr>
            <td style="width:3%;">Ln</td>
            <td style="width:12%;">&nbsp;</td>
            <td style="width:6%;">Total</td>
            <td style="width:5%;"> Last Year</td>
            <td style="width:5%;"> Jan</td>
            <td style="width:5%;"> Feb</td>
            <td style="width:5%;"> Mar</td>
            <td style="width:5%;"> Apr</td>
            <td style="width:5%;"> May</td>
            <td style="width:5%;"> Jun</td>
            <td style="width:5%;"> Jul</td>
            <td style="width:5%;"> Aug</td>
            <td style="width:5%;"> Sep</td>
            <td style="width:5%;"> Oct</td>
            <td style="width:5%;"> Nov</td>
            <td style="width:5%;"> Dec</td>
        </tr>

					  

        <tr>
            <td style="width:3%;">&nbsp;</td>
            <td style="width:12%;">&nbsp;</td>
            <td style="width:6%;">&nbsp;</td>
            <td style="width:5%;"> &nbsp;</td>
            <td><?php echo $totalDays1 = date('t',strtotime($year."-01-01")); ?></td>
			<td><?php echo $totalDays2 = date('t',strtotime($year."-02-01")); ?></td>
			<td><?php echo $totalDays3 = date('t',strtotime($year."-03-01")); ?></td>
			<td><?php echo $totalDays4 = date('t',strtotime($year."-04-01")); ?></td>
			<td><?php echo $totalDays5 = date('t',strtotime($year."-05-01")); ?></td>
			<td><?php echo $totalDays6 = date('t',strtotime($year."-06-01")); ?></td>
			<td><?php echo $totalDays7 = date('t',strtotime($year."-07-01")); ?></td>
			<td><?php echo $totalDays8 = date('t',strtotime($year."-08-01")); ?></td>
			<td><?php echo $totalDays9 = date('t',strtotime($year."-09-01")); ?></td>
			<td><?php echo $totalDays10 = date('t',strtotime($year."-10-01")); ?></td>
			<td><?php echo $totalDays11 = date('t',strtotime($year."-11-01")); ?></td>
			<td><?php echo $totalDays12 = date('t',strtotime($year."-12-01")); ?></td>

        </tr>



        <?php $sr = 1; while($row = mysqli_fetch_assoc($getRegionStatus)) {   ?>
				  <tr>

						<td style="width:3%;text-align:center;"><?php echo $sr;?></td>
			            <td style="width:12%;"><?php echo $row['status_option']; ?></td>
			            <td style="width:6%;">&nbsp;</td>
			            <td style="width:5%;"> &nbsp;</td>				    	
					  <td style="width:5%;"><?php if($rangetype == 'monthyear' && $monthselect == 1){
						$dataJan = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,$row['status_option'],'01',$yearselect); if(!is_null($dataJan)){ echo $dataJan; } else echo '-';
						}
						else{
							echo '-';
						} ?> </td>
								  <td style="width:5%;"><?php if($rangetype == 'monthyear' && $monthselect == 2){
							$dataFeb = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,$row['status_option'],'02',$yearselect); if(!is_null($dataFeb)){ echo $dataFeb; } else echo '-';
						}
						else{
							echo '-';
						} ?> </td>
								  <td style="width:5%;"><?php if($rangetype == 'monthyear' && $monthselect == 3){
							$dataMar = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,$row['status_option'],'03',$yearselect); if(!is_null($dataMar)){ echo $dataMar; } else echo '-';
						}
						else{
							echo '-';
						} ?> </td>
								  <td style="width:5%;"><?php if($rangetype == 'monthyear' && $monthselect == 4){
							$dataApr = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,$row['status_option'],'04',$yearselect); if(!is_null($dataApr)){ echo $dataApr; } else echo '-';
						}
						else{
							echo '-';
						} ?> </td>
								  <td style="width:5%;"><?php if($rangetype == 'monthyear' && $monthselect == 5){
							$dataMay = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,$row['status_option'],'05',$yearselect); if(!is_null($dataMay)){ echo $dataMay; } else echo '-';
						}
						else{
							echo '-';
						} ?> </td>
								  <td style="width:5%;"><?php if($rangetype == 'monthyear' && $monthselect == 6){
							$dataJun = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,$row['status_option'],'06',$yearselect); if(!is_null($dataJun)){ echo $dataJun; } else echo '-';
						}
						else{
							echo '-';
						} ?> </td>
								  <td style="width:5%;"><?php if($rangetype == 'monthyear' && $monthselect == 7){
							$dataJul = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,$row['status_option'],'07',$yearselect); if(!is_null($dataJul)){ echo $dataJul; } else echo '-';
						}
						else{
							echo '-';
						} ?> </td>
								  <td style="width:5%;"><?php if($rangetype == 'monthyear' && $monthselect == 8){
							$dataAug = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,$row['status_option'],'08',$yearselect); if(!is_null($dataAug)){ echo $dataAug; } else echo '-';
						}
						else{
							echo '-';
						} ?> </td>
								  <td style="width:5%;"><?php if($rangetype == 'monthyear' && $monthselect == 9){
							$dataSep = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,$row['status_option'],'09',$yearselect); if(!is_null($dataSep)){ echo $dataSep; } else echo '-';
						}
						else{
							echo '-';
						} ?> </td>
								  <td style="width:5%;"><?php if($rangetype == 'monthyear' && $monthselect == 10){
							$dataOct = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,$row['status_option'],'10',$yearselect); if(!is_null($dataOct)){ echo $dataOct; } else echo '-';
						}
						else{
							echo '-';
						} ?> </td>
								  <td style="width:5%;"><?php if($rangetype == 'monthyear' && $monthselect == 11){
							$dataNov = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,$row['status_option'],'11',$yearselect); if(!is_null($dataNov)){ echo $dataNov; } else echo '-';
						}
						else{
							echo '-';
						} ?> </td>
								  <td style="width:5%;"><?php if($rangetype == 'monthyear' && $monthselect == 12){
							$dataDec = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,$row['status_option'],'12',$yearselect); if(!is_null($dataDec)){ echo $dataDec; } else echo '-';
						}
						else{
							echo '-';
						} ?> </td>
					</tr>
					<?php $sr++; }  ?>


       

        <tr class="smallcolumns1" >

            <td style="width:3%;text-align:center;"></td>
            <td style="width:12%;"></td>
            <td style="width:6%;"></td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>

        </tr>

        <tr class="smallcolumns3">

            <td style="width:3%;text-align:center;"></td>
            <td style="width:12%;">Basic Pay</td>
            <td style="width:6%;"><?php echo $a;//$employeeDetailsData['basic_salary']; ?></td>
            <td style="width:5%;"> &nbsp;</td>
            <td style="width:5%;"> <?php if($monthselect == 1){ echo $a; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 2){ echo $a; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 3){ echo $a; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 4){ echo $a; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 5){ echo $a; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 6){ echo $a; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 7){ echo $a; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 8){ echo $a; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 9){ echo $a; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 10){ echo $a; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 11){ echo $a; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 12){ echo $a; } else { echo '-'; }?></td>

        </tr>

        <tr class="smallcolumns3">

            <td style="width:3%;text-align:center;"></td>
            <td style="width:12%;">Housing</td>
            <td style="width:6%;"><?php echo $b;//$employeeDetailsData['housing_allowance']; ?></td>
            <td style="width:5%;"> &nbsp;</td>
            <td style="width:5%;"> <?php if($monthselect == 1){ echo $b; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 2){ echo $b; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 3){ echo $b; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 4){ echo $b; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 5){ echo $b; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 6){ echo $b; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 7){ echo $b; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 8){ echo $b; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 9){ echo $b; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 10){ echo $b; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 11){ echo $b; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 12){ echo $b; } else { echo '-'; }?></td>

        </tr>


        <tr class="smallcolumns3">

            <td style="width:3%;text-align:center;"></td>
            <td style="width:12%;">Conveyance</td>
            <td style="width:6%;"><?php echo $c;//$employeeDetailsData['conveyance_allowance']; ?></td>
            <td style="width:5%;"> &nbsp;</td>
            <td style="width:5%;"> <?php if($monthselect == 1){ echo $c; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 2){ echo $c; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 3){ echo $c; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 4){ echo $c; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 5){ echo $c; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 6){ echo $c; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 7){ echo $c; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 8){ echo $c; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 9){ echo $c; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 10){ echo $c; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 11){ echo $c; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 12){ echo $c; } else { echo '-'; }?></td>

        </tr>


        <tr class="smallcolumns3">

            <td style="width:3%;text-align:center;"></td>
            <td style="width:12%;">Other Allowance</td>
            <td style="width:6%;"><?php echo $d;//$employeeDetailsData['other_allowance']; ?></td>
            <td style="width:5%;"> &nbsp;</td>
            <td style="width:5%;"> <?php if($monthselect == 1){ echo $d; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 2){ echo $d; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 3){ echo $d; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 4){ echo $d; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 5){ echo $d; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 6){ echo $d; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 7){ echo $d; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 8){ echo $d; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 9){ echo $d; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 10){ echo $d; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 11){ echo $d; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 12){ echo $d; } else { echo '-'; }?></td>

        </tr>

        <tr class="smallcolumns3">

            <td style="width:3%;text-align:center;"></td>
            <td style="width:12%;">Food Allowance</td>
            <td style="width:6%;"><?php echo $e; ?></td>
            <td style="width:5%;"> &nbsp;</td>
            <td style="width:5%;"> <?php if($monthselect == 1){ echo $e; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 2){ echo $e; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 3){ echo $e; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 4){ echo $e; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 5){ echo $e; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 6){ echo $e; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 7){ echo $e;} else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 8){ echo $e; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 9){ echo $e; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 10){ echo $e; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 11){ echo $e; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 12){ echo $e; } else { echo '-'; }?></td>

        </tr>

		<tr class="smallcolumns3">

			<td style="width:3%;text-align:center;">&nbsp;</td>
			<td style="width:12%;">Other Deductions</td>
			<td style="width:6%;"><?php echo $totalDeductions;?></td>
			<td style="width:5%;"> &nbsp;</td>
			<td style="width:5%;"> <?php if($monthselect == 1){ echo $totalDeductions; } else { echo '-'; }?></td>
			<td style="width:5%;"> <?php if($monthselect == 2){ echo $totalDeductions; } else { echo '-'; }?></td>
			<td style="width:5%;"> <?php if($monthselect == 3){ echo $totalDeductions; } else { echo '-'; }?></td>
			<td style="width:5%;"> <?php if($monthselect == 4){ echo $totalDeductions; } else { echo '-'; }?></td>
			<td style="width:5%;"> <?php if($monthselect == 5){ echo $totalDeductions; } else { echo '-'; }?></td>
			<td style="width:5%;"> <?php if($monthselect == 6){ echo $totalDeductions; } else { echo '-'; }?></td>
			<td style="width:5%;"> <?php if($monthselect == 7){ echo $totalDeductions; } else { echo '-'; }?></td>
			<td style="width:5%;"> <?php if($monthselect == 8){ echo $totalDeductions; } else { echo '-'; }?></td>
			<td style="width:5%;"> <?php if($monthselect == 9){ echo $totalDeductions; } else { echo '-'; }?></td>
			<td style="width:5%;"> <?php if($monthselect == 10){ echo $totalDeductions; } else { echo '-'; }?></td>
			<td style="width:5%;"> <?php if($monthselect == 11){ echo $totalDeductions; } else { echo '-'; }?></td>
			<td style="width:5%;"> <?php if($monthselect == 12){ echo $totalDeductions; } else { echo '-'; }?></td>

		</tr>

        <tr class="smallcolumns3">

            <td style="width:3%;text-align:center;">&nbsp;</td>
            <td style="width:12%;">Arrears</td>
            <td style="width:6%;"><?php echo $arrears;?></td>
            <td style="width:5%;"> &nbsp;</td>
            <td style="width:5%;"> <?php if($monthselect == 1){ echo $arrears; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 2){ echo $arrears; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 3){ echo $arrears; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 4){ echo $arrears; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 5){ echo $arrears; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 6){ echo $arrears; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 7){ echo $arrears; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 8){ echo $arrears; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 9){ echo $arrears; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 10){ echo $arrears; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 11){ echo $arrears; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 12){ echo $arrears; } else { echo '-'; }?></td>

        </tr>

        <tr class="smallcolumns3">

            <td style="width:3%;text-align:center;"></td>
            <td style="width:12%;">Total Salary</td>
            <td style="width:6%;"><?php echo $t + $food_allowance;//$employeeDetailsData['basic_salary'] + $employeeDetailsData['housing_allowance'] + $employeeDetailsData['conveyance_allowance'] + $employeeDetailsData['other_allowance'] + $food_allowance ?></td>
            <td style="width:5%;"> &nbsp;</td>
            <td style="width:5%;"> <?php if($monthselect == 1){ echo $t + $food_allowance; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 2){ echo $t + $food_allowance; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 3){ echo $t + $food_allowance; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 4){ echo $t + $food_allowance; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 5){ echo $t + $food_allowance; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 6){ echo $t + $food_allowance; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 7){ echo $t + $food_allowance; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 8){ echo $t + $food_allowance; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 9){ echo $t + $food_allowance; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 10){ echo $t + $food_allowance; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 11){ echo $t + $food_allowance; } else { echo '-'; }?></td>
            <td style="width:5%;"> <?php if($monthselect == 12){ echo $t + $food_allowance; } else { echo '-'; }?></td>

        </tr>

        <tr class="smallcolumns1" >

            <td style="width:3%;text-align:center;"></td>
            <td style="width:12%;"></td>
            <td style="width:6%;"></td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>

        </tr>


        <?php if(!empty($employeePayments)){ $sr = 1; $totalPayment = 0; foreach($employeePayments as $payments) { $totalPayment = $totalPayment + $payments['amount']; echo $payments['amount']; ?>
        	<tr class="smallcolumns3">


        		<td style="width:3%;text-align:center;"><?php //echo $sr; ?></td>
        		<td style="width:5%;">Payment - <?php echo $sr;?></td>
        		<td style="width:6%;"><?php  ?></td>
        		<td style="width:5%;"> &nbsp;</td>
        		<td style="width:5%;"> <?php if($monthselect == 1){ echo $payments['amount']; }?></td>
        		<td style="width:5%;"> <?php if($monthselect == 2){ echo $payments['amount']; }?></td>
        		<td style="width:5%;"> <?php if($monthselect == 3){ echo $payments['amount']; }?></td>
        		<td style="width:5%;"> <?php if($monthselect == 4){ echo $payments['amount']; }?></td>
        		<td style="width:5%;"> <?php if($monthselect == 5){ echo $payments['amount']; }?></td>
        		<td style="width:5%;"> <?php if($monthselect == 6){ echo $payments['amount']; }?></td>
        		<td style="width:5%;"> <?php if($monthselect == 7){ echo $payments['amount']; }?></td>
        		<td style="width:5%;"> <?php if($monthselect == 8){ echo $payments['amount']; }?></td>
        		<td style="width:5%;"> <?php if($monthselect == 9){ echo $payments['amount']; }?></td>
        		<td style="width:5%;"> <?php if($monthselect == 10){ echo $payments['amount']; }?></td>
        		<td style="width:5%;"> <?php if($monthselect == 11){ echo $payments['amount']; }?></td>
        		<td style="width:5%;"> <?php if($monthselect == 12){ echo $payments['amount']; }?></td>
        	</tr>
        	<tr class="smallcolumns3">


        		<td style="width:3%;text-align:center;"><?php //echo $sr; ?></td>
        		<td style="width:5%;">Date Payment - <?php echo $sr;?></td>
        		<td style="width:6%;"><?php //echo $payments['date']; ?></td>
        		<td style="width:5%;"> &nbsp;</td>
        		<td style="width:5%;" > <?php if($monthselect == 1){ echo $payments['date']; }?></td>
        		<td style="width:5%;" > <?php if($monthselect == 2){ echo $payments['date']; }?></td>
        		<td style="width:5%;" > <?php if($monthselect == 3){ echo $payments['date']; }?></td>
        		<td style="width:5%;" > <?php if($monthselect == 4){ echo $payments['date']; }?></td>
        		<td style="width:5%;" > <?php if($monthselect == 5){ echo $payments['date']; }?></td>
        		<td style="width:5%;" > <?php if($monthselect == 6){ echo $payments['date']; }?></td>
        		<td style="width:5%;" > <?php if($monthselect == 7){ echo $payments['date']; }?></td>
        		<td style="width:5%;" > <?php if($monthselect == 8){ echo $payments['date']; }?></td>
        		<td style="width:5%;" > <?php if($monthselect == 9){ echo $payments['date']; }?></td>
        		<td style="width:5%;" > <?php if($monthselect == 10){ echo $payments['date']; }?></td>
        		<td style="width:5%;" > <?php if($monthselect == 11){ echo $payments['date']; }?></td>
        		<td style="width:5%;" > <?php if($monthselect == 12){ echo $payments['date']; }?></td>
        	</tr>

        <?php $sr++; } ?>

			<tr class="smallcolumns3">
	        	<td style="width:3%;text-align:center;"></td>
	        	<td style="width:5%;">Payment Made</td>
	        	<td style="width:6%;"><?php //echo $totalPayment; ?></td>
	        	<td style="width:5%;"> &nbsp;</td>
	        	<td style="width:5%;"> <?php if($monthselect == 1){ echo $totalPayment; }?></td>
	    		<td style="width:5%;"> <?php if($monthselect == 2){ echo $totalPayment; }?></td>
	    		<td style="width:5%;"> <?php if($monthselect == 3){ echo $totalPayment; }?></td>
	    		<td style="width:5%;"> <?php if($monthselect == 4){ echo $totalPayment; }?></td>
	    		<td style="width:5%;"> <?php if($monthselect == 5){ echo $totalPayment; }?></td>
	    		<td style="width:5%;"> <?php if($monthselect == 6){ echo $totalPayment; }?></td>
	    		<td style="width:5%;"> <?php if($monthselect == 7){ echo $totalPayment; }?></td>
	    		<td style="width:5%;"> <?php if($monthselect == 8){ echo $totalPayment; }?></td>
	    		<td style="width:5%;"> <?php if($monthselect == 9){ echo $totalPayment; }?></td>
	    		<td style="width:5%;"> <?php if($monthselect == 10){ echo $totalPayment; }?></td>
	    		<td style="width:5%;"> <?php if($monthselect == 11){ echo $totalPayment; }?></td>
	    		<td style="width:5%;"> <?php if($monthselect == 12){ echo $totalPayment; }?></td> 
	    	</tr>      	

          <?php } else { ?>
        	<tr>
        		<td colspan="3">NO Data Found!</td>
        	</tr>
        <?php } ?>      

        <tr>

            <td colspan="2">Total Salary:<br><?php echo $t + $food_allowance;?></td>
            <td colspan="3">CasualLeave :<br><?php if($CasualLeave) echo $CasualLeave; else echo 0; ?></td>
            <td colspan="3">Annual leave :<br><?php if($AnnualLeave) echo $AnnualLeave; else echo 0; ?> </td>
            <td colspan="3">Idle :<br><?php if($Idle) echo $Idle; else echo 0; ?> </td>
            <td colspan="3">National Holiday :<br><?php if($NationalHoliday) echo $NationalHoliday; else echo 0; ?></td>
            <td colspan="2">-</td>

        </tr>

        <tr>

            <td colspan="2">Office :<br><?php if($Office) echo $Office; else echo 0; ?></td>
            <td colspan="3">Sick Leave :<br><?php if($SickLeave) echo $SickLeave; else echo 0; ?></td>
            <td colspan="3">On Job :<br><?php if($Job) echo $Job; else echo 0; ?></td>
            <td colspan="3">Week Off Day :<br><?php if($WeekOffDay) echo $WeekOffDay; else echo 0; ?></td>
            <td colspan="3">Unpaid Leave :<br><?php if($unpaidLeave) echo $unpaidLeave; else echo 0; ?></td>
            <td colspan="2">Verified by Immediate Supervisor</td>

        </tr>


    </table>
</div>
		<?php } ?>

	<?php } else if( $reporttypeselect == 'Maintenance Timesheet'){ 

			$getRegionStatus = get_Status_Options_For_location($regionselect);

			$monthDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

			$monthName = date('M',strtotime($date1));

			// print_r($_POST);

		?>
        <title> Maintenance Time Sheet</title>
		<style>

		    body{
		        padding:30px;
		        font-size:12px;
		    }

		    .labeldiv{
		        text-align: right;
		        color: #000;
		        font-size: 25px;
		        padding-bottom:10px;
		    }

		    p{
		        text-align: center;
		    }

		    .outertable td{
		        text-align:center;
		        padding: 3px !important;
		        margin: 3px !important;
		        vertical-align: middle !important;
		    }

		    .verticaltext{
		        transform: rotate(270deg);
		        /* height: 100px; */
		        white-space:nowrap;
		        
		        /* overflow: hidden; */
		        /* display: inline-block; */
		        /* float: left; */
		    }

		    .verticaltext2{
		        transform: rotate(270deg);
		        /* height: 50px; */
		        white-space:nowrap;
		        /* float: left; */
		    }

		    td.rotate {
		        /* Something you can count on */
		        height: 100px;
		        white-space: nowrap;
		    }

		    td.rotate > div {
		        transform: 
		        /* Magic Numbers */
		        translate(0px, 40px)
		        /* 45 is really 360 - 45 */
		        rotate(270deg);
		        width: 20px;
		    }
		    td.rotate > div > span {
		        /* border-bottom: 1px solid #ccc; */
		        padding: 5px 10px;
		    }

		    td.rotate2 {
		        /* Something you can count on */
		        height: 50px;
		        white-space: nowrap;
		    }

		    td.rotate2 > div {
		        transform: 
		        /* Magic Numbers */
		        translate(0px, 7px)
		        /* 45 is really 360 - 45 */
		        rotate(270deg);
		        width: 20px;
		    }
		    td.rotate2 > div > span {
		        /* border-bottom: 1px solid #ccc; */
		        padding: 5px 10px;
		    }
		    .npmlogo{
		        padding: 10px;
                margin-right: 1310px;
		    }

		</style>

		<body>
        
        
        
        
		<div class="labeldiv">
		    <img src="hollow-NPM.png" class="npmlogo" alt="Logo main" style="width:160px; align:center">   
		    <b>MAINTENANCE TIME SHEET</b>

		</div>




		<div class="table-responsive">

		    <table class="table table-bordered table-striped outertable" >
		        <tbody>
		            <tr>
		                <td><?php echo $employeeDetailsData['employee_NAME']; ?> <br> <?php echo $employeeDetailsData['employee_job_title']; ?></td>
		                <td style="width: 4%;"><?php echo $employeeDetailsData['employee_internal_id']; ?></td>
		                <td><?php echo $employeeDetailsData['employee_cnic']; ?></td>
		                <td><?php echo $employeeDetailsData['name_location']; ?></td>
		                <td>
		                
		                    
		                    <table border=1 style="width:100%">

		                        <tbody>
		                            <tr>
		                                <td>Total Days: <?php echo $monthDays;?></td>
		                                <td>Idle Days: <?php if($Idle) echo $Idle; else echo 0; ?></td>
		                            </tr>

		                            <tr>
		                                <td>Working Days: <?php echo $workDays;  ?></td>
		                                <td>Absence: <?php if($absence) echo $absence; else echo 0; ?></td>
		                            </tr>
		                        </tbody>
		                    </table>
		                    
		                
		                </td>

		                <td>Month <?php echo $monthName.' '.$year; ?> </td>

		            </tr>
		        
		            <tr>
		                <td colspan="6">-</td>
		            </tr>

		</tbody>

		</table>

		<table class="table table-bordered table-striped outertable" >

		<tbody>

		            <!-- START FIRST ROW -->

		            <tr>

		                <td style="width: 20%"><b>Ln</b></td>
		                <td style="width: 70%"><b>Date</b></td>
		                <td style="width: 10%"></td>


			                

		                <td colspan="4">
		                    <table border=1 style="width:100%">
		                    <tr>
		                    <?php for($i=0; $i<$monthDays ; $i++){ ?>
		                <td>
		                <table border=1 style="width:100%">
		                        <tr>
		                            <td class="rotate" ><div><span><b><?php echo ($i+1)."-".$monthName; ?> </b></span></div></td>
		                        </tr>

		                        <tr>
		                            <td class="rotate2" ><div><span><b><?php echo substr(date("l", strtotime(($i+1)."-".$monthName.'-'.$year)),0,3); ?></b></span></div></td>
		                        </tr>
		                        
		                </table>
		                </td>
		                    <?php } ?>
		                    </tr>
		                    </table>
		                </td>

		                <td>
		                    <b>Total Hrs</b>
		                </td>

		            </tr>

		            <!-- END FIRST ROW -->

		            <!-- START SECOND ROW -->

		            <tr>


		                <td style="width: 20%"><b></b></td>
		                <td style="width: 70%"><b>Deputed at</b></td>
		                <td style="width: 20%"></td>


			               	

			                <td colspan="4">
			                    <table border=1 style="width:100%">
			                    <tr>
			                    <?php $location_summary = array(); for($i=0; $i<$monthDays ; $i++){

			                    	$getSiteLocation = getSiteLocation($employeeSelect,$regionselect,date("Y-m-d", strtotime(($i+1)."-".$monthName.'-'.$year)));

			                    	if(isset($getSiteLocation[0]['site_location'])){
			                    		if(!array_key_exists(trim($getSiteLocation[0]['site_location']), $location_summary) ){
			                    			$location_summary[trim($getSiteLocation[0]['site_location'])] = 1;
			                    		}
			                    		else{
			                    			$location_summary[trim($getSiteLocation[0]['site_location'])] += 1;
			                    		}
			                    	}

			                    	

			                    	// print_r($getSiteLocation[0]);
			                    	// exit();

			                     ?>
			                <td>
		                <table style="width:100%">
		                        <tr>
		                            <td class="rotate" ><div><span><?php if(isset($getSiteLocation[0]['site_location'])){ echo $getSiteLocation[0]['site_location']; } else echo '-' ; ?></span></div></td>
		                        </tr>

		                        
		                </table>
		                </td>
		                    <?php } ?>
		                    </tr>
		                    </table>
		                		</td>
		                			<td>
		                		     
		                		 </td>

		            </tr>


		            <!-- END SECOND ROW -->


		            <!-- START THIRD ROW -->

		            <?php $srNo=1; $totalHoursAll = 0; while($row = mysqli_fetch_assoc($getRegionStatus)) { $totalHours = 0; //print_r($row); ?>
		                	  <tr>
		                	  	<th><?php echo $srNo;?></th>
		                	    <th><?php echo $row['status_option']; ?></th>
		                	    <th></th>
		                	   	
		                		  <td colspan="4">
		                    <table border=1 style="width:100%">
		                    <tr>
		                    <?php for($i=0; $i<$monthDays ; $i++){

		                    	$getAttendance = getSiteLocation($employeeSelect,$regionselect,date("Y-m-d", strtotime(($i+1)."-".$monthName.'-'.$year)));

		                    	// $checkRemarks = checkRemarks($getAttendance[0]['remarks'],$employeeSelect,$regionselect);

		                    	$hours = 0;
		                    	
		                    	$display = false;

		                    	if(isset($getAttendance[0])){
		                    		$timeIn = strtotime( $getAttendance[0]['attendance_for_date'].' '.$getAttendance[0]['time_in'].':00');
		                    		$timeOut = strtotime( $getAttendance[0]['attendance_for_date'].' '.$getAttendance[0]['time_out'].':00');

		                    		$diff = $timeOut - $timeIn;
		                    		$hours = $diff / ( 60 * 60 );
		                    		$display = true;                    		

		                    	}

		                    	


		                    	// exit();

		                     ?>
		                    <td>
		                    <table style="width:100%">
		                    <tr>
		                    <td class="" ><div><span><?php if(isset($getAttendance[0])){  if($row['status_option'] == $getAttendance[0]['status_option'] && $display) {  echo $getAttendance[0]['hours_worked']; $totalHours += $getAttendance[0]['hours_worked']; } else echo "<span class='print_white' style='color:white;'>^</span>";  } else echo "<span class='print_white' style='color:white;'>^</span>";  ?></span></div></td>
		                    </tr>
								


		                    </table>
		                    </td>
		                    <?php } ?>
		                    </tr>


		                    </table>
		                    </td>
		                		  <th><?php $totalHoursAll += $totalHours; echo $totalHours; ?></th>
		                		</tr>
		                				<?php  $srNo++; } ?>

		               	<!-- total row -->
								  <tr>
								  	<th></th>
								    <th><b>Total</b></th>
								    <th></th>
								   	
									<td colspan="4">
							    <table border=1 style="width:100%">
							    <tr>
							    <?php for($k=0; $k<$monthDays ; $k++){

							    	$getAttendance = getSiteLocation($employeeSelect,$regionselect,date("Y-m-d", strtotime(($k+1)."-".$monthName.'-'.$year)));

							    	// $checkRemarks = checkRemarks($getAttendance[0]['remarks'],$employeeSelect,$regionselect);

							    	$hours = 0;
							    	
							    	$display = false;

							    	if(isset($getAttendance[0])){
							    		$timeIn = strtotime( $getAttendance[0]['attendance_for_date'].' '.$getAttendance[0]['time_in'].':00');
							    		$timeOut = strtotime( $getAttendance[0]['attendance_for_date'].' '.$getAttendance[0]['time_out'].':00');

							    		$diff = $timeOut - $timeIn;
							    		$hours = $diff / ( 60 * 60 );
							    		$display = true;                    		

							    	}

							    	


							    	// exit();

							     ?>
							    <td>
							    <table style="width:100%">
							    <tr>
							    <td class="" ><div><span><?php if(isset($getAttendance[0])){  if($row['status_option'] == $getAttendance[0]['status_option'] && $display) {  echo $getAttendance[0]['hours_worked']; $totalHours += $getAttendance[0]['hours_worked']; }  }  ?></span></div></td>
							    </tr>
							


							    </table>
							    </td>
							    <?php } ?>
							    </tr>


							    </table>
							    </td>
									  <th><?php echo $totalHoursAll ?></th>
									</tr>
		            </tbody>
		    </table>

		    <table class="table table-bordered table-striped outertable" >

		        <tr>

		            <td>
		            
		            <table class="table table-bordered table-striped outertable" >

		                <?php if(isset($location_summary)) { foreach ($location_summary as $key => $value) { ?>
							
							<tr>
								<td><?php echo  $value.' '.$key; ?></td>
							</tr>

		                <?php } } ?>

		            </table>

		            </td>

		            <td>

		                <table class="table table-bordered table-striped outertable" >

		                    <tr><td><br><?php if($CasualLeave) echo $CasualLeave; else echo 0; ?><br>Casual Leaves<br>&nbsp;</td></tr>
		                    <tr><td><br>Verified by Immediate Superior<br>&nbsp;</td></tr>

		                </table>

		            </td>

		            <td>

		                <table class="table table-bordered table-striped outertable" >

		                    <tr><td><br><?php if($unpaidLeave) echo $unpaidLeave; else echo 0; ?><br>Unpaid Leave Days<br>&nbsp;</td></tr>
		                    <tr><td><br><?php if($absence) echo $absence; else echo 0; ?><br>Absence<br>&nbsp;</td></tr>

		                </table>

		            </td>


		            </td>

		            <td>

		                <table class="table table-bordered table-striped outertable" >

		                    <tr><td><br>&nbsp;<br>&nbsp;Paid Leave Days<br>&nbsp;</td><td><br>&nbsp;<?php if($AnnualLeave) echo $AnnualLeave; else echo 0; ?><br>&nbsp;</td></tr>
		                    <tr><td><br>&nbsp;<br>&nbsp;Sick Leaves<br>&nbsp;</td><td><br>&nbsp;<?php if($SickLeave) echo $SickLeave; else echo 0; ?><br>&nbsp;</td></tr>

		                </table>

		            </td>

		            </td>

		            <td>

		                <table class="table table-bordered table-striped outertable" >

		                <tr><td><br>&nbsp;<br>&nbsp;<br>&nbsp;</td></tr>
		                <tr><td>
		                    <table class="table table-bordered table-striped outertable" >

		                    <tr><td>
		                        <br>Approval by Finance
		                    </td>
		                    <td><b>Important:</b><br> All timesheets must be submitted<br> no later 
		                    than 6th of every <br>month both hard copy and soft copies.</td>
		                    </tr>

		                    </table>

		                </td></tr>

		                </table>

		            </td>


		        </tr>

		    </table>


		</div>

	<?php } ?> <p style="page-break-after: always;"></p>

	<?php } ?>



	</body>
	</html>


<?php } else { 


	// print_r($_POST);
	// exit();
	// 
	// All employee starts here

if($employeeInternalId  == 'all'){
	$employeeDetails = getAllEmployeeDetails($_POST['regionselect']);
}
else{



	$employeeSelect = $employeeInternalId;
	$employeeDetails = getEmployeeDetails($employeeSelect,$regionselect);
}


foreach($employeeDetails as $employeeDetailsData){

	$employeeSelect = $employeeDetailsData['employee_internal_id'];
	$regionselect = $employeeDetailsData['name_location'];


	for( $y=1;$y<=12;$y++ ){

	if($rangetype == 'monthyear' ){
		$year = $yearselect;
		if(strlen($y) == 1){
			$month = '0'.$y;
		}
		else{
			$month = $y;
		}

		$date1 = $year."-".$month."-01";
		$date2 = $year."-".$month."-".date("t",strtotime($date1));

		// print_r($employeePayments);
		// exit();
	}
	else{

		$explodedData1 = explode("-", $dateinput);
		$explodedData2 = explode("/", trim($explodedData1[0]));

		$date1 = date('Y-m-d',strtotime(trim($explodedData1[0])));
		$date2 = date('Y-m-d',strtotime(trim($explodedData1[1])));
		$year = $explodedData2[2];
		
	}

	$employeeSalary = getEmployeeSalary($employeeSelect,$month,$year);
	$arrears = 0;
	foreach($employeeSalary as $empSalary){
		$arrears += $empSalary['arrears'];

		// A = basic_salary x ((total days - (absence + unpaid leave)) / total days)
		$a = round( $empSalary['basic_salary']);

		// B = housing_allowance x ((total days - (absence + unpaid leave)) / total days)
		$b = round( $empSalary['housing_allowance']);

		// C = conveyance_allowance x ((total days - (absence + unpaid leave)) / total days)
		$c = round( $empSalary['conveyance_allowance']);

		// D = other_allowance x ((total days - (absence + unpaid leave)) / total days)
		$d = round( $empSalary['other_allowance']);

		// E = project_allowance x ((total days - (absence + unpaid leave)) / total days)
		// $e = round( $employeeDetailsData['project_allowance'] * (($totalDays - ($absence + $unpaidLeave)) / $totalDays));
		$e = round( $empSalary['project_allowance']);

		$totalDeductions = round($empSalary['deductions']);

		// T = A+B+C+D+E + F
		// $t = round($empSalary['gross_salary']);
		$t = $a + $b + $c + $d + $e;
	}


	$monthName = date('M',strtotime($date1));

	// print_r($monthName);
	// exit();

	$totalDays2 = date('t',strtotime($year."-".$month."-01"));

	$absence = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'Absence',$month,$yearselect);
	$unpaidLeave = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'UnpaidLeave',$month,$yearselect);
	$CasualLeave = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'CasualLeave',$month,$yearselect);
	$Idle = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'Idle',$month,$yearselect);
	$Job = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'Job',$month,$yearselect);
	$NationalHoliday = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'NationalHoliday',$month,$yearselect);
	$Office = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'Office',$month,$yearselect);
	$SickLeave = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'SickLeave',$month,$yearselect);
	$WeekOffDay = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'WeekOffDay',$month,$yearselect);
	$AnnualLeave = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'AnnualLeave',$month,$yearselect);


	$workDays = 0;
	if(!$Office){
		$Office = 0;
	};

	$workDays = $Office + $Job;


	if($month == '01' || $month == '03' || $month == '05' || $month == '07' || $month == '08' || $month == '10' || $month == '12'){
		$totalDays = 31;
	}
	else if($month == '02'){
		$totalDays = $totalDays2;
	}
	else{
		$totalDays = 30;
	}


	// A = basic_salary x ((total days - (absence + unpaid leave)) / total days)
	// $a = round( $employeeDetailsData['basic_salary'] * (($totalDays - ($absence + $unpaidLeave)) / $totalDays));

	// // B = housing_allowance x ((total days - (absence + unpaid leave)) / total days)
	// $b = round( $employeeDetailsData['housing_allowance'] * (($totalDays - ($absence + $unpaidLeave)) / $totalDays));

	// // C = conveyance_allowance x ((total days - (absence + unpaid leave)) / total days)
	// $c = round( $employeeDetailsData['conveyance_allowance'] * (($totalDays - ($absence + $unpaidLeave)) / $totalDays));

	// // D = other_allowance x ((total days - (absence + unpaid leave)) / total days)
	// $d = round( $employeeDetailsData['other_allowance'] * (($totalDays - ($absence + $unpaidLeave)) / $totalDays));

	// // E = project_allowance x ((total days - (absence + unpaid leave)) / total days)
	// // $e = round( $employeeDetailsData['project_allowance'] * (($totalDays - ($absence + $unpaidLeave)) / $totalDays));
	// $e = 20 * ($Job);

	// // F = T - P.T (of previous month)
	// // $f = 

	// // T = A+B+C+D+E + F
	// $t = $a + $b + $c + $d + $e + $arrears;

	//$absenceDeduction = ($absence/$totalDays)*$t;
	//$leaveWithoutDeduction = ($unpaidLeave/$totalDays)*$t;
	$absenceDeduction = $t*($totalDays/(($totalDays-($unpaidLeave + $absence))))*($absence/$totalDays);
		
	$leaveWithoutDeduction = $t*($totalDays/(($totalDays-($unpaidLeave + $absence))))*($unpaidLeave/$totalDays);
    $totalded = round($absenceDeduction + $leaveWithoutDeduction,2);

	// print_r($date1);
	// print_r($date2);


	if($reporttypeselect == 'Payslip' ){
	$employeePayments = getEmployeePaymentDetails($employeeSelect,$regionselect,$date1,$date2);

	$totalPayment = 0;
	if(!empty($employeePayments)){ 
		$sr = 1; $totalPayment = 0; 
		foreach($employeePayments as $payments) {
			$totalPayment = $totalPayment + $payments['amount'];
		} 
	}

	// $totalDeductions = round($absenceDeduction,1) + round($leaveWithoutDeduction,1) + round($totalPayment,1); ?>
	<style>

	    body{
	        padding:50px;
	    }

	    table tr td{
	        padding: 2px;
	        font-size: 10px;
	        width: 125px;
	        word-wrap: break-word;         /* All browsers since IE 5.5+ */
	        overflow-wrap: break-word;     /* Renamed property in CSS3 draft spec */
	    }

	    .innersubdetail tr td{
	        width: 95px;
	    }


	</style>
    <title>All - Payslip</title>
	<body>
    <div align="center">
        <style> 
        img {
            padding: 10px;
            margin-left: 380px;
            }
        </style>
        
        <img src="hollow-NPM.png" alt="Logo main" style="width:140px; align:center">
    </div>
	<!-- START OUTER TABLE 1 --->
	<div align="center">
		<table class="outer1" >

		<!-- START INNER TABLE 1 --->
		<table border=2 style= "text-align: center;width:512px;margin-bottom:10px;">

		    <tr>

		        <td><?php echo $employeeDetailsData['employee_NAME']; ?> <br> <?php echo $employeeDetailsData['employee_job_title']; ?></td>

		        <td>
		        	<table border=1>
		        		<tr>
		        			<td><?php echo $employeeDetailsData['employee_internal_id']; ?></td>
		        		</tr>
		        		<tr>
		        			<td><?php echo $employeeDetailsData['employee_nationality']; ?></td>
		        		</tr>
		        	</table>
		        </td>


		        
		        
		        <td> Month </td>
		        <td><?php

		        	$year = $yearselect;

		         if(strlen($y) == 1){
		        	$month = '0'.$y;
		        	$newDate = '01-'.$month.'-'.$year;
		        	echo  date('M',strtotime($newDate)) .'-'.$year;
		        } else{ 
		        	$month = $y;
		        	$newDate = '01-'.$month.'-'.$year;
		        	echo  date('M',strtotime($newDate)) .'-'.$year;
		        } ?></td>

		    </tr>

		</table>
		<!-- END INNER TABLE 1 --->

		<!-- <br> -->

		<!-- START INNER TABLE 2 --->
		<table border=2 style= "text-align: center;width:512px;margin-bottom:10px;">

		    <tr style="height: 50px;">

		        <td colspan="4" style="font-size: 20px;"><b>Salary Pay Slip</b></td>

		    </tr>

		    <tr>

		        <td>ID: <?php echo $employeeDetailsData['employee_cnic']; ?></td>
		        <td>Mobile No: <?php echo $employeeDetailsData['employee_mobile']; ?></td>
		        <td><?php echo $employeeDetailsData['account_no']; ?> </td>
		        <td ></td>

		    </tr>

		</table>

		<table border=2 style= "text-align: center;width:245px;margin-bottom:10px;display: inline;">

		    <tr style="height: 50px;">

		        <td>Basic: <?php echo $a//$employeeDetailsData['basic_salary'];?></td>
		        <td>Housing: <?php echo $b//$employeeDetailsData['housing_allowance'];?></td>
		        <!-- <td>Office Travel: <?php echo $employeeDetailsData['conveyance_allowance'];?></td>
		        <td style=""></td> -->

		    </tr>

		    <tr style="font-style:italic;">

		        <td><table border = 1 class="innersubdetail"><tr><td>Work Days</td><td>Idle Days</td></tr></table></td>
		        <td><table border = 1 class="innersubdetail"><tr><td style="font-size:9px;">Paid Leave</td><td>Absence</td></tr></table></td>
		        <!-- <td><table border = 1 class="innersubdetail"><tr><td style="font-size:9px;">Office Days</td><td style="font-size:9px;">Unpaid Leave</td></tr></table></td>
		        <td>Total Days</td> -->

		    </tr>

		    <tr>
				<?php
				$workDays = 0;
						if(!$Office){
							$Office = 0;
						};

				 $workDays = $Office + $Job; ?>
		        <td><table border = 1 class="innersubdetail"><tr><td><?php echo $workDays; ?></td><td><?php if($Idle) echo $Idle; else echo 0; ?></td></tr></table></td>
		        <td><table border = 1 class="innersubdetail"><tr><td><?php if($CasualLeave) echo $CasualLeave; else echo 0; ?></td><td><?php if($absence) echo $absence; else echo 0; ?></td></tr></table></td>
		        <!-- <td><table border = 1 class="innersubdetail"><tr><td><?php if($Office) echo $Office; else echo 0; ?></td><td><?php if($unpaidLeave) echo $unpaidLeave; else echo 0; ?></td></tr></table></td> -->
		        <!-- <td><?php echo $totalDays; ?></td> -->

		    </tr>

		    <tr>

		        <td>National Holidays: <?php echo $NationalHoliday;?></td>
		        <td></td>
		        <!-- <td colspan="2"></td> -->

		    </tr>

		    <tr style="height: 20px;">

		        <td><table border = 1 style="height: 20px;"><tr><td style="width: 25px;"></td><td style="width: 100px;"></td></tr></table></td>
		        <td></td>
		       <!--  <td></td>
		        <td style=""></td> -->

		    </tr>

		    <tr>

		        <td><table border = 1 ><tr><td style="width: 25px;"></td><td style="width: 100px;text-align:right;">Basic</td></tr></table></td>
		        <td ><?php echo $a;//$employeeDetailsData['basic_salary'];?></td>
		        <!-- <td style="text-align:right;">Jizan Substation</td>
		        <td >3</td> -->

		    </tr>

		    <tr>

		        <td><table border = 1 ><tr><td style="width: 25px;"></td><td style="width: 100px;text-align:right;">Housing</td></tr></table></td>
		        <td ><?php echo $b;//$employeeDetailsData['housing_allowance'];?></td>
		        <!-- <td style="text-align:right;">Not Joined</td>
		        <td >28</td> -->

		    </tr>

		        <tr>

		        <td><table border = 1 ><tr><td style="width: 25px;"></td><td style="width: 100px;text-align:right;">Office Travel</td></tr></table></td>
		        <td ><?php echo $c;//$employeeDetailsData['conveyance_allowance'];?></td>
		        <!-- <td style="text-align:right;"></td>
		        <td ></td> -->

		    </tr>

		    <tr>

		        <td><table border = 1 ><tr><td style="width: 25px;"></td><td style="font-size:9px;width: 100px;text-align:right;">Other Allowance</td></tr></table></td>
		        <td ><?php echo $d;//$employeeDetailsData['other_allowance'];?></td>
		        <!-- <td style="text-align:right;"></td>
		        <td ></td> -->

		    </tr>

		    <tr>
            <!-- ########## Improvisation here. see /10 -->
		        <td><table border = 1 ><tr><td style="width: 25px;"></td><td style="font-size:9px;width: 100px;text-align:right;">Food Allowance</td></tr></table></td>
		        <td ><?php echo $food_allowance = $e; ?></td>
		        <!-- <td style="text-align:right;"></td>
		        <td ></td> -->

		    </tr>

		    <tr>

		        <td><table border = 1 ><tr><td style="width: 25px;"></td><td style="font-size:9px;width: 100px;text-align:right;">Total</td></tr></table></td>
		        <td ><?php echo $t; ?></td>
		        <!-- <td style="text-align:right;"></td>
		        <td ></td> -->

		    </tr>

		    <tr>

		        <td><table border = 1 ><tr><td style="width: 25px;"></td><td style="font-size:9px;width: 100px;text-align:right;">Absences</td></tr></table></td>
		        <td ><?php echo round($absenceDeduction,2);?></td>
		        <!-- <td style="text-align:right;"></td>
		        <td ></td> -->

		    </tr>

		    <tr>

		        <td><table border = 1 ><tr><td style="width: 25px;"></td><td style="font-size:9px;width: 100px;text-align:right;">Leave without Pay</td></tr></table></td>
		        <td ><?php echo round($leaveWithoutDeduction,2);?></td>
		        <!-- <td style="text-align:right;"></td>
		        <td ></td> -->

		    </tr>

		    <tr>

		        <td><table border = 1 ><tr><td style="width: 25px;"></td><td style="font-size:9px;width: 100px;text-align:right;">Any other Deduction</td></tr></table></td>
		        <td ><?php echo $totalPayment - $totalDeductions; ?></td>
		        <!-- <td style="text-align:right;"></td>
		        <td ></td> -->

		    </tr>

		    <tr>
<!--
		        <td><table border = 1 ><tr><td style="width: 25px;"></td><td style="font-size:9px;width: 100px;text-align:right;">Arrears</td></tr></table></td>
		        <td ><?php echo $arrears;?></td>
		        <!-- <td style="text-align:right;"></td>
		        <td ></td> -->

		    </tr>

		    <tr>

		        <td><table border = 1 ><tr><td style="width: 25px;"></td><td style="font-size:9px;width: 100px;text-align:right;">Total Deductions</td></tr></table></td>
		        <td ><?php echo -$totalded + ($totalPayment - $totalDeductions);?></td>

		    </tr>

		    <tr>

		        <td><table border = 1 ><tr><td style="width: 25px;"></td><td style="font-size:9px;width: 100px;text-align:right;"><b>Net Salary Payable</b></td></tr></table></td>
		        <td ><b><?php echo $netPay = $t + $arrears ?></b></td>
		       <!--  <td style="text-align:right;"></td>
		        <td ></td> -->

		    </tr>

		    
		</table>
		<!-- END INNER TABLE 3 --->
		<table border=2 style= "text-align: center;width:245px;margin-bottom:10px;display: inline;">



		    <tr style="height: 50px;">

		        <!-- <td>Basic: <?php echo $employeeDetailsData['basic_salary'];?></td>
		        <td>Housing: <?php echo $employeeDetailsData['housing_allowance'];?></td> -->
		        <td>Total Salary: <?php echo floor(($totalDays/(($totalDays-($unpaidLeave + $absence))))*$t);?></td>
		        <td style=""></td>

		    </tr>

		    <tr style="font-style:italic;">

		        <!-- <td><table border = 1 class="innersubdetail"><tr><td>Work Days</td><td>Idle Days</td></tr></table></td>
		        <td><table border = 1 class="innersubdetail"><tr><td style="font-size:9px;">Paid Leave</td><td>Absence</td></tr></table></td> -->
		        <td><table border = 1 class="innersubdetail"><tr><td style="font-size:9px;">Office Days</td><td style="font-size:9px;">Unpaid L</td></tr></table></td>
		        <!-- <td></td> -->

		        <td><table border = 1 class=""><tr><td >Total Days</td></tr></table></td>
		        <!-- <td><table border = 1 class="innersubdetail"><tr><td style="font-size:9px;">Paid Leave</td><td>Absence</td></tr></table></td> -->

		    </tr>

		    <tr>
				<?php
				$workDays = 0;
						if(!$Office){
							$Office = 0;
						};

				 $workDays = $Office + $Job; ?>
		        <!-- <td><table border = 1 class="innersubdetail"><tr><td><?php echo $workDays; ?></td><td><?php if($Idle) echo $Idle; else echo 0; ?></td></tr></table></td>
		        <td><table border = 1 class="innersubdetail"><tr><td><?php if($CasualLeave) echo $CasualLeave; else echo 0; ?></td><td><?php if($absence) echo $absence; else echo 0; ?></td></tr></table></td> -->
		        <td><table border = 1 class="innersubdetail"><tr><td><?php if($Office) echo $Office; else echo 0; ?></td><td><?php if($unpaidLeave) echo $unpaidLeave; else echo 0; ?></td></tr></table></td>
		        
		        <td><table border = 1 class=""><tr><td ><?php echo $totalDays; ?></td></tr></table></td>

		    </tr>

		    <tr>

		        <!-- <td>National Holidays: <?php echo $NationalHoliday;?></td> -->
		        <td>&nbsp;</td>
		        <td colspan="2">&nbsp;</td>

		    </tr>

		    <tr style="height: 20px;">

		        <td><table border = 1 style="height: 20px;"><tr><td style="width: 25px;"></td><td style="width: 100px;"></td></tr></table></td>
		        <td></td>
		       <!--  <td></td>
		        <td style=""></td> -->

		    </tr>

		    <?php 
			    $monthDays = cal_days_in_month(CAL_GREGORIAN, $y, $year); $location_summary = array();  
			    for($i=0; $i<$monthDays ; $i++){		    	

                	$getSiteLocation = getSiteLocation($employeeSelect,$regionselect,date("Y-m-d", strtotime(($i+1)."-".$monthName.'-'.$year)));               	

                	if(isset($getSiteLocation[0]['site_location'])){
                		if(!array_key_exists(trim($getSiteLocation[0]['site_location']), $location_summary) ){
                			$location_summary[trim($getSiteLocation[0]['site_location'])] = 1;
                		}
                		else{
                			$location_summary[trim($getSiteLocation[0]['site_location'])] += 1;
                		}
                	}

                	
            	}
            	$remainingTr = 12 - count($location_summary);

            	if($remainingTr < 0){
            		$remainingTr = 0;
            	} ?>

				<?php if(isset($location_summary)) { foreach ($location_summary as $key => $value) { ?>
						
						<tr style="height: 20px;">

					        <td><table border = 1 style="height: 20px;"><tr><td style="width: 25px;"></td><td style="width: 100px;"><?php echo $key; ?></td></tr></table></td>
					        <td><?php echo $value; ?></td>
					       <!--  <td></td>
					        <td style=""></td> -->

					    </tr>

	                <?php } } ?>
		    
		</table>


		<!-- START INNER TABLE 4 --->
		<table border=2 style= "text-align: center;width:512px;height:100px;">
			<tr>

			    <!-- <td style="width: 25px;"></td> -->
			    <td colspan="3"><b><?php  echo convert_number_to_words(round($netPay,2)). " only" ?></b></td>
			

			</tr>
		    <tr>

		        <td style="text-align:right;">HR Incharge&nbsp;&nbsp;</td>
		        <td style="text-align:left;">&nbsp;&nbsp;Approved By</td>
		        <td rowspan="2">Thumb Impression</td>

		    </tr>

		    <tr>

		        <td style="text-align:right;">Accounts&nbsp;&nbsp;</td>
		        <td style="text-align:left;">&nbsp;&nbsp;Received By</td>

		    </tr>

		</table>
		<!-- END INNER TABLE 4 --->

		</table>
		<!-- END OUTER TABLE 1 --->
	</div>
	<?php }

	else if ($reporttypeselect == 'Summary'){

		// print_r($_POST);
		// exit();


	// $monthselect = 

	// $employeeDetails = getEmployeeDetails($employeeSelect,$regionselect);
	// 
	


	$getRegionStatus = get_Status_Options_For_location($regionselect); 


	


	// print_r($monthselect);
	// exit();
	 ?>

<!DOCTYPE html>
<html>
<head>
	<title>All Summary</title>
	<style>
	body{
	    padding:20px;
	}
	.outerNew td{
	    padding:8px;
	    font-size: 12px;
	}

	.smallcolumns td{
	    font-size: 10px;
	    height:3%;
	    padding: 4px;
	}

	.smallcolumns1 td{
	    padding: 1px;
	}

	.smallcolumns3 td{
	    font-size: 10px;
	    height:3%;
	    padding: 4px;
	    text-align:right;
	}
	</style>
</head>
    <div align="right">
        <style> 
        img {
            padding: 10px;
            margin-right: 0px;
            }
        </style>
        
        <img src="hollow-NPM.png" alt="Logo main" style="width:160px; align:center">
    </div>
<body>
		
<?php 

		if($rangetype == 'monthyear' ) {

			// echo "here";
			// exit();
			// var_dump($month);
						
			$absence_total = getAttendanceRecordsForYear($employeeDetailsData['employee_internal_id'],$regionselect,'Absence',$yearselect);
			$unpaidLeave_total = getAttendanceRecordsForYear($employeeDetailsData['employee_internal_id'],$regionselect,'UnpaidLeave',$yearselect);
			$CasualLeave_total = getAttendanceRecordsForYear($employeeDetailsData['employee_internal_id'],$regionselect,'CasualLeave',$yearselect);
			$Idle_total = getAttendanceRecordsForYear($employeeDetailsData['employee_internal_id'],$regionselect,'Idle',$yearselect);
			$Job_total = getAttendanceRecordsForYear($employeeDetailsData['employee_internal_id'],$regionselect,'Job',$yearselect);
			$NationalHoliday_total = getAttendanceRecordsForYear($employeeDetailsData['employee_internal_id'],$regionselect,'NationalHoliday',$yearselect);
			$Office_total = getAttendanceRecordsForYear($employeeDetailsData['employee_internal_id'],$regionselect,'Office',$yearselect);
			$SickLeave_total = getAttendanceRecordsForYear($employeeDetailsData['employee_internal_id'],$regionselect,'SickLeave',$yearselect);
			$WeekOffDay_total = getAttendanceRecordsForYear($employeeDetailsData['employee_internal_id'],$regionselect,'WeekOffDay',$yearselect);
			$AnnualDay_total = getAttendanceRecordsForYear($employeeDetailsData['employee_internal_id'],$regionselect,'AnnualLeave',$yearselect);





			if($month == '01' || $month == '03' || $month == '05' || $month == '07' || $month == '08' || $month == '10' || $month == '12'){
				$totalDays = 31;
			}
			else if($month == '02'){
				$totalDays = $totalDays2;
			}
			else{
				$totalDays = 30;
			}

			$employeeSalaryTotal = getEmployeeSalaryTotal($employeeDetailsData['employee_internal_id'],$yearselect);
			$jan_arrears = 0;
			foreach($employeeSalaryTotal as $empSalary){
				$arrears_total = $empSalary['arrears_total'];

				// A = basic_salary x ((total days - (absence + unpaid leave)) / total days)
				$total_a = round( $empSalary['basic_salary_total']);

				// B = housing_allowance x ((total days - (absence + unpaid leave)) / total days)
				$total_b = round( $empSalary['housing_allowance_total']);

				// C = conveyance_allowance x ((total days - (absence + unpaid leave)) / total days)
				$total_c = round( $empSalary['conveyance_allowance_total']);

				// D = other_allowance x ((total days - (absence + unpaid leave)) / total days)
				$total_d = round( $empSalary['other_allowance_total']);

				// E = project_allowance x ((total days - (absence + unpaid leave)) / total days)
				// $e = round( $employeeDetailsData['project_allowance_total'] * (($totalDays - ($absence + $unpaidLeave)) / $totalDays));
				$total_e = round( $empSalary['project_allowance_total']);

				$total_totalDeductions = round($empSalary['deductions_total']);

				// T = A+B+C+D+E + F
				$total_t = round($empSalary['gross_salary_total']);
			}
		 ?>
		




		<div align="center">
	
    <table class="outerNew" border="1">
	
        <tr>

            <td colspan="3">Employee Name: <?php echo $employeeDetailsData['employee_NAME']; ?> </td>
            <td colspan="2">Job Title: <?php echo $employeeDetailsData['employee_job_title']; ?></td>
            <td style="width:5%;">Internal ID: <?php echo $employeeDetailsData['employee_internal_id']; ?></td>
            <td colspan="2">CNIC: <?php echo $employeeDetailsData['employee_cnic']; ?></td>
            <td colspan="2">Mobile Number: <?php echo $employeeDetailsData['employee_mobile']; ?></td>
            <td colspan="3">Account Number: <?php echo $employeeDetailsData['account_no']; ?> </td>
            <td >Year </td>
            <td colspan="2"><?php echo $year; ?> </td>

        </tr>

        <tr>

            <td style="width:3%;">Ln</td>
            <td style="width:12%;">&nbsp;</td>
            <td style="width:6%;">Total</td>
            <td style="width:5%;"> Last Year</td>
            <td style="width:5%;"> Jan</td>
            <td style="width:5%;"> Feb</td>
            <td style="width:5%;"> Mar</td>
            <td style="width:5%;"> Apr</td>
            <td style="width:5%;"> May</td>
            <td style="width:5%;"> Jun</td>
            <td style="width:5%;"> Jul</td>
            <td style="width:5%;"> Aug</td>
            <td style="width:5%;"> Sep</td>
            <td style="width:5%;"> Oct</td>
            <td style="width:5%;"> Nov</td>
            <td style="width:5%;"> Dec</td>

        </tr>					  

        <tr>
            <td style="width:3%;">&nbsp;</td>
            <td style="width:12%;">&nbsp;</td>
            <td style="width:6%;">&nbsp;</td>
            <td style="width:5%;"> &nbsp;</td>
            <td><?php echo $totalDays1 = date('t',strtotime($year."-01-01")); ?></td>
			<td><?php echo $totalDays2 = date('t',strtotime($year."-02-01")); ?></td>
			<td><?php echo $totalDays3 = date('t',strtotime($year."-03-01")); ?></td>
			<td><?php echo $totalDays4 = date('t',strtotime($year."-04-01")); ?></td>
			<td><?php echo $totalDays5 = date('t',strtotime($year."-05-01")); ?></td>
			<td><?php echo $totalDays6 = date('t',strtotime($year."-06-01")); ?></td>
			<td><?php echo $totalDays7 = date('t',strtotime($year."-07-01")); ?></td>
			<td><?php echo $totalDays8 = date('t',strtotime($year."-08-01")); ?></td>
			<td><?php echo $totalDays9 = date('t',strtotime($year."-09-01")); ?></td>
			<td><?php echo $totalDays10 = date('t',strtotime($year."-10-01")); ?></td>
			<td><?php echo $totalDays11 = date('t',strtotime($year."-11-01")); ?></td>
			<td><?php echo $totalDays12 = date('t',strtotime($year."-12-01")); ?></td>

        </tr>



        <?php   $sr = 1; $arrears = 0; while($row = mysqli_fetch_assoc($getRegionStatus)) { //echo $month;  ?>
				  <tr>

						<td style="width:3%;text-align:center;"><?php echo $sr;?></td>
			            <td style="width:12%;"><?php echo $row['status_option']; ?></td>
			            <td style="width:6%;">&nbsp;</td>
			            <td style="width:5%;"> &nbsp;</td>				    	
					  <td style="width:5%;"><?php

                    // Fetching data for last year

                      //  $employeeSalary = getEmployeeSalary($employeeDetailsData['employee_internal_id'],'12',$yearselect-1);
					  //	$last_arrears = 0;
					  //	foreach($employeeSalary as $empSalary){
					  //	$last_arrears += $empSalary['arrears'];
					  //	}
					  
                    // End fetch
                    
					  	$employeeSalary = getEmployeeSalary($employeeDetailsData['employee_internal_id'],'01',$yearselect);
					  	$jan_arrears = 0;
					  	foreach($employeeSalary as $empSalary){
					  		$jan_arrears += $empSalary['arrears'];

					  		// A = basic_salary x ((total days - (absence + unpaid leave)) / total days)
					  		$jan_a = round( $empSalary['basic_salary']);

					  		// B = housing_allowance x ((total days - (absence + unpaid leave)) / total days)
					  		$jan_b = round( $empSalary['housing_allowance']);

					  		// C = conveyance_allowance x ((total days - (absence + unpaid leave)) / total days)
					  		$jan_c = round( $empSalary['conveyance_allowance']);

					  		// D = other_allowance x ((total days - (absence + unpaid leave)) / total days)
					  		$jan_o = round( $empSalary['other_allowance']);

					  		// E = project_allowance x ((total days - (absence + unpaid leave)) / total days)
					  		// $e = round( $employeeDetailsData['project_allowance'] * (($totalDays - ($absence + $unpaidLeave)) / $totalDays));
					  		$jan_e = round( $empSalary['project_allowance']);

					  		$jan_totalDeductions = round($empSalary['deductions']);

					  		// T = A+B+C+D+E + F
					  		// $jan_t = round($empSalary['gross_salary']);
					  		$jan_t = $jan_a + $jan_b + $jan_c + $jan_o + $jan_e;
					  	}

					  	$jan_Job = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'Job','01',$yearselect);

					   if($rangetype == 'monthyear'){
					$dataJan = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,$row['status_option'],'01',$yearselect); if(!is_null($dataJan)){ echo $dataJan; } else echo '-';

						
					}
					else{
						echo '-';
					} ?> 
					</td>
					<td style="width:5%;"><?php
						$employeeSalary = getEmployeeSalary($employeeDetailsData['employee_internal_id'],'02',$yearselect);
						$feb_arrears = 0;
					  	foreach($employeeSalary as $empSalary){
					  		$feb_arrears += $empSalary['arrears'];

					  		// A = basic_salary x ((total days - (absence + unpaid leave)) / total days)
					  		$feb_a = round( $empSalary['basic_salary']);

					  		// B = housing_allowance x ((total days - (absence + unpaid leave)) / total days)
					  		$feb_b = round( $empSalary['housing_allowance']);

					  		// C = conveyance_allowance x ((total days - (absence + unpaid leave)) / total days)
					  		$feb_c = round( $empSalary['conveyance_allowance']);

					  		// D = other_allowance x ((total days - (absence + unpaid leave)) / total days)
					  		$feb_o = round( $empSalary['other_allowance']);

					  		// E = project_allowance x ((total days - (absence + unpaid leave)) / total days)
					  		// $e = round( $employeeDetailsData['project_allowance'] * (($totalDays - ($absence + $unpaidLeave)) / $totalDays));
					  		$feb_e = round( $empSalary['project_allowance']);

					  		$feb_totalDeductions = round($empSalary['deductions']);

					  		// T = A+B+C+D+E + F
					  		// $feb_t = round($empSalary['gross_salary']);
					  		$feb_t = $feb_a + $feb_b + $feb_c + $feb_o + $feb_e;
					  	}

					  	$feb_Job = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'Job','02',$yearselect);

					 if($rangetype == 'monthyear' ){ 
						$dataFeb = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,$row['status_option'],'02',$yearselect); if(!is_null($dataFeb)){ echo $dataFeb; } else echo '-';
					}
					else{
						echo '-';
					} ?>  </td>
					<td style="width:5%;"><?php
						$employeeSalary = getEmployeeSalary($employeeDetailsData['employee_internal_id'],'03',$yearselect);
						
						$mar_arrears = 0;
					  	foreach($employeeSalary as $empSalary){
					  		$mar_arrears += $empSalary['arrears'];

					  		// A = basic_salary x ((total days - (absence + unpaid leave)) / total days)
					  		$mar_a = round( $empSalary['basic_salary']);

					  		// B = housing_allowance x ((total days - (absence + unpaid leave)) / total days)
					  		$mar_b = round( $empSalary['housing_allowance']);

					  		// C = conveyance_allowance x ((total days - (absence + unpaid leave)) / total days)
					  		$mar_c = round( $empSalary['conveyance_allowance']);

					  		// D = other_allowance x ((total days - (absence + unpaid leave)) / total days)
					  		$mar_o = round( $empSalary['other_allowance']);

					  		// E = project_allowance x ((total days - (absence + unpaid leave)) / total days)
					  		// $e = round( $employeeDetailsData['project_allowance'] * (($totalDays - ($absence + $unpaidLeave)) / $totalDays));
					  		$mar_e = round( $empSalary['project_allowance']);

					  		$mar_totalDeductions = round($empSalary['deductions']);

					  		// T = A+B+C+D+E + F
					  		// $mar_t = round($empSalary['gross_salary']);
					  		$mar_t = $mar_a + $mar_b + $mar_c + $mar_o + $mar_e;
					  	}

					  	$mar_Job = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'Job','03',$yearselect);

					 if($rangetype == 'monthyear' ){
							$dataMar = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,$row['status_option'],'03',$yearselect); if(!is_null($dataMar)){ echo $dataMar; } else echo '-';
						}
						else{
							echo '-';
						} ?> </td>
						<td style="width:5%;"><?php

							$employeeSalary = getEmployeeSalary($employeeDetailsData['employee_internal_id'],'04',$yearselect);
							
							$apr_arrears = 0;
							foreach($employeeSalary as $empSalary){
								$apr_arrears += $empSalary['arrears'];

								// A = basic_salary x ((total days - (absence + unpaid leave)) / total days)
								$apr_a = round( $empSalary['basic_salary']);

								// B = housing_allowance x ((total days - (absence + unpaid leave)) / total days)
								$apr_b = round( $empSalary['housing_allowance']);

								// C = conveyance_allowance x ((total days - (absence + unpaid leave)) / total days)
								$apr_c = round( $empSalary['conveyance_allowance']);

								// D = other_allowance x ((total days - (absence + unpaid leave)) / total days)
								$apr_o = round( $empSalary['other_allowance']);

								// E = project_allowance x ((total days - (absence + unpaid leave)) / total days)
								// $e = round( $employeeDetailsData['project_allowance'] * (($totalDays - ($absence + $unpaidLeave)) / $totalDays));
								$apr_e = round( $empSalary['project_allowance']);

								$apr_totalDeductions = round($empSalary['deductions']);

								// T = A+B+C+D+E + F
								// $apr_t = round($empSalary['gross_salary']);
								$apr_t = $apr_a + $apr_b + $apr_c + $apr_o + $apr_e;
							}
							$apr_Job = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'Job','04',$yearselect);

						 if($rangetype == 'monthyear' ){
							$dataApr = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,$row['status_option'],'04',$yearselect); if(!is_null($dataApr)){ echo $dataApr; } else echo '-';
						}
						else{
							echo '-';
						} ?> </td>
						<td style="width:5%;"><?php
							$employeeSalary = getEmployeeSalary($employeeDetailsData['employee_internal_id'],'05',$yearselect);
							
							$may_arrears = 0;
							foreach($employeeSalary as $empSalary){
								$may_arrears += $empSalary['arrears'];

								// A = basic_salary x ((total days - (absence + unpaid leave)) / total days)
								$may_a = round( $empSalary['basic_salary']);

								// B = housing_allowance x ((total days - (absence + unpaid leave)) / total days)
								$may_b = round( $empSalary['housing_allowance']);

								// C = conveyance_allowance x ((total days - (absence + unpaid leave)) / total days)
								$may_c = round( $empSalary['conveyance_allowance']);

								// D = other_allowance x ((total days - (absence + unpaid leave)) / total days)
								$may_o = round( $empSalary['other_allowance']);

								// E = project_allowance x ((total days - (absence + unpaid leave)) / total days)
								// $e = round( $employeeDetailsData['project_allowance'] * (($totalDays - ($absence + $unpaidLeave)) / $totalDays));
								$may_e = round( $empSalary['project_allowance']);

								$may_totalDeductions = round($empSalary['deductions']);

								// T = A+B+C+D+E + F
								// $may_t = round($empSalary['gross_salary']);
								$may_t = $may_a + $may_b + $may_c + $may_o + $may_e;
							}
							$may_Job = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'Job','05',$yearselect);
						 if($rangetype == 'monthyear' ){
							$dataMay = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,$row['status_option'],'05',$yearselect); if(!is_null($dataMay)){ echo $dataMay; } else echo '-';
						}
						else{
							echo '-';
						} ?> </td>
						<td style="width:5%;"><?php

							$employeeSalary = getEmployeeSalary($employeeDetailsData['employee_internal_id'],'06',$yearselect);
							
							$jun_arrears = 0;
					  	foreach($employeeSalary as $empSalary){
					  		$jun_arrears += $empSalary['arrears'];

					  		// A = basic_salary x ((total days - (absence + unpaid leave)) / total days)
					  		$jun_a = round( $empSalary['basic_salary']);

					  		// B = housing_allowance x ((total days - (absence + unpaid leave)) / total days)
					  		$jun_b = round( $empSalary['housing_allowance']);

					  		// C = conveyance_allowance x ((total days - (absence + unpaid leave)) / total days)
					  		$jun_c = round( $empSalary['conveyance_allowance']);

					  		// D = other_allowance x ((total days - (absence + unpaid leave)) / total days)
					  		$jun_o = round( $empSalary['other_allowance']);

					  		// E = project_allowance x ((total days - (absence + unpaid leave)) / total days)
					  		// $e = round( $employeeDetailsData['project_allowance'] * (($totalDays - ($absence + $unpaidLeave)) / $totalDays));
					  		$jun_e = round( $empSalary['project_allowance']);

					  		$jun_totalDeductions = round($empSalary['deductions']);

					  		// T = A+B+C+D+E + F
					  		// $jun_t = round($empSalary['gross_salary']);
					  		$jun_t = $jun_a + $jun_b + $jun_c + $jun_o + $jun_e;
					  	}

					  	$jun_Job = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'Job','06',$yearselect);
						 if($rangetype == 'monthyear' ){
							$dataJun = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,$row['status_option'],'06',$yearselect); if(!is_null($dataJun)){ echo $dataJun; } else echo '-';
						}
						else{
							echo '-';
						} ?> </td>
						<td style="width:5%;"><?php

							$employeeSalary = getEmployeeSalary($employeeDetailsData['employee_internal_id'],'07',$yearselect);
							$jul_arrears = 0;
							foreach($employeeSalary as $empSalary){
								$jul_arrears += $empSalary['arrears'];

								// A = basic_salary x ((total days - (absence + unpaid leave)) / total days)
								$jul_a = round( $empSalary['basic_salary']);

								// B = housing_allowance x ((total days - (absence + unpaid leave)) / total days)
								$jul_b = round( $empSalary['housing_allowance']);

								// C = conveyance_allowance x ((total days - (absence + unpaid leave)) / total days)
								$jul_c = round( $empSalary['conveyance_allowance']);

								// D = other_allowance x ((total days - (absence + unpaid leave)) / total days)
								$jul_o = round( $empSalary['other_allowance']);

								// E = project_allowance x ((total days - (absence + unpaid leave)) / total days)
								// $e = round( $employeeDetailsData['project_allowance'] * (($totalDays - ($absence + $unpaidLeave)) / $totalDays));
								$jul_e = round( $empSalary['project_allowance']);

								$jul_totalDeductions = round($empSalary['deductions']);

								// T = A+B+C+D+E + F
								// $jul_t = round($empSalary['gross_salary']);
								$jul_t = $jul_a + $jul_b + $jul_c + $jul_o + $jul_e;
							}

							$jul_Job = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'Job','07',$yearselect);

						 if($rangetype == 'monthyear' ){
							$dataJul = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,$row['status_option'],'07',$yearselect); if(!is_null($dataJul)){ echo $dataJul; } else echo '-';
						}
						else{
							echo '-';
						} ?> </td>
						<td style="width:5%;"><?php

							$employeeSalary = getEmployeeSalary($employeeDetailsData['employee_internal_id'],'08',$yearselect);
							$aug_arrears = 0;
							foreach($employeeSalary as $empSalary){
								$aug_arrears += $empSalary['arrears'];

								// A = basic_salary x ((total days - (absence + unpaid leave)) / total days)
								$aug_a = round( $empSalary['basic_salary']);

								// B = housing_allowance x ((total days - (absence + unpaid leave)) / total days)
								$aug_b = round( $empSalary['housing_allowance']);

								// C = conveyance_allowance x ((total days - (absence + unpaid leave)) / total days)
								$aug_c = round( $empSalary['conveyance_allowance']);

								// D = other_allowance x ((total days - (absence + unpaid leave)) / total days)
								$aug_o = round( $empSalary['other_allowance']);

								// E = project_allowance x ((total days - (absence + unpaid leave)) / total days)
								// $e = round( $employeeDetailsData['project_allowance'] * (($totalDays - ($absence + $unpaidLeave)) / $totalDays));
								$aug_e = round( $empSalary['project_allowance']);

								$aug_totalDeductions = round($empSalary['deductions']);

								// T = A+B+C+D+E + F
								// $aug_t = round($empSalary['gross_salary']);
								$aug_t = $aug_a + $aug_b + $aug_c + $aug_o + $aug_e;
							}

							$aug_Job = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'Job','08',$yearselect);
						 if($rangetype == 'monthyear' ){
							$dataAug = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,$row['status_option'],'08',$yearselect); if(!is_null($dataAug)){ echo $dataAug; } else echo '-';
						}
						else{
							echo '-';
						} ?> </td>
						<td style="width:5%;"><?php

						$employeeSalary = getEmployeeSalary($employeeDetailsData['employee_internal_id'],'09',$yearselect);
						$sep_arrears = 0;
						foreach($employeeSalary as $empSalary){
							$sep_arrears += $empSalary['arrears'];

							// A = basic_salary x ((total days - (absence + unpaid leave)) / total days)
							$sep_a = round( $empSalary['basic_salary']);

							// B = housing_allowance x ((total days - (absence + unpaid leave)) / total days)
							$sep_b = round( $empSalary['housing_allowance']);

							// C = conveyance_allowance x ((total days - (absence + unpaid leave)) / total days)
							$sep_c = round( $empSalary['conveyance_allowance']);

							// D = other_allowance x ((total days - (absence + unpaid leave)) / total days)
							$sep_o = round( $empSalary['other_allowance']);

							// E = project_allowance x ((total days - (absence + unpaid leave)) / total days)
							// $e = round( $employeeDetailsData['project_allowance'] * (($totalDays - ($absence + $unpaidLeave)) / $totalDays));
							$sep_e = round( $empSalary['project_allowance']);

							$sep_totalDeductions = round($empSalary['deductions']);

							// T = A+B+C+D+E + F
							// $sep_t = round($empSalary['gross_salary']);
							$sep_t = $sep_a + $sep_b + $sep_c + $sep_o + $sep_e;
						}

						$sep_Job = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'Job','09',$yearselect);
						 if($rangetype == 'monthyear' ){
							$dataSep = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,$row['status_option'],'09',$yearselect); if(!is_null($dataSep)){ echo $dataSep; } else echo '-';
						}
						else{
							echo '-';
						} ?> </td>
						<td style="width:5%;"><?php

							$employeeSalary = getEmployeeSalary($employeeDetailsData['employee_internal_id'],'10',$yearselect);
							$oct_arrears = 0;
							foreach($employeeSalary as $empSalary){
								$oct_arrears += $empSalary['arrears'];

								// A = basic_salary x ((total days - (absence + unpaid leave)) / total days)
								$oct_a = round( $empSalary['basic_salary']);

								// B = housing_allowance x ((total days - (absence + unpaid leave)) / total days)
								$oct_b = round( $empSalary['housing_allowance']);

								// C = conveyance_allowance x ((total days - (absence + unpaid leave)) / total days)
								$oct_c = round( $empSalary['conveyance_allowance']);

								// D = other_allowance x ((total days - (absence + unpaid leave)) / total days)
								$oct_o = round( $empSalary['other_allowance']);

								// E = project_allowance x ((total days - (absence + unpaid leave)) / total days)
								// $e = round( $employeeDetailsData['project_allowance'] * (($totalDays - ($absence + $unpaidLeave)) / $totalDays));
								$oct_e = round( $empSalary['project_allowance']);

								$oct_totalDeductions = round($empSalary['deductions']);

								// T = A+B+C+D+E + F
								// $oct_t = round($empSalary['gross_salary']);
								$oct_t = $oct_a + $oct_b + $oct_c + $oct_o + $oct_e;
							}

							$oct_Job = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'Job','10',$yearselect);

						 if($rangetype == 'monthyear' ){
							$dataOct = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,$row['status_option'],'10',$yearselect); if(!is_null($dataOct)){ echo $dataOct; } else echo '-';
						}
						else{
							echo '-';
						} ?> </td>
						<td style="width:5%;"><?php

							$employeeSalary = getEmployeeSalary($employeeDetailsData['employee_internal_id'],'11',$yearselect);
							$nov_arrears = 0;
							foreach($employeeSalary as $empSalary){
								$nov_arrears += $empSalary['arrears'];

								// A = basic_salary x ((total days - (absence + unpaid leave)) / total days)
								$nov_a = round( $empSalary['basic_salary']);

								// B = housing_allowance x ((total days - (absence + unpaid leave)) / total days)
								$nov_b = round( $empSalary['housing_allowance']);

								// C = conveyance_allowance x ((total days - (absence + unpaid leave)) / total days)
								$nov_c = round( $empSalary['conveyance_allowance']);

								// D = other_allowance x ((total days - (absence + unpaid leave)) / total days)
								$nov_o = round( $empSalary['other_allowance']);

								// E = project_allowance x ((total days - (absence + unpaid leave)) / total days)
								// $e = round( $employeeDetailsData['project_allowance'] * (($totalDays - ($absence + $unpaidLeave)) / $totalDays));
								$nov_e = round( $empSalary['project_allowance']);

								$nov_totalDeductions = round($empSalary['deductions']);

								// T = A+B+C+D+E + F
								// $nov_t = round($empSalary['gross_salary']);
								$nov_t = $nov_a + $nov_b + $nov_c + $nov_o + $nov_e;
							}

							$nov_Job = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'Job','11',$yearselect);

						 if($rangetype == 'monthyear' ){
							$dataNov = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,$row['status_option'],'11',$yearselect); if(!is_null($dataNov)){ echo $dataNov; } else echo '-';
						}
						else{
							echo '-';
						} ?> </td>
						<td style="width:5%;"><?php

							$employeeSalary = getEmployeeSalary($employeeDetailsData['employee_internal_id'],'12',$yearselect);
							$dec_arrears = 0;
							foreach($employeeSalary as $empSalary){
								$dec_arrears += $empSalary['arrears'];

								// A = basic_salary x ((total days - (absence + unpaid leave)) / total days)
								$dec_a = round( $empSalary['basic_salary']);

								// B = housing_allowance x ((total days - (absence + unpaid leave)) / total days)
								$dec_b = round( $empSalary['housing_allowance']);

								// C = conveyance_allowance x ((total days - (absence + unpaid leave)) / total days)
								$dec_c = round( $empSalary['conveyance_allowance']);

								// D = other_allowance x ((total days - (absence + unpaid leave)) / total days)
								$dec_o = round( $empSalary['other_allowance']);

								// E = project_allowance x ((total days - (absence + unpaid leave)) / total days)
								// $e = round( $employeeDetailsData['project_allowance'] * (($totalDays - ($absence + $unpaidLeave)) / $totalDays));
								$dec_e = round( $empSalary['project_allowance']);

								$dec_totalDeductions = round($empSalary['deductions']);

								// T = A+B+C+D+E + F
								// $dec_t = round($empSalary['gross_salary']);
								$dec_t = $dec_a + $dec_b + $dec_c + $dec_o + $dec_e;
							}

							$dec_Job = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,'Job','12',$yearselect);

						 if($rangetype == 'monthyear' ){
							$dataDec = getAttendanceRecordsForMonthYear($employeeDetailsData['employee_internal_id'],$regionselect,$row['status_option'],'12',$yearselect); if(!is_null($dataDec)){ echo $dataDec; } else echo '-';
						}
						else{
							echo '-';
						} ?> </td>
					</tr>
							<?php $sr++; }  ?>


       

        <tr class="smallcolumns1" >

            <td style="width:3%;text-align:center;"></td>
            <td style="width:12%;"></td>
            <td style="width:6%;"></td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>

        </tr>

        <tr class="smallcolumns3">

            <td style="width:3%;text-align:center;">15</td>
            <td style="width:12%;">Basic Pay</td>
            <td style="width:6%;"><?php echo $total_a;//$employeeDetailsData['basic_salary']; ?></td>
            <td style="width:5%;"> &nbsp;</td>
            <td style="width:5%;"> <?php echo $jan_a?></td>
            <td style="width:5%;"> <?php echo $feb_a?></td>
            <td style="width:5%;"> <?php echo $mar_a?></td>
            <td style="width:5%;"> <?php echo $apr_a?></td>
            <td style="width:5%;"> <?php echo $may_a?></td>
            <td style="width:5%;"> <?php echo $jun_a?></td>
            <td style="width:5%;"> <?php echo $jul_a?></td>
            <td style="width:5%;"> <?php echo $aug_a?></td>
            <td style="width:5%;"> <?php echo $sep_a?></td>
            <td style="width:5%;"> <?php echo $oct_a?></td>
            <td style="width:5%;"> <?php echo $nov_a?></td>
            <td style="width:5%;"> <?php echo $dec_a?></td>

        </tr>

        <tr class="smallcolumns3">

            <td style="width:3%;text-align:center;">16</td>
            <td style="width:12%;">Housing</td>
            <td style="width:6%;"><?php echo $total_b;//$employeeDetailsData['housing_allowance']; ?></td>
            <td style="width:5%;"> &nbsp;</td>
            <td style="width:5%;"> <?php echo $jan_b?></td>
            <td style="width:5%;"> <?php echo $feb_b?></td>
            <td style="width:5%;"> <?php echo $mar_b?></td>
            <td style="width:5%;"> <?php echo $apr_b?></td>
            <td style="width:5%;"> <?php echo $may_b?></td>
            <td style="width:5%;"> <?php echo $jun_b?></td>
            <td style="width:5%;"> <?php echo $jul_b?></td>
            <td style="width:5%;"> <?php echo $aug_b?></td>
            <td style="width:5%;"> <?php echo $sep_b?></td>
            <td style="width:5%;"> <?php echo $oct_b?></td>
            <td style="width:5%;"> <?php echo $nov_b?></td>
            <td style="width:5%;"> <?php echo $dec_b?></td>

        </tr>


        <tr class="smallcolumns3">

            <td style="width:3%;text-align:center;">17</td>
            <td style="width:12%;">Conveyance</td>
            <td style="width:6%;"><?php echo $total_c;//$employeeDetailsData['conveyance_allowance']; ?></td>
            <td style="width:5%;"> &nbsp;</td>
            <td style="width:5%;"> <?php echo $jan_c?></td>
            <td style="width:5%;"> <?php echo $feb_c?></td>
            <td style="width:5%;"> <?php echo $mar_c?></td>
            <td style="width:5%;"> <?php echo $apr_c?></td>
            <td style="width:5%;"> <?php echo $may_c?></td>
            <td style="width:5%;"> <?php echo $jun_c?></td>
            <td style="width:5%;"> <?php echo $jul_c?></td>
            <td style="width:5%;"> <?php echo $aug_c?></td>
            <td style="width:5%;"> <?php echo $sep_c?></td>
            <td style="width:5%;"> <?php echo $oct_c?></td>
            <td style="width:5%;"> <?php echo $nov_c?></td>
            <td style="width:5%;"> <?php echo $dec_c?></td>

        </tr>


        <tr class="smallcolumns3">

            <td style="width:3%;text-align:center;">18</td>
            <td style="width:12%;">Other Allowance</td>
            <td style="width:6%;"><?php echo $jan_o + $feb_o + $mar_o + $apr_o + $may_o + $jun_o + $jul_o + $aug_o + $sep_o + $oct_o + $nov_o + $dec_o ;//$employeeDetailsData['other_allowance']; ?></td>
            <td style="width:5%;"> &nbsp;</td>
            <td style="width:5%;"> <?php echo $jan_o?></td>
            <td style="width:5%;"> <?php echo $feb_o?></td>
            <td style="width:5%;"> <?php echo $mar_o?></td>
            <td style="width:5%;"> <?php echo $apr_o?></td>
            <td style="width:5%;"> <?php echo $may_o?></td>
            <td style="width:5%;"> <?php echo $jun_o?></td>
            <td style="width:5%;"> <?php echo $jul_o?></td>
            <td style="width:5%;"> <?php echo $aug_o?></td>
            <td style="width:5%;"> <?php echo $sep_o?></td>
            <td style="width:5%;"> <?php echo $oct_o?></td>
            <td style="width:5%;"> <?php echo $nov_o?></td>
            <td style="width:5%;"> <?php echo $dec_o?></td>

        </tr>

        <tr class="smallcolumns3">

            <td style="width:3%;text-align:center;">19</td>
            <td style="width:12%";">Food Allowance</td>
            <td style="width:6%;"><?php echo $food_allowance_total =  ($jan_e + $feb_e + $mar_e + $apr_e + $may_e + $jun_e + $jul_e + $aug_e + $sep_e + $oct_e + $nov_e + $dec_e); ?></td>
            <td style="width:5%;"> &nbsp;</td>
            <td style="width:5%;"> <?php echo  $jan_e?></td>
            <td style="width:5%;"> <?php echo  $feb_e?></td>
            <td style="width:5%;"> <?php echo  $mar_e?></td>
            <td style="width:5%;"> <?php echo  $apr_e?></td>
            <td style="width:5%;"> <?php echo  $may_e?></td>
            <td style="width:5%;"> <?php echo  $jun_e?></td>
            <td style="width:5%;"> <?php echo  $jul_e?></td>
            <td style="width:5%;"> <?php echo  $aug_e?></td>
            <td style="width:5%;"> <?php echo  $sep_e?></td>
            <td style="width:5%;"> <?php echo  $oct_e?></td>
            <td style="width:5%;"> <?php echo  $nov_e?></td>
            <td style="width:5%;"> <?php echo  $dec_e?></td>

        </tr>
<!--
		<tr class="smallcolumns3">

			<td style="width:3%;text-align:center;">20</td>
			<td style="width:12%;">Other Deductions</td>
			<td style="width:6%;"><?php echo ($jan_totalDeductions+$feb_totalDeductions+$mar_totalDeductions+$apr_totalDeductions+$may_totalDeductions+$jun_totalDeductions+$jul_totalDeductions+$aug_totalDeductions+$sep_totalDeductions+$oct_totalDeductions+$nov_totalDeductions+$dec_totalDeductions);?></td>
			<td style="width:5%;"> &nbsp;</td>
			<td style="width:5%;"> <?php echo $jan_totalDeductions?></td>
			<td style="width:5%;"> <?php echo $feb_totalDeductions?></td>
			<td style="width:5%;"> <?php echo $mar_totalDeductions?></td>
			<td style="width:5%;"> <?php echo $apr_totalDeductions?></td>
			<td style="width:5%;"> <?php echo $may_totalDeductions?></td>
			<td style="width:5%;"> <?php echo $jun_totalDeductions?></td>
			<td style="width:5%;"> <?php echo $jul_totalDeductions?></td>
			<td style="width:5%;"> <?php echo $aug_totalDeductions?></td>
			<td style="width:5%;"> <?php echo $sep_totalDeductions?></td>
			<td style="width:5%;"> <?php echo $oct_totalDeductions?></td>
			<td style="width:5%;"> <?php echo $nov_totalDeductions?></td>
			<td style="width:5%;"> <?php echo $dec_totalDeductions?></td>

		</tr>
-->
        <tr class="smallcolumns3">

            <td style="width:3%;text-align:center;">&nbsp;</td>
            <td style="font-weight:bold", "width:12%;">Arrear</td>
            <td style="width:6%;"><?php echo $arrears_total;?></td>
            <td style="width:5%;"> <?php echo $jan_arrears?></td>
            <td style="width:5%;"> <?php echo $jan_arrears?></td>
            <td style="width:5%;"> <?php echo $feb_arrears?></td>
            <td style="width:5%;"> <?php echo $mar_arrears?></td>
            <td style="width:5%;"> <?php echo $apr_arrears?></td>
            <td style="width:5%;"> <?php echo $may_arrears?></td>
            <td style="width:5%;"> <?php echo $jun_arrears?></td>
            <td style="width:5%;"> <?php echo $jul_arrears?></td>
            <td style="width:5%;"> <?php echo $aug_arrears?></td>
            <td style="width:5%;"> <?php echo $sep_arrears?></td>
            <td style="width:5%;"> <?php echo $oct_arrears?></td>
            <td style="width:5%;"> <?php echo $nov_arrears?></td>
            <td style="width:5%;"> <?php echo $dec_arrears?></td>

        </tr>

        <tr class="smallcolumns3">

            <td style="width:3%;text-align:center;">21</td>
            <td style="font-weight:bold", "width:12%;">Total Salary</td>
            <td style="width:6%;"><?php echo $jan_t + $feb_t + $mar_t + $apr_t + $may_t + $jun_t + $jul_t + $aug_t + $sep_t + $oct_t + $nov_t + $dec_t;
             //$employeeDetailsData['basic_salary'] + $employeeDetailsData['housing_allowance'] + $employeeDetailsData['conveyance_allowance'] + $employeeDetailsData['other_allowance'] + $food_allowance ?></td>
            <td style="width:5%;"> &nbsp;</td>
            <td style="width:5%;"> <?php echo $jan_t?></td>
            <td style="width:5%;"> <?php echo $feb_t?></td>
            <td style="width:5%;"> <?php echo $mar_t?></td>
            <td style="width:5%;"> <?php echo $apr_t?></td>
            <td style="width:5%;"> <?php echo $may_t?></td>
            <td style="width:5%;"> <?php echo $jun_t?></td>
            <td style="width:5%;"> <?php echo $jul_t?></td>
            <td style="width:5%;"> <?php echo $aug_t?></td>
            <td style="width:5%;"> <?php echo $sep_t?></td>
            <td style="width:5%;"> <?php echo $oct_t?></td>
            <td style="width:5%;"> <?php echo $nov_t?></td>
            <td style="width:5%;"> <?php echo $dec_t?></td>

        </tr>
        
        
        <tr class="smallcolumns3">

			<td style="width:3%;text-align:center;">20</td>
			<td style="font-weight:bold","width:12%;">Net Payable</td>
			<td style="width:6%;"><?php echo ($jan_t + $feb_t + $mar_t + $apr_t + $may_t + $jun_t + $jul_t + $aug_t + $sep_t + $oct_t + $nov_t + $dec_t + $jan_arrears)- ($jan_totalDeductions+ $feb_totalDeductions+ $mar_totalDeductions+ $apr_totalDeductions+ $may_totalDeductions+ $jun_totalDeductions+ $jul_totalDeductions+ $aug_totalDeductions+ $sep_totalDeductions+ $oct_totalDeductions+ $nov_totalDeductions+$dec_totalDeductions);?></td>
			<td style="width:5%;"> &nbsp;</td>
			<td style="width:5%;"> <?php echo $jan_t + $jan_arrears ?></td>
			<td style="width:5%;"> <?php echo $feb_t + $feb_arrears ?></td>
			<td style="width:5%;"> <?php echo $mar_t + $mar_arrears ?></td>
			<td style="width:5%;"> <?php echo $apr_t + $apr_arrears ?></td>
			<td style="width:5%;"> <?php echo $may_t + $may_arrears ?></td>
			<td style="width:5%;"> <?php echo $jun_t + $jun_arrears ?></td>
			<td style="width:5%;"> <?php echo $jul_t + $jul_arrears ?></td>
			<td style="width:5%;"> <?php echo $aug_t + $aug_arrears ?></td>
			<td style="width:5%;"> <?php echo $sep_t + $sep_arrears ?></td>
			<td style="width:5%;"> <?php echo $oct_t + $oct_arrears ?></td>
			<td style="width:5%;"> <?php echo $nov_t + $nov_arrears ?></td>
			<td style="width:5%;"> <?php echo $dec_t + $dec_arrears ?></td>

		</tr>

        <tr class="smallcolumns3">

			<td style="width:3%;text-align:center;">20</td>
			<td style="font-weight:bold","width:12%;">Net Payments</td>
			<td style="width:6%;"><?php echo ($jan_totalDeductions+$feb_totalDeductions+$mar_totalDeductions+$apr_totalDeductions+$may_totalDeductions+$jun_totalDeductions+$jul_totalDeductions+$aug_totalDeductions+$sep_totalDeductions+$oct_totalDeductions+$nov_totalDeductions+$dec_totalDeductions);?></td>
			<td style="width:5%;"> &nbsp;</td>
			<td style="width:5%;"> <?php echo $jan_totalDeductions?></td>
			<td style="width:5%;"> <?php echo $feb_totalDeductions?></td>
			<td style="width:5%;"> <?php echo $mar_totalDeductions?></td>
			<td style="width:5%;"> <?php echo $apr_totalDeductions?></td>
			<td style="width:5%;"> <?php echo $may_totalDeductions?></td>
			<td style="width:5%;"> <?php echo $jun_totalDeductions?></td>
			<td style="width:5%;"> <?php echo $jul_totalDeductions?></td>
			<td style="width:5%;"> <?php echo $aug_totalDeductions?></td>
			<td style="width:5%;"> <?php echo $sep_totalDeductions?></td>
			<td style="width:5%;"> <?php echo $oct_totalDeductions?></td>
			<td style="width:5%;"> <?php echo $nov_totalDeductions?></td>
			<td style="width:5%;"> <?php echo $dec_totalDeductions?></td>

		</tr>
		
		

        <tr class="smallcolumns1" >

            <td style="width:3%;text-align:center;"></td>
            <td style="width:12%;"></td>
            <td style="width:6%;"></td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>
            <td style="width:5%;"> </td>

        </tr>

		<?php for($yr = 1;$yr<=12;$yr++){ 

			if(strlen($yr) == 1){
				$monthNew = '0'.$yr;
			}
			else{
				$monthNew = $yr;
			}


			$date1 = $yearselect.'-'.$monthNew.'-01';
			$date2 = $yearselect.'-'.$monthNew.'-'.date("t",strtotime($date1));
			// print_r($date2);
			// exit();

			$employeePayments = getEmployeePaymentDetails($employeeSelect,$regionselect,$date1,$date2);

			?>
        <?php if(!empty($employeePayments)){ $sr = 1; $totalPayment = 0; foreach($employeePayments as $payments) { $totalPayment = $totalPayment + $payments['amount']; echo $payments['amount']; ?>
        	
        	
        	<tr class="smallcolumns3">


        		<td style="width:3%;text-align:center;"><?php //echo $sr; ?></td>
        		<td style="width:12%;">Payment - <?php echo $sr;?></td>
        		<td style="width:6%;"><?php  ?></td>
        		<td style="width:5%;"> &nbsp;</td>
        		<td style="width:5%;"> <?php if($yr == 1){ echo $payments['amount']; }?></td>
        		<td style="width:5%;"> <?php if($yr == 2){ echo $payments['amount']; }?></td>
        		<td style="width:5%;"> <?php if($yr == 3){ echo $payments['amount']; }?></td>
        		<td style="width:5%;"> <?php if($yr == 4){ echo $payments['amount']; }?></td>
        		<td style="width:5%;"> <?php if($yr == 5){ echo $payments['amount']; }?></td>
        		<td style="width:5%;"> <?php if($yr == 6){ echo $payments['amount']; }?></td>
        		<td style="width:5%;"> <?php if($yr == 7){ echo $payments['amount']; }?></td>
        		<td style="width:5%;"> <?php if($yr == 8){ echo $payments['amount']; }?></td>
        		<td style="width:5%;"> <?php if($yr == 9){ echo $payments['amount']; }?></td>
        		<td style="width:5%;"> <?php if($yr == 10){ echo $payments['amount']; }?></td>
        		<td style="width:5%;"> <?php if($yr == 11){ echo $payments['amount']; }?></td>
        		<td style="width:5%;"> <?php if($yr == 12){ echo $payments['amount']; }?></td>
        	</tr>
        	
        	<tr class="smallcolumns3">


        		<td style="width:3%;text-align:center;"><?php //echo $sr; ?></td>
        		<td style="width:12%;">Payment Date - <?php echo $sr;?></td>
        		<td style="width:6%;"><?php //echo $payments['date']; ?></td>
        		<td style="width:5%;"> &nbsp;</td>
        		<td style="width:5%;"> <?php if($yr == 1){ echo $payments['date']; }?></td>
        		<td style="width:5%;"> <?php if($yr == 2){ echo $payments['date']; }?></td>
        		<td style="width:5%;"> <?php if($yr == 3){ echo $payments['date']; }?></td>
        		<td style="width:5%;"> <?php if($yr == 4){ echo $payments['date']; }?></td>
        		<td style="width:5%;"> <?php if($yr == 5){ echo $payments['date']; }?></td>
        		<td style="width:5%;"> <?php if($yr == 6){ echo $payments['date']; }?></td>
        		<td style="width:5%;"> <?php if($yr == 7){ echo $payments['date']; }?></td>
        		<td style="width:5%;"> <?php if($yr == 8){ echo $payments['date']; }?></td>
        		<td style="width:5%;"> <?php if($yr == 9){ echo $payments['date']; }?></td>
        		<td style="width:5%;"> <?php if($yr == 10){ echo $payments['date']; }?></td>
        		<td style="width:5%;"> <?php if($yr == 11){ echo $payments['date']; }?></td>
        		<td style="width:5%;"> <?php if($yr == 12){ echo $payments['date']; }?></td>
        	</tr>

        <?php $sr++; } ?>
<!--
			<tr class="smallcolumns3">
	        	<td style="width:3%;text-align:center;"></td>
	        	<td style="width:12%;">Payment Made</td>
	        	<td style="width:6%;"><?php //echo $totalPayment; ?></td>
	        	<td style="width:5%;"> &nbsp;</td>
	        	<td style="width:5%;"> <?php if($yr == 1){ echo $totalPayment; }?></td>
	        	<td style="width:5%;"> <?php if($yr == 2){ echo $totalPayment; }?></td>
	        	<td style="width:5%;"> <?php if($yr == 3){ echo $totalPayment; }?></td>
	        	<td style="width:5%;"> <?php if($yr == 4){ echo $totalPayment; }?></td>
	        	<td style="width:5%;"> <?php if($yr == 5){ echo $totalPayment; }?></td>
	        	<td style="width:5%;"> <?php if($yr == 6){ echo $totalPayment; }?></td>
	        	<td style="width:5%;"> <?php if($yr == 7){ echo $totalPayment; }?></td>
	        	<td style="width:5%;"> <?php if($yr == 8){ echo $totalPayment; }?></td>
	        	<td style="width:5%;"> <?php if($yr == 9){ echo $totalPayment; }?></td>
	        	<td style="width:5%;"> <?php if($yr == 10){ echo $totalPayment; }?></td>
	        	<td style="width:5%;"> <?php if($yr == 11){ echo $totalPayment; }?></td>
	        	<td style="width:5%;"> <?php if($yr == 12){ echo $totalPayment; }?></td>    
        	</tr>
 -->          	
        	

          <?php } else { ?>
        	<!-- <tr>
        		<td colspan="3">NO Data Found!</td>
        	</tr> -->
        <?php } ?>      
		<?php } ?> 
        <tr>

            <td colspan="2">Sick Leave :<br><?php if($SickLeave_total) echo $SickLeave_total; else echo 0; ?></td>
            <td colspan="3">CasualLeave :<br><?php if($CasualLeave_total) echo $CasualLeave_total; else echo 0; ?></td>
            <td colspan="3">Annual leave :<br><?php if($AnnualDay_total) echo $AnnualDay_total; else echo 0; ?> </td>
            <td colspan="3">Unpaid Leave :<br><?php if($unpaidLeave_total) echo $unpaidLeave_total; else echo 0; ?></td>
            <td colspan="2">Absence :<br><?php if($absence_total) echo $absence_total; else echo 0; ?> </td>
            <td colspan="1">Salary due:<br><?php echo $jan_t + $feb_t + $mar_t + $apr_t + $may_t + $jun_t + $jul_t + $aug_t + $sep_t + $oct_t + $nov_t + $dec_t;?></td>
            <td colspan="1">Salary paid:<br><?php echo ($jan_totalDeductions+$feb_totalDeductions+$mar_totalDeductions+$apr_totalDeductions+$may_totalDeductions+$jun_totalDeductions+$jul_totalDeductions+$aug_totalDeductions+$sep_totalDeductions+$oct_totalDeductions+$nov_totalDeductions+$dec_totalDeductions);?></td>
         
           
         
            <td colspan="1">Payments due <br> <?php echo ($jan_arrears + $jan_t + $feb_t + $mar_t + $apr_t + $may_t + $jun_t + $jul_t + $aug_t + $sep_t + $oct_t + $nov_t + $dec_t)-($jan_totalDeductions+$feb_totalDeductions+$mar_totalDeductions+$apr_totalDeductions+$may_totalDeductions+$jun_totalDeductions+$jul_totalDeductions+$aug_totalDeductions+$sep_totalDeductions+$oct_totalDeductions+$nov_totalDeductions+$dec_totalDeductions); ?></td>
          

            </tr>

        <tr>

            <td colspan="2">Office :<br><?php if($Office_total) echo $Office_total; else echo 0; ?></td>   
            <td colspan="3">On Job :<br><?php if($Job_total) echo $Job_total; else echo 0; ?></td>
            <td colspan="3">Idle :<br><?php if($Idle_total) echo $Idle_total; else echo 0; ?> </td>
            <td colspan="3">Week Off Day :<br><?php if($WeekOffDay_total) echo $WeekOffDay_total; else echo 0; ?></td>
            <td colspan="2">National Holiday :<br><?php if($NationalHoliday_total) echo $NationalHoliday_total; else echo 0; ?></td>
            <td colspan="3">Verified by Immediate Supervisor</td>

        </tr>


    </table>
</div>
	<?php } exit();//dont remove this exit ?>

<?php } else if( $reporttypeselect == 'Maintenance Timesheet'){ 

		$getRegionStatus = get_Status_Options_For_location($regionselect);

		$monthDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

		$monthName = date('M',strtotime($date1));

		// print_r($_POST);

	?>

	<style>

	    body{
	        padding:30px;
	        font-size:12px;
	    }

	    .labeldiv{
	        text-align: right;
	        color: #000;
	        font-size: 20px;
	        padding-bottom:7px;
	    }

	    p{
	        text-align: center;
	    }

	    .outertable td{
	        text-align:center;
	        padding: 3px !important;
	        margin: 3px !important;
	        vertical-align: middle !important;
	    }

	    .verticaltext{
	        transform: rotate(270deg);
	        /* height: 100px; */
	        white-space:nowrap;
	        
	        /* overflow: hidden; */
	        /* display: inline-block; */
	        /* float: left; */
	    }

	    .verticaltext2{
	        transform: rotate(270deg);
	        /* height: 50px; */
	        white-space:nowrap;
	        /* float: left; */
	    }

	    td.rotate {
	        /* Something you can count on */
	        height: 100px;
	        white-space: nowrap;
	    }

	    td.rotate > div {
	        transform: 
	        /* Magic Numbers */
	        translate(0px, 40px)
	        /* 45 is really 360 - 45 */
	        rotate(270deg);
	        width: 20px;
	    }
	    td.rotate > div > span {
	        /* border-bottom: 1px solid #ccc; */
	        padding: 5px 10px;
	    }

	    td.rotate2 {
	        /* Something you can count on */
	        height: 50px;
	        white-space: nowrap;
	    }

	    td.rotate2 > div {
	        transform: 
	        /* Magic Numbers */
	        translate(0px, 7px)
	        /* 45 is really 360 - 45 */
	        rotate(270deg);
	        width: 20px;
	    }
	    td.rotate2 > div > span {
	        /* border-bottom: 1px solid #ccc; */
	        padding: 5px 10px;
	    }

	    .npmlogo{
		    padding: 10px;
            margin-right: 1310px;
		}

		</style>
        <title>All Maintenance</title>
		<body>
        
		<div class="labeldiv">
		    <img src="hollow-NPM.png" class="npmlogo" alt="Logo main" style="width:160px; align:center">   
		    <b>MAINTENANCE TIME SHEET</b>

		</div>




	<div class="table-responsive">

	    <table class="table table-bordered table-striped outertable" >
	        <tbody>
	            <tr>
	                <td><?php echo $employeeDetailsData['employee_NAME']; ?> <br> <?php echo $employeeDetailsData['employee_job_title']; ?></td>
	                <td style="width: 4%;"><?php echo $employeeDetailsData['employee_internal_id']; ?></td>
	                <td><?php echo $employeeDetailsData['employee_cnic']; ?></td>
	                <td><?php echo $employeeDetailsData['name_location']; ?></td>
	                <td>
	                
	                    
	                    <table border=1 style="width:100%">

	                        <tbody>
	                            <tr>
	                                <td>Total Days: <?php echo $monthDays;?></td>
	                                <td>Idle Days: <?php if($Idle) echo $Idle; else echo 0; ?></td>
	                            </tr>

	                            <tr>
	                                <td>Working Days: <?php echo $workDays;  ?></td>
	                                <td>Absence: <?php if($absence) echo $absence; else echo 0; ?></td>
	                            </tr>
	                        </tbody>
	                    </table>
	                    
	                
	                </td>

	                <td>Month <?php echo $monthName.' '.$year; ?> </td>

	            </tr>
	        
	            <tr>
	                <td colspan="6">-</td>
	            </tr>

	</tbody>

	</table>

	<table class="table table-bordered table-striped outertable" >

	<tbody>

	            <!-- START FIRST ROW -->

	            <tr>

	                <td style="width: 20%"><b>Ln</b></td>
	                <td style="width: 70%"><b>Date</b></td>
	                <td style="width: 10%"></td>


		                

	                <td colspan="4">
	                    <table border=1 style="width:100%">
	                    <tr>
	                    <?php for($i=0; $i<$monthDays ; $i++){ ?>
	                <td>
	                <table border=1 style="width:100%">
	                        <tr>
	                            <td class="rotate" ><div><span><b><?php echo ($i+1)."-".$monthName; ?> </b></span></div></td>
	                        </tr>

	                        <tr>
	                            <td class="rotate2" ><div><span><b><?php echo substr(date("l", strtotime(($i+1)."-".$monthName.'-'.$year)),0,3); ?></b></span></div></td>
	                        </tr>
	                        
	                </table>
	                </td>
	                    <?php } ?>
	                    </tr>
	                    </table>
	                </td>

	                <td>
	                    <b>Total Hrs</b>
	                </td>

	            </tr>

	            <!-- END FIRST ROW -->

	            <!-- START SECOND ROW -->

	            <tr>


	                <td style="width: 20%"><b></b></td>
	                <td style="width: 70%"><b>Deputed at</b></td>
	                <td style="width: 20%"></td>


		               	

		                <td colspan="4">
		                    <table border=1 style="width:100%">
		                    <tr>
		                    <?php $location_summary = array(); for($i=0; $i<$monthDays ; $i++){

		                    	$getSiteLocation = getSiteLocation($employeeSelect,$regionselect,date("Y-m-d", strtotime(($i+1)."-".$monthName.'-'.$year)));

		                    	if(isset($getSiteLocation[0]['site_location'])){
		                    		if(!array_key_exists(trim($getSiteLocation[0]['site_location']), $location_summary) ){
		                    			$location_summary[trim($getSiteLocation[0]['site_location'])] = 1;
		                    		}
		                    		else{
		                    			$location_summary[trim($getSiteLocation[0]['site_location'])] += 1;
		                    		}
		                    	}

		                    	

		                    	// print_r($getSiteLocation[0]);
		                    	// exit();

		                     ?>
		                <td>
	                <table style="width:100%">
	                        <tr>
	                            <td class="rotate" ><div><span><?php if(isset($getSiteLocation[0]['site_location'])){ echo $getSiteLocation[0]['site_location']; } else echo '-' ; ?></span></div></td>
	                        </tr>

	                        
	                </table>
	                </td>
	                    <?php } ?>
	                    </tr>
	                    </table>
	                		</td>
	                			<td>
	                		     
	                		 </td>

	            </tr>


	            <!-- END SECOND ROW -->


	            <!-- START THIRD ROW -->

	            <?php $srNo=1; $totalHoursAll = 0; while($row = mysqli_fetch_assoc($getRegionStatus)) { $totalHours = 0; //print_r($row); ?>
	                	  <tr>
	                	  	<th><?php echo $srNo;?></th>
	                	    <th><?php echo $row['status_option']; ?></th>
	                	    <th></th>
	                	   	
	                		  <td colspan="4">
	                    <table border=1 style="width:100%">
	                    <tr>
	                    <?php for($i=0; $i<$monthDays ; $i++){

	                    	$getAttendance = getSiteLocation($employeeSelect,$regionselect,date("Y-m-d", strtotime(($i+1)."-".$monthName.'-'.$year)));

	                    	// $checkRemarks = checkRemarks($getAttendance[0]['remarks'],$employeeSelect,$regionselect);

	                    	$hours = 0;
	                    	
	                    	$display = false;

	                    	if(isset($getAttendance[0])){
	                    		$timeIn = strtotime( $getAttendance[0]['attendance_for_date'].' '.$getAttendance[0]['time_in'].':00');
	                    		$timeOut = strtotime( $getAttendance[0]['attendance_for_date'].' '.$getAttendance[0]['time_out'].':00');

	                    		$diff = $timeOut - $timeIn;
	                    		$hours = $diff / ( 60 * 60 );
	                    		$display = true;                    		

	                    	}

	                    	


	                    	// exit();

	                     ?>
	                    <td >
	                    <table style="width:100%">
	                    <tr>
	                    <td ><div><span><?php if(isset($getAttendance[0])){  if($row['status_option'] == $getAttendance[0]['status_option'] && $display) {  echo $getAttendance[0]['hours_worked']; $totalHours += $getAttendance[0]['hours_worked']; } else echo "<span class='print_white' style='color:white;'>^</span>";  } else echo "<span class='print_white' style='color:white;'>^</span>";  ?></span></div></td>
	                    </tr>
							


	                    </table>
	                    </td>
	                    <?php } ?>
	                    </tr>


	                    </table>
	                    </td>
	                		  <th><?php $totalHoursAll += $totalHours; echo $totalHours; ?></th>
	                		</tr>
	                				<?php  $srNo++; } ?>

	               	<!-- total row -->
							  <tr>
							  	<th></th>
							    <th><b>Total</b></th>
							    <th></th>
							   	
								<td colspan="4">
						    <table border=1 style="width:100%">
						    <tr>
						    <?php for($k=0; $k<$monthDays ; $k++){

						    	$getAttendance = getSiteLocation($employeeSelect,$regionselect,date("Y-m-d", strtotime(($k+1)."-".$monthName.'-'.$year)));

						    	// $checkRemarks = checkRemarks($getAttendance[0]['remarks'],$employeeSelect,$regionselect);

						    	$hours = 0;
						    	
						    	$display = false;

						    	if(isset($getAttendance[0])){
						    		$timeIn = strtotime( $getAttendance[0]['attendance_for_date'].' '.$getAttendance[0]['time_in'].':00');
						    		$timeOut = strtotime( $getAttendance[0]['attendance_for_date'].' '.$getAttendance[0]['time_out'].':00');

						    		$diff = $timeOut - $timeIn;
						    		$hours = $diff / ( 60 * 60 );
						    		$display = true;                    		

						    	}

						    	


						    	// exit();

						     ?>
						    <td>
						    <table style="width:100%">
						    <tr>
						    <td class="" ><div><span><?php if(isset($getAttendance[0])){  if($row['status_option'] == $getAttendance[0]['status_option'] && $display) {  echo $getAttendance[0]['hours_worked']; $totalHours += $getAttendance[0]['hours_worked']; }  }  ?></span></div></td>
						    </tr>
						


						    </table>
						    </td>
						    <?php } ?>
						    </tr>


						    </table>
						    </td>
								  <th><?php echo $totalHoursAll ?></th>
								</tr>
	            </tbody>
	    </table>

	    <table class="table table-bordered table-striped outertable" >

	        <tr>

	            <td>
	            
	            <table class="table table-bordered table-striped outertable" >

	                <?php if(isset($location_summary)) { foreach ($location_summary as $key => $value) { ?>
						
						<tr>
							<td><?php echo  $value.' '.$key; ?></td>
						</tr>

	                <?php } } ?>

	            </table>

	            </td>

	            <td>

	                <table class="table table-bordered table-striped outertable" >

	                    <tr><td><br><?php if($CasualLeave) echo $CasualLeave; else echo 0; ?><br>Casual Leaves<br>&nbsp;</td></tr>
	                    <tr><td><br>Verified by Immediate Superior<br>&nbsp;</td></tr>

	                </table>

	            </td>

	            <td>

	                <table class="table table-bordered table-striped outertable" >

	                    <tr><td><br><?php if($unpaidLeave) echo $unpaidLeave; else echo 0; ?><br>Unpaid Leave Days<br>&nbsp;</td></tr>
	                    <tr><td><br><?php if($absence) echo $absence; else echo 0; ?><br>Absence<br>&nbsp;</td></tr>

	                </table>

	            </td>


	            </td>

	            <td>

	                <table class="table table-bordered table-striped outertable" >

	                    <tr><td><br>&nbsp;<br>&nbsp;Paid Leave Days<br>&nbsp;</td><td><br>&nbsp;<?php if($AnnualLeave) echo $AnnualLeave; else echo 0; ?><br>&nbsp;</td></tr>
	                    <tr><td><br>&nbsp;<br>&nbsp;Sick Leaves<br>&nbsp;</td><td><br>&nbsp;<?php if($SickLeave) echo $SickLeave; else echo 0; ?><br>&nbsp;</td></tr>

	                </table>

	            </td>

	            </td>

	            <td>

	                <table class="table table-bordered table-striped outertable" >

	                <tr><td><br>&nbsp;<br>&nbsp;<br>&nbsp;</td></tr>
	                <tr><td>
	                    <table class="table table-bordered table-striped outertable" >

	                    <tr><td>
	                        <br>Approval by Finance
	                    </td>
	                    <td><b>Important:</b><br> All timesheets must be submitted<br> no later 
	                    than 6th of every <br>month both hard copy and soft copies.</td>
	                    </tr>

	                    </table>

	                </td></tr>

	                </table>

	            </td>


	        </tr>

	    </table>


	</div>

<?php } ?> <p style="page-break-after: always;"></p>

<?php } } ?>



</body>
</html>
<?php } ?>