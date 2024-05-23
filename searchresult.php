<?php 
include('hrssession.php');
if (!session_id())
{
  session_start(); 
}
//include 'headeradmin.php';
include ('dbconnect.php');

$fid = $_SESSION['xuserid'];
if (isset($_POST['search'])) {
    $x_userclass = $_POST['x_userclass'];
}

?>


<!doctype html>
<html lang="en">
  <head>
    <title>Hotel Reservation System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700,900|Rubik:300,400,700" rel="stylesheet">

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">

    <link rel="stylesheet" href="fonts/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <!-- Theme Style -->
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    
    <header role="banner">
      <nav class="navbar navbar-expand-md navbar-dark bg-light">
        <div class="container">
          <a class="navbar-brand" href="home.php">Hotel Sunshine</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <?php


// Check if the userclass is set in the session
if (isset($_SESSION['x_userclass'])) {
    // Check if userclass is admin (0)
    if ($_SESSION['x_userclass'] == 0) {
        // Admin navigation menu
        echo '
          <div class="collapse navbar-collapse navbar-light" id="navbarsExample05">
            <ul class="navbar-nav ml-auto pl-lg-5 pl-0">
              <li class="nav-item">
                <a class="nav-link" href="home.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="dashboard.php">Dashboard</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="manageall.php">All Reservation</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="manage.php">Reservation Approval</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="report.php">Report</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="mailto:support@hotelsunshine.com">Contact</a>
              </li>
              <li class="nav-item cta">
                <a class="nav-link" href="logout.php"><span>Logout</span></a>
              </li>
            </ul>
          </div>';
    } elseif ($_SESSION['x_userclass'] == 1) {
        // Customer navigation menu
        echo '
          <div class="collapse navbar-collapse navbar-light" id="navbarsExample05">
            <ul class="navbar-nav ml-auto pl-lg-5 pl-0">
              <li class="nav-item">
                <a class="nav-link" href="home.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="customer.php">Room Reservation</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="customermanage.php">My Reservation</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="home.php#featuredrooms">Rooms</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="mailto:support@hotelsunshine.com">Contact</a>
              </li>
              <li class="nav-item cta">
                <a class="nav-link" href="logout.php"><span>Logout</span></a>
              </li>
            </ul>
          </div>';
    }
}
?>
        </div>
      </nav>
    </header>
    <!-- END header -->



    <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url(images/big_image_1.jpg);">
      <div class="container">
        <div class="row align-items-center site-hero-inner justify-content-center">
          <div class="col-md-12 text-center">

            <div class="mb-5 element-animate">
              <h1>Search Result</h1>
              <p></p>
            </div>

          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

    <section class="site-section">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 text-right">  
            <table class="table table-hover">
                <thead>
                  <tr>
                       <form method="POST" name="search" action="searchresult.php"><br>
                      <input type="hidden" name="x_userid" value="<?php echo $_SESSION['x_userid']; ?>">
                       <input type="hidden" name="x_userclass" value="<?php echo $_SESSION['x_userclass']; ?>">
                      <input type="text" placeholder=" Reservation ID" name="search">
                      <button type="submit" value="search"><i class="fa fa-search"></i></button>
                      </form>
                  </tr>
                </thead>
            </table>
          </div>


            <div class="col-md-12 text-center">               
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Reservation ID</th>
                    <th>Room Number</th>
                    <th>Room Type</th>
                    <th>Check In Date</th>
                    <th>Check Out Date</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Operation</th>
                  </tr>
                </thead>

                <tbody>
                  <?php              
                        // PROCESS SEARCH WHEN FORM SUBMITTED
                        if (isset($_POST['search'])) 
                        {
                          // SEARCH FOR USERS
                          require "searchprocess.php";

                          // DISPLAY RESULTS
                          if (count($results) > 0) 
                          {
                            foreach ($results as $row) 
                            {
                              //printf("<div>%s - %s</div>", $r['x_bookid'], $r['x_room']);
                              echo"<tr>";
                              echo "<td>".$row['x_bookid']."</td>";
                              echo "<td>".$row['x_roomid']."</td>";
                              echo "<td>".$row['x_roomtype']."</td>";
                              echo "<td>".$row['x_datein']."</td>";
                              echo "<td>".$row['x_dateout']."</td>";
                              echo "<td>".$row['x_totalfee']."</td>";
                              echo "<td>".$row['x_name']."</td>";
                              echo "<td>";
                                echo "<a href='customercancel.php?id=".$row['x_bookid']."' class ='btn btn-secondary'>Cancel</a>&nbsp;";
                                echo "<a href='customermodify.php?id=".$row['x_bookid']."' class ='btn btn-primary'>Modify</a>&nbsp";
                              echo "</td>";
                              echo "</tr>";
                            }
                          } 
                          else 
                          { 
                            echo "<td colspan='9'>No results found</td>";                        
                          }
                        }
                    

                  ?>
                </tbody>
              </table>
            </div>


          
        </div>
      </div>
    </section>

   
   <?php include 'footer.php'; ?>
  </body>
</html>
