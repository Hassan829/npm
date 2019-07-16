<?php require_once("includes/Database.php"); ?>
<?php require_once("includes/functions.php"); ?>

<?php

if(isset($_GET['location'])) { 
     
    
    $location = escape_it($_GET["location"]);
    
    if(empty($location)||$location == ""||$location == "undefined"){
        $_SESSION["message"] = "**Please Select A location First**";
        
        
        }
     
     else{
         
         $result = get_Status_Options_For_location($location);
         
         if(mysqli_num_rows($result) === 0){
             
         }
         
     else{$_SESSION["message"] = "Status Options"; ?>
         
         
        <table class="table table-bordered table-hover">
        <thead>
                    <tr>
                        <th>Delete</th>
                        <th>Status Options</th>
                        <th>Code</th>
                        
                    
                    </tr>
            <tr>
           
            
            </tr>
       </thead>     
       <tbody>
        
         
         
         <?php
         while($row = mysqli_fetch_assoc($result )) {
        $status_id = $row['status_id'];
        $status_option = $row['status_option'];
        $remarks_option = $row['remarks_option'];
          
             
        echo "<tr>";
        echo '<td><button rel="'.$status_id.'" class="btn btn-danger statusdeletebtn">Delete</button></td>';
        echo '<td><div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" style="background:#006a4a;" type="button" data-toggle="dropdown">'.$status_option.'
        <span class="caret"></span></button>
        <ul class="dropdown-menu">';
      
          $remarksresult = get_site_location_For_Statusoption($status_id);
             
        while($remarksrow = mysqli_fetch_assoc($remarksresult )) {
        $site_location = $remarksrow['site_location'];
        
             
             echo '<li>'.$site_location.'<span class="deleteicon deleteremarkslink" title="delete" rel="'.$status_id.'" value="'.$site_location.'">&times;</span></li>';
        }
    echo'</ul>
</div></td>';
             
             
    echo '<td>'.$remarks_option.'</td>';         
        echo "</tr>";
   }   
//    while closes
        }
//           else closes
           ?>
            </tbody> 
            </table>    
        <?php  
    }
//     else close
}
//isset close
?>
    
<script type="text/javascript">


        $(document).ready(function() {
        
//            click handler for status button remove
            $(".statusdeletebtn").on('click', function(e){
             
            var target = $(this);  
             var status_id = $(this).attr("rel");
         
            target.parent().parent().hide();
                
            var url = "delete_status_option.php?status_id="+status_id;
            
                 $.get(url, function(data, status){
                
                                   });

                
        });
            
//            click handler for removing remarks
        $(".deleteremarkslink").on('click', function(e){
            
              var target = $(this);  
             var remarks_status_id = target.attr("rel");
             var site_location = target.attr("value");
                
    var url = "delete_remarks.php?remarks_status_id="+remarks_status_id+"&site_location="+site_location;
                
             target.parent().css({"display": "none"});
           
                 $.get(url, function(data, status){
            

                                            });

        });
            
            
});

</script>