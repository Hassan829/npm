<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<body>

  <div class="container-scroller">

<?php 
include("includes/header.php"); 
$locations = getAllLocations();
$payrollData = GetAllPayRollData();
$message = $_GET['status'];

if (strtolower($_SESSION["role"])!="super admin" && strtolower($_SESSION["role"])!="admin"){
    header("Location: index.php");
    }

$error = false;

// var_dump($payrollData);exit;
?>

    <div class="container-fluid page-body-wrapper">

    <?php include("includes/sidebar.php");
    
    if (strtolower($_SESSION["role"])!="super admin" && strtolower($_SESSION["role"])!="admin"){
        echo "<div class='col-md-8 grid-margin stretch-card' style='padding:75px;'><h3>Unauthorized Access!</h3></div>";exit;
        }
    
    ?>

      <div class="main-panel">
        <div class="content-wrapper">


        <div class="card" style="background: #fcfcfc; padding: 15px;" id = "singleform">
          <form action="viewattendanceentry.php" method="GET" class="form form-inline" >
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                    <h3>View Attendance Entries</h3>
                    <p class="card-description">
                      View All Attendance Entries
                    </p>
                </div>
                <div class="form-group">
                            <label for="location" class="col-sm-2 control-label">Select location</label>
          
                            <div class="col-sm-3">
                              <select name="location" id="locationselect" name="locationselect" class="form-control col-sm-8">
                                <option value="">Select</option> 
                                  <?php if (strtolower($_SESSION["role"])=="super admin"){
                                          $result = getlocations();
                                          while($row = mysqli_fetch_assoc($result )) {
                                            $location_name = $row['location_name'];
                                            if($location_name === isset($_GET['location'])){                                                      
                                              echo "<option value='$location_name' selected optionid='$location_name'>{$location_name}</option>"; 
                                            }else{
                                              echo "<option value='$location_name' optionid='$location_name'>{$location_name}</option>"; 
                                            }
                                          }
                                        }else if (strtolower($_SESSION["role"])=="admin" || strtolower($_SESSION["role"])=="entry maker"){
                                          echo "<option value='".$_SESSION["location"]."'>".$_SESSION["location"]."</option>";
                                          }
                                  ?>
                             </select>
                            </div>
                             <label for=employee" class="col-sm-2 control-label">Select Employee</label>
          
                            <div class="col-sm-3">
                              <select class="form-control" id="employee" name="employee" class="form-control col-sm-8">

                              </select>
                            </div>

                            
                          </div>
                          </br>
                          <div class="form-group">
                            <label for="reservationDate" class="col-sm-2 control-label">From</label>
          
                            <div class="col-sm-3">
                              <input type="text" placeholder="dd/mm/yyyy" class="form-control" name="fordate" >
                            </div>
                             <label for="reservationTime" class="col-sm-2 control-label">To</label>
          
                            <div class="col-sm-3">
                              <input type="text" placeholder="dd/mm/yyyy" class="form-control" name="todate">
                            </div>

                            
                          </div>
                          <br>
               
                <div class="form-group">
                
                    <input type="submit" class="btn btn-primary" value="View" name="viewattendance">

                    <button type="button" class="btn btn-primary" data-toggle="modal" style="float: right" data-target="#myModal">
                         Add Single Record
                    </button>
                    
                </div>
              </div>
            </div>
          </form>
        </div>

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
               <select name="status_option" id="status_option" onchange="myFunction1(0);" class="form-control">
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
                 onchange="myFunction1('site_location')">
                 
                   <option value="<?php echo $the_site_location; ?>" ></option>;
                 
               </select>
              </div>
        <br>
        </div>
        <div class="form-inline">
        <label >Select code</label>
        <div class="form-group">
               <select name="remarks_option" id="remarks_option" class="form-control"
                 onchange="myFunction1('site_location')">
                 
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


        <div class="row">
        
        <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h3>Attendance Entries Details</h3>
                  <p class="card-description">
                    Detailed Entries Table
                  </p>


                <div class="card" style="background: #fcfcfc; padding: 15px;" id = "singleform">

                <?php 
        
        if(isset($_GET["viewattendance"])){
              
                $location = escape_it($_GET["location"]);
                $date = escape_it($_GET["fordate"]);
                $to_date = escape_it($_GET["todate"]);
                $employee = escape_it($_GET["employee"]);
                
                $dateless = explode('/',$date);
                
                if((!empty($dateless[0])) && (!empty($dateless[1])) && (!empty($dateless[2]))){
                    
                    $date = $dateless[1] ."/".$dateless[0]. "/".$dateless[2];
                    
                }
            
                 $dateless = explode('/',$to_date);
                
                if((!empty($dateless[0])) && (!empty($dateless[1])) && (!empty($dateless[2]))){
                    
                    $to_date = $dateless[1] ."/".$dateless[0]. "/".$dateless[2];
                    
                }
                
                 
    //            $date = strtodate($date);
                if(!empty($date)){
                    $date = strtotime($date);
                    $date = date('Y/m/d',$date);
                }
               if(!empty($to_date)){
                    $to_date = strtotime($to_date);
                    $to_date = date('Y/m/d',$to_date);
                }
               
    
               if((empty($date)) || (empty($location))){
                   
                    $messageTemp = "Select Location/ Type date";
                    header("Location: viewattendanceentry.php?status=$messageTemp");
            
                   
               }
            
            if((empty($to_date) || $date === $to_date) && (!check_Admin_Entry_Made($location, $date))){
                    
                    $error = true;
                    $messageTemp = "Attendance For This Date Has Not Been taken Yet";
                    header("Location: viewattendanceentry.php?status=$messageTemp");
                    
                }
            
            if((!empty($to_date)) && (!$date === $to_date)){
                
                        if(!check_Admin_From_To_Entry_Made($location, $date, $to_date)){
                            
                    $error = true;
                    $messageTemp = "Attendance For These Dates Has Not Been taken Yet";
                    header("Location: viewattendanceentry.php?status=$messageTemp");
                    
                }
                else{
                     $error = false;
                }
                        
                
            }
            //if no error ocoured 
            if(!$error){ 
                    $show;
                    $href;
                    $redirect;
                    $result;
            
                    if((isset($location)) && (!empty($date)) && (!empty($to_date))){
                        
                        $href = "export_excel.php?location=".$location."&fordate=".$date."&todate=".$to_date;
                        $redirect = "location=".$location."&date=".$date."&todate=".$to_date;
                        $show = "fromto";
                    }
                    elseif(isset($location) && isset($date)){
                        
                        $href = "export_excel.php?location=".$location."&fordate=".$date;
                        $redirect = "location=".$location."&date=".$date;
                        $show = "date";
                    }
            
                    
            
            ?>
            
 <form action="editAttendanceEntery.php" method="POST" class="form form-inline" id="formName" name="formName"> 
               <table class="table table-bordered table-hover" id ="example" data-page-length='500'>
            <thead>
                        <tr>
                            <th>Sr. No</th>
                            <th>Employee ID</th>
                            <th>Staff Name</th>
                            <th>Status Option</th>
                            <th>Site Location</th>
                            <th>Code</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>Hours</th>
                            <th>Comments</th>
                            <th>Date</th>
                            <th>Edit</th>
                            <!-- <th>Delete</th> -->
                        
                        </tr>
           </thead>    
           
           <tbody>
            
            
            
                    <?php
                    
                    if($show === "fromto"){
                        
                        $result = view_Admin_From_To_Entries($location, $date, $to_date,$employee);
                        
                        
                    }else{
                        
                        $result = view_Admin_Entries($location, $date);
                        
                        
                    }
                    
                if(mysqli_num_rows($result) == 0){
                        $error = true;
                    $messageTemp = "Attendance For These Dates Has Not Been taken Yet";
                    header("Location: viewattendanceentry.php?status=$messageTemp");
                        
                    }
                else{
                    
                    $checkBoxValue = 1;
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
                        $attendance_for_date = convert($entery['attendance_for_date']);

                            
            ?>
                    
                <tr>
                   
                    <td><?php echo $checkBoxValue; ?></td>
                    <td>
                    
                     <div class="form-group" >
                    <input value="<?php echo $employee_internal_id; ?>" style="width:60px;" class="form-control">
                    </div>
                    
                    
                    </td>
                    
                    <td>
                    
                     <div class="form-group">
                    <input type="hidden" name="location" value="<?php echo $location; ?>">
                    <input type="hidden" name="todate" value="<?php echo $to_date; ?>">
                    <input type="hidden" name="attendance_id[]" value="<?php echo $attendance_id; ?>" id="attendance_id">
                    <input type="hidden" name="date" value="<?php echo $date; ?>">
                    <input value="<?php echo $employee_name; ?>" style="width:160px;" class="form-control">
                    </div>
                    
                    
                    </td>
                    
                     <td>
            <div class="form-group">
           <select name="status_option<?php echo $attendance_id;  ?>" id="status_option<?php echo $attendance_id;  ?>" class="form-control"
             onchange='myFunction("status_option",<?php echo $attendance_id; ?>)'>
               <option value=""></option>
               <?php
             
             $status_result = get_Status_Options_For_location($location);
             
             while($row = mysqli_fetch_assoc($status_result )) {
             $status_id = $row['status_id'];
            $status_option = $row['status_option'];
              
                 if($status_option === $the_status_option){
                     
                     
                     echo "<option value='$status_id' selected optionid='$status_id'>{$status_option}</option>"; 
                 }
               else{
                     
                      echo "<option value='$status_id' optionid='$status_id'>{$status_option}</option>"; 
               }
           
                 }?>
                 
           </select>
          </div>
        </td>
         <td>

                     <div class="form-group">
               <select name="site_location<?php echo $attendance_id;  ?>" id="site_location<?php echo $attendance_id;  ?>" class="form-control"
                 onchange="myFunction('site_location',<?php echo $attendance_id; ?>)">
                 
                   <option value="<?php echo $the_site_location; ?>" ><?php echo $the_site_location; ?></option>;
                 
               </select>
              </div>
                    </td>
                    
                    
                    <td>
                    
           <!--  <?php echo $the_remarks_option; ?> -->
           <div class="form-group">
               <select name="remarks_option<?php echo $attendance_id;  ?>" id="remarks_option<?php echo $attendance_id;  ?>" class="form-control"
                 onchange='myFunction("remarks_option",<?php echo $attendance_id; ?>)'>
                  <option value="<?php echo $the_remarks_option; ?>" ><?php echo $the_remarks_option; ?></option>
                                   
               </select>
              </div>
                        
                    
                    
                    </td>
                    
                    
                                    
                    
<td> 
                   <div class="form-group">
                    <input type="text" class="form-control" name="time_in<?php  echo $attendance_id;?>" style="width:70px;" title="values between 00:00 and 24:00" maxlength="5" id="time_in<?php echo $attendance_id;  ?>" value="<?php echo $time_in; ?>"
                    onchange="myFunction('',<?php echo $attendance_id; ?>)">
                    </div> 
                    
            </td>  
                    
            <td> 
                   <div class="form-group">
                    <input type="text" class="form-control" style="width:70px;" name="time_out<?php  echo $attendance_id;?>" title="values between 00:00 and 24:00" maxlength="5" id="time_out<?php echo $attendance_id;  ?>" value="<?php echo $time_out; ?>"
                    onchange="myFunction('',<?php echo $attendance_id; ?>)">
                    </div> 
                    
            </td>  
                      <script type="text/javascript">
                            
                           
                            $('#time_in<?php echo $attendance_id;  ?>').on('focus', function(){
                              
                              
                          }).on('blur', function() {
                    
                          var time_out = $('#time_out<?php echo $attendance_id;  ?>').val();  
        //                  var time_out_str = time_out.split(":");  
                              
                          var time_in = $('#time_in<?php echo $attendance_id;  ?>').val();
        //                  var time_in_str = time_in.split(":");
                              
                              
                        var startDate = new Date("1/1/1900 " + time_in);
                        var endDate = new Date("1/1/1900 " + time_out);      
                        
                        var start_time = startDate.getTime();      
                        var end_time = endDate.getTime();      
                              
                        var diff =  end_time - start_time ;
                              
                        var hours = Math.floor(diff / 1000 / 60 / 60);
                                    
                     var hours_worked = $('#hours_worked<?php echo $attendance_id;  ?>').val(hours);    
                              
                              
                          });
                            
                            
                        
                          $('#time_out<?php echo $attendance_id;  ?>').on('focus', function(){
                              
                              
                          }).on('blur', function() {
                    
                          var time_out = $('#time_out<?php echo $attendance_id;  ?>').val();  
        //                  var time_out_str = time_out.split(":");  
                              
                          var time_in = $('#time_in<?php echo $attendance_id;  ?>').val();
        //                  var time_in_str = time_in.split(":");
                              
                              
                        var startDate = new Date("1/1/1900 " + time_in);
                        var endDate = new Date("1/1/1900 " + time_out);      
                        
                        var start_time = startDate.getTime();      
                        var end_time = endDate.getTime();      
                              
                        var diff =  end_time - start_time ;
                              
                        var hours = Math.floor(diff / 1000 / 60 / 60);
                                    
                     var hours_worked = $('#hours_worked<?php echo $attendance_id;  ?>').val(hours);    
                              
                              
                          });
                        
                        </script>
                    
            <td> 
                   <div class="form-group">
                      
                       <input type="text" class="form-control" style="width:50px;" name="hours_worked<?php echo $attendance_id;  ?>"  value="<?php echo $hours_worked; ?>" maxlength="2" id="hours_worked<?php echo $attendance_id;  ?>"> 
                   
                    
                    </div> 
                    
            </td>
                    
            <td> 
                   <div class="form-group">
                    <input type="text" class="form-control" style="width:110px;"  name="comments<?php echo $attendance_id;  ?>" placeholder="your comments here." value="<?php echo $comment; ?>" id="comments<?php echo $attendance_id;  ?>"
                     onchange="myFunction('',<?php echo $attendance_id; ?>)">
                    </div> 
                    
            </td> 
                        
            <td> 
                   <div class="form-group">
                       
                       <input type="text" disabled value="<?php echo $attendance_for_date; ?>">
                       
                    </div> 
            </td>            
                        
            <td>
                        
              <!-- <div class="form-group">
              <input class="btn btn-primary" type="submit" name="updateentry" value="Update">
                </div> -->
    
                                  
            </td>
    
          
                    
     
                    
                </tr>
           
                    
                    
            <?php $checkBoxValue++; 
          }}
               //while loop ends here
               ?>  
               
                </tbody> 
              
                <div class="col-md-4" style="margin:30px 0px 30px 0px;">
                  <a class="btn btn-success" href="<?php echo $href; ?>" target="_blank">Export</a> 
                  <input type='hidden' id= 'updatedData' name='updatedData' value='' />  
                  <input type="button" class="btn btn-primary"  name="data" value="Update" id="data" onclick="mySubmit()">    
                                 
                </div> 
            
                     
            </table>
</form> 
               
    <!--        form div ends here-->
               
             <?php }
                //else closes
    }
    //isset closes
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

