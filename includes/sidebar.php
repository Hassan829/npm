      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <div class="nav-link">
              <div class="user-wrapper">
                <div class="profile-image">
                <?php

              

                $image = getimage($_SESSION["id"]);
                $image_path;
                if($image === "male.png" || $image==="female.jpg" ){
                    
                    $image_path = "employee_images/images/".$image;
                    
                }else{
                    
                    $image_path = "employee_images/images/id/".$_SESSION["id"]."/".$image;
                    
                }

                ?>
                  <img src="<?php echo $image_path; ?>">
                </div>
                <div class="text-wrapper">
                  <p class="profile-name"><?php echo $_SESSION["name"]; ?></p>
                  <div>
                    <small class="designation text-muted"><?php echo $_SESSION["role"]; ?></small>
                    <span class="status-indicator online"></span>
                  </div>
                </div>
              </div>


              <a class="btn btn-success btn-block" style="background:#006a4a;" href="addattendanceentry.php">Attendance Entry
                <i class="mdi mdi-plus"></i>
              </a>
            </div>
          </li>
          <?php if (strtolower($_SESSION["role"])=="super admin" || strtolower($_SESSION["role"])=="admin"){ ?>
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="menu-icon mdi mdi-television"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="menu-icon mdi mdi-content-copy"></i>
              <span class="menu-title">Employees</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="addEmployee.php">Add Employee</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="viewAllEmployees.php">View All Employees</a>
                </li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic-location" aria-expanded="false" aria-controls="ui-basic">
              <i class="menu-icon mdi mdi-content-copy"></i>
              <span class="menu-title">Locations</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic-location">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="locations.php">View All Locations</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="statusoptions.php">View All Status Options</a>
                </li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic-attendance" aria-expanded="false" aria-controls="ui-basic">
              <i class="menu-icon mdi mdi-content-copy"></i>
              <span class="menu-title">Attendance</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic-attendance">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="addattendanceentry.php">Make Entry</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="viewattendanceentry.php">View Entries</a>
                </li>
              </ul>
            </div>
          </li>

        <?php if (strtolower($_SESSION["role"])=="super admin"){ ?>

          <li class="nav-item">
            <a class="nav-link" href="accounts.php">
              <i class="menu-icon mdi mdi-table"></i>
              <span class="menu-title">Account Operations</span>
            </a>
          </li>

        <?php } ?>


        <?php if (strtolower($_SESSION["role"])=="super admin"){ ?>

          <li class="nav-item">
            <a class="nav-link" href="reporting.php">
              <i class="menu-icon mdi mdi-sticker"></i>
              <span class="menu-title">Reports</span>
            </a>
          </li>

        <?php } } ?>

        </ul>
      </nav>
      <!-- partial -->