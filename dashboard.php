<?php
include 'hrssession.php';
if (!session_id()) {
    session_start();
}
include 'dbconnect.php';
include 'functions.php'; // Include the file where the getroleid function is defined
ini_set('display_errors', 0);

// Check if the user is logged in
if (!isset($_SESSION['userislogged']) || $_SESSION['userislogged'] != 1) {
    header("Location: index.php");
    exit;
}

// Check if the necessary session variables are set
if (!isset($_SESSION['x_userid']) || empty($_SESSION['x_userid'])) {
    header("Location: index.php");
    exit;
}

$alloweduserclass = array(0);
if (!in_array($_SESSION['x_userclass'], $alloweduserclass)) {
    header("Location: index.php");
}

// Proceed with retrieving data
$sql = "SELECT * FROM o_book
              LEFT JOIN o_user ON o_book.x_user = o_user.x_userid
              LEFT JOIN o_room ON o_book.x_room = o_room.x_roomid
              LEFT JOIN o_status ON o_book.x_status = o_status.x_id
              WHERE x_status='0'"; //in ('0','1', '2') to display all reservations

$result = mysqli_query($con, $sql);

if (isset($_POST['search'])) {
    $x_userclass = $_POST['x_userclass'];
}

$totalBookings = countTotalBookings();
$totalCheckIn = countCheckIn();
$totalCheckOut = countCheckOut();
$countStay =countStay();

// revenue
$totalRevenueMonthly = totalRevenueMonthly();
$totalRevenueDaily = totalRevenueDaily();


// PROGRESS BAR 1: Get total and available rooms from the database
// Get total and available rooms from the database
$roomAvailability = getRoomAvailabilityFromDatabase($con);
// Generate the progress bar HTML
$totalProgressBarAvailableRoom = generateRoomAvailabilityProgressBar($roomAvailability['totalRooms'], $roomAvailability['availableRooms']);

// PROGRESS BAR 2: Get total and available rooms from the database
$roomOccupied = getRoomOccupiedFromDatabase($con);
// Generate the progress bar HTML
$totalProgressBarOccupiedRoom = generateRoomOccupiedProgressBar($roomAvailability['totalRooms'], $roomOccupied['occupiedRooms']);


