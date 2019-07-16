<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<style>

 </style>
<body>

  <div class="container-scroller">

<?php 
include("includes/header.php"); 
$locations = getAllLocations();
$payrollData = GetAllPayRollData();
$message = $_GET['status'];

if (strtolower($_SESSION["role"])!="super admin" && strtolower($_SESSION["role"])!="admin" && strtolower($_SESSION["role"])!="entry maker"){
  header("Location: index.php");
}

$id = $_SESSION["id"];

if(isset($_POST['addentry'])) {
   

    if(isset($_POST["employee_id"])){
        
        $employee_id = $_POST["employee_id"];
        $status_option = $_POST["status_option"];
        $site_location = $_POST["site_location"];
        $remarks_option = $_POST["remarks_option"];
        $time_in = $_POST["time_in"];
        $time_out = $_POST["time_out"];
        $hours_worked = $_POST["hours_worked"];
        $comments = $_POST["comments"];
        $date = $_POST["date"];
   
//         $hours_worked = escape_it($_POST["employee_id"]);
        $size = sizeof($_POST["employee_id"]);
       for($i = 0; $i < $size; $i++){
   
        $employee_id = $_POST["employee_id"][$i];
        $status_option = $_POST["status_option"][$i];
        $site_location = $_POST["site_location"][$i];
        $remarks_option = $_POST["remarks_option"][$i];
        $time_in = $_POST["time_in"][$i];
        $time_out = $_POST["time_out"][$i];
        $hours_worked = $_POST["hours_worked"][$i];
        $comment = $_POST["comments"][$i];
        $date = $_POST["date"][$i];       
           
        $employee_id = escape_it($employee_id);
        $status_option = escape_it($status_option);
        $site_location = escape_it($site_location);
        $remarks_option = escape_it($remarks_option);
        $time_in = escape_it($time_in);
        $time_out = escape_it($time_out);
        $hours_worked = escape_it($hours_worked);
        $comment = escape_it($comment);
        $date = escape_it($date);
           
        $date = strtotime($date);
        $date = date('Y/m/d',$date);
           
       $time_in = explode(":", $time_in);
       $time_out = explode(":", $time_out);
           
       $the_time_in ="";
       $the_time_out ="";
           
           
       if((isset($time_in[0])) && (isset($time_in[1]))){
           
           
           $the_time_in = $time_in[0].":".$time_in[1];
           
           
       }elseif(isset($time_in[0])){
           
           $the_time_in = $time_in[0].":"."00";
           
       }
       else{
           
           $the_time_in = "00:00";
       }
           
           
       if((isset($time_out[0])) && (isset($time_out[1]))){
           
            $the_time_out = $time_out[0].":".$time_out[1];
           
           
       }elseif(isset($time_out[0])){
           
           $the_time_out = $time_out[0].":"."00";
           
       }else{
           
            $the_time_out = "00:00";
       }
           
       $time_in = $time_in[0];    
       $time_out = $time_out[0];    
           
           if(!is_numeric($time_in)){
               
               $time_in = "9";
               
           }
           if(!is_numeric($time_out)){
               
               $time_out = "17";
           }
           
           
           
           if(empty($time_in)){
               
               $time_in = 0;
               
           }
           
           if(empty($time_out)){
               
               $time_out = 0;
               
           }
           
           if($time_in == 0 || $time_out == 0){
               
               $hours_worked = 0;
           }
           else{
               
               $hours_worked = ceil(strval($time_out) - strval($time_in));    
           }
           
           if($hours_worked < 0){
               
               $hours_worked = 0;
           }
   
       if(!check_Entry_ON_Date($employee_id, $date)){
    if(makeentry($employee_id, $status_option, $site_location, $the_time_in, $the_time_out, $hours_worked, $date, $remarks_option, $comment , $id)){
        
        $error = false;

       }
       else{
               $error = true;
               
           }
           
           
       }
        
    }
    
    

//         
//     }
   
}
if($error){
   
   $messageTemp = "Some Error Occoured";
   header("Location: addattendanceentry.php?status=$messageTemp");
}
else{
   
   $messageTemp = "Successfully Entered!";
   header("Location: addattendanceentry.php?status=$messageTemp");
   
}
    
}


?>