</style>

<script>

$(document).ready( function () {
    $("#allform").hide();
    $('#example').DataTable({
        "scrollX": true
    });

    var status = "<?php echo $message; ?>";

    if (status!="" && status != null){
        alert(status);
    } 

} );


</script>

<?php

 if(isset($_POST['updateentry'])) {
     
     
         $attendance_id = $_POST["attendance_id"];
         $date = $_POST["date"];
         $location = $_POST["location"];
         $to_go;
         $toodate;
     
     
        $dateless = explode('/',$date);
            
            if((!empty($dateless[0])) && (!empty($dateless[1])) && (!empty($dateless[2]))){
                
                $date = $dateless[1] ."/".$dateless[2]. "/".$dateless[0];
                
            } 
     
     
        $date = strtotime($date);
        $date = date('d/m/Y',$date);
          $date = escape_it($date);
     
         if(isset($_POST['todate'])){

         $toodate = $_POST["todate"];
            
          $dateless = explode('/',$toodate);
            
            if((!empty($dateless[0])) && (!empty($dateless[1])) && (!empty($dateless[2]))){
                
                $toodate = $dateless[1] ."/".$dateless[2]. "/".$dateless[0];
                $toodate = strtotime($toodate);
                $toodate = date('d/m/Y',$toodate);
                
            }   
            
            $toodate = escape_it($toodate);
            $to_go = "view_attendance_enteries.php?viewattendance=true&fordate=".$date."&location=".$location."&todate=".$toodate;
            
        }
        else{
            
            $to_go = "view_attendance_enteries.php?viewattendance=true&fordate=".$date."&location=".$location;
        }
     
     
     
     
         $status_option = $_POST["status_option"];
         $site_location = $_POST["site_location"];
         $remarks_option = $_POST["remarks_option"];
         $time_in = $_POST["time_in"];
         $time_out = $_POST["time_out"];
         $hours_worked = $_POST["hours_worked"];
         $comments = $_POST["comments"];
         
        $attendance_id = escape_it($attendance_id);
        $location = escape_it($location);
         $status_option = escape_it($status_option);
         $site_location = escape_it($site_location);
         $remarks_option = escape_it($remarks_option);
         $time_in = escape_it($time_in);
         $time_out = escape_it($time_out);
         $hours_worked = escape_it($hours_worked);
         $comment = escape_it($comments);
     
        
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
                
                $hours_worked = 8;
            }
            else{
                
                $hours_worked = ceil(strval($time_out) - strval($time_in));    
            }
            
            if($hours_worked < 0){
                
                $hours_worked = 0;
            }

     if(update_Entry($attendance_id, $status_option, $site_location, $the_time_in, $the_time_out, $hours_worked, $remarks_option, $comment)){
         
         $messageTemp = "Successfully Updated!";
         header("Location: viewattendanceentry.php?status=$messageTemp");

        }
        else{
                $messageTemp = "Some Error Occoured, Try Again";
                header("Location: viewattendanceentry.php?status=$messageTemp");
                
            }
         
}


