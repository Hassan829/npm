<?php ob_start(); 
$GLOBALS['labelDates'] = array(); 

 ?>
<!DOCTYPE html>
<html lang="en">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

<body>
<style type="text/css">
  .container-flex {
    display: flex;
   width: 100%;
   justify-content: space-between;
}
.card-description{
  padding: 10px;
}
</style>
  <div class="container-scroller">

<?php 
 
   // Function to get all the dates in given range 
     function getDatesFromRange($start, $end, $format = 'Y-m-d') { 
            $GLOBALS['labelDates'] =  array();
          // Declare an empty array 
          $dates = array(); 
            
          // Variable that store the date interval 
          // of period 1 day 
          $interval = new DateInterval('P1D'); 
        
          $realEnd = new DateTime($end); 
          $realEnd->add($interval); 
        
          $period = new DatePeriod(new DateTime($start), $interval, $realEnd); 
          // Use loop to store date into array 
          foreach($period as $date) {                  
             $dates[] = $date->format($format);  
             if($date->format($format) == date('Y-m-d'))
                $GLOBALS['labelDates'][] = "Today";
              else
                $GLOBALS['labelDates'][] = $date->format('M-d');
          } 
          $dates = array_reverse($dates) ;
          $GLOBALS['labelDates'] = array_reverse( $GLOBALS['labelDates']) ;

            
       
          // Return the array elements 
          return $dates; 
      } 

include("includes/header.php"); 
if (strtolower($_SESSION["role"]) == "entry maker"){
  header("Location: addattendanceentry.php");
}


?>

    <div class="container-fluid page-body-wrapper">

    <?php include("includes/sidebar.php"); ?>

      <div class="main-panel">
        <div class="content-wrapper">

          <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    <div class="float-left">
                      <i class="mdi mdi-cube text-success icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="mb-0 text-right">Locations</p>
                      <div class="fluid-container">
                        <h3 class="font-weight-medium text-right mb-0">4
                        
                         </h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted mt-3 mb-0">
                    <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i> More to come soon!
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    <div class="float-left">
                      <i class="mdi mdi-receipt text-success icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="mb-0 text-right">Entry Makers</p>
                      <div class="fluid-container">
                        <h3 class="font-weight-medium text-right mb-0">20</h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted mt-3 mb-0">
                    <i class="mdi mdi-bookmark-outline mr-1" aria-hidden="true"></i> Total Entry Makers
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    <div class="float-left">
                      <i class="mdi mdi-poll-box text-success icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="mb-0 text-right">Super Admins</p>
                      <div class="fluid-container">
                        <h3 class="font-weight-medium text-right mb-0">2</h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted mt-3 mb-0">
                    <i class="mdi mdi-calendar mr-1" aria-hidden="true"></i> Total Super Admins
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    <div class="float-left">
                      <i class="mdi mdi-account-location text-success icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="mb-0 text-right">Employees</p>
                      <div class="fluid-container">
                        <h3 class="font-weight-medium text-right mb-0">246</h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted mt-3 mb-0">
                    <i class="mdi mdi-reload mr-1" aria-hidden="true"></i> Total employees
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-7 grid-margin stretch-card">


              <!--weather card-->
              <div class="card card-weather">
                <div class="card-body">

                <div style="float:right;">
                
                <div id="icon"></div>
                    <h3 id="weather"></h3>

                </div>

                  <div class="weather-date-location">
                    <h3>Monday</h3>
                    <p class="text-gray">
                      <span class="weather-date">25 October, 2016</span>
                      <span class="weather-location">
                          
                        <form id="search" class="" role="form" action="javascript:void(0);">
                            
                            <input type="text" id="city" class="btn btn-success" placeholder="City, country" autocomplete disabled/>
                            
                            
                        </form>

                      </span>
                    </p>
                  </div>

                  <div class="weather-data d-flex">
                    <div class="mr-auto">
                      <h4 class="display-3"><span id="temp"></span>&#32;<span id="unit">°C</span></h4>
                      <p>
                        Humidity: <span id="hum"></span> %
                      </p>
                    </div>


                  </div>
                </div>
  
              </div>

              <!--weather card ends-->
            </div>



            <div class="col-lg-5 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h2 class="card-title mb-5" style="color:#006a4a;"><b>Employee Stats</b></h2>
                  <div class="wrapper d-flex justify-content-between">
                    <div class="side-left">
                      <p class="mb-2">Admins</p>
                      <p class="display-3 mb-4 font-weight-light">20%</p>
                    </div>
                    <div class="side-right">
                      <small class="text-muted">2018</small>
                    </div>
                  </div>
                  <div class="wrapper d-flex justify-content-between">
                    <div class="side-left">
                      <p class="mb-2">Entry Makers</p>
                      <p class="display-3 mb-5 font-weight-light">60%</p>
                    </div>
                    <div class="side-right">
                      <small class="text-muted">2018</small>
                    </div>
                  </div>
                  <div class="wrapper">
                    <div class="d-flex justify-content-between">
                      <p class="mb-2">Entry Makers</p>
                      <p class="mb-2" >60%</p>
                    </div>
                    <div class="progress">
                      <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 60%" aria-valuenow="60"
                        aria-valuemin="0" aria-valuemax="100" ></div>
                    </div>
                  </div>
                  <div class="wrapper mt-4">
                    <div class="d-flex justify-content-between">
                      <p class="mb-2">Visits</p>
                      <p class="mb-2" >20%</p>
                    </div>
                    <div class="progress">
                      <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 20%" aria-valuenow="20"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
         <div class="col-md-12">
          <?php

          $locationList = getlocations();
         while($row = mysqli_fetch_assoc($locationList )){
            $markedEntries = [];
            $dates = [];
            $startDate =  date('Y-m-d', strtotime('today - 29 days'));  
            $endDate = date("Y-m-d");
            if(strtolower($_SESSION["role"])=="admin" || strtolower($_SESSION["role"])=="entry maker")
              $locationName = $_SESSION['location'];
            else
              $locationName = $row['location_name'];

            // Function call with passing the start date and end date 
            $dates = getDatesFromRange($startDate, $endDate); 
            
            for($i=0; $i<sizeof($dates); $i++ ){
              if(check_Admin_Entry_Made($locationName, $dates[$i]))
                $markedEntries[] = true;
              else
                $markedEntries[] = false;
            }
              
           ?>

              <div class="row my-2">
                  <div class="col-md-12">
                      <div class="card">
                      <!-- <div class="container-flex">
                      <div class="flex-start">
                        <h4 class="card-description"><?php echo $locationName ; ?></h4>
                        <p > Attendance record log   </p>
                      </div>
                         <div class="flex-end">
                         <img src="1.png">
                         </div>
                      </div> -->

                <div class="card-body">
                  <h3><?php echo $locationName ; ?></h3>
                  <p class="card-description">
                    Attendance record log 
                  </p>
                  </div>

                          <div class="card-body">
                            <canvas id="<?php echo $row['location_name']; ?>" height="30"></canvas>
                          </div>
                      </div>
                  </div>
              </div>
              <script type="text/javascript">
                /* chart.js chart examples */
                // chart colors
                var colors = ['#007bff','#28a745','#444444','#c3e6cb','#dc3545','#6c757d'];

                var chBar = document.getElementById("<?php echo $row['location_name']; ?>");
                var lebelsList = <?php echo json_encode( $GLOBALS['labelDates']); ?>;
                var markedEntriesList = <?php echo json_encode($markedEntries); ?>;
                var chartData = {
                  labels: lebelsList,
                  datasets: [{
                    data: markedEntriesList,
                    backgroundColor: colors[1]
                  }]
                };

                if (chBar) {
                  new Chart(chBar, {
                  type: 'bar',
                  data: chartData,
                  options: {

                    scales: {
                      xAxes: [{
                        barPercentage: 0.8,
                        categoryPercentage: 0.7,
                        scaleLabel: {
                            display: true,
                            labelString: 'Last 30 Days'
                          },
                          gridLines: {
                                color: "rgba(0, 0, 0, 0)",
                            } 
                      }],
                      yAxes: [{
                        ticks: {
                          beginAtZero: false,
                          display: false
                        },gridLines: {
                                color: "rgba(0, 0, 0, 0)",
                            } 
                      }]
                    },
                    legend: {
                      display: false
                    }
                  }
                  });
                }
                      </script>
         <?php 
       if(strtolower($_SESSION["role"])=="admin" || strtolower($_SESSION["role"])=="entry maker")
            break;
        } 

         
            

              ?>
          
                  
              </div>              

          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Overview Bar Chart</h4>
                  <canvas id="barChart" ></canvas>
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

    <script>