<?php
if(isset($_POST['import'])) {
   
     $file        = $_FILES['filetoimport']['name'];
    $temp_file   = $_FILES['filetoimport']['tmp_name'];
     
   $target_dir = "files/";
   $target_file = $target_dir . basename($_FILES["filetoimport"]["name"]);
    
   $FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
   
    if(empty($file)){
        
         $messageTemp = "**Select A file first**";
         header("Location: addattendanceentry.php?status=$messageTemp");
    }
    elseif(($FileType != "csv")) {
        
          $messageTemp = "**File not supported**";
          header("Location: addattendanceentry.php?status=$messageTemp");
    }elseif($_FILES["filetoimport"]["size"] > 2000000) {
        
          $messageTemp = "**File Size is too large**";
          header("Location: addattendanceentry.php?status=$messageTemp");
        
    }
else{
         ?>

<script type="text/javascript">
    

//    $("#loading").show();

// $("#loading").ajaxStop(function () {
//   $(this).hide();
// });
    
    
    
</script>

<?php
        
        if(movefile($temp_file, $target_file)){
            
                
              if(import_Attendance_Date($target_file, $FileType, $id)){
                  
                   unlink($target_file);
                  $messageTemp = "**Successfylly Imported**";
//                  header("Location: addattendanceentry.php?status=$messageTemp");
              
              }
            else{
                
            unlink($target_file);
            $messageTemp = "**Could not import, try again**";
//            header("Location: addattendanceentry.php?status=$messageTemp");
            }            
    
        }else{
            
             $messageTemp = "**Could not import, try again**";
            header("Location: addattendanceentry.php?status=$messageTemp");
            
        }
    }

    //else ends here
}
//isset post ends here
?>


    <div class="container-fluid page-body-wrapper">

    <?php 
    include("includes/sidebar.php");
    
    if (strtolower($_SESSION["role"])!="super admin" && strtolower($_SESSION["role"])!="admin" && strtolower($_SESSION["role"])!="entry maker"){
      echo "<div class='col-md-8 grid-margin stretch-card' style='padding:75px;'><h3>Unauthorized Access!</h3></div>";exit;
      }
    
    ?>

      <div class="main-panel">
        <div class="content-wrapper">


        <div class="row">
        
        <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h3>Add Attendance Entry</h3>
                  <p class="card-description">
                    Add Manual Attendance Entries
                  </p>


                <div class="card" style="background: #fcfcfc; padding: 15px;" id = "singleform">


                <form action="" method="get" class="form form-vertical">
                    
                    <div class="form-group">
                    <label>Select location</label>
                        <select name="location" id="locationselect" class="form-control">
                        <option value="">Select</option> 
                                <?php

                          if (strtolower($_SESSION["role"])=="super admin"){

                            $result = getlocations();

                            while($row = mysqli_fetch_assoc($result)) {

                                $location_name = $row["location_name"];
                                echo "<option value='{$location_name}'>{$location_name}</option>";

                            }

                          }else if (strtolower($_SESSION["role"])=="admin" || strtolower($_SESSION["role"])=="entry maker"){

                            echo "<option value='".$_SESSION["location"]."'>".$_SESSION["location"]."</option>";

                          }

                                ?>
                        </select>    
                     </div>     
                        
                        <div class="form-group">
                        
                            <label>Enter Date</label>
                            <input type="text" placeholder="dd/mm/yyyy" class="form-control" name="date">
                            
                        </div>
                        <!-- <div class="form-group">
                        
                            <label>Enter Employee Id</label>
                            <input type="text" placeholder="dd/mm/yyyy" class="form-control" name="date">
                            
                        </div> -->
                        
                        <div class="form-group">
                        
                            <input type="submit" class="btn btn-primary" value="Enter" name="dateform">

                            
                      
                      <button type="button" class="btn btn-primary" data-toggle="modal" style="float: right" data-target="#myModal">
                         Add Single Record
                    </button>
                            
                        </div>
                          

                        
                        
                    </form>
 
                </div>


              </div>
            </div>
        
        </div>
        <!-- Modal -->
        <div class="modal" tabindex="-1" role="dialog" id ="myModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Attandance</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      <form method="post" action="addattandance.php">

        <fieldset>


        <div class="form-group">
        <label for="locationselect1">Select Region:</label>

        <select class="form-control" id="locationselect1" name="locationselect1">
          <option> Select </option>
        <?php foreach($locations as $row){ ?>

        <option value="<?php echo $row['location_name'] ?>"><?php echo $row['location_name'] ?></option>

        <?php } ?>

        </select>
        </div>
        

        <div class="form-group">
        <label for="employeeSelect">Select Employee&nbsp;&nbsp;</label>

          <select class="form-control" id="employeeSelect" name="employeeSelect">

          </select>
        </select>
        </div>

        <div class="form-group">
        <label >Date</label>
        <input type="date" class="form-control" name="date" id="date" placeholder="dd/mm/yyyy" required>
        </div>

        <div class="form-inline">
        <label >Select location</label>
        <div class="form-group">
               <select name="status_option" id="status_option" onchange="myFunction(0);" class="form-control">
               <option value=""></option>
               <?php
             
             $status_result = get_Status_Options_For_location($location);
             
             while($row = mysqli_fetch_assoc($status_result )) {
             echo "<option value='$status_id' optionid='$status_id'>{$status_option}</option>"; 
           
                 }?>
                 
           </select>
              </div>
        <br>
        </div>
        <div class="form-inline">
        <label >Select status</label>
        <div class="form-group">
               <select name="site_location" id="site_location" class="form-control"
                 onchange="myFunction('site_location')">
                 
                   <option value="<?php echo $the_site_location; ?>" ></option>;
                 
               </select>
              </div>
        <br>
        </div>
        <div class="form-inline">
        <label >Select code</label>
        <div class="form-group">
               <select name="remarks_option" id="remarks_option" class="form-control"
                 onchange="myFunction('site_location')">
                 
                   <option value="<?php echo $the_site_location; ?>" ></option>;
                 
               </select>
              </div>
        <br>
        </div>

        <div class="form-group">
         <label >Time In</label>
          
                <input type="text" class="form-control" name="time_in" id="time_in" placeholder="Time In" required>
        </div>

        <div class="form-group">
        <label >Time Out</label>
        <input type="text" class="form-control" name="time_out" id="time_out" placeholder="Time Out" required>
        </div>

        <div class="form-group">
        <label >Hours</label>
        <input type="text" class="form-control" name="hours_worked" id="hours_worked" placeholder="Hours Worked" required>
        </div>
        
        <script type="text/javascript">
                            
                           
                            $('#time_in').on('focus', function(){
                              
                              
                          }).on('blur', function() {
                    
                          var time_out = $('#time_out').val();  
        //                  var time_out_str = time_out.split(":");  
                              
                          var time_in = $('#time_in').val();
        //                  var time_in_str = time_in.split(":");
                              
                              
                        var startDate = new Date("1/1/1900 " + time_in);
                        var endDate = new Date("1/1/1900 " + time_out);      
                        
                        var start_time = startDate.getTime();      
                        var end_time = endDate.getTime();      
                              
                        var diff =  end_time - start_time ;
                              
                        var hours = Math.floor(diff / 1000 / 60 / 60);
                                    
                     var hours_worked = $('#hours_worked').val(hours);    
                              
                              
                          });
                            
                            
                        
                          $('#time_out').on('focus', function(){
                              
                              
                          }).on('blur', function() {
                    
                          var time_out = $('#time_out').val();  
        //                  var time_out_str = time_out.split(":");  
                              
                          var time_in = $('#time_in').val();
        //                  var time_in_str = time_in.split(":");
                              
                              
                        var startDate = new Date("1/1/1900 " + time_in);
                        var endDate = new Date("1/1/1900 " + time_out);      
                        
                        var start_time = startDate.getTime();      
                        var end_time = endDate.getTime();      
                              
                        var diff =  end_time - start_time ;
                              
                        var hours = Math.floor(diff / 1000 / 60 / 60);
                                    
                     var hours_worked = $('#hours_worked').val(hours);    
                              
                              
                          });
                        
                        </script>
       
        
        <button type="submit" class="btn btn-primary" name="insertbtn">Submit</button>
        </fieldset>
        </form>

      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

        <div class="col-md-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h3>Upload Attendance Entry</h3>
                  <p class="card-description">
                    Upload attendance entries file
                  </p>


                <div class="card" style="background: #fcfcfc; padding: 15px;" id = "singleform">

                <form action="addattendanceentry.php" method="post" class="form form-vertical" enctype="multipart/form-data">
                
                <div class="form-group">
                
                    <label title="only CSV files">Import Data</label>
                    <input type="file" placeholder=".csv or .xls/.xlsx" class="form-control" title="only, CSV files" name="filetoimport" >
                    
                </div>
                
