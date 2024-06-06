<?php 
include('hrssession.php');
if (!session_id())
{
	session_start(); 
}

include ('dbconnect.php');

// Check if the user is logged in
if (!isset($_SESSION['userislogged']) || $_SESSION['userislogged'] != 1) {
    header("Location: index.php?");
    exit;
}
// Check if the necessary session variables are set
if (!isset($_SESSION['x_userid']) || empty($_SESSION['x_userid'])) {
    header("Location: index.php");
    exit;
}

$alloweduserclass = array(1); // can support multiple userclass
if (!in_array($_SESSION['x_userclass'], $alloweduserclass)) {
    header("Location: index.php");
}

$fid = $_SESSION['xuserid'];


$sql = "SELECT * FROM o_book
        LEFT JOIN o_room ON o_book.x_room = o_room.x_roomid
        LEFT JOIN o_status ON o_book.x_status = o_status.x_id
        WHERE x_user = ?";

$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "s", $fid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if(isset($_POST['search']))
{
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
                <a class="nav-link " href="customer.php">Room Reservation</a>
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
            
          </div>
        </div>
      </nav>
    </header>
    <!-- END header -->

    <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url(images/big_image_1.jpg);">
      <div class="container">
        <div class="row align-items-center site-hero-inner justify-content-center">
          <div class="col-md-12 text-center">

            <div class="mb-5 pt-5 element-animate">
              <h1 style= "color:white" >My Reservation</h1>
              <p>Manage and view your reservations</p>
            </div>

          </div>
        </div>
      </div>
    </section>
    <!-- END section -->
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <section class="site-section">
      <div class="container-fluid">
        <div class="row">

          <!-- // Search Function for Customer -->
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
                while($row=mysqli_fetch_array($result))
                {
                  echo"<tr>";
                  echo "<td>".$row['x_bookid']."</td>";
                  echo "<td>".$row['x_roomid']."</td>";
                  echo "<td>".$row['x_roomtype']."</td>";
                  echo "<td>".$row['x_datein']."</td>";
                  echo "<td>".$row['x_dateout']."</td>";
                  echo "<td>".$row['x_totalfee']."</td>";
                  echo "<td>".$row['x_name']."</td>";
                  echo "<td>";

                  // Check if the status is not 'Cancelled' (status 3) before displaying the Cancel button
                  if ($row['x_status'] != 3) {
                  echo "<a href='customercancel.php?id=".$row['x_bookid']. "' onClick='return delConfirmation(event, this.href);' class ='btn btn-secondary'>Cancel</a>&nbsp;";
                  }
                   // echo "<a href='customercancel.php?id=".$row['x_bookid']. "' onClick='return delConfirmation();' class ='btn btn-secondary'>Cancel</a>&nbsp;";
                  if($row['x_status'] == 0){
                    echo "<a href='customermodify.php?id=" . $row['x_bookid'] . "' class ='btn btn-primary'>Modify</a>&nbsp";
                  }
                    
                  echo "</td>";
                  echo "</tr>";
                }
              ?>
              <!-- <script type="text/javascript">
                function delConfirmation()
                {
                  var x = confirm("Are you sure you want to delete?");
                  if (x == true)
                  {
                    return true;
                  }
                  else
                  {
                    return false;
                  }
                }
              </script> -->
              <script type="text/javascript" src="js/sweetalert.js" language="javascript"></script>
              <script type="text/javascript">
                function delConfirmation(event, url)
                {
                  event.preventDefault(); // Prevent the default link behavior
                  
                  Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = url;
                    }
                  });
                }
              </script>
            </tbody>
          </table>
              
        </div>
      </div>
    </section>

<?php include 'footer.php' ?>