?>
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
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">
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
               </div>
            </div>
         </nav>
      </header>
      <!-- END header -->

      <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url(images/big_image_1.jpg);">
         <div class="container">
            <div class="row align-items-center site-hero-inner justify-content-center">
               <div class="col-md-12 text-center">
                  <div class="mb-5 element-animate">
                     <h1>Dashboard</h1>
                     <!-- <p>View Dashboard</p> -->
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- END section -->
      <section class="site-section">
         <div class="container-fluid">
            <!-- <div class="row">
               <div class="col-md-12 text-right">
                  <table class="table table-hover">
                     <thead>
                        <tr style="background-color: #f8f9fa;">
                           <th class="mt-6 pt-3 text-center">New Pending Order</th>
                           <form method="POST" name="search" action="searchresult.php"><br>
                              <input type="hidden" name="x_userid" value="<?php echo $_SESSION['x_userid']; ?>">
                              <input type="hidden  " name="x_userclass" value="<?php echo $_SESSION['x_userclass']; ?>">
                              <input type="text" placeholder=" Reservation ID" name="search">
                              <button type="submit" value="search"><i class="fa fa-search"></i></button>
                           </form>
                        </tr>
                     </thead>
                  </table>
               </div>
            </div> -->
         </div>
         <div class="container-fluid">
         <div class="row">
            <div class="col-md-12 text-right">
               <table class="table table-hover">
                  <thead>
                     <tr style="background-color: #6fde71;">
                        <th class="mt-6 pt-3 text-center" style="color: #ffffff;">Dashboard </th>
                        <!-- <form method="POST" name="search" action="searchresult.php"><br>
                           <input type="hidden" name="x_userid" value="<?php echo $_SESSION['x_userid']; ?>">
                            <input type="text" name="x_userclass" value="<?php echo $_SESSION['x_userclass']; ?>">
                           <input type="text" placeholder=" Reservation ID" name="search">
                           <button type="submit" value="search"><i class="fa fa-search"></i></button>
                           </form> -->
                     </tr>
                  </thead>
               </table>
            </div>
            <div class="col-md-12 text-center">
               <div class="row">
                  <div class="col-md-3">
                     <div class="card card-stats card-warning" style="background-color: #bae1ff;">
                        <div class="card-body ">
                           <div class="row">
                              <div class="col-4">
                                 <div class="icon-big text-center">
                                    <i class="la la-users"></i>
                                 </div>
                              </div>
                              <div class="col-7 d-flex align-items-center">
                                 <div class="numbers">
                                    <p class="card-category">New Reservation</p>
                                    <h4 class="card-title" style="font-family: Arial, sans-serif;"><?php echo $totalBookings;?></h4>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="card card-stats card-success" style="background-color: #baffc9;">
                        <div class="card-body ">
                           <div class="row">
                              <div class="col-4">
                                 <div class="icon-big text-center">
                                    <i class="la la-bar-chart"></i>
                                 </div>
                              </div>
                              <div class="col-7 d-flex align-items-center">
                                 <div class="numbers">
                                    <p class="card-category">Today's Check-In</p>
                                    <h4 class="card-title" style="font-family: Arial, sans-serif;"><?php echo $totalCheckIn; ?></h4>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="card card-stats card-danger" style="background-color: #ffdfba;">
                        <div class="card-body">
                           <div class="row">
                              <div class="col-4">
                                 <div class="icon-big text-center">
                                    <i class="la la-newspaper-o"></i>
                                 </div>
                              </div>
                              <div class="col-7 d-flex align-items-center">
                                 <div class="numbers">
                                    <p class="card-category">Today's Check-Out</p>
                                    <h4 class="card-title" style="font-family: Arial, sans-serif;"><?php echo $totalCheckOut;?></h4>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="card card-stats card-primary" style="background-color: #ffb3ba;">
                        <div class="card-body">
                           <div class="row">
                              <div class="col-5">
                                 <div class="icon-big text-center">
                                    <i class="la la-check-circle"></i>
                                 </div>
                              </div>
                              <div class="col-7 d-flex align-items-center">
                                 <div class="numbers">
                                     <p class="card-category">Stay</p>
                                    <h4 class="card-title" style="font-family: Arial, sans-serif;"><?php echo $countStay;?></h4>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
        <div class="col-md-12 pt-4 text-right">
            </div>
             <div class="col-md-12 text-center">
               <div class="row row-card-no-pd">
                
                  <div class="col-md-4">
                     <div class="card">
                        <div class="card-body">
                           <p class="fw-bold mt-1">Total Revenue (monthly)</p>
                           <h4 class="card-title" style="font-family: Arial, sans-serif;">RM <?php echo $totalRevenueMonthly;?></h4>
                           <!-- <a href="#" class="btn btn-primary btn-full text-left mt-3 mb-3"><i class="la la-plus"></i> Add Balance</a> -->
                        </div>
                        <div class="card-footer d-flex justify-content-center">
                           <ul class="nav">
                              <li class="nav-item"><a class="btn btn-default btn-link" href="manage.php#approvedsection"><i class="la la-history"></i>Details</a></li>
                              <!-- <li class="nav-item ml-auto"><a class="btn btn-default btn-link" href="#"><i class="la la-refresh"></i> Refresh</a></li> -->
                           </ul>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="card">
                        <div class="card-body">
                           <p class="fw-bold mt-1">Total Revenue (daily)</p>
                           <h4 class="card-title" style="font-family: Arial, sans-serif;">RM <?php echo $totalRevenueDaily;?></h4>
                           <!-- <a href="#" class="btn btn-primary btn-full text-left mt-3 mb-3"><i class="la la-plus"></i> Add Balance</a> -->
                        </div>
                        <div class="card-footer d-flex justify-content-center"">
                           <ul class="nav">
                              <li class="nav-item"><a class="btn btn-default btn-link" href="manage.php#approvedsection"><i class="la la-history"></i>Details</a></li>
                              <!-- <li class="nav-item ml-auto"><a class="btn btn-default btn-link" href="#"><i class="la la-refresh"></i> Refresh</a></li> -->
                           </ul>
                        </div>
                     </div>
                  </div>
                      <div class="col-md-4">
                     <div class="card" style="height: 205px;">
                        <div class="card-body">
                            <br>
                          <?php echo $totalProgressBarAvailableRoom;?>

                          <?php echo $totalProgressBarOccupiedRoom; ?>
                           <!-- <div class="progress-card">
                              <div class="d-flex justify-content-between mb-1">
                                 <span class="text-muted">Occupied</span>
                                 <span class="text-muted fw-bold"> 70%</span>
                              </div>
                              <div class="progress mb-2" style="height: 7px;">
                                 <div class="progress-bar bg-primary" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="70%"></div>
                              </div>
                           </div> -->
                           <!-- <div class="progress-card">
                              <div class="d-flex justify-content-between mb-1">
                                 <span class="text-muted">Free Space</span>
                                 <span class="text-muted fw-bold"> 60%</span>
                              </div>
                              <div class="progress mb-2" style="height: 7px;">
                                 <div class="progress-bar bg-warning" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="60%"></div>
                              </div>
                           </div> -->
                        </div>
                     </div>
                  </div>
              
               </div>
            </div>
         </div>
         
         <div class="container-fluid">
         <div class="row">
           
           
         </div>
      </section>
      <?php include 'footer.php';?>

<script type="text/javascript" src="js/sweetalert.js" language="javascript"></script>

<?php
if (isset($_GET["stype"]) && $_GET["stype"] == 'logged') {
    echo '
        <script>
            // Use SweetAlert
            Swal.fire({
                icon: "success",
                title: "Welcome Back!",
                text: "You Have Successfully Accessed Your Account.",
            });
        </script>
    ';
}      