<!--
                <div id="loading" style="display:none;">
            Loading Please Wait....
                    </div>
-->
                <div class="form-group">
                
                    <input type="submit" class="btn btn-primary" value="Import" name="import" title="only CSV files">
                    
                </div>
            
            </form>

                </div>

                </div>
            </div>
        </div>

        
        </div>
        

<!-- Modal -->
             
             <div id="myModal" class="modal fade" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    
                    <h4 class="modal-title">Confirm Delete</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    
                  </div>
                  <div class="modal-body">
                    <h5 class="text-center">Are You Sure To remove this location, All employees on this location would be unchained?</h5>
                  </div>
                  <div class="modal-footer">
                    <a href="" class="btn btn-danger modal_delete_link">Remove</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  </div>
                </div>

              </div>
            </div>
        <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h3>View and Modify Entries</h3>
              


                <div class="card" style="background: #fcfcfc; padding: 5px;" id = "singleform">

                             
                    <?php 
        
        if((isset($_GET["date"])) && (isset($_GET["location"]))){
                    
                    
                    $location_name = escape_it($_GET["location"]);
                   $date = escape_it($_GET["date"]);
                    
                    $dateless = explode('/',$date);

                    $currDay = $dateless[0];
                    $currMonth = $dateless[1];
                    $currYear = $dateless[2];

                    $currDate = $currYear."-".$currMonth."-".$currDay;
                    $currDate = date_create($currDate);
                    $currDate = date_format($currDate,"Y/m/d");
                    $todaydate=date("Y/m/d");

                    if ($currDate > $todaydate){
                      header("Location: addattendanceentry.php?status=Future date entry not allowed!");
                    }
                    
                    if((!empty($dateless[0])) && (!empty($dateless[1])) && (!empty($dateless[2]))){
                        
                        $date = $dateless[1] ."/".$dateless[0]. "/".$dateless[2];
                        
                    }
                    
                    $date = strtotime($date);
                    $date= date('Y/m/d',$date);  
                    
                   if(empty($date) || empty($location_name)){
                       
                echo "<div class='col-md-offset-4 col-md-6'><h4 class='black'> Type Date /select location First</h4><div>";
                
                       
                   }
                    elseif($dateless[1] >12 || $dateless[1] < 1 || $dateless[0] > 31 || $dateless[0] < 1 || $dateless[2] < 2014 || $dateless[2] > date("Y") ){
                        
                        
                        
                        $messageTemp = "Invalid Date";
                        header("Location: addattendanceentry.php?status=$messageTemp");
                        
                        
                    }
                    elseif(check_Admin_Entry_Made($location_name, $date)){
                        
                        $messageTemp = "Attendance For This Date Has Already Been Made, Try Editting Them";
                        header("Location: addattendanceentry.php?status=$messageTemp");
                        
                    }
                    else{ ?>
                        
                                
        <!--        form div-->
                <div class="col-md-12">
                <form action="addattendanceentry.php" method="post" class="form form-inline">    
                   <table class="table table-bordered table-hover" id="tableentries">
                <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Staff Name</th>
                                <th>Status Option</th>
                                <th>Site Location</th>
                                <th>Code</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Hours</th>
                                <th>Date</th>
                                <th>Comments</th>
                                
                            
                            </tr>
               </thead>     
               <tbody>
                   
                   
                   
               
            
                    <?php
                   
                $result = getemployeesonlocation($location_name);
                        
                if(mysqli_num_rows($result) > 0){
             
             while($row = mysqli_fetch_assoc($result )) {
                $employee_id = $row['id_employee'];
                $employee_name = getemployeename($employee_id);  
                 $employee_internal_id = get_Employee_Internalid($employee_id); 
                    
                 ?>
                    <tr>
                       <td>
                        
                         <div class="form-group" >
                        <input value="<?php echo $employee_internal_id; ?>" style="width:60px;" class="form-control">
                        </div>
                        
                        
                        </td>
                        
                        <td>
                        
                         <div class="form-group">
                        <input type="hidden" name="employee_id[]" value="<?php echo $employee_id; ?>">
                        <input value="<?php echo $employee_name; ?>" style="width:160px;" class="form-control">
                        </div>
                        
                        
                        </td>
                        
                         <td>
                        
                <div class="form-group">
               <select name="status_option[]" id="status_option<?php echo $employee_id;  ?>"  class="form-control">
                   <option value="">Select</option>
                   <?php
                 
                 $status_result = get_Status_Options_For_location($location_name);
                 
                 while($row = mysqli_fetch_assoc($status_result )) {
                 $status_id = $row['status_id'];
                $status_option = $row['status_option'];
                  
                   echo "<option value='$status_option' optionid='$status_id'>{$status_option}</option>"; }?>
                  
               </select>
              </div>
                        
                        
                        </td>
                        
                        
                        <td>
                        
                <div class="form-group">
               <select name="site_location[]" id="site_location<?php echo $employee_id;  ?>" class="form-control">
                 <option value="">select</option> 
                 
               </select>
              </div>
              
                         
                        </td>
                        
                        
                        <td>
                        
                <div class="form-group">
               <select name="remarks_option[]" id="remarks_option<?php echo $employee_id;  ?>" class="form-control">
                   <option value="">select</option> 
                  
               </select>
              </div>
                        
                        
                        </td>
                        
                  <script type="text/javascript">
                            // alert("hello");

                    $('#<?php echo "status_option".$employee_id ; ?>').on('change', function() {
                        
                     
                      var status_id = $('#<?php echo "status_option".$employee_id ; ?>').find(":selected").attr("optionid");
                
                      var url2 = "get_remarks_sitelocation.php?remarks_statusid="+status_id;
                
                      $.get(url2, function(data, status){
                        
                    
                        $("#site_location<?php echo $employee_id;  ?>").html(data);
            
                      }); 

                            
                        var status_id = $('#<?php echo "status_option".$employee_id ; ?>').find(":selected").attr("optionid");
                                
                        var url = "get_remarks_options.php?remarks_statusid="+status_id;
                                
                        $.get(url, function(data, status){
                        
                        $("#remarks_option<?php echo $employee_id;  ?>").html(data);
            
                             });
        
                             });   
                                 
                            
                            </script>      
                       
                  
                  <td> 
                       <div class="form-group">
                        <input type="text" class="form-control" name="time_in[]" style="width:70px;" title="values between 00:00 and 24:00" maxlength="5" id="time_in<?php echo $employee_id;  ?>" value="9:00">
                        </div> 
                        
                </td>  
                        
                <td> 
                       <div class="form-group">
                        <input type="text" class="form-control" style="width:70px;" name="time_out[]" title="values between 00:00 and 24:00" maxlength="5" id="time_out<?php echo $employee_id;  ?>" value="17:00">
                        </div> 
                        
                </td>             
                        
                        <script type="text/javascript">
                            
                           
                            $('#time_in<?php echo $employee_id;  ?>').on('focus', function(){
                              
                              
                          }).on('blur', function() {
                    
                          var time_out = $('#time_out<?php echo $employee_id;  ?>').val();  
        //                  var time_out_str = time_out.split(":");  
                              
                          var time_in = $('#time_in<?php echo $employee_id;  ?>').val();
        //                  var time_in_str = time_in.split(":");
                              
                              
                        var startDate = new Date("1/1/1900 " + time_in);
                        var endDate = new Date("1/1/1900 " + time_out);      
                        
                        var start_time = startDate.getTime();      
                        var end_time = endDate.getTime();      
                              
                        var diff =  end_time - start_time ;
                              
                        var hours = Math.floor(diff / 1000 / 60 / 60);
                                    
                     var hours_worked = $('#hours_worked<?php echo $employee_id;  ?>').val(hours);    
                              
                              
                          });
                            
                            
                        
                          $('#time_out<?php echo $employee_id;  ?>').on('focus', function(){
                              
                              
                          }).on('blur', function() {
                    
                          var time_out = $('#time_out<?php echo $employee_id;  ?>').val();  
        //                  var time_out_str = time_out.split(":");  
                              
                          var time_in = $('#time_in<?php echo $employee_id;  ?>').val();
        //                  var time_in_str = time_in.split(":");
                              
                              
                        var startDate = new Date("1/1/1900 " + time_in);
                        var endDate = new Date("1/1/1900 " + time_out);      
                        
                        var start_time = startDate.getTime();      
                        var end_time = endDate.getTime();      
                              
                        var diff =  end_time - start_time ;
                              
                        var hours = Math.floor(diff / 1000 / 60 / 60);
                                    
                     var hours_worked = $('#hours_worked<?php echo $employee_id;  ?>').val(hours);    
                              
                              
                          });
                        
                        </script>
                        
                <td> 
                       <div class="form-group">
                          
                           <input type="text" class="form-control" style="width:50px;" name="hours_worked[]"  value="8" maxlength="2" id="hours_worked<?php echo $employee_id;  ?>"> 
                       
                        
                        </div> 
                        
                </td>  
              
                 <td> 
                       <div class="form-group">
                           
                           <select name="date[]" class="form-control">
                           
                           <option value="<?php echo $date; ?>"><?php echo $date; ?></option>
                           
                           </select>
                        </div> 
                </td>
                        
                <td> 
                       <div class="form-group">
                        <input type="text" class="form-control" style="width:110px;"  name="comments[]" placeholder="your comments here.">
                        </div> 
                        
                </td>                 
                        
                    </tr>
                <?php } ?>  
                   
                    </tbody>    
                </table>
        <!--            loop ends here-->
               <div class="form-group col-md-offset-5">
                  <input class="btn btn-primary" type="submit" name="addentry" value="Mark Entries">
              </div>
        
        
                </form>
                    
                </div>
        <!--        form div ends here-->
                   <?php 
                
                }else{
                    
                    
                    echo "<div class='col-md-offset-4 col-md-6'><h4 class='black'>No Employee Found</h4><div>";
                    
                    
                }
                
                ?>  
                
                
                        
                <?php }
          
                    
                }
                
                
        ?>

                </div>

            </div>

        </div>

        </div>

        </div>

        </div>
        <!-- content-wrapper ends -->

        <?php include("includes/footer.php");?>

      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->