var lat = 0,
  lon = 0;

$(document).ready(function() {
  //Weather through geolocation
  if (navigator && navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(succesGetPos, errorGetPos);
  }
  //Weather through city search 
  $("#search").submit(getCityWeather);
  //Unit conversion
  $("#unit").click(unitConversion);
});

function succesGetPos(pos) {
  var openWeatherURL = "",
    corsAwURL = "https://cors-anywhere.herokuapp.com/";

  lat = pos.coords.latitude;
  lon = pos.coords.longitude;

  // The "https://cors-anywhere.herokuapp.com/" url is used to fix the "same-origin policy" (crossorigin) problem with the ajax call.
  //If you want to work with navigator.geolocation, JSONP can't solve the issue for every browser due to the different connection type: https on codepen (for making navigator.geolocation works on chrome), http on api.openweathermap (it doesn't seem to work on firefox anyway).
  // The "https://cors-anywhere.herokuapp.com/" url actually behaves like a proxy.
  openWeatherURL = "http://api.openweathermap.org/data/2.5/weather?lat=" + lat + "&lon=" + lon + "&units=metric&appid=3d3b5a9ac6383aca1ebce6fe9865189d";
  $.getJSON(corsAwURL + openWeatherURL, openWeatherCall);

  return 0;
}

function errorGetPos() {
  alert("Failed to get current position.");

  return -1
}

function openWeatherCall(json) {
  $("#city").val(json.name + ", " + json.sys.country);
  $("#temp").html(json.main.temp.toFixed(1));
  $("#hum").html(json.main.humidity);
  $("#icon").html("<img src='http://openweathermap.org/img/w/" + json.weather[0]["icon"] + ".png'>");
  $("#weather").html(json.weather[0]["description"]);

  return 0;
}

function getCityWeather() {
  var openWeatherQuery = "http://api.openweathermap.org/data/2.5/weather?q=",
    cityName = $("#city").val(),
    appid = "&units=metric&appid=3d3b5a9ac6383aca1ebce6fe9865189d",
    corsAwURL = "https://cors-anywhere.herokuapp.com/";

  $.getJSON(corsAwURL + openWeatherQuery + cityName + appid, openWeatherCall);

  return 0;
}

function unitConversion() {
  var T = $("#temp").html(),
    unit = $("#unit").html();

  if (unit == "°C") {
    T = (T * 1.8) + 32;
    $("#temp").html(T.toFixed(1));
    $("#unit").html("°F");
  } else {
    T = (T - 32) / 1.8;
    $("#temp").html(T.toFixed(1));
    $("#unit").html("°C");
  }

  return 0;
}

        </script>

</body>

</html>