?>    
<script type="text/javascript">
    let arr = [];
    function myFunction( option, index){
      let obj = {};
      obj.timeIn = document.getElementById("time_in"+index).value;
      obj.timeOut = document.getElementById("time_out"+index).value;
      obj.comments = document.getElementById("comments"+index).value;
      obj.hours_worked = document.getElementById("hours_worked"+index).value;

      var e = document.getElementById("status_option"+index);
      obj.status_option = e.options[e.selectedIndex].text;
      
      if(option == "status_option"){
        showState("site_location",index,e.options[e.selectedIndex].value);
        showState("remarks_option",index,e.options[e.selectedIndex].value);
      }  
      

      var e = document.getElementById("site_location"+index);
      obj.site_location = e.options[e.selectedIndex].value;

      var e = document.getElementById("remarks_option"+index);
      obj.remarks_option = e.options[e.selectedIndex].value;

      obj.attendanceId = index;

      if(arr.length == 0){
        arr.push(obj);
      }else{
        let obj1 = arr.find((e) => e.attendanceId === obj.attendanceId);
         let index = arr.indexOf(obj1);
          if (index === -1) {
              arr.push(obj);
          } else {
              arr[index] = obj;
          }
        }
        console.log( arr );
    }
/*
    $('#data').click(function() {
          //var data_str = list.join(","); 
          console.log(arr);
          $.ajax({
              type: 'post',
              cache: false,
              url: 'editAttendanceEntery.php',
              data: arr
          });
      });*/
      function mySubmit() {
        arr.forEach(function (arrayItem) {
            var x = arrayItem.attendanceId;
            let obj1 = arr.find((e) => e.attendanceId === x);
           let index = arr.indexOf(obj1);
            if (index === -1) {
                //arr.push(obj);
                alert("not found");
            } else {
                //arr[index] = obj;
                //alert(" found");
                let obj = {};
                if(document.getElementById("time_in"+x).value === null){
                  obj.timeIn = "";
                }else{
                  obj.timeIn = document.getElementById("time_in"+x).value; 
                }
                if(document.getElementById("time_out"+x).value === null){
                  obj.timeOut = "";
                }else{
                  obj.timeOut = document.getElementById("time_out"+x).value;
                }
                if(document.getElementById("comments"+x).value === null){
                  obj.comments = "";
                }else{
                   obj.comments = document.getElementById("comments"+x).value;
                }
                if(document.getElementById("hours_worked"+x).value === null){
                  obj.hours_worked = "";
                }else{
                   obj.hours_worked = document.getElementById("hours_worked"+x).value;
                }
                var e = document.getElementById("status_option"+x);
                if(e === null){
                  obj.status_option = "";
                }else{
                   obj.status_option = e.options[e.selectedIndex].text;
                }
                var e = document.getElementById("site_location"+x);
                if(e === null){
                  obj.site_location = "";
                }else{
                   obj.site_location = e.options[e.selectedIndex].value;
                }
                if(document.getElementById("remarks_option"+x).value === null){
                  obj.remarks_option = "";
                }else{
                   obj.remarks_option = document.getElementById("remarks_option"+x).value;
                }
                obj.attendanceId = x;
                arr[index] = obj;
            }

        });
        console.log(arr);
        var json_arr = JSON.stringify(arr);
        document.getElementById('updatedData').value = json_arr;
        document.getElementById("formName").submit();
   }

function showState(option,index,val) {
  //alert(option+index+val);
  if(option == "site_location")
      path = "getsitelocations.php";
  if(option == "remarks_option")  
      path = "getstatusoption.php";
  var select = $('#'+option+index);
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

$('#locationselect').on('change', function() {
 
  var region = $("#locationselect").val();

  $.ajax({
            type : "GET",
            data : "region="+ region,
            url  : "getregionalemployees.php",
            success : function(response)
            { 
              var data = $.parseJSON(response);
              $('#employee').html(data);
                    
            }
        });

});

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
             var option =  e.options[e.selectedIndex].id;
              myFunction1( option);
            }
        });

}

function myFunction1( option){

        if(option > 0){
          showState1("site_location",option);
          showState1("remarks_option",option);
        }else{
          var e = document.getElementById("status_option");
             var option =  e.options[e.selectedIndex].id;
             showState1("site_location",option);
          showState1("remarks_option",option);

        }
        
      
      
    }

       function showState1(option,val) {

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