</body>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        
        <h4 class="modal-title">Confirm Delete</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">
        <h5 class="text-center">Are You Sure To remove this location, All employees on this location would be unchained?</h5>
      </div>
      <div class="modal-footer">
      	<a href="" class="btn btn-danger modal_delete_link">Remove</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>

  </div>
</div>


<style>

#example{
  font-size: 12px;
}

.dataTables_wrapper {
    font-size: 12px;
}

#tableentries{

    font-size: 12px;

}

#tableentries tr td{

}

</style>

<script>

$(document).ready( function () {
    // $("#allform").hide();
    // $('#example').DataTable();

    var status = "<?php echo $message; ?>";

    if (status!="" && status != null){
        alert(status);
    }  

    $('#tableentries').DataTable({
        "scrollX": true,
        "lengthMenu": [[-1], [ "All"]]
    });

} );

$('#locationselect1').on('change', function() {
 
  var region = $("#locationselect1").val();

  $.ajax({
            type : "GET",
            data : "region="+ region,
            url  : "getregionalemployees.php",
            success : function(response)
            { 
              var data = $.parseJSON(response);
              $('#employeeSelect').html(data);
              updateStatusOption(region);
            }
        });

});

function updateStatusOption(region){
  $.ajax({
            type : "GET",
            data : "location="+ region,
            url  : "get_status_options.php",
            success : function(response)
            { 
              $('#status_option').html(response);
              var e = document.getElementById("status_option");
             var option =  e.options[e.selectedIndex].value;
              myFunction( option);
            }
        });

}
function myFunction( option){

        if(option > 0){
          showState("site_location",option);
          showState("remarks_option",option);
        }else{
          var e = document.getElementById("status_option");
             var option =  e.options[e.selectedIndex].value;
             showState("site_location",option);
          showState("remarks_option",option);

        }
        
      
      
    }
    function showState(option,val) {
  //alert(option+index+val);
  if(option == "site_location")
      path = "getsitelocations.php";
  if(option == "remarks_option")  
      path = "getstatusoption.php";
  var select = $('#'+option);
     $.ajax({
      type: "POST",
      url: path,
      data: "remarks_statusid="+val,
      cache: false,
      /*beforeSend: function () { 
        $('#output1').html('<img src="loader.gif" alt="" width="24" height="24">');
      },*/
      success: function(response) {  
        //alert(response);
        select.html( response );
        

      },
      error: function(error) {
        alert(error.responseJSON.message);
    }
    });
  }



</script>

</html>