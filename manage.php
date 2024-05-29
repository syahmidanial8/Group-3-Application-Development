<?php
include('hrssession.php');
if (!session_id()) {
    session_start(); 
}
include 'dbconnect.php';
include 'functions.php'; // Include the file where the getroleid function is defined

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

// Proceed with retrieving data
$sql1 = "SELECT * FROM o_book
        LEFT JOIN o_user ON o_book.x_user = o_user.x_userid
        LEFT JOIN o_room ON o_book.x_room = o_room.x_roomid
        LEFT JOIN o_status ON o_book.x_status = o_status.x_id
        WHERE x_status='1'"; //in ('0','1', '2') to display all reservations

$result1 = mysqli_query($con, $sql1);

// Proceed with retrieving data
$sql2 = "SELECT * FROM o_book
        LEFT JOIN o_user ON o_book.x_user = o_user.x_userid
        LEFT JOIN o_room ON o_book.x_room = o_room.x_roomid
        LEFT JOIN o_status ON o_book.x_status = o_status.x_id
        WHERE x_status='2'"; //in ('0','1', '2') to display all reservations

$result2 = mysqli_query($con, $sql2);


if (isset($_POST['search'])) {
    $x_userclass = $_POST['x_userclass'];
}

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
              <h1>Pending Reservations</h1>
              <p>Reservations pending approval</p>
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
                  <tr style="background-color: #f8f9fa;">
                      <th class="mt-6 pt-3 text-center">New Reservation</th>
                      
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
                    <th>Customer</th>
                    <th>Contact</th>
                    <th>Room No.</th>
                    <th>Checkin Date</th>
                    <th>Checkout Date</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Operation</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                    while($row=mysqli_fetch_array($result))
                    {
                      echo"<tr>";
                      echo "<td>".$row['x_bookid']."</td>";
                      echo "<td>".$row['x_user']."</td>";
                      echo "<td>".$row['x_tel']."</td>";
                      echo "<td>".$row['x_roomid']."</td>";
                      echo "<td>".$row['x_datein']."</td>";
                      echo "<td>".$row['x_dateout']."</td>";
                      echo "<td>".$row['x_totalfee']."</td>";
                      echo "<td>".$row['x_name']."</td>";
                      echo "<td>";
                      echo "<a href='manageapproval.php?id=".$row['x_bookid']."' class ='btn btn-primary'>Approval</a>";
                      echo "</td>";
                      echo "</tr>";
                    }
                  ?>
                </tbody>
              </table>
            </div>

        </div>
      </div>

       <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 pt-5 text-right">   
            <table class="table table-hover">
                <thead>
                  <tr style="background-color: #6fde71;">
                     <th class="mt-6 pt-3 text-center" style="color: #ffffff;">Approved Reservation</th>
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
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Reservation ID</th>
                    <th>Customer</th>
                    <th>Contact</th>
                    <th>Room No.</th>
                    <th>Checkin Date</th>
                    <th>Checkout Date</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Operation</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                    while($row1=mysqli_fetch_array($result1))
                    {
                      echo"<tr>";
                      echo "<td>".$row1['x_bookid']."</td>";
                      echo "<td>".$row1['x_user']."</td>";
                      echo "<td>".$row1['x_tel']."</td>";
                      echo "<td>".$row1['x_roomid']."</td>";
                      echo "<td>".$row1['x_datein']."</td>";
                      echo "<td>".$row1['x_dateout']."</td>";
                      echo "<td>".$row1['x_totalfee']."</td>";
                      echo "<td>".$row1['x_name']."</td>";
                      echo "<td>";
                      echo "<a href='manageapproval.php?id=".$row1['x_bookid']."' class ='btn btn-primary'>Modify</a>";
                      echo "</td>";
                      echo "</tr>";
                    }
                  ?>
                </tbody>
              </table>
            </div>

        </div>
      </div>

       <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 pt-5 text-right">  
            <table class="table table-hover">
                <thead>
                  <tr style="background-color: #fa7d89;">
                    <th class="mt-6 pt-3 text-center"  style="color: #ffffff;">Rejected Reservation</th>
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
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Reservation ID</th>
                    <th>Customer</th>
                    <th>Contact</th>
                    <th>Room No.</th>
                    <th>Checkin Date</th>
                    <th>Checkout Date</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Operation</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                    while($row2=mysqli_fetch_array($result2))
                    {
                      echo"<tr>";
                      echo "<td>".$row2['x_bookid']."</td>";
                      echo "<td>".$row2['x_user']."</td>";
                      echo "<td>".$row2['x_tel']."</td>";
                      echo "<td>".$row2['x_roomid']."</td>";
                      echo "<td>".$row2['x_datein']."</td>";
                      echo "<td>".$row2['x_dateout']."</td>";
                      echo "<td>".$row2['x_totalfee']."</td>";
                      echo "<td>".$row2['x_name']."</td>";
                      echo "<td>";
                      echo "<a href='manageapproval.php?id=".$row2['x_bookid']."' class ='btn btn-primary'>Modify</a>";
                      echo "</td>";
                      echo "</tr>";
                    }
                  ?>
                </tbody>
              </table>
            </div>

        </div>
      </div>
    </section>

   
   <?php include 'footer.php'; ?>
   
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