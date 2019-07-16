<?php
include_once("includes/Database.php");
include_once("includes/functions.php");

session_start();
// var_dump($_SESSION);exit;
if (isset($_SESSION['id'])){
  header("Location: index.php");
}

if (isset($_POST['loginBtn'])){

  $email = $_POST['email'];
  $password = $_POST['password'];

  $conn = getconnection();

  $username = mysqli_real_escape_string($conn,$email);
  
  $password = mysqli_real_escape_string($conn,$password);

  if(empty($username)||empty($password)){

    header("Location: login.php?status=Fill All Fields");

  }
  else{

    $loginas;
    $found_account = loginAttempt($username, $password);

    if($found_account === null){
        
      header("Location: login.php?status=Invalid Username or Password");
        
    }else{

                  
      $loginas = $found_account["employee_role"];
      session_start();

      if($loginas===null){         
      
        header("Location: login.php?status=You are no longer part of company!");
      
      }else{

        $_SESSION["id"] = $found_account["employee_id"];
        $_SESSION["name"] = $found_account["employee_NAME"];
        $_SESSION["username"] = $found_account["employee_username"];
        $_SESSION["email"] = $found_account["employee_email"];
        $_SESSION["role"] = $loginas;
        $_SESSION["location"] = $found_account["name_location"];


        if (strtolower($loginas) == "entry maker"){
          header("Location: addattendanceentry.php");
        }else{
          header("Location: index.php");
        }

        

      }
      

    }
    
  }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>NPM- Login</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/website_icon.png" />
</head>

<body>

  <div class="container-scroller">

    <div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
      <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">

        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auto-form-wrapper">
              <form action="login.php" method="post">
                
              <div class="col-md-12" style="" >
               
                <img src="images/login-logo.svg" alt="logo" />
              </div>
              <br>
                <div class="form-group">
                  <label class="label">Username</label>
                  <div class="input-group">
                    <input type="email" class="form-control" placeholder="Email" name="email">
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="mdi mdi-check-circle-outline"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="label">Password</label>
                  <div class="input-group">
                    <input type="password" class="form-control" placeholder="*********" name="password">
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="mdi mdi-check-circle-outline"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <button class="btn btn-success submit-btn btn-block" name="loginBtn" style="background:#006a4a;">Login</button>
                </div>
                <div class="form-group d-flex justify-content-between">
                 
                  <a href="#" class="text-small forgot-password text-black">Forgot Password</a>
                </div>
                <br>

                <?php if (isset($_GET['status'])){
                  echo "<span style='color:red'>".$_GET['status']."</span>";
                } ?>

              </form>
            </div>
<br>
            
          </div>

        </div>
        <div class="fixed-bottom">
            <p class="footer-text text-right" style="font-size: 15px;padding-bottom:0px;margin-bottom:0px;">A product developed by <img src = "images/logo_white.svg" alt="NPM Logo" width="70px" height="70px"/></p>
        </div>
      </div>
      <!-- content-wrapper ends -->
      
    </div>
    <!-- page-body-wrapper ends -->
    
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
  <!-- endinject -->



</body>

</html>